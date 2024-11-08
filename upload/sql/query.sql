ALTER TABLE `products` ADD COLUMN `product_asset_name` VARCHAR(255) DEFAULT NULL COMMENT 'Nama Asset' AFTER `product_reminder_date`;
ALTER TABLE `products` ADD COLUMN `product_asset_code` VARCHAR(255) DEFAULT NULL COMMENT 'Nomor Asset' AFTER `product_asset_name`;
ALTER TABLE `products` ADD COLUMN `product_asset_note` TEXT DEFAULT NULL COMMENT 'Deskripsi Asset' AFTER `product_asset_code`;

ALTER TABLE `products` ADD COLUMN `product_asset_acquisition_date` DATE DEFAULT NULL COMMENT 'Tgl Akusisi' AFTER `product_asset_note`;
ALTER TABLE `products` ADD COLUMN `product_asset_acquisition_value` DOUBLE(18,2) DEFAULT NULL COMMENT 'Biaya Akusisi' AFTER `product_asset_acquisition_date`;

ALTER TABLE `products` ADD COLUMN `product_asset_dep_flag` INT(5) DEFAULT NULL COMMENT '0=NonDepresiasi, 1=Depresiasi' AFTER `product_asset_acquisition_value`;
ALTER TABLE `products` ADD COLUMN `product_asset_dep_method` INT(5) DEFAULT NULL COMMENT '1=Straight Line, 2=Reducing Balance' AFTER `product_asset_dep_flag`;

ALTER TABLE `products` ADD COLUMN `product_asset_dep_period` INT(255) DEFAULT NULL COMMENT 'Masa Manfaat / Tahun' AFTER `product_asset_dep_method`;
ALTER TABLE `products` ADD COLUMN `product_asset_dep_percentage` DOUBLE(18,2) DEFAULT NULL COMMENT 'Nilai / Tahun Persen' AFTER `product_asset_dep_period`;

ALTER TABLE `products` ADD COLUMN `product_asset_fixed_account_id` BIGINT(255) DEFAULT NULL COMMENT 'Account Asset Tetap' AFTER `product_asset_dep_percentage`;
ALTER TABLE `products` ADD COLUMN `product_asset_cost_account_id` BIGINT(255) DEFAULT NULL COMMENT 'Account Biaya Akusisi' AFTER `product_asset_fixed_account_id`;
ALTER TABLE `products` ADD COLUMN `product_asset_depreciation_account_id` BIGINT(255) DEFAULT NULL COMMENT 'Account Penyusutan' AFTER `product_asset_cost_account_id`;
ALTER TABLE `products` ADD COLUMN `product_asset_accumulated_depreciation_account_id` BIGINT(255) DEFAULT NULL COMMENT 'Account Akumulasi Penyusutan' AFTER `product_asset_depreciation_account_id`;

ALTER TABLE `products` ADD COLUMN `product_asset_accumulated_depreciation_value` DOUBLE(18,2) DEFAULT NULL COMMENT 'Akumulasi Penyusutan' AFTER `product_asset_accumulated_depreciation_account_id`;
ALTER TABLE `products` ADD COLUMN `product_asset_accumulated_depreciation_date` DATE DEFAULT NULL COMMENT 'Tgl Mulai Awal' AFTER `product_asset_accumulated_depreciation_value`;


DELIMITER $$
/* USE `database_name`$$ */
DROP PROCEDURE IF EXISTS `sp_journal_from_asset`$$
CREATE PROCEDURE `sp_journal_from_asset`(
  IN vACTION VARCHAR(255),
  IN vPRODUCT_ID BIGINT(255)
)
BEGIN
    /*
        TYPE
        16 Asset Beli 
        17 Asset Susut
        18 Asset Jual
    */
    -- Block A : Get Product
    -- Block B : Create Debit Credit 

    BLOCK_A:BEGIN
        DECLARE mBRANCH_ID INT(5) DEFAULT 0;
        DECLARE mBRANCH_WITH_JOURNAL VARCHAR(255) DEFAULT 0;
        DECLARE mUSER_ID BIGINT(255);

        DECLARE mACCOUNT_FIXED BIGINT(255);
        DECLARE mACCOUNT_COST BIGINT(255);
        DECLARE mACCOUNT_DEPRECIATION BIGINT(255);
        DECLARE mACCOUNT_ACCUMULATED BIGINT(255);
        DECLARE mACCOUNT_EQUITY BIGINT(255);

        DECLARE mASSET_CODE VARCHAR(255);
        DECLARE mASSET_NAME VARCHAR(255);        

        DECLARE mASSET_ACQUISITION_DATE VARCHAR(255);
        DECLARE mASSET_ACQUISITION_VALUE DOUBLE(18,2) DEFAULT '0.00';
        DECLARE mASSET_DEP_FLAG INT(5); -- 0 Non Dep, 1 Dep
        DECLARE mASSET_DEP_METHOD INT(5); -- 1 Straigt, 2 Reducing
        DECLARE mASSET_DEP_PERIOD INT(5); -- Year
        DECLARE mASSET_DEP_PERCENTAGE DOUBLE(18,2) DEFAULT '0.00'; -- Percen

        DECLARE mASSET_ACCUMULATED_DATE VARCHAR(255); 
        DECLARE mASSET_ACCUMULATED_VALUE DOUBLE(18,2);

        DECLARE mJOURNAL_ID BIGINT(255);
        DECLARE mJOURNAL_ID_2 BIGINT(255);

        DECLARE mFINISHED INTEGER;
        
        -- DECLARE mACTION_CURSOR CURSOR FOR
        --     SELECT column_one, column_two FROM table_name ORDER BY id ASC;
        -- DECLARE CONTINUE HANDLER FOR NOT FOUND SET mFINISHED = 1;
        -- OPEN mACTION_CURSOR;

        -- LOOP_1: LOOP
        --     FETCH mACTION_CURSOR INTO mCOLUMN_ONE, mCOLUMN_TWO;
        --     IF mFINISHED = 1 THEN LEAVE LOOP_1; END IF;

        --     INSERT INTO temps(`COLUMN_TWO`,`COLUMN_THREE`)VALUES(mCOLUMN_TWO,mCOLUMN_THREE);
        --     /* Code the logic here */
        
        -- END LOOP LOOP_1;
        
    
        /* Get Product Info*/
        SELECT product_branch_id, product_user_id, 
            product_asset_fixed_account_id, product_asset_cost_account_id,
            product_asset_depreciation_account_id, product_asset_accumulated_depreciation_account_id,
            product_asset_acquisition_value, product_asset_acquisition_date, product_asset_dep_method, product_asset_dep_period, product_asset_dep_percentage,
            product_asset_dep_flag, product_asset_accumulated_depreciation_date, product_asset_accumulated_depreciation_value,
            product_asset_code, product_asset_name
        INTO mBRANCH_ID, mUSER_ID, mACCOUNT_FIXED, mACCOUNT_COST, mACCOUNT_DEPRECIATION, mACCOUNT_ACCUMULATED,
        mASSET_ACQUISITION_VALUE, mASSET_ACQUISITION_DATE, mASSET_DEP_METHOD, mASSET_DEP_PERIOD, mASSET_DEP_PERCENTAGE, 
        mASSET_DEP_FLAG, mASSET_ACCUMULATED_DATE, mASSET_ACCUMULATED_VALUE,
        mASSET_CODE, mASSET_NAME
        FROM products 
        WHERE product_id=vPRODUCT_ID;

        /* Get Branch if Have Journal Config */
        SELECT branch_transaction_with_journal INTO mBRANCH_WITH_JOURNAL FROM branchs WHERE branch_id=mBRANCH_ID;

        IF mBRANCH_WITH_JOURNAL = 'Yes' THEN
            IF vACTION = 'CREATE' THEN
                IF mASSET_DEP_FLAG = 0 THEN -- NonDepresiasi
                    
                    -- Insert Journal
                        SET @journal_type := 16;
                        SET @journal_number := 'Pembelian-Asset-0001';
                        SET @journal_session := fn_create_session();
                        INSERT INTO `journals` (`journal_number`,`journal_type`,`journal_date`,`journal_total`,`journal_date_created`,
                        `journal_user_id`,`journal_flag`,`journal_session`,`journal_asset_id`,`journal_branch_id`) 
                        VALUES (@journal_number,@journal_type,CONCAT(mASSET_ACQUISITION_DATE,' 07:00:00'),mASSET_ACQUISITION_VALUE,NOW(),
                        mUSER_ID,1,@journal_session,vPRODUCT_ID,mBRANCH_ID);

                        SELECT LAST_INSERT_ID() INTO mJOURNAL_ID;

                    -- Insert Journal Item (Debit & Credit)
                        -- Fixed Account ID
                        INSERT INTO `journals_items` (
                            `journal_item_journal_id`,`journal_item_group_session`,`journal_item_branch_id`,
                            `journal_item_account_id`,`journal_item_date`,
                            `journal_item_type`,`journal_item_type_name`,`journal_item_debit`,`journal_item_credit`,
                            `journal_item_user_id`, `journal_item_note`,
                            `journal_item_date_created`,`journal_item_flag`,`journal_item_position`,`journal_item_journal_session`,`journal_item_session`
                        ) VALUES (
                            mJOURNAL_ID, @journal_session, mBRANCH_ID,
                            mACCOUNT_FIXED, CONCAT(mASSET_ACQUISITION_DATE,' 07:00:00'),
                            @journal_type, 'Beli Asset', mASSET_ACQUISITION_VALUE,'0.00',
                            mUSER_ID, CONCAT('(',mASSET_CODE,') ',mASSET_NAME),
                            NOW(),1,1,@journal_session,fn_create_session()
                        );

                        -- Cost Account ID
                        INSERT INTO `journals_items` (
                            `journal_item_journal_id`,`journal_item_group_session`,`journal_item_branch_id`,
                            `journal_item_account_id`,`journal_item_date`,
                            `journal_item_type`,`journal_item_type_name`,`journal_item_debit`,`journal_item_credit`,
                            `journal_item_user_id`, `journal_item_note`,
                            `journal_item_date_created`,`journal_item_flag`,`journal_item_position`,`journal_item_journal_session`,`journal_item_session`
                        ) VALUES (
                            mJOURNAL_ID, @journal_session, mBRANCH_ID,
                            mACCOUNT_COST, CONCAT(mASSET_ACQUISITION_DATE,' 07:00:00'),
                            @journal_type, 'Beli Asset', '0.00', mASSET_ACQUISITION_VALUE,
                            mUSER_ID, CONCAT('(',mASSET_CODE,') ',mASSET_NAME),
                            NOW(), 1, 2, @journal_session, fn_create_session()
                        );

                    SET @SQL_Text := CONCAT('SELECT CONCAT(1) AS status, CONCAT("-") AS message, CONCAT("Operator CREATE NONDEPRESIASI Asset to Journal") AS operator, CONCAT("',vPRODUCT_ID,'") AS product_id, CONCAT("0") AS result');
                ELSEIF mASSET_DEP_FLAG = 1 THEN -- Depresiasi

                    /* Ekuitas Saldo Awal */ 
                    SELECT account_map_account_id INTO mACCOUNT_EQUITY 
                    FROM accounts_maps WHERE account_map_branch_id=mBRANCH_ID AND account_map_for_transaction=10 AND account_map_type=1;

                    -- Insert Journal
                        SET @journal_type := 16;
                        SET @journal_number := 'Pembelian-Asset-0002';
                        SET @journal_session := fn_create_session();
                        INSERT INTO `journals` (`journal_number`,`journal_type`,`journal_date`,`journal_total`,`journal_date_created`,
                        `journal_user_id`,`journal_flag`,`journal_session`,`journal_asset_id`,`journal_branch_id`) 
                        VALUES (@journal_number,@journal_type,CONCAT(mASSET_ACQUISITION_DATE,' 07:00:00'),mASSET_ACQUISITION_VALUE,NOW(),
                        mUSER_ID,1,@journal_session,vPRODUCT_ID,mBRANCH_ID);

                        SELECT LAST_INSERT_ID() INTO mJOURNAL_ID;

                    -- Standard Insert Journal Item (Debit & Credit)
                        -- Fixed Account ID
                        INSERT INTO `journals_items` (
                            `journal_item_journal_id`,`journal_item_group_session`,`journal_item_branch_id`,
                            `journal_item_account_id`,`journal_item_date`,
                            `journal_item_type`,`journal_item_type_name`,`journal_item_debit`,`journal_item_credit`,
                            `journal_item_user_id`,`journal_item_note`,
                            `journal_item_date_created`,`journal_item_flag`,`journal_item_position`,`journal_item_journal_session`,`journal_item_session`
                        ) VALUES (
                            mJOURNAL_ID, @journal_session, mBRANCH_ID,
                            mACCOUNT_FIXED, CONCAT(mASSET_ACQUISITION_DATE,' 07:00:00'),
                            @journal_type, 'Beli Asset', mASSET_ACQUISITION_VALUE,'0.00',
                            mUSER_ID, CONCAT('(',mASSET_CODE,') ',mASSET_NAME),
                            NOW(),1,1,@journal_session,fn_create_session()
                        );

                        -- Cost Account ID
                        INSERT INTO `journals_items` (
                            `journal_item_journal_id`,`journal_item_group_session`,`journal_item_branch_id`,
                            `journal_item_account_id`,`journal_item_date`,
                            `journal_item_type`,`journal_item_type_name`,`journal_item_debit`,`journal_item_credit`,
                            `journal_item_user_id`,`journal_item_note`,
                            `journal_item_date_created`,`journal_item_flag`,`journal_item_position`,`journal_item_journal_session`,`journal_item_session`
                        ) VALUES (
                            mJOURNAL_ID, @journal_session, mBRANCH_ID,
                            mACCOUNT_COST, CONCAT(mASSET_ACQUISITION_DATE,' 07:00:00'),
                            @journal_type, 'Beli Asset', '0.00', mASSET_ACQUISITION_VALUE,
                            mUSER_ID, CONCAT('(',mASSET_CODE,') ',mASSET_NAME),
                            NOW(), 1, 2, @journal_session, fn_create_session()
                        );

                    -- Insert Journal For Depreciation
                        SET @journal_type := 17;
                        SET @journal_number := 'Penyusutan-Asset-0001';
                        SET @journal_session := fn_create_session();
                        INSERT INTO `journals` (`journal_number`,`journal_type`,`journal_date`,`journal_total`,`journal_date_created`,
                        `journal_user_id`,`journal_flag`,`journal_session`,`journal_asset_id`,`journal_branch_id`,`journal_id_source`) 
                        VALUES (@journal_number,@journal_type,CONCAT(mASSET_ACCUMULATED_DATE,' 07:00:00'),mASSET_ACCUMULATED_VALUE,NOW(),
                        mUSER_ID,1,@journal_session,vPRODUCT_ID,mBRANCH_ID,mJOURNAL_ID);

                        SELECT LAST_INSERT_ID() INTO mJOURNAL_ID_2;

                    -- Depresiasi Insert Journal Item (Debit & Credit)
                        -- Ekuitas, Depretiation Account ID
                        INSERT INTO `journals_items` (
                            `journal_item_journal_id`,`journal_item_group_session`,`journal_item_branch_id`,
                            `journal_item_account_id`,`journal_item_date`,
                            `journal_item_type`,`journal_item_type_name`,`journal_item_debit`,`journal_item_credit`,
                            `journal_item_user_id`,`journal_item_note`,
                            `journal_item_date_created`,`journal_item_flag`,`journal_item_position`,`journal_item_journal_session`,`journal_item_session`
                        ) VALUES (
                            mJOURNAL_ID_2, @journal_session, mBRANCH_ID,
                            mACCOUNT_EQUITY, CONCAT(mASSET_ACCUMULATED_DATE,' 07:00:00'),
                            @journal_type, 'Penyusutan Asset', mASSET_ACCUMULATED_VALUE,'0.00',
                            mUSER_ID, CONCAT('(',mASSET_CODE,') ',mASSET_NAME),
                            NOW(),1,1,@journal_session,fn_create_session()
                        );

                        -- Accumulated Account ID
                        INSERT INTO `journals_items` (
                            `journal_item_journal_id`,`journal_item_group_session`,`journal_item_branch_id`,
                            `journal_item_account_id`,`journal_item_date`,
                            `journal_item_type`,`journal_item_type_name`,`journal_item_debit`,`journal_item_credit`,
                            `journal_item_user_id`,`journal_item_note`,
                            `journal_item_date_created`,`journal_item_flag`,`journal_item_position`,`journal_item_journal_session`,`journal_item_session`
                        ) VALUES (
                            mJOURNAL_ID_2, @journal_session, mBRANCH_ID,
                            mACCOUNT_ACCUMULATED, CONCAT(mASSET_ACCUMULATED_DATE,' 07:00:00'),
                            @journal_type, 'Penyusutan Asset', '0.00', mASSET_ACCUMULATED_VALUE,
                            mUSER_ID, CONCAT('(',mASSET_CODE,') ',mASSET_NAME),
                            NOW(), 1, 2, @journal_session, fn_create_session()
                        );

                    SET @SQL_Text := CONCAT('SELECT CONCAT(1) AS status, CONCAT("-") AS message, CONCAT("Operator CREATE DEPRESIASI Asset to Journal") AS operator, CONCAT("',vPRODUCT_ID,'") AS product_id, CONCAT("0") AS result');
                END IF;
            ELSEIF vACTION = 'UPDATE' THEN
                SET @SQL_Text := CONCAT('SELECT CONCAT(1) AS status, CONCAT("-") AS message, CONCAT("Operator UPDATE Asset to Journal") AS operator, CONCAT("',vPRODUCT_ID,'") AS product_id, CONCAT("0") AS result');     
            ELSEIF vACTION = 'SELL' THEN
                SET @SQL_Text := CONCAT('SELECT CONCAT(1) AS status, CONCAT("-") AS message, CONCAT("Operator SELL Asset to Journal") AS operator, CONCAT("',vPRODUCT_ID,'") AS product_id, CONCAT("0") AS result');
            ELSEIF vACTION = 'DELETE' THEN
                DELETE FROM journals_items WHERE journal_item_journal_id IN (SELECT journal_id FROM journals WHERE journal_asset_id = vPRODUCT_ID);
                DELETE FROM journals WHERE journal_asset_id = vPRODUCT_ID;
                SET @SQL_Text := CONCAT('SELECT CONCAT(1) AS status, CONCAT("-") AS message, CONCAT("Operator DELETE Asset to Journal") AS operator, CONCAT("',vPRODUCT_ID,'") AS product_id, CONCAT("0") AS result');
            END IF; 
        END IF;

        /*
        SET mFOUND_ROW = FOUND_ROWS();
        IF mFOUND_ROW > 0 THEN
        END IF;
        */

    END BLOCK_A;

    /* Prepare Query Statement */
    PREPARE stmt FROM @SQL_Text;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;  

END$$
DELIMITER ;

-- ALTER TABLE `journals` ADD COLUMN journal_id_source BIGINT(255) COMMENT 'Hanya Asset yg menggunakan' AFTER journal_label;
-- ALTER TABLE `journals` ADD COLUMN journal_asset_id BIGINT(255) COMMENT 'Relasi products = product_type=3' AFTER journal_id_source;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_journal_from_pos`$$
CREATE PROCEDURE `sp_journal_from_pos`(
  IN vOPERATION VARCHAR(255),
  IN vTRANS_ID INT(255),
  IN vTRANS_DATE DATE,
  IN vJOURNAL_TYPE INT(5),
  IN vPAID_TYPE INT(5),
  IN vPAID_TYPE_ACCOUNT_ID INT(5),
  IN vBRANCH_ID INT(50)
)
BEGIN

    /* Prepare Temporary Table */
    /*
    DROP TEMPORARY TABLE IF EXISTS temps;
    CREATE TEMPORARY TABLE temps (
        `temp_id` BIGINT(50) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `temp_label` VARCHAR(255),
        `temp_flag` INT(5),
        `temp_status` INT(5) DEFAULT 0,
        `temp_message` VARCHAR(255),
        `temp_total_data` INT(255) DEFAULT 0,
        INDEX `ID`(`temp_id`) USING BTREE
    ) ENGINE=MEMORY;    
    */

    -- BLOCK_A:BEGIN
    --     DECLARE mCOLUMN_ONE INT(5) DEFAULT 0;
    --     DECLARE mCOLUMN_TWO VARCHAR(255) DEFAULT 0;
    --     DECLARE mCOLUMN_THREE VARCHAR(255) DEFAULT 0;
    --     DECLARE mFINISHED INTEGER;
    --     DECLARE mACTION_CURSOR CURSOR FOR
    --         SELECT column_one, column_two FROM table_name ORDER BY id ASC;
    --     DECLARE CONTINUE HANDLER FOR NOT FOUND SET mFINISHED = 1;
    --     OPEN mACTION_CURSOR;

    --     LOOP_1: LOOP
    --         FETCH mACTION_CURSOR INTO mCOLUMN_ONE, mCOLUMN_TWO;
    --         IF mFINISHED = 1 THEN LEAVE LOOP_1; END IF;

    --         INSERT INTO temps(`COLUMN_TWO`,`COLUMN_THREE`)VALUES(mCOLUMN_TWO,mCOLUMN_THREE);
    --         /* Code the logic here */
        
    --     END LOOP LOOP_1;
    
    --     /*
    --     SET mFOUND_ROW = FOUND_ROWS();
    --     IF mFOUND_ROW > 0 THEN
    --     END IF;
    --     */

    -- END BLOCK_A;

    -- BLOCK_B:BEGIN
    --     DECLARE mCOLUMN_ONE INT(5) DEFAULT 0;
    --     DECLARE mCOLUMN_TWO VARCHAR(255) DEFAULT 0;,
    --     DECLARE mCOLUMN_THREE VARCHAR(255) DEFAULT 0;
    --     DECLARE mFINISHED INTEGER;
    --     SET mFINISHED = 0;

    --     SELECT column_one, column_two, column_three 
    --     INTO mCOLUMN_ONE, mCOLUMN_TWO, mCOLUMN_THREE
    --     FROM table_name
    --     WHERE table_id > 0;

    --     WHILE mFINISHED < FOUND_ROWS() DO
    --         INSERT INTO temps(`COLUMN_ONE`,`COLUMN_TWO`,`COLUMN_THREE`)VALUES(mCOLUMN_ONE, mCOLUMN_TWO, mCOLUMN_THRE);
    --         SET mFINISHED = mFINISHED + 1;
    --     END WHILE;
    -- END BLOCK_B;

        DECLARE mTDISCOUNT INT(50) DEFAULT 0;
        DECLARE mTVOUCHER INT(50) DEFAULT 0;
        DECLARE mTTOTAL FLOAT(18,2);
        DECLARE mTCONTACT_ID INT(50); 
        DECLARE mTUSER_ID INT(50);
        
        DECLARE mPRODUCT_ID INT(50);
        DECLARE mPRODUCT_SELL_ACCOUNT_ID INT(50);
        DECLARE mTRANS_ITEM_SELL_TOTAL FLOAT(18,2);

        DECLARE mFINISH INTEGER;
        DECLARE mTRANS_ITEMS_CURSOR CURSOR FOR
            SELECT trans_item_product_id, product_sell_account_id, trans_item_sell_total 
            FROM trans_items
            LEFT JOIN products ON trans_item_product_id = product_id 
            WHERE trans_item_trans_id = vTRANS_ID;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET mFINISH = 1;

        -- Request Type
        SELECT type_doc INTO @mHEADER_DOC FROM `types` WHERE type_for=3 AND type_type=vJOURNAL_TYPE;

        -- Request Number
        SELECT IFNULL(MAX(RIGHT(journal_number,5)),0) INTO @mJOURNAL_NUMBER
        FROM journals WHERE DATE_FORMAT(journal_date_created, '%Y%m') = DATE_FORMAT(NOW(),'%Y%m')
        AND journal_branch_id=vBRANCH_ID AND journal_type=vJOURNAL_TYPE;

        IF @mJOURNAL_NUMBER = 0 THEN
            SET @mNUMBER := '0001';
        ELSE 
            SET @mNUMBER := @mJOURNAL_NUMBER + 1;
            SELECT LPAD(@mNUMBER,5,0) INTO @mNUMBER;
        END IF;

        -- Set Journal Number
        SET @mNUMBER := CONCAT(@mHEADER_DOC,'-',DATE_FORMAT(NOW(),'%y%m'),'-',@mNUMBER);

        -- GET trans
            SELECT trans_contact_id, trans_discount, trans_voucher, trans_total, trans_user_id INTO mTCONTACT_ID, mTDISCOUNT, mTVOUCHER, mTTOTAL, mTUSER_ID FROM trans WHERE trans_id = vTRANS_ID;
        -- INSERT journals
            SET @mJOURNAL_SESSION = fn_create_session_length(20);
            INSERT INTO `journals` (
                `journal_branch_id`, `journal_type`, `journal_number`, `journal_date`
                , `journal_account_id`, `journal_total`, `journal_contact_id`, `journal_paid_type`
                , `journal_date_created`, `journal_user_id`, `journal_flag`, `journal_session` 
            ) VALUES (
                vBRANCH_ID, vJOURNAL_TYPE, @mNUMBER, vTRANS_DATE
                , vPAID_TYPE_ACCOUNT_ID, mTTOTAL, mTCONTACT_ID, vPAID_TYPE
                , NOW(), mTUSER_ID, 1, @mJOURNAL_SESSION
            );
            SELECT journal_id INTO @mJOURNAL_ID FROM journals WHERE journal_session=@mJOURNAL_SESSION;

        -- INSERT journals_items DEBIT (CASH, TRANSFER, EDC, FREE)
            INSERT INTO `journals_items` (`journal_item_journal_id`,`journal_item_branch_id`,`journal_item_account_id`,`journal_item_trans_id`,`journal_item_date`,
            `journal_item_type`,`journal_item_debit`,`journal_item_credit`,`journal_item_user_id`,`journal_item_date_created`,`journal_item_flag`,`journal_item_position`)
            VALUES(@mJOURNAL_ID, vBRANCH_ID, vPAID_TYPE_ACCOUNT_ID, vTRANS_ID, vTRANS_DATE, 
            11, mTTOTAL, '0.00', mTUSER_ID, NOW(), 1, 1);

            -- OPTIONAL INSERT journals_items DEBIT (DISCOUNT)
                IF mTDISCOUNT > 0 THEN
                    SELECT account_id INTO @mACCOUNT_DISCOUNT FROM accounts_maps LEFT JOIN accounts ON account_map_account_id = account_id 
                    WHERE account_map_for_transaction = 2 AND account_map_type = 5 AND account_map_branch_id = vBRANCH_ID;
                    
                    INSERT INTO `journals_items` (`journal_item_journal_id`,`journal_item_branch_id`,`journal_item_account_id`,`journal_item_trans_id`,`journal_item_date`,
                    `journal_item_type`,`journal_item_debit`,`journal_item_credit`,`journal_item_user_id`,`journal_item_date_created`,`journal_item_flag`,`journal_item_position`)
                    VALUES(@mJOURNAL_ID, vBRANCH_ID, @mACCOUNT_DISCOUNT, vTRANS_ID, vTRANS_DATE, 
                    11, mTDISCOUNT, '0.00', mTUSER_ID, NOW(), 1, 1);            
                END IF;
            -- OPTIONAL INSERT journals_items DEBIT (VOUCHER)
                IF mTVOUCHER > 0 THEN
                    SELECT account_id INTO @mACCOUNT_DISCOUNT FROM accounts_maps LEFT JOIN accounts ON account_map_account_id = account_id 
                    WHERE account_map_for_transaction = 2 AND account_map_type = 9 AND account_map_branch_id = vBRANCH_ID;
                    
                    INSERT INTO `journals_items` (`journal_item_journal_id`,`journal_item_branch_id`,`journal_item_account_id`,`journal_item_trans_id`,`journal_item_date`,
                    `journal_item_type`,`journal_item_debit`,`journal_item_credit`,`journal_item_user_id`,`journal_item_date_created`,`journal_item_flag`,`journal_item_position`)
                    VALUES(@mJOURNAL_ID, vBRANCH_ID, @mACCOUNT_DISCOUNT, vTRANS_ID, vTRANS_DATE, 
                    11, mTVOUCHER, '0.00', mTUSER_ID, NOW(), 1, 1); 
                END IF;
        -- LOOP trans_items
            OPEN mTRANS_ITEMS_CURSOR;
            LOOP_1: LOOP 
                FETCH mTRANS_ITEMS_CURSOR INTO mPRODUCT_ID, mPRODUCT_SELL_ACCOUNT_ID, mTRANS_ITEM_SELL_TOTAL;
                IF mFINISH = 1 THEN LEAVE LOOP_1; END IF;
                
                -- INSERT journals_items CREDIT (PENDAPATAN, PENJUALAN)
                    INSERT INTO `journals_items` (`journal_item_journal_id`,`journal_item_branch_id`,`journal_item_account_id`,`journal_item_trans_id`,`journal_item_date`,
                    `journal_item_type`,`journal_item_debit`,`journal_item_credit`,`journal_item_user_id`,`journal_item_date_created`,`journal_item_flag`,`journal_item_position`)
                    VALUES(@mJOURNAL_ID, vBRANCH_ID, mPRODUCT_SELL_ACCOUNT_ID, vTRANS_ID, vTRANS_DATE, 
                    11, '0.00', mTRANS_ITEM_SELL_TOTAL, mTUSER_ID, NOW(), 1, 2); 
            
            END LOOP LOOP_1;
        -- END LOOP

    SET @QUERY := CONCAT('SELECT @mNUMBER');
    PREPARE stmt FROM @QUERY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

END $$
DELIMITER ;