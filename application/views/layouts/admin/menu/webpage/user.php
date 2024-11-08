<style>
    *,*:before,*:after{
        box-sizing:border-box;
        margin:0;
        padding:0;
        /*transition*/
        -webkit-transition:.25s ease-in-out;
        -moz-transition:.25s ease-in-out;
        -o-transition:.25s ease-in-out;
        transition:.25s ease-in-out;
        outline:none;
        /*font-family:Helvetica Neue,helvetica,arial,verdana,sans-serif;*/
    }

    .toggles{
        width:48px;
        /*margin-left: 25px;*/
        /*margin:50px auto;*/
        /*text-align:center;*/
    }
    .ios-toggle,.ios-toggle:active{
        position:absolute;
        top:-5000px;
        height:0;
        width:0;
        opacity:0;
        border:none;
        outline:none;
    }
    .checkbox-label{
        display:block;
        position:relative;
        padding:10px;
        margin-bottom:0px!important;
        font-size:12px;
        line-height:16px;
        width:100%;
        height:24px;
        /*border-radius*/
        -webkit-border-radius:18px;
        -moz-border-radius:18px;
        border-radius:18px;
        /*background:#f8f8f8;*/
        background: #f46767;
        cursor:pointer;
    }
    .checkbox-label:before{
        content:'';
        display:block;
        position:absolute;
        z-index:1;
        line-height:34px;
        text-indent:40px;
        height:24px;
        width:24px;
        /*border-radius*/
        -webkit-border-radius:100%;
        -moz-border-radius:100%;
        border-radius:100%;
        top:0px;
        left:0px;
        right:auto;
        background:white;
        /*box-shadow*/
        -webkit-box-shadow:0 3px 3px rgba(0,0,0,.2),0 0 0 2px #dddddd;
        -moz-box-shadow:0 3px 3px rgba(0,0,0,.2),0 0 0 2px #dddddd;
        box-shadow:0 3px 3px rgba(0,0,0,.2),0 0 0 2px #dddddd;
    }
    .checkbox-label:after{
        /*content:attr(data-off);*/
        display:block;
        position:absolute;
        z-index:0;
        top:0;
        left:-300px;
        padding:10px;
        height:100%;
        width:300px;
        text-align:right;
        color:#bfbfbf;
        white-space:nowrap;
    }
    .ios-toggle:checked + .checkbox-label{
        /*box-shadow*/
        -webkit-box-shadow:inset 0 0 0 20px rgba(19,191,17,1),0 0 0 2px rgba(19,191,17,1);
        -moz-box-shadow:inset 0 0 0 20px rgba(19,191,17,1),0 0 0 2px rgba(19,191,17,1);
        box-shadow:inset 0 0 0 20px rgba(19,191,17,1),0 0 0 2px rgba(19,191,17,1);
    }
    .ios-toggle:checked + .checkbox-label:before{
        left:calc(100% - 24px);
        /*box-shadow*/
        -webkit-box-shadow:0 0 0 2px transparent,0 3px 3px rgba(0,0,0,.3);
        -moz-box-shadow:0 0 0 2px transparent,0 3px 3px rgba(0,0,0,.3);
        box-shadow:0 0 0 2px transparent,0 3px 3px rgba(0,0,0,.3);
    }
    .ios-toggle:checked + .checkbox-label:after{
        /*content:attr(data-on);*/
        left:60px;
        width:36px;
    }

    /* GREEN CHECKBOX
    #checkbox1 + .checkbox-label{
            -webkit-box-shadow:inset 0 0 0 0px rgba(19,191,17,1),0 0 0 2px #dddddd;
            -moz-box-shadow:inset 0 0 0 0px rgba(19,191,17,1),0 0 0 2px #dddddd;
                            box-shadow:inset 0 0 0 0px rgba(19,191,17,1),0 0 0 2px #dddddd;
    }
    #checkbox1:checked + .checkbox-label{
            -webkit-box-shadow:inset 0 0 0 18px rgba(19,191,17,1),0 0 0 2px rgba(19,191,17,1);
            -moz-box-shadow:inset 0 0 0 18px rgba(19,191,17,1),0 0 0 2px rgba(19,191,17,1);
                            box-shadow:inset 0 0 0 18px rgba(19,191,17,1),0 0 0 2px rgba(19,191,17,1);
    }
    #checkbox1:checked + .checkbox-label:after{
            color:rgba(19,191,17,1);
    } */

    /* RED CHECKBOX
    #checkbox2 + .checkbox-label{
            -webkit-box-shadow:inset 0 0 0 0px #f35f42,0 0 0 2px #dddddd;
            -moz-box-shadow:inset 0 0 0 0px #f35f42,0 0 0 2px #dddddd;
                            box-shadow:inset 0 0 0 0px #f35f42,0 0 0 2px #dddddd;
    }
    #checkbox2:checked + .checkbox-label{
            -webkit-box-shadow:inset 0 0 0 20px #f35f42,0 0 0 2px #f35f42;
            -moz-box-shadow:inset 0 0 0 20px #f35f42,0 0 0 2px #f35f42;
                            box-shadow:inset 0 0 0 20px #f35f42,0 0 0 2px #f35f42;
    }
    #checkbox2:checked + .checkbox-label:after{
            color:#f35f42;
    } */

    /* BLUE CHECKBOX
    #checkbox3 + .checkbox-label{
            -webkit-box-shadow:inset 0 0 0 0px #1fc1c8,0 0 0 2px #dddddd;
            -moz-box-shadow:inset 0 0 0 0px #1fc1c8,0 0 0 2px #dddddd;
                            box-shadow:inset 0 0 0 0px #1fc1c8,0 0 0 2px #dddddd;
    }
    #checkbox3:checked + .checkbox-label{
            -webkit-box-shadow:inset 0 0 0 20px #1fc1c8,0 0 0 2px #1fc1c8;
            -moz-box-shadow:inset 0 0 0 20px #1fc1c8,0 0 0 2px #1fc1c8;
                            box-shadow:inset 0 0 0 20px #1fc1c8,0 0 0 2px #1fc1c8;
    }
    #checkbox3:checked + .checkbox-label:after{
            color:#1fc1c8;
    } */

    /* Large desktops and laptops */
    @media (min-width: 1200px) {
        .table-responsive{
            overflow-x: unset;
        }
    }

    /* Landscape tablets and medium desktops */
    @media (min-width: 992px) and (max-width: 1199px) {
        .table-responsive{
            overflow-x: unset;
        }
    }

    /* Portrait tablets and small desktops */
    @media (min-width: 768px) and (max-width: 991px) {
        .table-responsive{
            overflow-x: unset;
        }
    }

    /* Landscape phones and portrait tablets */
    @media (max-width: 767px) {
        .table-responsive{
            overflow-x: unset;
        }
    }

    /* Portrait phones and smaller */
    @media (max-width: 480px) {
        .tab-content > .active{
            padding: 8px!important;
        }  
        .padding-remove-left, .padding-remove-right{
            padding-left:0px!important;
            padding-right:0px!important;    
        }
        .padding-remove-side{
            padding-left: 5px!important;
            padding-right: 5px!important;
        }
        .form-label{
            /*padding-left: 5px!important;*/
        }
        .prs-0{
            padding-left: 0px!important;
            padding-right: 0px!important;    
        }
        .prs-0 > label{
            padding-left: 5px!important;
            padding-right: 5px!important;    
        }
        .prs-0 > div{
            /*padding-left: 5px!important;*/
            /*padding-right: 5px!important;    */
        }
        .prs-0 > input{
            margin-left: 0px!important;
            margin-right: 0px!important;    
        }
        .prs-0 > select{
            margin-left: 5px!important;
            margin-right: 5px!important;    
        }

        .prs-5{
            padding-left: 5px!important;
            padding-right: 5px!important;    
        }
        .prs-5 > label{
            padding-left: 5px!important;
            padding-right: 5px!important;    
        }
        .prs-5 > div{
            /*padding-left: 5px!important;*/
            /*padding-right: 5px!important;    */
        }
        .prs-5 > input{
            margin-left: 5px!important;
            margin-right: 5px!important;    
        }
        .prs-5 > select{
            margin-left: 5px!important;
            margin-right: 5px!important;    
        }    

        .prl-2{
            padding-left: 2.5px!important;
        }
        .prr-2{
            padding-right: 2.5px!important;
        }    
    }       
</style> 
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php #include '_navigation.php'; ?>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                    <div id="div-form-trans" style="display: none;" class="col-md-12 col-sm-12 col-xs-12 padding-remove-side prs-0">
                        <div class="grid simple">
                            <div class="hidden grid-title">
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#grid-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="grid-body">
                                <h5><b>Form <?php echo $title; ?></b></h5>                            
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 padding-remove-side">
                                        <form id="form-master" name="form-master" method="" action="">    
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                <div class="col-lg-12 col-md-12 col-xs-12 padding-remove-side">
                                                    <div class="form-group">                        
                                                        <label class="form-label">Group *</label>
                                                        <select id="user_user_group_id" name="user_user_group_id" class="form-control" disabled readonly>
                                                            <option value="0">-- Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>            
                                                <div class="col-lg-12 col-md-12 col-xs-12 padding-remove-side">                                                                    
                                                    <div class="col-lg-6 col-md-6 col-xs-6 padding-remove-left">
                                                        <div class="form-group">
                                                            <label class="form-label">Username *</label>
                                                            <input id="user_username" name="user_username" type="text" value="" class="form-control" readonly='true'/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-xs-6 padding-remove-side">
                                                        <div class="form-group">
                                                            <label class="form-label">Password *</label>
                                                            <input id="user_password" name="user_password" type="password" value="" class="form-control" readonly='true'/>
                                                        </div>
                                                    </div>    											           
                                                </div>                                                                       
                                            </div>
                                            <div class="col-md-3 col-sm-12 col-xs-12">
                                                <div class="col-lg-12 col-md-12 col-xs-12 padding-remove-side">
                                                    <div class="col-lg-6 col-md-6 col-xs-12 padding-remove-left">
                                                        <div class="form-group">
                                                            <label class="form-label">Telepon *</label>
                                                            <input id="user_phone_1" name="user_phone_1" type="text" value="" class="form-control" readonly='true'/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-xs-12 padding-remove-side prs-0">
                                                        <div class="form-group">
                                                            <label class="form-label">Email</label>
                                                            <input id="user_email_1" name="user_email_1" type="text" value="" class="form-control" readonly='true'/>
                                                        </div>
                                                    </div>      
                                                </div>  
                                                <div class="col-lg-12 col-md-12 col-xs-12 padding-remove-side"> 
                                                    <div class="col-lg-6 col-md-6 col-xs-6 padding-remove-left">
                                                        <div class="form-group">
                                                            <label class="form-label">Warna Interface</label>
                                                            <select id="user_theme" name="user_theme" class="form-control" disabled readonly>
                                                                <?php
                                                                $theme_values = array(
                                                                    'black' => 'Black',
                                                                    'white' => 'White',
                                                                    'blue' => 'Blue',
                                                                    'green' => 'Green',
                                                                    'red' => 'Red',
                                                                    'purple' => 'Purple',
                                                                    'orange' => 'Orange',
                                                                    'black-blue' => 'Black-Blue',
                                                                    'black-white' => 'Black-White',
                                                                );

                                                                foreach ($theme_values as $value => $display_text) {
                                                                    $selected = ($value == $this->input->post('theme')) ? ' selected="selected"' : "";
                                                                    echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-xs-12 padding-remove-side">
                                                    <div class="form-group">
                                                        <label class="form-label">Status</label>
                                                        <select id="user_flag" name="user_flag" class="form-control" disabled readonly>
                                                            <?php
                                                            $status_values = array(
                                                                '1' => 'Aktif (Dapat Login)',
                                                                '0' => 'Nonaktif (Tdk Dapat Login / Matikan Akses)',
                                                            );
                                                            foreach ($status_values as $value => $display_text) {
                                                                echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>                                                                   
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top: 10px;">
                                                <div class="form-group">
                                                    <div class="pull-right">
                                                        <button id="btn-cancel" class="btn btn-warning btn-small" type="reset">
                                                            <i class="fas fa-ban"></i> 
                                                            Cancel
                                                        </button>                                                                  
                                                        <button id="btn-save" class="btn btn-primary btn-small" type="button">
                                                            <i class="fas fa-save"></i>                                 
                                                            Save
                                                        </button> 
                                                    </div>
                                                </div>
                                            </div>
                                        </form>                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                    <div class="grid simple">
                        <div class="grid-body">        
                            <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                                <div class="col-md-6 col-xs-12 col-sm-12" style="padding-left: 0;">
                                    <h5><b>Data <?php echo $title; ?></b></h5>
                                </div>
                                <div class="col-md-6 col-xs-12 col-sm-12 padding-remove-right">
                                    <div class="pull-right">
                                        <button id="btn-new" onClick="" class="btn btn-success btn-small" type="button"
                                                style="display: inline;">
                                            <i class="fas fa-plus"></i>
                                            Buat <?php echo $title; ?> Baru
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side" style="padding-top:8px;">
                                <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 form-group padding-remove-side prs-0">
                                    <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                                        <label class="form-label">Group</label>
                                        <select id="filter_group" name="filter_group" class="form-control">
                                            <option value="0">Semua</option>                 
                                        </select>
                                    </div>
                                </div>     
                                <div class="col-lg-7 col-md-10 col-xs-6 col-sm-6 form-group padding-remove-right">
                                    <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">                                
                                        <label class="form-label">Cari</label>
                                        <input id="filter_search" name="filter_search" type="text" value="" class="form-control" placeholder="Pencarian" />
                                    </div>
                                </div>                                 
                                <div class="col-lg-2 col-md-2 col-xs-6 col-sm-6 form-group padding-remove-right">
                                    <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                                        <label class="form-label">Tampil</label>
                                        <select id="filter_length" name="filter_length" class="form-control">
                                            <option value="10">10 Baris</option>
                                            <option value="25">25 Baris</option>
                                            <option value="50">50 Baris</option>
                                            <option value="100">100 Baris</option>
                                        </select>
                                    </div>
                                </div>                   
                            </div>                      
                            <div class="col-md-12 col-xs-12 col-sm-12 padding-remove-side">
                                <div class="table-responsive">
                                    <table id="table-data" class="table table-bordered" style="width:100%;">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>			
            </div>
            <div class="tab-pane" id="tab2">
            </div>
        </div>
    </div>
</div>