<?php
/*
    @AUTHOR: Joe Witaya
*/ 
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends MY_Controller{

    var $folder_upload = 'uploads/device/';

    function __construct(){
        parent::__construct();
        if(!$this->is_logged_in()){
            //Will Return to Last URL Where session is empty
            $this->session->set_userdata('url_before',base_url(uri_string()));
            redirect(base_url("login/return_url"));
        }           
        $this->load->library('form_validation');                  
        $this->load->helper('form');

        $this->load->model('Aktivitas_model');
        $this->load->model('User_model');       
        $this->load->model('Device_model');               
    }

    function index(){
        $session            = $this->session->userdata();
        $session_branch_id  = !empty($session['user_data']['branch']['id']) ? $session['user_data']['branch']['id'] : null;
        $session_user_id    = !empty($session['user_data']['user_id']) ? $session['user_data']['user_id'] : null;
        $data['session']    = $this->session->userdata();  
        $data['theme'] = $this->User_model->get_user($data['session']['user_data']['user_id']);

        if ($this->input->post()) {    
            $post = $this->input->post();

            $upload_directory       = $this->folder_upload;     
            $upload_path_directory  = FCPATH . $upload_directory;

            $return             = new \stdClass();
            $return->status     = 0;
            $return->message    = '';
            $return->result     = '';      

            $action = !empty($this->input->post('action')) ? $this->input->post('action') : false;
            switch($action){
                case "load":
                    $columns = array(
                        '0' => 'device_number',
                        '1' => 'device_token',
                        // '2' => 'device_session',
                        // '3' => 'group_name'
                    );
                    $limit     = $this->input->post('length');
                    $start     = $this->input->post('start');
                    $order     = $columns[$this->input->post('order')[0]['column']];
                    $dir       = $this->input->post('order')[0]['dir'];
                    $search    = [];
                    if ($this->input->post('search')['value']) {
                        $s = $this->input->post('search')['value'];
                        foreach ($columns as $v) {
                            $search[$v] = $s;
                        }
                    }

                    $params = array();
                    if($session_user_id){
                        $params['device_branch_id'] = $session_branch_id;
                    }
                    /* If Form Mode Transaction CRUD not Master CRUD
                    !empty($this->input->post('date_start')) ? $params['device_date >'] = date('Y-m-d H:i:s', strtotime($this->input->post('date_start').' 23:59:59')) : $params;
                    !empty($this->input->post('date_end')) ? $params['device_date <'] = date('Y-m-d H:i:s', strtotime($this->input->post('date_end').' 23:59:59')) : $params;                
                    */

                    //Default Params for Master CRUD Form
                    // $params['device_id']   = !empty($this->input->post('device_id')) ? $this->input->post('device_id') : $params;
                    // $params['device_name'] = !empty($this->input->post('device_name')) ? $this->input->post('device_name') : $params;                

                    /*
                    if($this->input->post('other_column') && $this->input->post('other_column') > 0) {
                        $params['other_column'] = $this->input->post('other_column');
                    }
                    */    
                    if($this->input->post('media') && $this->input->post('media') !== 'ALL') {
                        $params['device_media'] = $this->input->post('media');
                    }                    
                    $get_count = $this->Device_model->get_all_device_count($params, $search);
                    if($get_count > 0){
                        $datas = $this->Device_model->get_all_device($params, $search, $limit, $start, $order, $dir);
                        $return->status          = 1; 
                        $return->message         = 'Load '.$get_count.' datas'; 
                        $return->result          = $datas;
                    }else{
                        $return->message         = 'Load '.$get_count.' datas'; 
                        $return->result          = array();                
                    }
                    $return->total_records       = $get_count;
                    $return->recordsTotal        = $get_count;
                    $return->recordsFiltered     = $get_count;
                    $return->action              = $action;
                    $return->params              = $params;
                    break;                
                case "create":
                    $next = true;
                    $device_number = !empty($this->input->post('device_number')) ? $this->input->post('device_number') : null;
                    $device_label = !empty($this->input->post('device_label')) ? $this->input->post('device_label') : null;
                    // $device_auth = !empty($this->input->post('device_auth')) ? $this->input->post('device_auth') : null;
                    $device_status = !empty($this->input->post('device_flag')) ? $this->input->post('device_flag') : 1;
                    // $device_group = !empty($this->input->post('device_group')) ? $this->input->post('device_group') : 0;
                    $device_media = !empty($this->input->post('device_media')) ? $this->input->post('device_media') : null;
                    $device_email = !empty($this->input->post('device_mail_email')) ? $this->input->post('device_mail_email') : null;
                    
                    $device_number = $this->contact_number($device_number);

                    $params = array(
                        'device_number' => $device_number,
                        'device_label' => $device_label,
                        // 'device_token' => $this->random_token(),
                        'device_flag' => $device_status,
                        'device_date_created' => date("YmdHis"),
                        // 'device_group_id' => $device_group
                        'device_branch_id' => !empty($post['device_branch_id']) ? intval($post['device_branch_id']) : $session_branch_id,
                        'device_media' => !empty($post['device_media']) ? $post['device_media'] : null,
                        'device_mail_host' => !empty($post['device_mail_host']) ? $post['device_mail_host'] : null,
                        'device_mail_port' => !empty($post['device_mail_port']) ? $post['device_mail_port'] : null,
                        'device_mail_email' => !empty($post['device_mail_email']) ? $post['device_mail_email'] : null,
                        'device_mail_password' => !empty($post['device_mail_password']) ? $post['device_mail_password'] : null,
                        'device_mail_from_alias' => !empty($post['device_mail_from_alias']) ? $post['device_mail_from_alias'] : null,
                        'device_mail_reply_alias' => !empty($post['device_mail_reply_alias']) ? $post['device_mail_reply_alias'] : null,
                        'device_mail_label_alias' => !empty($post['device_mail_label_alias']) ? $post['device_mail_label_alias'] : null                        
                    );
                    // var_dump($params);die;
                    //Check Data Exist
                    if($device_media=='WhatsApp'){
                        $params_check = array(
                            'device_number' => $device_number
                        );
                    }else if($device_media=='Email'){
                        $params_check = array(
                            'device_mail_email' => $device_email
                        );
                    }                    
                    $check_exists = $this->Device_model->check_data_exist($params_check);
                    if($check_exists==false){

                        if($device_media=='WhatsApp'){
                            $params_register = array(
                                'device_branch_id' => $session_branch_id,
                                'device_media' => 'WhatsApp'
                            );
                            $get_register = $this->Device_model->get_all_device_count($params_register);
                            if($get_register > 0){
                                $next=false;
                                $return->message = 'Nomor tidak dapat didaftarkan, maksimal 1';
                            }
                        }

                        if($next){
                            $set_data=$this->Device_model->add_device($params);
                            if($set_data==true){
                                /* Start Activity */
                                /*
                                $params = array(
                                    'activity_user_id' => $session['user_data']['user_id'],
                                    'activity_action' => 2,
                                    'activity_table' => 'device',
                                    'activity_table_id' => $set_data,                            
                                    'activity_text_1' => strtoupper($data['kode']),
                                    'activity_text_2' => ucwords(strtolower($data['nama'])),                        
                                    'activity_date_created' => date('YmdHis'),
                                    'activity_flag' => 1
                                );
                                $this->save_activity($params);    
                                */
                                /* End Activity */   
                                $get_data = $this->Device_model->get_device($set_data);
                                if($device_media=='WhatsApp'){
                                    // $opr = $this->device_curl('register',$get_data);
                                    // $opr = json_encode($opr);
                                    // $return->result = $opr->result;
                                    // $return->status =$opr->status;
                                    // $return->message= $opr->message;
                                    // $return->result= array(
                                    //     'id' => $set_data,
                                    //     'number' => $device_number
                                    // ); 
                                    // if($return->status == 1){
                                        // $this->Device_model->update_device($set_data,array('device_token'=>$opr['result']['device_auth']));
                                    // }
                                    $return->result = $get_data;
                                    $return->status = 1;
                                    $return->message= 'Berhasil menambahkan';                                         
                                }else if($device_media=='Email'){
                                    $return->result = $get_data;
                                    $return->status = 1;
                                    $return->message= 'Berhasil menambahkan '.$device_email;                            
                                }
                            }
                        }
                    }else{
                        $return->message='Data sudah ada';
                    }
                    $return->action=$action;
                    break;
                case "read":
                    $device_id = !empty($this->input->post('id')) ? $this->input->post('id') : null;
                    if(intval($device_id) > 0){
                        $datas = $this->Device_model->get_device($device_id);
                        if($datas==true){
                            /* Activity */
                            /*
                            $params = array(
                                'actvity_user_id' => $session['user_data']['user_id'],
                                'actvity_action' => 3,
                                'actvity_table' => 'devices',
                                'actvity_table_id' => $device_id,
                                'actvity_text_1' => '',
                                'actvity_text_2' => ucwords(strtolower($datas['username'])),
                                'actvity_date_created' => date('YmdHis'),
                                'actvity_flag' => 0
                            );
                            $this->save_activity($params);                    
                            /* End Activity */
                            $return->status=1;
                            $return->message='Berhasil mendapatkan data';
                            $return->result=$datas;
                        }else{
                            $message = 'Data tidak ditemukan';
                        }
                    }else{
                        $return->message='Data tidak ditemukan ';
                    }
                    $return->action=$action;                            
                    break;
                case "update":
                    $device_id = !empty($this->input->post('id')) ? $this->input->post('id') : null;
                    $device_number = !empty($this->input->post('device_number')) ? $this->input->post('device_number') : null;
                    // $device_auth = !empty($this->input->post('device_auth')) ? $this->input->post('device_auth') : null;
                    $device_label = !empty($this->input->post('device_label')) ? $this->input->post('device_label') : null;
                    $device_status = !empty($this->input->post('device_flag')) ? $this->input->post('device_flag') : 1;
                    // $device_group = !empty($this->input->post('device_group')) ? $this->input->post('device_group') : 0;
                    $device_media = !empty($this->input->post('device_media')) ? $this->input->post('device_media') : null;
                    $device_email = !empty($this->input->post('device_mail_email')) ? $this->input->post('device_mail_email') : null;

                    $params = array(
                        'device_number' => $device_number,
                        'device_label' => $device_label,
                        // 'device_auth' => $device_auth,
                        'device_date_updated' => date("YmdHis"),
                        'device_flag' => $device_status,
                        // 'device_group_id' => $device_group
                        // 'device_branch_id' => !empty($post['device_branch_id']) ? intval($post['device_branch_id']) : null,
                        'device_media' => !empty($post['device_media']) ? $post['device_media'] : null,
                        'device_mail_host' => !empty($post['device_mail_host']) ? $post['device_mail_host'] : null,
                        'device_mail_port' => !empty($post['device_mail_port']) ? $post['device_mail_port'] : null,
                        'device_mail_email' => !empty($post['device_mail_email']) ? $post['device_mail_email'] : null,
                        'device_mail_password' => !empty($post['device_mail_password']) ? $post['device_mail_password'] : null,
                        'device_mail_from_alias' => !empty($post['device_mail_from_alias']) ? $post['device_mail_from_alias'] : null,
                        'device_mail_reply_alias' => !empty($post['device_mail_reply_alias']) ? $post['device_mail_reply_alias'] : null,
                        'device_mail_label_alias' => !empty($post['device_mail_label_alias']) ? $post['device_mail_label_alias'] : null                      
                    );
                    // var_dump($params);die;
                    if(!empty($post['device_mail_password'])){
                        $params['device_mail_password'] = $post['device_mail_password'];
                    }
                    // var_dump($params);die;
                    $set_update=$this->Device_model->update_device($device_id,$params);
                    if($set_update==true){
                        
                        $data = $this->Device_model->get_device($device_id);
                        /* Activity */
                        /*
                        $params = array(
                            'activity_user_id' => $session['user_data']['user_id'],
                            'activity_action' => 4,
                            'activity_table' => 'devices',
                            'activity_table_id' => $id,
                            'activity_text_1' => '',
                            'activity_text_2' => ucwords(strtolower($device_name),
                            'activity_date_created' => date('YmdHis'),
                            'activity_flag' => 0
                        );
                        $this->save_activity($params);
                        */                    
                        /* End Activity */
                        $return->status  = 1;
                        $return->message = 'Berhasil memperbarui ';
                    }else{
                        $return->message='Gagal memperbarui ';
                    }    
                    $return->action=$action;                           
                    break;        
                case "delete":
                    $device_id   = !empty($this->input->post('id')) ? $this->input->post('id') : 0;
                    $device_name = !empty($this->input->post('name')) ? $this->input->post('name') : null;                                
                    $return->message = 'Action belum tersedia';
                    // if(intval($device_id) > 0){
                    //     $get_data=$this->Device_model->get_device($device_id);
                    //     $set_data=$this->Device_model->delete_device($device_id);                
                    //     if($set_data==true){    

                    //         if($get_data['device_media']=='WhatsApp'){
                    //             $opr = $this->device_curl('unregister',$get_data);
                    //             $return->result = $opr['result'];
                    //             $return->status =$opr['status'];
                    //             $return->message= $opr['message'];
                    //         }
                    //         /* Activity */
                    //         /*
                    //         $params = array(
                    //             'activity_user_id' => $session['user_data']['user_id'],
                    //             'activity_action' => $act,
                    //             'activity_table' => 'devices',
                    //             'activity_table_id' => $id,
                    //             'activity_text_1' => '',
                    //             'activity_text_2' => ucwords(strtolower($device_name)),
                    //             'activity_date_created' => date('YmdHis'),
                    //             'activity_flag' => 0
                    //         );
                    //         $this->save_activity($params);                               
                    //         */
                    //         /* End Activity */
                    //         $return->status=1;
                    //         $return->message='Berhasil menghapus'.$device_name;
                    //     }else{
                    //         $return->message='Gagal menghapus '.$device_name;
                    //     } 
                    // }else{
                    //     $return->message='Data tidak ditemukan';
                    // }
                    $return->action=$action;                             
                    break;
                case "set_flag":
                    $device_id = !empty($this->input->post('id')) ? $this->input->post('id') : null;
                    $device_number = !empty($this->input->post('nama')) ? $this->input->post('nama') : null;
                    $device_flag = !empty($this->input->post('flag')) ? $this->input->post('flag') : 0;

                    $params = array(
                        'device_flag' => $device_flag
                    );
                    /*
                    if(!empty($data['password'])){
                        $params['password'] = md5($data['password']);
                    }
                    */
                    // var_dump($params);die;
                    $set_update=$this->Device_model->update_device($device_id,$params);
                    if($set_update==true){
                        
                        $data = $this->Device_model->get_device($device_id);
                        /* Activity */
                        /*
                        $params = array(
                            'activity_user_id' => $session['user_data']['user_id'],
                            'activity_action' => 4,
                            'activity_table' => 'devices',
                            'activity_table_id' => $id,
                            'activity_text_1' => '',
                            'activity_text_2' => ucwords(strtolower($device_name),
                            'activity_date_created' => date('YmdHis'),
                            'activity_flag' => 0
                        );
                        $this->save_activity($params);
                        */                    
                        /* End Activity */
                        $return->status  = 1;
                        $return->message = 'Berhasil memperbarui '.$device_number;
                    }else{
                        $return->message='Gagal memperbarui '.$device_number;
                    }    
                    $return->action=$action;                             
                    break;     
                case "restart": die;
                    $this->form_validation->set_rules('device_id', 'device_id', 'required');                
                    if ($this->form_validation->run() == FALSE){
                        $return->message = validation_errors();
                    }else{
                        $device_id   = !empty($post['device_id']) ? $post['device_id'] : 0;   
                        if(intval($device_id) > 0){        
                            $datas = $this->Device_model->get_device($device_id);
                            if($datas){
                                $return->status = 1;
                                $return->message = 'Berhasil merestart, silahkan check 30 detik lagi';
                                $curl = $this->device_curl('restart',$datas);
                                // $return->result = $curl;    
                                $return->result = $curl['message'];
                            }else{
                                $return->message = 'Data tidak ditemukan';
                            }
                        }else{
                            $return->message='Data tidak ada';
                        }
                    }
                    break;   
                case "request_qr_code": //API Required
                    $this->form_validation->set_rules('device_id', 'device_id', 'required');     
                    $this->form_validation->set_rules('device_id', 'device_number', 'required');                                    
                    if ($this->form_validation->run() == FALSE){
                        $return->message = validation_errors();
                    }else{
                        $device_id   = !empty($post['device_id']) ? $post['device_id'] : 0;   
                        if(intval($device_id) > 0){        
                            $datas = $this->Device_model->get_device($device_id);
                            if($datas){

                                // Live 
                                $curl = $this->device_curl('create-instance',$datas);
                                $return->result = $curl;
                                $return->status = $curl->status; 
                                $return->message = $curl->message;

                                // Demo
                                // $return->status = 1; 
                                // $return->message = 'Scan Kode QR Berikut';
                                // $return->result = array(
                                //     'status' => 1,
                                //     'message' => 'Scan Kode QR Berikut',
                                //     'result' => 'data:image/png;base64,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ihOVqeJEZaqYVKaKk4oTlZOKSWWqmFSmikllUrmp4qRiUpkqTipOVE4qJpWpYlL5QuVEZaqYVKaKSeWNikllqvii4qaHtda65GGttS55WGutS374SOVE5aTiRGWqmCq+UJkqTiomlZOKk4pJZap4Q+ULlS8qJpWTijcqJpWTiknljYoTlS8q3qiYVKaKSeVEZar44mGttS55WGutSx7WWuuSHy6rmFROVKaKmyomlaliUnmjYlKZKiaVqeJEZaqYVKaKN1Smiknli4o3VKaKSeUNlaliUpkqTlSmiknlpGJSOamYVKaKSWWqmFR+08Naa13ysNZalzystdYlP/zHqPymijcqJpWTit+kcqLyhcobKlPFicpUMVWcVEwqU8WkMql8UTGpvKEyVUwqk8pvqrjpYa21LnlYa61LHtZa6xL7gw9UTipuUjmp+EJlqjhRmSomlaliUvmi4kRlqjhRmSr+l6icVJyoTBUnKlPFpHJSMalMFV+oTBVfPKy11iUPa611ycNaa13yw2UVJypTxYnKGypTxYnKVDGpfFHxRsUbKr9J5aRiUpkqJpWTikllqnhDZao4UZkqpopJZaqYKiaVk4o3VE4q/qaHtda65GGttS55WGutS+wPLlKZKk5UTipOVKaKSWWqmFS+qJhUpopJ5Y2KSWWq+EJlqvhNKlPFpDJVTCpTxYnKGxUnKicVX6i8UTGpTBWTylRx08Naa13ysNZalzystdYlP/wylaliqjhReUPljYqbKt6omFQmlaniDZW/SWWq+EJlqjhRmSomlaliUjmpmFQmlZOKSWWqmFROVL5QmSq+eFhrrUse1lrrkoe11rrkh/+4ihOVqWJSeUPlpGJSmSomlROVqeJEZaqYVKaKSWWqeENlqpgqJpXfpPKFylQxqUwqJxVvVEwqU8WJylTxLz2stdYlD2utdcnDWmtd8sNHKlPFicpUMamcVEwVk8pU8UXFFxWTyhcVk8pU8YXKScWJyhsqU8WkMqlMFV9UTCpfqLxRMVVMKlPFTRU3Pay11iUPa611ycNaa11if/CByknFicpU8YbKVPE3qUwVk8pJxaTyX1YxqUwVk8pUMam8UTGpnFRMKicVk8pUMalMFScqU8UbKlPFFypTxRcPa611ycNaa13ysNZal/zwl6lMFScqb6i8UTGpvFExqXxRcaIyVZyoTBVvqJxUTCpTxRsVJypTxYnKScWkMlVMKicqJxWTyhsVX6j8poe11rrkYa21LnlYa61LfvioYlKZVN5QmSpOVKaKE5VJZap4Q+UmlaniROULlTdUpoo3VKaKE5WbKt5Q+aLijYoTlaniv+RhrbUueVhrrUse1lrrkh8+UvlCZaqYVKaKE5Wp4guVk4pJZao4UfmiYlKZKt6omFRuqphUpoqp4g2VE5Wp4qRiUjmpOFG5SeWNit/0sNZalzystdYlD2utdYn9wUUqJxWTylRxovJGxRsqJxVvqPxNFZPKTRWTylRxovJGxRsqJxWTylRxonJScaIyVZyoTBUnKlPFpDJV3PSw1lqXPKy11iUPa611if3BL1L5myp+k8pUMalMFScqJxUnKlPFicpUcaJyUjGpvFFxovJGxRcqU8UXKicVJypvVJyonFR88bDWWpc8rLXWJQ9rrXXJDx+pvFExqUwVX6i8UTGpTBVTxaTyhspUMamcqJyo3FRxU8WkclIxqbyhclIxVZyoTBWTylQxqUwqJxW/qeKmh7XWuuRhrbUueVhrrUt++MtUpooTlZOKk4pJZVJ5Q+Wk4jdVTConFZPKpPI3qbyhMlWcqNykcqLym1TeqDip+E0Pa611ycNaa13ysNZal/zwUcVvqjhRualiUpkqTlROKiaVN1TeUJkqJpWp4g2Vk4oTlaniRGWqeKNiUpkqpopJZaqYVE4qJpWp4g2VSeWNipse1lrrkoe11rrkYa21LvnhI5W/qWKqmFQmlZOKSeUNlS8qflPFFypTxUnFpHJSMamcVJxUnKi8ofJGxaTyhcpU8UbFpDKpTBVfPKy11iUPa611ycNaa13yw2UVN6mcqJxUnKh8UTGpfKEyVXyhMlW8UfGGylQxqUwqN6m8UTGpTBWTyhsVk8obFW9UnFRMKjc9rLXWJQ9rrXXJw1prXfLDL1N5o+KLiknlN6lMFW+o3FRxonKi8kXFpDJVTCpvqEwVJxVvVLyhMlVMKm+ofKEyVUwqv+lhrbUueVhrrUse1lrrkh/+P1cxqbxRMalMFScVk8qk8obKScWk8kXFScWkclJxk8pJxaQyVUwVb1S8ofJGxRsVk8pND2utdcnDWmtd8rDWWpf88D9G5Q2VqeJEZar4QmWqmFSmikllqjhRmSomlZOKE5WTikllUnmjYqr4omJSuanipGJS+b/kYa21LnlYa61LHtZa65IfflnFb6o4UflC5UTlDZUTlS9UpooTlTdU3qg4qZhUpooTlZsqTiomlanib1KZKv6lh7XWuuRhrbUueVhrrUvsDz5Q+ZsqJpWp4kRlqnhDZaqYVE4qJpWp4kTlpOJEZaq4SeWLikllqjhReaNiUvmXKk5UpopJZaqYVE4qvnhYa61LHtZa65KHtda6xP5grbUueFhrrUse1lrrkoe11rrkYa21LnlYa61LHtZa65KHtda65GGttS55WGutSx7WWuuSh7XWuuRhrbUueVhrrUse1lrrkoe11rrk/wHziWjZbSicXQAAAABJRU5ErkJggg=='
                                // );

                                if($return->status == 1){
                                    $par = array(
                                        'device_client' => $curl->set_device_client,
                                        'device_token' => $curl->set_device_token,
                                        'device_uid' => $curl->set_device_uid
                                    );
                                    $this->Device_model->update_device($device_id,$par);
                                }                                
                            }else{
                                $return->message = 'Data tidak ditemukan';
                            }
                        }else{
                            $return->message='Data tidak ada';
                        }
                    }                
                    break;   
                case "check_status": //API Required
                    $this->form_validation->set_rules('device_id', 'device_id', 'required');                
                    if ($this->form_validation->run() == FALSE){
                        $return->message = validation_errors();
                    }else{
                        $device_id   = !empty($post['device_id']) ? $post['device_id'] : 0;   
                        if(intval($device_id) > 0){        
                            $datas = $this->Device_model->get_device($device_id);
                            if($datas){
                                // $return->status = 1;
                                // $return->message = 'Cek status nomor';
                                $curl = $this->device_curl('check-instance',$datas);
                                // var_dump($curl);die;
                                $return->status = $curl->status;
                                $return->result = $curl->result;
                                $return->message = $curl->message;
                                // $return->status = ($curl->status == 1)
                                // if($curl->success==true){
                                    // $return->status  = 1;                                    
                                    // $return->message = 'Device telah tersambung ke server';
                                // }
                            }else{
                                $return->message = 'Data tidak ditemukan';
                            }
                        }else{
                            $return->message='Data tidak ada';
                        }
                    }
                    break;
                                                                            
                default:
                    // Date Now
                    $firstdate = new DateTime('first day of this month');
                    $firstdateofmonth = $firstdate->format('Y-m-d');        
                    $datenow =date("Y-m-d");         
                    $data['first_date'] = $firstdateofmonth;
                    $data['end_date'] = $datenow;      
            }
            echo json_encode($return);
        }else{
            // Date Now
            $firstdate = new DateTime('first day of this month');
            $firstdateofmonth = $firstdate->format('Y-m-d');        
            $datenow =date("Y-m-d");         
            $data['first_date'] = $firstdateofmonth;
            $data['end_date'] = $datenow;

            $data['identity'] = 1;
            $data['title'] = 'Device';
            $data['_view'] = 'layouts/admin/menu/message/device';
            $this->load->view('layouts/admin/index',$data);
            $this->load->view('layouts/admin/menu/message//device_js.php',$data);         
        }
    }
    function random_token(){
        $text = 'qpArnmsBCtDEguFhGHveJfKwdjcMxNOPybaQzRSTkUVWXYZ'.time();
        $txtlen = strlen($text)-1;
        $result = '';
        for($i=1; $i<=30; $i++){
        $result .= $text[mt_rand(0, $txtlen)];}
        return $result;
    }
    function device_curl($action,$params){
        $return = new \stdClass();
        $return->status = 0;
        $return->message = '';
        $return->result = '';

        $whatsapp_vendor    = $this->config->item('whatsapp_vendor');
        $whatsapp_server    = $this->config->item('whatsapp_server');
        $whatsapp_action    = $this->config->item('whatsapp_action');
        $whatsapp_action_v1    = $this->config->item('whatsapp_action_v1');        
        $whatsapp_token     = $this->config->item('whatsapp_token');
        $whatsapp_key       = $this->config->item('whatsapp_key');
        $whatsapp_auth      = $this->config->item('whatsapp_auth');
        $whatsapp_sender    = $this->config->item('whatsapp_sender');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 0);        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);        
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);        
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 0);

        if($action == 'create-instance'){
            $url = $whatsapp_server . $whatsapp_action_v1['create-instance'];
            $form_body = array(
                'id' => $whatsapp_auth,
                'number' => $params['device_number']
            );
        }else if($action == 'delete-instance'){
            $url = $whatsapp_server . $whatsapp_action_v1['delete-instance'];
            $form_body = array(
                'key' => $params['device_client']
            );
        }else if($action == 'check-instance'){
            $url = $whatsapp_server . $whatsapp_action_v1['check-instance'];
            $form_body = array(
                'key' => $params['device_client']
            );
        }                

        curl_setopt($curl, CURLOPT_URL, $url);           
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$params['device_token']."")); 
        curl_setopt($curl, CURLOPT_POSTFIELDS, $form_body);             

        $response = curl_exec($curl); curl_close($curl);
        $get_response = json_decode($response,true);
        // var_dump($get_response);die;

        if($get_response){
            $return->status = 1;
            $return->message = $get_response['message'];

            if($action=='create-instance'){
                $return->result = $get_response['data']['qr'];  
                $return->set_device_client = base64_encode('{"uid":"'.$whatsapp_auth.'","client_id":"'.$params['device_number'].'"}');      
                $return->set_device_token = $whatsapp_token;    
                $return->set_device_number = $params['device_number'];
                $return->set_device_uid = $whatsapp_auth;
            }else{
                $return->status = ($get_response['success'] == true) ? 1 : 0;
                // $return->result = $get_response['data'];
                // $return->message = $get_response['message'];                
            }
        }else{
            $return->result = null;
        }
        
        return $return;
        // return $get_response;
    }    
    function contact_number($contact_phone){ //Contact 0 / +62 to safe
        $contact_phone = str_replace("'","",$contact_phone); //Remove ' if excel format    
        $contact_phone = str_replace('+','',str_replace('-','',$contact_phone)); //Remove + and -
        $contact_phone = ltrim(rtrim(trim($contact_phone))); //Remove space
        $contact_phone = str_replace(' ','',$contact_phone);
        $contact_phone_check = substr($contact_phone,0,1); // First char is 0
        if($contact_phone_check == 0){
            $contact_phone = '62'.substr($contact_phone,1,15); //To 62 81213123
        }else{
            $contact_phone = $contact_phone; //
        }
        return $contact_phone;        
    }    
    function test(){
        $params = [
            'device_number' => '628989900148'
        ];
        $r = $this->device_curl('register',$params);
        echo json_encode($r);
    }     
    function blowfish_test(){
        $pass_db = '$2a$07$nxeWkI5q8eVTA4o6Q4TXrOU8YM/G/Lb6N8fKANR5PMJ5hJWzD0Thy';
        $pass_input = 'masterjoe00';
        echo $this->blowfish_matching($pass_input,$pass_db);
        // echo "\r\n".crypt($pass_input,'$2a$09$taeplfnantesrrimxgosal$');
        echo $this->blowfish_create($pass_input);
    }

    function blowfish_matching($pass_input,$pass_from_db){
        if(crypt($pass_input, $pass_from_db) == $pass_from_db) {
            return 1;
        }else{
            return 0;
        }
    }

    function blowfish_create($input, $rounds = 7){
        $salt = "";
        $salt_chars = array_merge(range('A','Z'), range('a','z'), range(0,9));
        for($i=0; $i < 22; $i++) {
            $salt .= $salt_chars[array_rand($salt_chars)];
        }
        return crypt($input, sprintf('$2a$%02d$', $rounds) . $salt);
    }

}

?>