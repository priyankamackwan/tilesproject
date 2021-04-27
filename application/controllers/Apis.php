<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
defined('BASEPATH') OR exit('No direct script access allowed');

    class Apis extends CI_Controller
    {
        public $model;
        
        public function __construct() {
                    
            $this->model = "My_model";
            parent::__construct();
            $this->load->model('orders_model', 'orders_model');
            $headers = apache_request_headers();
            $actionName = $this->router->fetch_method();
            $this->db->select('*');
            $this->db->where('value', $headers['Xapi']);
            $q = $this->db->get('x_api_keys');
            $apiKeyData = $q->result_array();
            if (count($apiKeyData) == 0) {
                $response['status'] = 'failure';
                $response['message'] = 'API Key is not matching';
                // Returning back the response in JSON
                echo json_encode($response);
                exit();
            }
                    
        if ($actionName == 'refreshToken')
        {
                        $this->user_id = $headers['Userid'];
        }
        elseif ($actionName != 'userLogin' && $actionName != 'userRegister' && $actionName != 'forgotpassword') 
        {
            if ((isset($headers['Userid']) && (!empty($headers['Userid']))) && (isset($headers['Firebasetoken']) && (!empty($headers['Firebasetoken'])))) 
            {
                        $this->db->select('*');
                        $this->db->where('user_id', $headers['Userid']);
                        $this->db->where('firebase_token', $headers['Firebasetoken']);
                        $this->db->where('login_status', 1);
                        $q = $this->db->get('user_login_details');
                        $userLoginData = $q->result_array();
                if (count($userLoginData) == 0) 
                {
                            $response['status'] = 'failure';
                            $response['message'] = 'Wrong authentication parameters used';
                            // Returning back the response in JSON
                            echo json_encode($response);
                            exit();
                        }
                        $this->user_id = $headers['Userid'];
                        $this->firebase_token = $headers['Firebasetoken'];
            } 
            else 
            {
                            $response['status'] = 'failure';
                            $response['message'] = 'Please provide proper headers';
                            // Returning back the response in JSON
                            echo json_encode($response);
                            exit();
                        }
        } 
        else 
        {
            if ($actionName != 'forgotpassword') 
            {
                if(isset($headers['Firebasetoken']) && (!empty($headers['Firebasetoken']))) 
                {

                                $this->firebase_token = $headers['Firebasetoken'];
                } 
                else 
                {
                                  $response['status'] = 'failure';
                                $response['message'] = 'Please provide proper headers';
                                // Returning back the response in JSON
                                echo json_encode($response);
                                exit();
                            }
                        }
                         
                    }
        }
                
        public function userRegister() {
                    $model = $this->model;
                    $data = $_POST;
                        
        if ((isset($data['device_id']) && (!empty($data['device_id']))) && (isset($data['device_type']) && (!empty($data['device_type']))) && (isset($data['phone_no']) && (!empty($data['phone_no']))) && (isset($data['company_name']) && (!empty($data['company_name']))) && (isset($data['company_address']) && (!empty($data['company_address']))) && (isset($data['contact_person_name']) && (!empty($data['contact_person_name']))) && (isset($data['vat_number']) && (!empty($data['vat_number']))) && (isset($data['email']) && (!empty($data['email']))) && (isset($data['password']))) 
        {

                        // Checking Email exist in our application
                        
                        $this->db->where('email',$data['email']);
                     
                        $users = $this->db->get('users');
                        $checkEmailExist = $users->result_array();
                        
                        $this->db->where('email',$data['email']);
                        $this->db->where('is_deleted', 0);
                        $adminUsers = $this->db->get('admin_users');
                        $checkAdminEmailExist = $users->result_array();

            if (count($checkEmailExist)<1 && count($checkAdminEmailExist)<1) 
            {
                            $userData = array(
                                    'company_name' => $data['company_name'],
                                    'company_address' => $data['company_address'],
                                    'contact_person_name' => $data['contact_person_name'],
                                    'vat_number' => $data['vat_number'],
                                    'email' => $data['email'],
                                    'phone_no' => $data['phone_no'],
                                    'password' => md5($data['password']),
                                    'created' => date('Y-m-d h:i:s'),
                            );

                            $this->$model->insert('users',$userData);
                            $lastInsertedUserId = $this->db->insert_id();
                            
                            // Adding data in user login details table
                            
                            $userLoginData = array(
                                    'user_id' => $lastInsertedUserId,
                                    'firebase_token' => $this->firebase_token,
                                    'login_status' => 1,
                                    'device_type' => $data['device_type'],
                                    'device_id' => $data['device_id'],
                                    'role' => 1,
                                    'created' => date('Y-m-d h:i:s'),
                            );
                            $this->$model->insert('user_login_details',$userLoginData); 
                            
                            $this->db->select('*');
                            $this->db->where('login_status', 1);
                            $this->db->where('role', 2);
                            $q = $this->db->get('user_login_details');
                            $adminUserdata = $q->result_array();
                            
                            $companyName = $data['company_name'];
                            $companyAdd = $data['company_address'];
                            $contactPersonName = $data['contact_person_name'];
                            $vatNumber = $data['vat_number'];
                            $email = $data['email'];
                            $phone_no = $data['phone_no'];
                            $created = date('Y-m-d h:i:s');
                 
                         //   echo '<pre>';
                          //  print_r($adminUserdata); exit;
                
                if ($adminUserdata) 
                {
                    for ($k=0;$k<count($adminUserdata);$k++) 
                    {
                        if ($adminUserdata[$k]['device_type'] == 1) 
                        {
                                        // For Android
                                           $notificationArray = array(
                                            "notification_type" => 1,
                                            "company_name" => $companyName,
                                            "contact_person_name" => $contactPersonName,
                                            "company_add" => $companyAdd,
                                            "email" => $email,
                                            "vat_number" => $vatNumber,
                                            "phone_no" => $phone_no,
                                            "created" => $created
                                        );
                                        $arr = array(
            "registration_ids" => array($adminUserdata[$k]['firebase_token']),
            "data" => [
                "body" => $notificationArray,
                "title" => "New User Registered",
                // "icon" => "ic_launcher"
            ],
            // "data" => json_encode(array())
        );
        $data = json_encode($arr);
                            $this->android_ios_notification($data,"Android");
        /*//FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        //echo "----".$result;
        if ($result === FALSE) {
            //die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);*/
                                    } else {
                                        // For IOS
                                        $notificationArray = array(
                            "notification_type" => 2,
                            "company_name" => $companyName,
                            "contact_person_name" => $contactPersonName,
                            "company_add" => $companyAdd,
                            "email" => $email,
                            "vat_number" => $vatNumber,
                            "phone_no" => $phone_no,
                            "created" => $created,
                            );
                            /*      Old array
                            $arr = array(
                                    "registration_ids" => array($adminUserdata[$k]['firebase_token']),
                                    "notification" => [
                                    "body" => $notificationArray,
                                    "title" => "New User Registered",
                                    'priority' => 'high',
                                    // "icon" => "ic_launcher"
                                    ],
                                    // "data" => json_encode(array())
                            );
                            */
                            //new array
                            $arr = array(
                                "registration_ids" => array($adminUserdata[$k]['firebase_token']),
                                
                                "notification" => [
                                // "body" => $notificationArray,
                                    "body" => "",
                                //"title" => "New User Registered",
                                 "title" => "'".$contactPersonName."' has registered now from the Company ‘'".$companyName."'’. Please click to accept/reject the request.",
                                ],
                                "priority"=> "high",
                                "content_available"=> true,
                                "mutable_content"=> true,
                                "data" => $notificationArray
                            );
                            $data = json_encode($arr);
                           $this->android_ios_notification($data,"Ios");
                                    }
                                }
                            }
                            
                            $userData['id'] = $lastInsertedUserId;
                            $response['status'] = 'success';
                            $response['data'] = $userData;
            } 
            else 
            {
                            // If email al'Error']['codeready exists
                            $response['status'] = 'failure';
                            $response['message'] = 'This email already exists. Please provide new email Id or login with existing one';
                        }
        } 
        else 
        {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide company name, company address, contact person name, contact person address, vat number, email and password';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function userLogin() {
                    
                    $model = $this->model;
                    $data = $_POST;
        if ((isset($data['device_id']) && (!empty($data['device_id']))) && (isset($data['device_type']) && (!empty($data['device_type']))) && (isset($data['email']) && (!empty($data['email']))) && (isset($data['password']) && (!empty($data['password']))))
        {
                            
                        $this->db->select('*');
                        $this->db->where('email', $data['email']);
                        $this->db->where('password', md5($data['password']));
                        $q = $this->db->get('users');
                        $userdata = $q->result_array();
            
            if ($userdata) 
            {
                if ($userdata[0]['is_deleted'] == 1) 
                {
                                $response['status'] = 'failure';
                                $response['message'] = 'Your account is deleted. Please contact Administrator.';
                } 
                elseif($userdata[0]['status'] == 0) 
                {
                    $response['status'] = 'failure';
                    $response['message'] = 'Your account is inactivated. Please contact Administrator.';
                } else {
                                //check if user has login details. if exists then remove old and update with new one

                                // $this->db->select('*');
                                // $this->db->where('user_id', $userdata[0]['id']);
                                // $exist_query= $this->db->get('user_login_details');
                                // $exist_row=$exist_query->num_rows();
                                // if($exist_row > 0)
                                // {
                                //     $userData = array(
                                //         'firebase_token' => $this->firebase_token,
                                //         'device_type' => $data['device_type'],
                                //         'device_id' => $data['device_id'],
                                //         'login_status' => 1,
                                //         'role' => 1,
                                //         'created' => date('Y-m-d h:i:s'),
                                //     );

                                //     $this->db->where('user_id',$userdata[0]['id']);
                                //     $this->db->update('user_login_details',$userData);
                                // }
                                // else
                                // {
                                    //if not existing login details found then insert new
                                    $userLoginData = array(
                                        'user_id' => $userdata[0]['id'],
                                        'firebase_token' => $this->firebase_token,
                                        'device_type' => $data['device_type'],
                                        'device_id' => $data['device_id'],
                                        'login_status' => 1,
                                        'role' => 1,
                                        'created' => date('Y-m-d h:i:s'),
                                );
                                $this->$model->insert('user_login_details',$userLoginData);
                                // }
                    
                                $response['status'] = 'success';
                                $response['message'] = 'You are successfully logged in.';
                                $response['data']= $userdata[0];
                                $response['role']= 1;
                                // Adding data in user login details table
                            
                            }
                        } else {
                            $this->db->select('*');
                            $this->db->where('email', $data['email']);
                            $this->db->where('password', md5($data['password']));
                            $q = $this->db->get('admin_users');
                            $adminUserData = $q->result_array();
                            
                            if ($adminUserData){
                                if ($adminUserData[0]['is_deleted'] == 1) {
                                    $response['status'] = 'failure';
                                    $response['message'] = 'Your account is deleted. Please contact Administrator.';
                                } elseif($adminUserData[0]['status'] == 0) {
                                    $response['status'] = 'failure';
                                    $response['message'] = 'Your account is inactivated. Please contact Administrator.';
                                } else {
                                    $response['status'] = 'success';
                                    $response['message'] = 'You are successfully logged in.';
                                    $response['data']= $adminUserData[0];
                                    $response['role']= 2;
                                    
                                    // //check ig already login details exists
                                    // $this->db->select('*');
                                    // $this->db->where('user_id', $adminUserData[0]['id']);
                                    // $exist_query= $this->db->get('user_login_details');
                                    // $exist_row=$exist_query->num_rows();
                                    // if($exist_row > 0)
                                    // {
                                    //     $userData = array(
                                    //         'firebase_token' => $this->firebase_token,
                                    //         'device_type' => $data['device_type'],
                                    //         'device_id' => $data['device_id'],
                                    //         'login_status' => 1,
                                    //     //  'role' => 2,
                                    //         'created' => date('Y-m-d h:i:s'),
                                    //     );

                                    //     $this->db->where('user_id',$userdata[0]['id']);
                                    //     $this->db->update('user_login_details',$userData);
                                    // }else{
                                    
                                        $userLoginData = array(
                                            'user_id' => $adminUserData[0]['id'],
                                            'firebase_token' => $this->firebase_token,
                                            'login_status' => 1,
                                            'device_type' => $data['device_type'],
                                            'device_id' => $data['device_id'],
                                            'role' => 2,
                                            'created' => date('Y-m-d h:i:s'),
                                        );
                                        $this->$model->insert('user_login_details',$userLoginData);
                                    // }
                                }
                            } else {
                                // If any of the mandatory parameters are missing
                                $response['status'] = 'failure';
                                $response['message'] = 'Credentials are incorrect';
                            }
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide device_id, device_type, email and password';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function changeUserPassword() {
                    
                    $model = $this->model;
                    $data = $_POST;
                    if ((isset($data['role']) && (!empty($data['role']))) && (isset($data['old_password']) && (!empty($data['old_password']))) && (isset($data['password']) && (!empty($data['password'])))){
                            
                        $this->db->select('*');
                        $this->db->where('id', $this->user_id);
                        $this->db->where('status', 1);
                        $this->db->where('is_deleted', 0);
                        if ($data['role'] == 1) {
                            $q = $this->db->get('users');
                        } else {
                            $q = $this->db->get('admin_users');
                        }
                        $userdata = $q->result_array();
                        if ($userdata) {
                            if ($userdata[0]['password'] != md5($data['old_password'])) {
                                $response['status'] = 'failure';
                                $response['message'] = 'Old password is incorrect';
                            } else {
                                $dataUser['password'] = md5($data['password']);
                                $this->db->set('password', md5($data['password']));
                                $this->db->where('id',$this->user_id);
                                if ($data['role'] == 1) {
                                    $this->db->update('users',$dataUser);
                                } else {
                                    $this->db->update('admin_users',$dataUser);
                                }
                                $response['status'] = 'success';
                                $response['message'] = 'You password changed successfully';
                            }
                        } else {
                            // If any of the mandatory parameters are missing
                            $response['status'] = 'failure';
                            $response['message'] = 'You cannot change password';
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide role, old password and password';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function generateRandomString($length = 10) {
        
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }
                
                public function forgotpassword() {
                    
                    $model = $this->model;
                    $data = $_POST;
                    if ((isset($data['role']) && (!empty($data['role']))) && (isset($data['email']) && (!empty($data['email'])))){
                         
                      
                        $this->db->select('*');
                        $this->db->where('email', $data['email']);
                        $this->db->where('status', 1);
                        $this->db->where('is_deleted', 0);
                        if ($data['role'] == 1) {
                            $q = $this->db->get('users');
                        } else {
                            $q = $this->db->get('admin_users');
                        }
                        $userdata = $q->result_array();
                      //  echo '<pre>';
                        //print_r($userdata); exit;
                        if ($userdata) {
                            
                            $randomPassword = $this->generateRandomString(6);
                            $dataUser['password'] = md5($randomPassword);
                            $this->db->set('password', md5($randomPassword));
                            $this->db->where('id',$userdata[0]['id']);
                            if ($data['role'] == 1) {
                                $this->db->update('users',$dataUser);
                            } else {
                                $this->db->update('admin_users',$dataUser);
                            }
                            $mail = new PHPMailer;
                            $mail->isMail();
                            $mail->setFrom('pnpsales2019@gmail.com', 'Tiles Admin');
                            $mail->Subject = "Password Reset Confirmation";
                            $mail->MsgHTML('Dear '.$userdata[0]['company_name'].',<br/><br/>
                                
There was recently a request to reset the password for your account.<br/>
    If you requested this password reset, please enter this new temporarily created password.<br/><br/>
            New temporary password is "'.$randomPassword.'"<br/><br/>
                
You can change this password from mobile application after you are logged in once.<br/><br/>


    Best Regards,<br/>
    Customer Service<br/>
    www.pnptiles.com<br/><br/>
        
        This is an automatically generated mail.Please do not reply.If you have any queries regarding your account, please contact us.
');
                             if ($data['role'] == 1) {
                                $mail->addAddress($data['email'], $userdata[0]['company_name']);
                            } else {
                                $mail->addAddress($data['email'], $userdata[0]['first_name']);
                            }
                           
                            $mail->send();
                           if (!$mail->send()) {

                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                            } else {
                                echo 'Message sent!';
                            }
                            
                            $response['status'] = 'success';
                           // $response['random'] = $randomPassword;
                            $response['message'] = 'New password sent successfully';
                            
                        } else {
                            // If any of the mandatory parameters are missing
                            $response['status'] = 'failure';
                            $response['message'] = 'No such email exists';
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide email';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                    
                }
                
                
                public function getCategories() {
                           
                    $this->db->select('*');
                    $this->db->where('status', 1);
                    $this->db->where('is_deleted', 0);
                    $q = $this->db->get('categories');
                    $categories = $q->result_array();
                    
                    if ($categories) {
                        for ($k=0;$k<count($categories);$k++) {
                            if (!empty($categories[$k]['image'])) {
                                $categories[$k]['image']= base_url().'assets/uploads/'.$categories[$k]['image'];
                            } else {
                                $categories[$k]['image']= '';
                            }
                        }
                        $response['status'] = 'success';
                        $response['data']= $categories;
                    } else {
                          // If any of the mandatory parameters are missing
                          $response['status'] = 'success';
                        $response['message'] = 'No Categories found';
                    }

                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                
                public function getProducts() {
                   
                    $data = $_POST;
                    if ((isset($data['cat_id']) && (!empty($data['cat_id'])))) {
                      //totalPurchaseExpense from history table
                            $this->db->select('u.*,AVG(ph.purchase_rate) as totalPurchaseExpense, sum(ph.quantity_per_unit) as quantity_per_unit');
                            $this->db->from('product_categories as s');
                            $this->db->where('u.is_deleted =', 0);
                            $this->db->where('u.status =', 1);
                            $this->db->where('s.cat_id', $data['cat_id']);
                            $this->db->or_where('ph.product_id',null);
                            $this->db->group_by('u.id');
                            $this->db->join('products as u', 'u.id = s.product_id');
                            //for purchase price
                            $this->db->join('product_purchase_history as ph', 'ph.product_id = s.product_id');
                            $productData = $this->db->get()->result_array();
                        
                    } else {
                        $this->db->select('products.*,AVG(ph.purchase_rate) as totalPurchaseExpense, sum(ph.quantity_per_unit) as quantity_per_unit');
                        $this->db->where('status', 1);
                        $this->db->where('is_deleted', 0);
                        $this->db->or_where('ph.product_id',null);
                        $this->db->group_by('products.id');
                        //for purchase price
                        $this->db->join('product_purchase_history as ph', 'ph.product_id = products.id');
                        $q = $this->db->get('products');
                        $productData = $q->result_array();
                    }
                    // echo $this->db->last_query();die();
                      $productData = array_map("unserialize", array_unique(array_map("serialize", $productData)));
                            $productData = array_values($productData);
                             //  echo '<pre>';
                         // print_r($productData); exit;
                     if ($productData) {
                         
                            for($i=0;$i<count($productData);$i++) {
                 
                             
                               $categoryString = '';
                               $img= $productData[$i]['image'];
                                $productData[$i]['image']= base_url().'assets/uploads/'.$img;
                                $productData[$i]['thumbnail']= base_url().'assets/uploads/small/'.$img;
                                if ($productData[$i]['unit'] == 1) {
                                    $productData[$i]['unit'] = 'CTN';
                                }
                                if ($productData[$i]['unit'] == 2) {
                                    $productData[$i]['unit'] = 'SQM';
                                }
                                if ($productData[$i]['unit'] == 3) {
                                    $productData[$i]['unit'] = 'PCS';
                                }
                                if ($productData[$i]['unit'] == 4) {
                                    $productData[$i]['unit'] = 'SET';
                                }
                                $this->db->select('s.*');
                                $this->db->from('product_categories as s');
                                $this->db->where('c.is_deleted =', 0);
                                $this->db->where('c.status =', 1);
                                $this->db->where('s.product_id', $productData[$i]['id']);
                                $this->db->join('categories as c', 'c.id = s.cat_id');
                                $categoryData = $this->db->get()->result_array();
                                $categoryName= array();
                                for($m=0;$m<count($categoryData);$m++) {
                                        
                                        $this->db->select('name');
                                        $this->db->where('status', 1);
                                        $this->db->where('is_deleted', 0);
                                        $this->db->where('id', $categoryData[$m]['cat_id']);
                                        $q = $this->db->get('categories');
                                        $categoryies = $q->result_array();
                                        $categoryName[] = $categoryies[0]['name'];
                                }
                                
                                $categoryName = array_values(array_unique($categoryName));
                             
                                $categoryString = implode(',',$categoryName);
                                // $productData[$i]['purchase_price']= $productData[$i]['purchase_expense'];
                                //avreage gfrom history table
                                $productData[$i]['purchase_price']=$productData[$i]['totalPurchaseExpense'];
                                // unset($productData[$i]['purchase_expense']);
                                unset($productData[$i]['totalPurchaseExpense']);
                                $productData[$i]['purchase_price']=0;
                                
                                $productData[$i]['categories_name']= $categoryString;
                                
                            }
               
                            $response['status'] = 'success';
                            $response['data'] = $productData;
                        } else {
                            $response['status'] = 'success';
                            $response['message'] = 'No products found';
                        }
               
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                    
                }
                
                public function getProductDetail() {
                    
                    $data = $_POST;
                    if ((isset($data['product_id']) && (!empty($data['product_id']))) ) {
                        
                        $this->db->select('products.*,AVG(ph.purchase_rate) as totalPurchaseExpense, sum(ph.quantity_per_unit) as quantity_per_unit');
                        $this->db->where('status', 1);
                        $this->db->where('is_deleted', 0);
                        $this->db->where('products.id', $data['product_id']);
                        $this->db->or_where('ph.product_id',null);
                        $this->db->group_by('products.id');
                        //for purchase price
                        $this->db->join('product_purchase_history as ph', 'ph.product_id = products.id');
                        $q = $this->db->get('products');
                        $productData = $q->result_array();
               
                        if ($productData) {
                            $img= $productData[0]['image'];
                            $productData[0]['image']= base_url().'assets/uploads/'.$img;
                            $productData[0]['thumbnail']= base_url().'assets/uploads/small/'.$img;
                            if ($productData[0]['unit'] == 1) {
                                    $productData[0]['unit'] = 'CTN';
                                }
                                if ($productData[0]['unit'] == 2) {
                                    $productData[0]['unit'] = 'SQM';
                                }
                                if ($productData[0]['unit'] == 3) {
                                    $productData[0]['unit'] = 'PCS';
                                }
                                if ($productData[0]['unit'] == 4) {
                                    $productData[0]['unit'] = 'SET';
                                }
                                
                                   $this->db->select('s.*');
                                $this->db->from('product_categories as s');
                                $this->db->where('c.is_deleted =', 0);
                                $this->db->where('c.status =', 1);
                                $this->db->where('s.product_id', $data['product_id']);
                                $this->db->join('categories as c', 'c.id = s.cat_id');
                                $categoryData = $this->db->get()->result_array();
                                
                                     $categoryName= array();
                                for($m=0;$m<count($categoryData);$m++) {
                                        
                                        $this->db->select('name');
                                        $this->db->where('status', 1);
                                        $this->db->where('is_deleted', 0);
                                        $this->db->where('id', $categoryData[$m]['cat_id']);
                                        $q = $this->db->get('categories');
                                        $categoryies = $q->result_array();
                                        $categoryName[] = $categoryies[0]['name'];
                                }
                                
                                $categoryName = array_values(array_unique($categoryName));
                             
                                $categoryString = implode(',',$categoryName);
                                     // $productData[0]['purchase_price']= $productData[0]['purchase_expense'];
                                $productData[0]['purchase_price']= $productData[0]['totalPurchaseExpense'];

                                // unset($productData[0]['purchase_expense']);
                                unset($productData[0]['totalPurchaseExpense']);
                                $productData[0]['purchase_price']=0;
                                $productData[0]['categories_name']= $categoryString;
                                $response['status'] = 'success';
                            $response['data'] = $productData;
                        } else {
                            $response['status'] = 'failure';
                            $response['message'] = 'Product is either deleted or supended';
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide product id';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function editProfile() {
                    
                    $data = $_POST;
                    if ((isset($data['phone_no']) && (!empty($data['phone_no']))) && (isset($data['company_name']) && (!empty($data['company_name']))) && (isset($data['company_address']) && (!empty($data['company_address']))) && (isset($data['contact_person_name']) && (!empty($data['contact_person_name']))) && (isset($data['vat_number']) && (!empty($data['vat_number'])))) {
                            $userData = array(
                                    'company_name' => $data['company_name'],
                                    'company_address' => $data['company_address'],
                                    'contact_person_name' => $data['contact_person_name'],
                                    'vat_number' => $data['vat_number'],
                                    'phone_no' => $data['phone_no'],
                                    'modified' => date('Y-m-d h:i:s'),
                            );
                            $this->db->where('id',$this->user_id);
                            $this->db->update('users',$userData);
                            $response['status'] = 'success';
                            $response['message'] = 'User updated successfully';
                 
                    } else {
                
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide company name, company address, contact person name, Phone no, vat number, and email';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function addOrder() {

                    $model = $this->model;
                    $orderData = array();
                    $data = $_POST;
                  
                    if ((isset($data['product_id']) && (!empty($data['product_id']))) && (isset($data['mark']) && (!empty($data['mark']))) && (isset($data['location']) && (!empty($data['location']))) && (isset($data['cargo_number']) && (!empty($data['cargo_number']))) && (isset($data['cargo']) && (!empty($data['cargo']))) && (isset($data['tax']) && (!empty($data['tax']))) && (isset($data['total_price']) && (!empty($data['total_price'])))) {

                        
                        
                        //order for particular user
                        $orderUserId=$this->user_id;
                            
                        if(!empty($data['placed_by']) && isset($data['placed_by'])) // placed by is set or not
                        {
                            $placed_by=trim($data['placed_by']);
                            $placed_by=strtolower($placed_by);
                            if($placed_by=='admin'){
                                $orderUserId=trim($data['customer_id']);
                            }
                        }
                        else
                        {
                            $placed_by="customer";
                        }


                        if(!empty($data['customer_id']) && isset($data['customer_id'])) // customer id is set or not
                        {
                            $customer_id=trim($data['customer_id']);
                        }
                        else
                        {
                            $customer_id="0";
                        }


                        if(!empty($data['customer_lpo']) && isset($data['customer_lpo'])) // customer lpo is set or not
                        {
                            $customer_lpo=trim($data['customer_lpo']);
                        }
                        else
                        {
                            $customer_lpo="";
                        }


                    $customercheck=$this->db->select('id')->from('users')->where('id',$customer_id)->where('status',1)->get()->num_rows();

                    if($placed_by=="admin" && $customercheck=="0") // if order is placed by admin then need to check customer is exist or not and status
                    {
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide customer id who is exist and active';
                        echo json_encode($response);
                        exit();
                    }
                      
                        $orderProductArray = json_decode($data['product_id'], true);
                        
                        //$orderProductArray = $this->db->get("products")->result_array();
                        // Checking Email exist in our application
                        
                        $this->db->select('id');
                        
                       
                            $q = $this->db->get('orders');
                            
                            $orderLast = $q->result_array();

                            if(count($orderLast) == 0){
                                $newOrder = invoiceincrement;
                            }else{
                                $newOrder = end($orderLast)['id'] + 1;
                            }
                        
                         if (date('m') <= 3) {//Upto June 2014-2015
                            $financial_year = (date('y')-1) . '-' . date('y');
                        } else {//After June 2015-2016
                            $financial_year = date('y') . '-' . (date('y') + 1);
                        }

                         $lpo = 'LPO/'.$newOrder.'/'.$financial_year;
                         $do = 'DO/'.$newOrder.'/'.$financial_year;
                         $invoice = 'Invoice/'.$newOrder.'/'.$financial_year;
                        
                        if($placed_by=='admin')
                        {
                            $orderData = array(
                                    'user_id' => $customer_id,
                                    'lpo_no' => $lpo,
                                    'do_no' => $do,
                                    'invoice_no' => $invoice,
                                    'tax' => $data['tax'],
                                    'tax_percentage' => Vat,
                                    'total_price' => $data['total_price'],
                                    'cargo' => $data['cargo'],
                                    'cargo_number' => $data['cargo_number'],
                                    'location' => $data['location'],
                                    'mark' => $data['mark'],
                                    'placed_by'=>$placed_by,
                                    'customer_lpo'=>$customer_lpo,
                                    'admin_id'=>$this->user_id,
                                    'invoice_status' => 0,
                                    'created' => date('Y-m-d h:i:s'),
                            );
                        }
                        else
                        {
                            $orderData = array(
                                    'user_id' => $this->user_id,
                                    'lpo_no' => $lpo,
                                    'do_no' => $do,
                                    'invoice_no' => $invoice, 
                                    'tax' => $data['tax'],
                                    'tax_percentage' => Vat,
                                    'total_price' => $data['total_price'],
                                    'cargo' => $data['cargo'],
                                    'cargo_number' => $data['cargo_number'],
                                    'location' => $data['location'],
                                    'mark' => $data['mark'],
                                    'placed_by'=>$placed_by,
                                    'customer_lpo'=>$customer_lpo,
                                    'invoice_status' => 0,
                                    'created' => date('Y-m-d h:i:s'),
                            );
                        }


                            $this->$model->insert('orders',$orderData);
                            $lastInsertedOrderId = $this->db->insert_id();

                            

                            for($k=0;$k<count($orderProductArray);$k++) {
                                $product_orders= array();

                                
                                if(isset($orderProductArray[$k]['rate']) && !empty($orderProductArray[$k]['rate'])){
                                    $rate = $orderProductArray[$k]['rate'];
                                }else{ // if rate filed is not found so working for old version of application and take walkin_rate as per instruction

                                    $queryrate = $this->db->where('id',$orderUserId)->get('users');
                                    $result = $queryrate->result_array();
                                    if($result[0]['client_type']==1){ // Cash
                                        $productData = $this->db->select('cash_rate')->from('products')->where('id',$orderProductArray[$k]['product_id'])->where('status',1)->where('is_deleted',0)->get()->row();
                                        $rate=$productData->cash_rate;
                                    }elseif($result[0]['client_type']==2){ //  Credit
                                        $productData = $this->db->select('credit_rate')->from('products')->where('id',$orderProductArray[$k]['product_id'])->where('status',1)->where('is_deleted',0)->get()->row();
                                        $rate=$productData->credit_rate;
                                    }elseif($result[0]['client_type']==3){ // Walkin
                                        $productData = $this->db->select('walkin_rate')->from('products')->where('id',$orderProductArray[$k]['product_id'])->where('status',1)->where('is_deleted',0)->get()->row();
                                        $rate=$productData->walkin_rate;
                                    }elseif($result[0]['client_type']==4){  // Flexible Rate
                                        $productData = $this->db->select('flexible_rate')->from('products')->where('id',$orderProductArray[$k]['product_id'])->where('status',1)->where('is_deleted',0)->get()->row();
                                        $rate=$productData->flexible_rate;
                                    }
                                    //$rate = number_format($orderProductArray[$k]['price']/$orderProductArray[$k]['quantity'], 2);
                                }
                               

                                $product_orders = array(
                                    'order_id'  => $lastInsertedOrderId,
                                    'product_id'=> $orderProductArray[$k]['product_id'],
                                    'quantity'  => $orderProductArray[$k]['quantity'],
                                    'price'     => $orderProductArray[$k]['price'],
                                    'rate'      => $rate,
                                    'created'   => date('Y-m-d h:i:s'));
                            
                                $this->$model->insert('order_products', $product_orders);

                                $this->db->select('*');
                                $this->db->where('id', $orderProductArray[$k]['product_id']);
                                $q = $this->db->get('products');
                                $productData = $q->result_array();
                                $oldSoldQuantity = $productData[0]['sold_quantity'];
                                $newSoldQuantity = $oldSoldQuantity + $orderProductArray[$k]['quantity'];
                                $dataUser['sold_quantity'] = $newSoldQuantity;
                                $this->db->set('sold_quantity', $newSoldQuantity);
                                $this->db->where('id',$orderProductArray[$k]['product_id']);
                                $this->db->update('products',$dataUser);
                            }
                            
                        $do_no = $do;

                        $finalDate = date("d-M-Y");
                        //echo $finalDate; exit;
                         $multipleWhere = ['id' =>$orderUserId];
                        $this->db->where($multipleWhere);
                        $userData= $this->db->get("users")->result_array();
                       
                        
                        $multipleWhere = ['order_id' => $lastInsertedOrderId];
                        $this->db->where($multipleWhere);
                        $productOrder = $this->db->get("order_products")->result_array();
                     // echo '<pre>';
                     // print_r($productOrder); exit;
                      $finalOrderData = array();
                      $subTotal = 0;
                      for($k=0;$k<count($productOrder);$k++) {
                        $productIdArray = $productOrder[$k]['product_id'];
                        $multipleWhere2 = ['id' => $productIdArray];
                        $this->db->where($multipleWhere2);
                        $productData= $this->db->get("products")->result_array();
                        
                        $finalOrderData[$k]['description'] = $productData[0]['name'];
                        $finalOrderData[$k]['size'] = $productData[0]['size'];
                        $finalOrderData[$k]['design_no'] = $productData[0]['design_no'];
                        
                        //product price from order products table
                        // $finalOrderData[$k]['rate'] = $productOrder[$k]['price'];
                        $finalOrderData[$k]['rate'] = $productOrder[$k]['rate'];
                        /*
                            if ($userData[0]['client_type'] == 1) {
                            $finalOrderData[$k]['rate'] = $productData[0]['cash_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 2) {
                            $finalOrderData[$k]['rate'] = $productData[0]['credit_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 3) {
                            $finalOrderData[$k]['rate'] = $productData[0]['walkin_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 4) {
                            $finalOrderData[$k]['rate'] = $productData[0]['flexible_rate'];
                        }
                        */
                        if ($productData[0]['unit'] == 1) {
                            $finalOrderData[$k]['unit'] = 'CTN';
                        }
                        if ($productData[0]['unit'] == 2) {
                            $finalOrderData[$k]['unit'] = 'SQM';
                        }
                        if ($productData[0]['unit'] == 3) {
                            $finalOrderData[$k]['unit'] = 'PCS';
                        }
                        if ($productData[0]['unit'] == 4) {
                            $finalOrderData[$k]['unit'] = 'SET';
                        }
                            $finalOrderData[$k]['quanity'] = $productOrder[$k]['quantity'];
                            $finalOrderData[$k]['amount'] = $productOrder[$k]['price'];
                        $subTotal = $subTotal+ $finalOrderData[$k]['amount'];
                      }
                        // $vat = $subTotal* Vat/100;
                        $vat = $orderData['tax'];
                        $address = "Saja'a Industrial Area, Sharjah, U.A.E";
                        $finalTotal = $subTotal+$vat;
                        include 'TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage('P', 'A4');
$html = '<html>
<head>Delivery Note</head>
<body>
<p align="center"><img src = "'.base_url().'image1.png"></p>
<h2><b><p align="center">Delivery Note</p></b></h2>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">D.O. No. : '.$do_no.'</td><td style="width:40%; text-align:right;">Date : '.$finalDate.'</td></tr></table>

<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer : '.$userData[0]['company_name'].'</td><td style="width:40%; text-align:right;">Tel : '.$userData[0]['phone_no'].'</td></tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">LPO No. : '.$lpo.'</td><td style="width:40%; text-align:right;">Invoice No. : '.$invoice.'</td></tr></table>
    <br><br/>';

if(trim($customer_lpo)!="") // if customer lpo field not null then display it'
{
    $html.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer LPO No. : '.$customer_lpo.'</td><td style="width:40%; text-align:right;"></td></tr></table>';
}

$html.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Cargo : '.$data['cargo'].'</td><td style="width:40%; text-align:right;">Cargo Number : '.$data['cargo_number'].'</td></tr></table>
 <table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Location : '.$data['location'].'</td><td style="width:40%; text-align:right;">Mark : '.$data['mark'].'</td></tr></table> 
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">THE FOLLOWING ITEMS HAVE BEEN DELIVERED</td></tr></table>
<table style="width:100%;" border="1"><tr><th style="text-align: center">DESCRIPTION</th><th style="text-align: center">SIZE</th><th style="text-align: center">DESIGN</th><th style="text-align: center">QUANTITY</th><th style="text-align: center">UNIT</th></tr>';
for($p=0;$p<count($finalOrderData);$p++) {
    $html .= '<tr><td style="text-align: center" width="60%">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center" width="10%">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center" width="10%">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center" width="10%">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: center" width="10%">'.$finalOrderData[$p]['unit'].'</td></tr>';
                          }
                          $html .= '<tr><td></td><td></td><td colspan="2"></td><td></td></tr></table>';

$html .= '<table style="width:100%;"><tr><td style="width:60%;">Received the above goods in good condition</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:50%;">Receivers Sign : </td><td style="width:50%; ">Delivered By [Sign] : </td></tr></table> 
<br><br/>
<table style="width:100%;"><tr><td style="width:50%;">Name : </td><td style="width:50%;">Name : </td></tr></table>
<br>
<table style="width:100%;"><tr><td style="width:100%;">Mobile : </td></tr></table>
<br><br/><br><br/><br>
<table style="width:100%;"><tr><td style="text-align:center">Tel: 06-5952061/ Mob: 055-8532631/050-4680842 | '.$address.'</td></tr>
                            <tr><td style="text-align:center">Website: www.pnptiles.com | Email: info@pnptiles.com</td></tr></table>

</body></html>';

$pdf->writeHTML($html, true, false, true, false, '');

$filelocation = FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads';
$filename_do = str_replace('/','_', $do_no).'.pdf';

    $fileNL_do = $filelocation.DIRECTORY_SEPARATOR.$filename_do;
   //echo $fileNL; exit;
$pdf->Output($fileNL_do, 'F');

$pdf1 = new TCPDF();
$pdf1->AddPage('P', 'A4');
$html1 = '<html>
<head>Local Purchase Order</head>
<body>
<h2><b><p align="center">Local Purchase Order</p></b></h2>
<table style="width:100%;"><tr><td style="width:100%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:40%;">From</td><td style="width:60%; text-align:center;">To</td> </tr></table>
<table style="width:100%;"><tr><td style="width:40%;">Buyer : '.$userData[0]['company_name'].'</td><td style="width:60%; text-align:right;">Seller : PNP BUILDING MATERIAL TRADING LLC </td></tr></table>
<table style="width:100%;"><tr><td style="width:40%;">Tel. : '.$userData[0]['phone_no'].'</td><td style="width:60%; text-align:right;">Tel. : +97143531040 / +971558532631</td> </tr></table>
<table style="width:100%;"><tr><td style="width:40%;">LPO : '.$lpo.'</td><td style="width:60%; text-align:right;">Address : INDUSTRIAL AREA 2,<br>
    RAS AL KHOR, PO BOX: 103811 DUBAI-UAE</td> </tr>
    <tr><td style="width:100%; text-align:right;">Email : info@pnptiles.com</td></tr></table>
<br><br/>';

if(trim($customer_lpo)!="") { // if customer lpo is exist then display it.
$html1.='<table style="width:100%;"><tr><td style="width:40%;">LPO : '.$lpo.'</td><td style="width:60%; text-align:right;">Address : INDUSTRIAL AREA 2,</td></tr></table>
<table style="width:100%;"><tr><td style="width:40%;">Customer LPO No. : '.$customer_lpo.'</td><td style="width:60%; text-align:right;">RAS AL KHOR, PO BOX: 103811 DUBAI-UAE</td> </tr>
    <tr><td style="width:100%; text-align:right;">Email : info@pnptiles.com</td></tr></table>
    <br><br/>'; } else {

$html1.='<table style="width:100%;"><tr><td style="width:40%;">LPO : '.$lpo.'</td><td style="width:60%; text-align:right;">Address : INDUSTRIAL AREA 2,<br/>
    RAS AL KHOR, PO BOX: 103811 DUBAI-UAE</td> </tr>
    <tr><td style="width:100%; text-align:right;">Email : info@pnptiles.com</td></tr></table>
    <br><br/>';
}


$html1.='<table style="width:100%;"><tr><td style="width:60%;">Customer VAT # : '.$userData[0]['vat_number'].'</td><td style="width:40%; text-align:right;">VAT ID # : 100580141800003</td> </tr></table>
<br><br/>
<table style="width:100%;" border="1"><tr><th style="text-align: center" width="5%">SR No.</th><th style="text-align: center" width="30%">DESCRIPTION</th><th style="text-align: center" width="10%">SIZE</th><th style="text-align: center" width="10%">DESIGN</th><th style="text-align: center" width="10%">UNIT</th><th style="text-align: center" width="13%">QUANTITY</th><th style="text-align: center" width="10%".>RATE</th><th style="text-align: center" width="12%">AMOUNT</th></tr>';
$count = 0;
for($p=0;$p<count($finalOrderData);$p++) {
    $count++;
    $html1 .= '<tr><td style="text-align: center">'.$count.'</td><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td><td style="text-align: center">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: center">'.$finalOrderData[$p]['rate'].'</td><td style="text-align: center">'.$finalOrderData[$p]['amount'].'</td></tr>';
                                
                          }
                          $html1 .= '<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">SubTotal</td><td>'.$subTotal.'</td></tr>
                                  
                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat '.Vat.'%</td><td>'.$vat.'</td></tr>
                                  
<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Grand Total(AED)</td><td>'.$finalTotal.'</td></tr></table>
    <br><br/>
                                  <table style="width:100%;" border="1"><tr><th style="text-align:center">Terms and Conditions</th></tr>
                                  <tr><td>1) Goods subject to lien of seller till full payment is made by buyer.</td></tr>
                                  <tr><td>2) NO CLAIM for shortage/damage will be entertained after 24 hours of delivery.</td></tr>
                                  <tr><td>3) Payment should be made by cash or A/C payees cheque only in the name of our company.</td></tr>
                                  <tr><td></td></tr>
</table><br><br/>
<table style="width:100%;"><tr><td width="50%";>Buyer Signature:</td><td width="50%";>For PNP Building Materials Trading L.L.C</td></tr></table>
<br><br/><br><br/>';
$html1 .='</body></html>';

$pdf1->writeHTML($html1, true, false, true, false, '');
$filelocation = FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads';
$filename_lpo = str_replace('/','_', $lpo).'.pdf';
    $fileNL_lpo = $filelocation.DIRECTORY_SEPARATOR.$filename_lpo;
   //echo $fileNL; exit;
$pdf1->Output($fileNL_lpo, 'F');

$address = "Saja'a Industrial Area, Sharjah, U.A.E";
$pdf2 = new TCPDF();
$pdf2->AddPage('P', 'A4');
$html2 = '<html>
<head>Tax Invoice</head>
<body>
<p align="center"><img src = "'.base_url().'image1.png"></p>
<h2><b><p align="center" style="margin-top:5px;">Tax Invoice</p></b></h2>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:100%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Invoice No. : '.$invoice.'</td><td style="width:40%; text-align:right;">Customer : '.$userData[0]['company_name'].'</td> </tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Tel. : '.$userData[0]['phone_no'].'</td><td style="width:40%; text-align:right;">LPO : '.$lpo.'</td> </tr></table>';

if(trim($customer_lpo)!="") // if customer lpo field not null then display it.
{
    $html2.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer LPO No. : '.$customer_lpo.'</td><td style="width:40%; text-align:right;"></td></tr></table>';
}

$html2.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer VAT # : '.$userData[0]['vat_number'].'</td><td style="width:40%; text-align:right;">VAT ID # : 100580141800003</td> </tr></table>
<br><br/>
<table style="width:100%;" border="1"><tr><th style="text-align: center" width="5%">SR No.</th><th style="text-align: center" width="35%">DESCRIPTION</th><th style="text-align: center" width="10%">SIZE</th><th style="text-align: center" width="10%">DESIGN</th><th style="text-align: center" width="10%">UNIT</th><th style="text-align: center" width="10%">QUANTITY</th><th style="text-align: center" width="10%">RATE</th><th style="text-align: center" width="10%">AMOUNT</th></tr>';
$count = 0;
for($p=0;$p<count($finalOrderData);$p++) {
    $count++;
    $html2 .= '<tr><td style="text-align: center">'.$count.'</td><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td><td style="text-align: center">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: center">'.$finalOrderData[$p]['rate'].'</td><td style="text-align: center">'.$finalOrderData[$p]['amount'].'</td></tr>';
                          }
                          $html2 .= '<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">SubTotal</td><td>'.$subTotal.'</td></tr>

                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat '.Vat.'%</td><td>'.$vat.'</td></tr>
                                  
<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Grand Total(AED)</td><td>'.$finalTotal.'</td></tr></table>
    <br><br/>
                                  <table style="width:100%;" border="1"><tr><th style="text-align:center">Terms and Conditions</th></tr>
                                  <tr><td>1) Goods subject to lien of seller till full payment is made by buyer.</td></tr>
                                  <tr><td>2) NO CLAIM for shortage/damage will be entertained after 24 hours of delivery.</td></tr>
                                  <tr><td>3) Payment should be made by cash or A/C payees cheque only in the name of our company.</td></tr>
                                  <tr><td></td></tr>
</table><br><br/>
<table style="width:100%;"><tr><td width="50%";>Buyer Signature:</td><td width="50%";>For PNP Building Materials Trading L.L.C</td></tr></table>
<br><br/><br><br/>
<table style="width:100%;"><tr><td style="text-align:center">Tel: 06-5952061/ Mob: 055-8532631/050-4680842 | '.$address.'</td></tr>
                            <tr><td style="text-align:center">Website: www.pnptiles.com | Email: info@pnptiles.com</td></tr></table>';
$html2 .='</body></html>';
$pdf2->writeHTML($html2, true, false, true, false, '');
$filelocation = FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads';
$filename_invoice = str_replace('/','_', $invoice).'.pdf';
    $fileNL_invoice = $filelocation.DIRECTORY_SEPARATOR.$filename_invoice;
   //echo $fileNL; exit;
$pdf2->Output($fileNL_invoice, 'F');
                            $orderData['do_url'] = base_url().'assets/uploads/'.$filename_do;
                             $orderData['lpo_url'] = base_url().'assets/uploads/'.$filename_lpo;
                              $orderData['invoice_url'] = base_url().'assets/uploads/'.$filename_invoice;
                            $this->db->select('*');
                            $this->db->where('login_status', 1);
                            $this->db->where('role', 2);
                            $q = $this->db->get('user_login_details');
                            $adminUserdata = $q->result_array();
                            
                            $productId = $data['product_id'];
                            $userId = $this->user_id;
             
           
                            $total_price = $data['total_price'];
                            $tax = $data['tax'];
                            $created = date('Y-m-d h:i:s');
 
                            if ($adminUserdata) {
                                for ($k=0;$k<count($adminUserdata);$k++) {
                                    if ($adminUserdata[$k]['device_type'] == 1) {
                                        // For Android
                                         $notificationArray = array(
                                            "notification_type" => 2,
                                            "product_id" => $productId,
                                            "user_id" => $userId,
                                            "total_price" => $total_price,
                                            "tax" => $tax,
                                            "created" => $created
                                        );
                                        $arr = array(
            "registration_ids" => array($adminUserdata[$k]['firebase_token']),
            "data" => [
                "body" => $notificationArray,
                "title" => "New Order Added",
                // "icon" => "ic_launcher"
            ],
            // "data" => json_encode(array())
        );
        $data = json_encode($arr);
        $this->android_ios_notification($data,'Android');
        /*//FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        //echo '<pre>';print_r($result);
        //echo '<pre>';print_r(curl_error($ch));
        //die;
        //echo "----".$result;
        if ($result === FALSE) {
            //die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);*/
                                    } else {
                                        // For IOS
                                        //for ios
                                        $notificationArray = array(
                                            "notification_type" => 2,
                                            "product_id" => $productId,
                                            "user_id" => $userId,
                                            "total_price" => $total_price,
                                            "tax" => $tax,
                                            "created" => $created,
                                        );
                                        /* OLd array
                                        $arr = array(
                                            "registration_ids" => array($adminUserdata[$k]['firebase_token']),
                                            
                                            "notification" => [
                                            "body" => $notificationArray,
                                            "title" => "New Order Added",
                                            'priority' => 'high',

                                            // "icon" => "ic_launcher"
                                            ],
                                            // "data" => json_encode(array())
                                        );*/
                                        // New array
                                        $arr = array(
                                            "registration_ids" => array($adminUserdata[$k]['firebase_token']),
                                            
                                            "notification" => [
                                            // "body" => $notificationArray,
                                            "body" => "",
                                            //"title" => "New Order Added",
                                            "title" => "New order has been placed. Please check admin portal to check this order."
                                            ],
                                            "priority"=> "high",
                                            "content_available"=> true,
                                            "mutable_content"=> true,
                                            "data" => $notificationArray
                                        );
                                           $data = json_encode($arr);
                                           $this->android_ios_notification($data,'Ios');
                                    }
                                }
                            }
                            
                            $orderData['id'] = $lastInsertedOrderId;
                            $response['status'] = 'success';
                            $response['data'] = $orderData;
                    } else {
                
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide product id, tax and total price ';
                    }
                     $companyName = $userData[0]['company_name'];
                   
                            $mail = new PHPMailer;
                            //$mail->isSMTP();
                            $mail->isMail();
                            /*$mail->Host = Mail_Host;                      
                            $mail->SMTPAuth = true;                               
                            $mail->Username = Mail_Username;     
                            $mail->Password = Mail_Password;                    
                            $mail->SMTPOptions = array(
                              'ssl' => array(
                              'verify_peer' => false,
                              'verify_peer_name' => false,
                                'allow_self_signed' => true
                                )
                            );                         
                            $mail->SMTPSecure = 'tls';                           
                            $mail->Port = 587; */
                            $mail->setFrom('pnpsales2019@gmail.com', 'Tiles Admin');
                            $mail->isHTML(true);  
                            $mail->Subject = "New Order from $companyName";
                            $mail->MsgHTML('
                                Dear Admin,<br/><br/>
    You have received a new Order from '.$userData[0]['company_name'].'<br/>
    New order number is #'.$newOrder.'<br/><br/>
    
    Order Grand Total is '.$finalTotal.'<br/><br/>
    
    Your order is now being processed.<br/>
    We are attaching a copy of LPO,DO and Invoice in this email. And your merchandise will be delivered to :<br/>
    '.$userData[0]['company_address'].'<br/>
    '.$userData[0]['phone_no'].'<br/><br/>
    
    For more order details and updates, please get in touch with us from our mobile application.<br/><br/>
    
    Best Regards,<br/>
    Customer Service<br/>
    www.pnptiles.com<br/><br/>
    
    This is an automatically generated mail.Please do not reply.If you have any queries regarding your account/order, please contact us.');
                            $mail->AddAttachment($fileNL_invoice, $name = 'INVOICE',  $encoding = 'base64', $type = 'application/pdf');
                            $mail->AddAttachment($fileNL_lpo, $name = 'LPO',  $encoding = 'base64', $type = 'application/pdf');
                            $mail->AddAttachment($fileNL_do, $name = 'DO',  $encoding = 'base64', $type = 'application/pdf');
                            $mail->addAddress('pnpsales2019@gmail.com', 'PNP Admin');
                            $mail->send();
                            
                            $mail = new PHPMailer;
                            //$mail->isSMTP(); 
                            $mail->isMail();
                            /*$mail->Host = Mail_Host;                      
                            $mail->SMTPAuth = true;                               
                            $mail->Username = Mail_Username;     
                            $mail->Password = Mail_Password;                    
                            $mail->SMTPOptions = array(
                              'ssl' => array(
                              'verify_peer' => false,
                              'verify_peer_name' => false,
                                'allow_self_signed' => true
                                )
                            );                         
                            $mail->SMTPSecure = 'tls';                           
                            $mail->Port = 587; */
                            $mail->setFrom('pnpsales2019@gmail.com', 'Tiles Admin');
                            $mail->isHTML(true);  
                            $mail->Subject = "Order Confirmation";
                            $mail->MsgHTML('
                                Dear '.$userData[0]['company_name'].',<br/><br/>
    Thanks for your order.We hope you had a good time shopping with us.<br/>
    Your order number is #'.$newOrder.'<br/><br/>
    
    Order Grand Total is '.$finalTotal.'<br/><br/>
    
    Your order is now being processed.<br/>
    We are attaching a copy of LPO and Invoice in this email.And we will deliver your merchandise to :<br/>
    '.$userData[0]['company_address'].'<br/>
    '.$userData[0]['phone_no'].'<br/><br/>
    
    For more order details and updates, please get in touch with us from our mobile application.<br/><br/>
    
    Best Regards,<br/>
    Customer Service<br/>
    www.pnptiles.com<br/><br/>
    
    This is an automatically generated mail.Please do not reply.If you have any queries regarding your account/order, please contact us.');
                            $mail->AddAttachment($fileNL_invoice, $name = 'INVOICE',  $encoding = 'base64', $type = 'application/pdf');
                            $mail->AddAttachment($fileNL_lpo, $name = 'LPO',  $encoding = 'base64', $type = 'application/pdf');
                            $mail->addAddress($userData[0]['email'],$userData[0]['company_name']);
                            $mail->send();
                    
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function sampleRequest() {

                    $model = $this->model;
                    $orderData = array();
                    $data = $_POST;
    
                        /* Sample Request Section Start */              
                        if ((isset($data['product_id']) && (!empty($data['product_id']))) && (isset($data['mark']) && (!empty($data['mark']))) && (isset($data['location']) && (!empty($data['location']))) && (isset($data['cargo_number']) && (!empty($data['cargo_number']))) && (isset($data['cargo']) && (!empty($data['cargo']))) && (isset($data['tax']) && (!empty($data['tax'])))) {

                                //order for particular user
                                $orderUserId=$this->user_id;
                                 
                                // placed by is set or not               
                                if(!empty($data['placed_by']) && isset($data['placed_by'])) {

                                    $placed_by=trim($data['placed_by']);
                                    $placed_by=strtolower($placed_by);
                                    if($placed_by=='admin'){
                                        $orderUserId=trim($data['customer_id']);
                                    }
                                } else {
                                    $placed_by="customer";
                                }

                                // customer id is set or not
                                if(!empty($data['customer_id']) && isset($data['customer_id'])) {
                                    
                                    $customer_id=trim($data['customer_id']);
                                } else {
                                    $customer_id="0";
                                }

                                $customercheck=$this->db->select('id')->from('users')->where('id',$customer_id)->where('status',1)->get()->num_rows();

                                // if order is placed by admin then need to check customer is exist or not and status
                                if($placed_by=="admin" && $customercheck=="0") {
                                    $response['status'] = 'failure';
                                    $response['message'] = 'Please provide customer id who is exist and active';
                                    echo json_encode($response);
                                    exit();
                                }
                              
                                
                                if($placed_by=='admin') {

                                    $sampleData = array(
                                            'user_id' => $customer_id,
                                            'product_id' => $data['product_id'],
                                            'tax' => $data['tax'],
                                            'cargo' => $data['cargo'],
                                            'cargo_number' => $data['cargo_number'],
                                            'location' => $data['location'],
                                            'mark' => $data['mark'],
                                            'placed_by'=>$placed_by,
                                            'admin_id'=>$this->user_id,
                                            'status' => 1,
                                            'created' => date('Y-m-d h:i:s'),
                                    );
                                } else {
                                    $sampleData = array(
                                        'user_id' => $this->user_id,
                                        'product_id' => $data['product_id'],
                                        'tax' => $data['tax'],
                                        'cargo' => $data['cargo'],
                                        'cargo_number' => $data['cargo_number'],
                                        'location' => $data['location'],
                                        'mark' => $data['mark'],
                                        'placed_by'=>$placed_by,
                                        'status' => 1,
                                        'created' => date('Y-m-d h:i:s')
                                    );
                                }

                                $this->$model->insert('sample_requests',$sampleData);
                                $lastInsertedSampleRequestId = $this->db->insert_id();

                                $this->db->select('*');
                                $this->db->where('login_status', 1);
                                $this->db->where('role', 2);
                                $q = $this->db->get('user_login_details');
                                $adminUserdata = $q->result_array();
                      
                                $productId = $data['product_id'];
                                $userId = $this->user_id;

                                $tax = $data['tax'];
                                $created = date('Y-m-d h:i:s');
                     
                                if ($adminUserdata) {
                                    for ($k=0;$k<count($adminUserdata);$k++) {
                                      if ($adminUserdata[$k]['device_type'] == 1) {
                                          // For Android
                                           $notificationArray = array(
                                              "notification_type" => 2,
                                              "product_id" => $productId,
                                              "user_id" => $userId,
                                              "tax" => $tax,
                                              "created" => $created
                                          );
                                          $arr = array(
                                                  "registration_ids" => array($adminUserdata[$k]['firebase_token']),
                                                  "data" => [
                                                  "body" => $notificationArray,
                                                  "title" => "New Sample Request Added",
                                                  // "icon" => "ic_launcher"
                                                  ],
                                          );
                                          $data = json_encode($arr);
                                          $this->android_ios_notification($data,'Android');
                                      } else {
                                          // For IOS
                                          //for ios
                                          $notificationArray = array(
                                              "notification_type" => 2,
                                              "product_id" => $productId,
                                              "user_id" => $userId,
                                              "tax" => $tax,
                                              "created" => $created,
                                          );   
                                          // New array
                                          $arr = array(
                                              "registration_ids" => array($adminUserdata[$k]['firebase_token']),
                                              
                                              "notification" => [
                                              // "body" => $notificationArray,
                                              "body" => "",
                                              //"title" => "New Order Added",
                                              "title" => "New order has been placed. Please check admin portal to check this order."
                                              ],
                                              "priority"=> "high",
                                              "content_available"=> true,
                                              "mutable_content"=> true,
                                              "data" => $notificationArray
                                          );
                                          $data = json_encode($arr);
                                          $this->android_ios_notification($data,'Ios');
                                      }
                                    }
                                }

                                $orderData['id'] = $lastInsertedSampleRequestId;
                                $response['status'] = 'success';
                                $response['data'] = $orderData;
                                                   
                        } else {             
                            // If any of the mandatory parameters are missing
                            $response['status'] = 'failure';
                            $response['message'] = 'Please provide product id, tax and total price ';
                        }
                        /* Sample Request Section Section Start */

                        /* Send Email Section Start */

                            //1. Admin Email Send
                            
                            $companyName = $userData[0]['company_name'];   
                            $mail = new PHPMailer;
                            $mail->isSMTP();
                            //$mail->isMail();
                            $mail->Host = Mail_Host;                      
                            $mail->SMTPAuth = true;                               
                            $mail->Username = Mail_Username;     
                            $mail->Password = Mail_Password;                    
                            $mail->SMTPOptions = array(
                              'ssl' => array(
                              'verify_peer' => false,
                              'verify_peer_name' => false,
                                'allow_self_signed' => true
                                )
                            );                         
                            $mail->SMTPSecure = 'tls';                           
                            $mail->Port = 587; 
                            $mail->setFrom('chirag.webpatriot@gmail.com', 'Tiles Admin');
                            $mail->isHTML(true);  
                            $mail->Subject = "New Order from $companyName";
                            $mail->MsgHTML('Dear Admin,<br/><br/>
                                You have received a new Order from '.$userData[0]['company_name'].'<br/>
                                New order number is #'.$newOrder.'<br/><br/>
                                
                                Order Grand Total is '.$finalTotal.'<br/><br/>
                                
                                Your order is now being processed.<br/>
                                We are attaching a copy of LPO,DO and Invoice in this email. And your merchandise will be delivered to :<br/>
                                '.$userData[0]['company_address'].'<br/>
                                '.$userData[0]['phone_no'].'<br/><br/>
                                
                                For more order details and updates, please get in touch with us from our mobile application.<br/><br/>
                                
                                Best Regards,<br/>
                                Customer Service<br/>
                                www.pnptiles.com<br/><br/>
                                
                                This is an automatically generated mail.Please do not reply.If you have any queries regarding your account/order, please contact us.');
                            $mail->addAddress('chirag.webpatriot@gmail.com', 'PNP Admin');
                            $mail->send();

                            //2. User Email Send
                            $mail = new PHPMailer;
                            $mail->isSMTP(); 
                            //$mail->isMail();
                            $mail->Host = Mail_Host;                      
                            $mail->SMTPAuth = true;                               
                            $mail->Username = Mail_Username;     
                            $mail->Password = Mail_Password;                    
                            $mail->SMTPOptions = array(
                              'ssl' => array(
                              'verify_peer' => false,
                              'verify_peer_name' => false,
                                'allow_self_signed' => true
                                )
                            );                         
                            $mail->SMTPSecure = 'tls';                           
                            $mail->Port = 587; 
                            $mail->setFrom('chirag.webpatriot@gmail.com', 'Tiles Admin');
                            $mail->isHTML(true);  
                            $mail->Subject = "Order Confirmation";
                            $mail->MsgHTML('Dear '.$userData[0]['company_name'].',<br/><br/>
                                Thanks for your order.We hope you had a good time shopping with us.<br/>
                                Your order number is #'.$newOrder.'<br/><br/>
                                
                                Order Grand Total is '.$finalTotal.'<br/><br/>
                                
                                Your order is now being processed.<br/>
                                We are attaching a copy of LPO and Invoice in this email.And we will deliver your merchandise to :<br/>
                                '.$userData[0]['company_address'].'<br/>
                                '.$userData[0]['phone_no'].'<br/><br/>
                                
                                For more order details and updates, please get in touch with us from our mobile application.<br/><br/>
                                
                                Best Regards,<br/>
                                Customer Service<br/>
                                www.pnptiles.com<br/><br/>
                                
                                This is an automatically generated mail.Please do not reply.If you have any queries regarding your account/order, please contact us.');
                            $mail->send();
                            echo json_encode($response);
                            exit();
                        
                        /* Send Email Section End */
                }

                public function  getallsampleRequest() {

                    $this->db->select('p.name,u.company_name,s.tax,s.cargo,s.cargo_number,s.location,s.mark');
                    $this->db->from('sample_requests as s');
                    $this->db->join('products as p', 's.product_id = p.id');
                    $this->db->join('users as u', 's.user_id = u.id');
                    $sampleData = $this->db->get()->result_array();
                    if ($sampleData) {
                        $response['status'] = 'success';
                        $response['data'] = $sampleData;
                    } else {
                        $response['status'] = 'success';
                        $response['message'] = 'No orders found';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }

                public function removeFiles() {
                    
                    $data = $_POST;
                    if ((isset($data['order_id']) && (!empty($data['order_id']))) ) {
                        
                    if (date('m') <= 3) {
                        $financial_year = (date('y')-1) . '-' . date('y');
                    } else {
                        $financial_year = date('y') . '-' . (date('y') + 1);
                    }
                    $lpo = '\LPO/'.$data['order_id'].'/'.$financial_year;
                    $do = '\DO/'.$data['order_id'].'/'.$financial_year;
                    $invoice = '\Invoice/'.$data['order_id'].'/'.$financial_year;
                    $filename_lpo = str_replace('/','_', $lpo).'.pdf';
                    $filename_do = str_replace('/','_', $do).'.pdf';
                    $filename_invoice = str_replace('/','_', $invoice).'.pdf';

                    $pathLpo = FCPATH .'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$filename_lpo;
                    $pathDo = FCPATH .'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$filename_do;
                    $pathInvoice = FCPATH .'assets'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$filename_invoice;
                    unlink($pathLpo);
                    unlink($pathDo);
                    unlink($pathInvoice);
                    $response['status'] = 'success';
                    $response['message'] = 'Files deleted successfully';
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide order id';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function getAllUserOrders() {

                    $this->db->select('u.*,p.*,o.*,o.price as order_price');
                    $this->db->from('orders as o');
                    $this->db->where('o.user_id', $this->user_id);
                    $this->db->join('products as p', 'o.product_id = p.id');
                    $this->db->join('users as u', 'o.user_id = u.id');
                    $orderData = $this->db->get()->result_array();
                    if ($orderData) {
                        for($i=0;$i<count($orderData);$i++) {
                            $orderData[$i]['image']= base_url().'assets/uploads/'.$orderData[$i]['image'];
                        }
                        $response['status'] = 'success';
                        $response['data'] = $orderData;
                    } else {
                        $response['status'] = 'success';
                        $response['message'] = 'No orders found';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function userLogout() {
                    
                    $data = $_POST;
                    
                    if ((isset($data['role']) && (!empty($data['role']))) ) {
                       
                        $this->db->where('user_id', $this->user_id);
                        $this->db->where('firebase_token',$this->firebase_token);
                        $this->db->delete('user_login_details');

                    //     $dataUser['login_status'] = 0;
                    //     $this->db->set('login_status', $dataUser['login_status']);
                    //     $this->db->set('firebase_token', '');
                    //     $this->db->where('user_id',$this->user_id);
                    //    // $this->db->where('firebase_token',$this->firebase_token);
                    //   //  $this->db->where('role',$data['role']);
                    //     $this->db->update('user_login_details',$dataUser);
                        $response['status'] = 'success';
                        $response['message'] = 'You are logged out successfully';
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide user id';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }


                public function getOrderList() // New function created on 19th dec 2019
                { 
                    $this->model = "My_model";
                    $data = $_POST;
                    if ( (isset($data['user_id']) && (!empty($data['user_id']))) && (isset($data['role']) && (!empty($data['role']))) ) 
                    {
                        $totalData = $this->orders_model->get_OrderDatatables('','','','','',$data['user_id'],$data['role']);

                        $model = $this->model; //Load My_model

                        for($k=0;$k<sizeof($totalData['result']);$k++) // replace status code to string
                        {
                            $totalData['result'][$k]['total_price']=$this->$model->getamount(ROUND($totalData['result'][$k]['total_price'] + $totalData['result'][$k]['tax'],2),'no','no'); 

                            if($totalData['result'][$k]['invoice_status']==0)
                            {
                                $totalData['result'][$k]['payment_status']="Unpaid";
                                $totalData['result'][$k]['created']=$this->$model->date_conversion($totalData['result'][$k]['created'],'d/m/Y H:i:s',' ');
                            }
                            else
                            {
                                $totalData['result'][$k]['payment_status']="Paid";
                                $totalData['result'][$k]['created']=$this->$model->date_conversion($totalData['result'][$k]['created'],'d/m/Y H:i:s',' ');
                            }
                            unset($totalData['result'][$k]['invoice_status']);
                        }

                        if (sizeof($totalData)>0) // data found
                        {
                            $response['status'] = 'success';
                            $response['data'] = $totalData;
                        } 
                        else 
                        {
                            $response['status'] = 'failure';
                            $response['message'] = 'No order details found';
                        }
                    } 
                    else // If any of the mandatory parameters are missing
                    {
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide user id';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }

                public function getOrderListDetail() // Order detail by id created on 19th dec 2019 
                {
                    $this->model = "My_model";
                    $data = $_POST;
                    if ((isset($data['order_id']) && (!empty($data['order_id'])))) 
                    {
                        $user_id = $this->user_id;
                        $model = $this->model; //Load My_model
                        $id = $data['order_id'];

                        $multipleWhere = ['order_id' => $id];
                        $this->db->where($multipleWhere);
                        $dataProduct = $this->db->get("order_products")->result_array();
                        for($k=0;$k<count($dataProduct);$k++) 
                        {
                            $productIdArray = $dataProduct[$k]['product_id'];
                            $multipleWhere2 = ['id' => $productIdArray];
                            $this->db->where($multipleWhere2);
                            $productData= $this->db->get("products")->result_array();
                            $productNameArray[] = $productData[0]['name'];
                            $designNoArray[] = $productData[0]['design_no'];
                            $quantityArray[]= $dataProduct[$k]['quantity'];
                            $priceArray[]= $dataProduct[$k]['price'];
                            $sizeArray[]= $productData[0]['size'];
                            $imageArray[]= $productData[0]['image'];
                        }

                        $data['productData'] = array();
                        for($p=0;$p<count($productNameArray);$p++)
                        {
                            $data['productData'][$p]['name']= $productNameArray[$p];
                            $data['productData'][$p]['design_no']= $designNoArray[$p];
                            $data['productData'][$p]['quantity']= $quantityArray[$p];
                            $data['productData'][$p]['price']= number_format($priceArray[$p],2);
                            $data['productData'][$p]['size']= $sizeArray[$p];

                            if(file_exists("assets/uploads/".$imageArray[$p]))
                            {
                                $data['productData'][$p]['image']= base_url()."assets/uploads/".$imageArray[$p];
                            }
                            else
                            {
                                $data['productData'][$p]['image']= base_url()."assets/default.png";
                            }

                            $bagTotal+=$priceArray[$p];
                        }
                       
                        //$multipleWhere2 = ['id' => $user_id];
                        //$this->db->where($multipleWhere2);

                        // remove unused key from additionalDetail
                        $removeKeys1 = array('id', 'user_id','tax','total_price','modified','is_deleted','admin_id','sales_expense','tax_percentage');

                        $data['additionalDetail'] = $this->$model->select(array(),'orders',array('id'=>$id),'','');

                        foreach($removeKeys1 as $key) 
                        {
                           unset($data['additionalDetail'][0]->$key);
                        }

                        if($data['additionalDetail'][0]->placed_by=="admin") // if order is placed by admin then display admin name
                        {
                            $adminDbData=$this->db->select('first_name,last_name')->from('admin_users')->where('id',$user_id)->get()->result_array();
                            $placed_by_name=$adminDbData[0]['first_name'].' '.$adminDbData[0]['last_name'];
                        }
                        else
                        {
                            $userDbData=$this->db->select('contact_person_name')->from('users')->where('id',$user_id)->get()->result_array();
                            $placed_by_name=$userDbData[0]['contact_person_name'];
                        }

                        $data['additionalDetail'][0]->placed_by=$placed_by_name; // give placed by name

                        //Check status and assign string value
  
                        if($data['additionalDetail']['0']->status==0)
                        {
                            $delivery_status = "Pending";
                        }
                        else if($data['additionalDetail']['0']->status==1)
                        {
                            $delivery_status = "In Progress";
                        }
                        else if($data['additionalDetail']['0']->status==2)
                        {
                            $delivery_status = "Completed";
                        }

                        if($data['additionalDetail']['0']->invoice_status==0)
                        {
                            $payment_status = "Unpaid";
                        }
                        else if($data['additionalDetail']['0']->invoice_status==1)
                        {
                            $payment_status = "Paid";
                        }

                        // replace status and date format in array
                        $data['additionalDetail']['0']->delivery_status = $delivery_status;
                        $data['additionalDetail']['0']->delivery_date = $this->$model->date_conversion($data['additionalDetail']['0']->delivery_date,'d/m/Y H:i:s',' ');

                        $data['additionalDetail']['0']->payment_status = $payment_status;
                        $data['additionalDetail']['0']->payment_date = $this->$model->date_conversion($data['additionalDetail']['0']->payment_date,'d/m/Y H:i:s',' ');

                        $data['additionalDetail']['0']->created = $this->$model->date_conversion($data['additionalDetail']['0']->created,'d/m/Y H:i:s',' ');

                        // remove key so delivery and payment status not repeated again
                        unset($data['additionalDetail'][0]->invoice_status);
                        unset($data['additionalDetail'][0]->status);

                        // remove unused key from orderDetail

                        $data['orderDetail'] = $this->$model->select(array(),'orders',array('id'=>$id),'','');
                        
                        $removeKeys = array('lpo_no','do_no','sales_expense','cargo','cargo_number','location','mark','placed_by','admin_id','customer_lpo','invoice_status','status','payment_date','delivery_date','is_deleted','created','modified','invoice_no');

                        foreach($removeKeys as $key) 
                        {
                           unset($data['orderDetail'][0]->$key);
                        }

                        
                        //tax price
                        //$taxprice=$data['orderDetail']['0']->tax;
                        $data['orderDetail']['0']->total_price =$this->$model->getamount(ROUND($data['orderDetail']['0']->total_price + $data['orderDetail']['0']->tax,2),'no','no');

                        $data['orderDetail']['0']->bagTotal = $this->$model->getamount(ROUND($bagTotal,2),'no','no'); // add bagtotal in array

                        $data['orderDetail']['0']->tax = $this->$model->getamount(ROUND($data['orderDetail']['0']->tax,2),'no','no');

                        if (sizeof($data)>0) // data found
                        {
                            $response['status'] = 'success';
                            $response['data'] = $data;
                        } 
                        else 
                        {
                            $response['status'] = 'failure';
                            $response['message'] = 'No order details found';
                        }
                    } 
                    else // If any of the mandatory parameters are missing
                    {
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide order id';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();

                    
                }
                
                public function getOrderDetail() {
                    
                    $data = $_POST;
                    if ((isset($data['order_id']) && (!empty($data['order_id']))) ) {
                        
                        $this->db->select('u.*,p.*,o.*,o.price as order_price');
                        $this->db->from('orders as o');
                        $this->db->where('o.id', $data['order_id']);
                        $this->db->join('products as p', 'o.product_id = p.id');
                        $this->db->join('users as u', 'o.user_id = u.id');
                        $orderData = $this->db->get()->result_array();
                        
                        if ($orderData) { 
                            $orderData[0]['image']= base_url().'assets/uploads/'.$orderData[0]['image'];
                            $response['status'] = 'success';
                            $response['data'] = $orderData;
                        } else {
                            $response['status'] = 'failure';
                            $response['message'] = 'No order details found';
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide order';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function getAllOrders() {

                    $this->db->select('u.*,p.*,o.*,o.price as order_price');
                    $this->db->from('orders as o');
                    $this->db->join('products as p', 'o.product_id = p.id');
                    $this->db->join('users as u', 'o.user_id = u.id');
                    $orderData = $this->db->get()->result_array();
                    if ($orderData) {
                        for($i=0;$i<count($orderData);$i++) {
                            $orderData[$i]['image']= base_url().'assets/uploads/'.$orderData[$i]['image'];
                        }
                        $response['status'] = 'success';
                        $response['data'] = $orderData;
                    } else {
                        $response['status'] = 'success';
                        $response['message'] = 'No orders found';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function refreshToken() {
                    
                    $model = $this->model;
                    $data = $_POST;
                    if ((isset($data['device_id']) && (!empty($data['device_id']))) && (isset($data['firebase_token']) && (!empty($data['firebase_token'])))){
                            
                        $this->db->select('*');
                        $this->db->where('device_id', $data['device_id']);
                        $this->db->where('user_id', $this->user_id);
                        $this->db->where('login_status', 1);
                        $q = $this->db->get('user_login_details');

                        $userdata = $q->result_array();
                        if ($userdata) {

                            $dataUser['firebase_token'] = $data['firebase_token'];
                            $this->db->set('firebase_token', $data['firebase_token']);
                            $this->db->where('id',$userdata[0]['id']);
                            $this->db->update('user_login_details',$dataUser);

                            $response['status'] = 'success';
                            $response['message'] = 'You token updated successfully';
                            
                        } else {
                            // If any of the mandatory parameters are missing
                            $response['status'] = 'failure';
                            $response['message'] = 'There is no device with device token';
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide role, old password and password';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                function sendGCM() {
                    
                    $arr = array(
            "registration_ids" => array('dno8AtTMSnU:APA91bEj_YXvr3T3iI0e3d2wXgDGTTrPpaa_hFHO5pJvOzfUqI9cE-wsKVW6myyCEtZMzj7EJxFnU0yPRe5ng-H2PJM8q2q2n9fySU8uMefMO34C6QAOGwgayNKjNQZdnmMtrPFOV2ue'),
            "data" => [
                "body" => "{'notification_type':1,'company_name':'IOS'}",
                "title" => "Latest Code IOS",
                // "icon" => "ic_launcher"
            ],
            // "data" => json_encode(array())
        );
        $data = json_encode($arr);
        echo $data; exit;
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        echo "----".$result;
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        die("sent");
        curl_close($ch);
                     
                }
                
                function sendIOSGCM() {
            
                    $arr = array(
            "registration_ids" => array('cs4h5yYUByU:APA91bEV6HqKsp2aLeCjJOq1jGOKefRCVsdDN4Imx9t-7WcteuushA_ILkRHzjlOoX2c0M25ciGQHV_EL1ucBkiA1SKoWuxcLZICWRnFw4Lm0FcnVfDkJ-LgXBIZJljHAPRlJpxpiDXq'),
            "data" => [
                "body" => "{'notification_type':1,'company_name':'IOS''}",
                "title" => "Latest Code IOS",
                // "icon" => "ic_launcher"
            ],
            // "data" => json_encode(array())
        );
        $data = json_encode($arr);
        //FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        //CURL request to route notification to FCM connection server (provided by Google)
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        echo "----".$result;
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        die("sent");
        curl_close($ch);
                     
                }
                
                public function getAllContacts() {
                    
                         $this->db->select('*');
                 
                         
                        $this->db->where('is_deleted', 0);
          
                            $q = $this->db->get('users');
                            $userdata = $q->result_array();
                            $response['status'] = 'success';
                            $response['data'] = $userdata;
                                 // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function changeStatusOfUser() {
                    
                    $model = $this->model;
                    $data = $_POST;
                    if ((isset($data['user_id']) && (!empty($data['user_id']))) ){
                                if ($data['status'] == 1 || $data['status'] == 2 || $data['status'] == 3) {
                                    $newData['status'] = $data['status'];
                                    if (isset($data['client_type']) && (!empty($data['client_type']))) {
                                        $this->db->set('client_type', $data['client_type']);
                                    }
                                    $this->db->set('status', $data['status']);
                                    $this->db->where('id',$data['user_id']);
                                    $this->db->update('users',$newData);
                                } else {
                                    $this->db->where('user_id', $data['user_id']);
                                    $this->db->delete('orders'); 
                                    $this->db->where('id', $data['user_id']);
                                    $this->db->delete('users'); 
                                }
                                $response['status'] = 'success';
                          
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide user id';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                   public function getCustomerReport() {
                    
                    $model = $this->model;
                    $data = $_POST;

                    if (empty($data)) {
                    $this->db->select('u.company_name, u.contact_person_name,o.id,o.total_price,o.location,o.invoice_status,o.created,o.tax');
                    $this->db->from('orders as o');
                    $this->db->join('users as u', 'o.user_id = u.id');
                    $this->db->where('o.is_deleted',0);
                    $this->db->where('u.is_deleted',0);
                    $this->db->where('u.status',1);
                    $finalOrderData = $this->db->get()->result_array();
                    for($l=0;$l<count($finalOrderData);$l++){
                        if ($finalOrderData[$l]['invoice_status'] == 0){
                            $finalOrderData[$l]['invoice_status'] = 'Unpaid';
                        }else{
                            $finalOrderData[$l]['invoice_status'] = 'Paid';
                        }

                        $finalOrderData[$l]['total_price'] = $this->$model->getamount(ROUND($finalOrderData[$l]['total_price'] + $finalOrderData[$l]['tax'],2),'no','no');
                    }

                     } else {
                          $q= $this->db->select('*')->where('created >=', $data['start_date']);
                            $this->db->where('created <=', $data['end_date']);
                            $this->db->where('is_deleted',0);
                            // $orderData = $this->db->get('orders')->result_array();
                            $q = $q->get('orders')->result();
                         //   echo '<pre>';
                         //   print_r($q); exit;
                        if ($q) {
                            $orderData = array(); 
                         
                        for($k=0;$k<count($q);$k++) {

                        $multipleWhere2 = ['id' => $q[$k]->user_id];
                        $this->db->where($multipleWhere2);
                        $userData = $this->db->get("users")->result_array();
                        
                        $orderData['id'] = $q[$k]->id;
                        $orderData['company_name'] = $userData[0]['company_name'];
                        $orderData['contact_person_name'] = $userData[0]['contact_person_name'];
                        $orderData['location'] = $q[$k]->location;
                        if ($q[$k]->invoice_status == 0) {
                            $orderData['invoice_status'] = 'Unpaid';
                        } else {
                            $orderData['invoice_status'] = 'Paid';
                        }
                        $orderData['created'] = $q[$k]->created;
                        //$orderData['total_price'] = $q[$k]->total_price + $q[$k]->tax;
                        $orderData['total_price'] = $this->$model->getamount(ROUND($q[$k]->total_price + $q[$k]->tax,2),'no','no');
                        $finalOrderData [] = $orderData;
                            }
                        } else {
                            $finalOrderData = array();
                        }
                     } 
                     $response['status'] = 'success';
                     $response['data'] = $finalOrderData;
                   // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function getExpenseReport() {
                
                    $data = $_POST;
                    if (empty($data)) {
                    $this->db->select('o.id,o.sales_expense,o.invoice_no,o.created');
                    $this->db->from('orders as o');
                    $this->db->where('o.is_deleted',0);
                    $finalOrderData = $this->db->get()->result_array();
                    
                     } else {
                          $q= $this->db->select('*')->where('created >=', $data['start_date']);
                            $this->db->where('created <=', $data['end_date']);
                            $this->db->where('is_deleted',0);
                            // $orderData = $this->db->get('orders')->result_array();
                            $q = $q->get('orders')->result();
                            if ($q) {
                            $orderData = array(); 
                            for($k=0;$k<count($q);$k++) {
                                 
                        
                        $orderData['id'] = $q[$k]->id;
                      
                        $orderData['sales_expense'] = $q[$k]->sales_expense;
                        $orderData['invoice_no'] = $q[$k]->invoice_no;
                        $orderData['created'] = $q[$k]->created;
                        $finalOrderData [] = $orderData;
                            }
                            } else {
                                $finalOrderData = array();
                            }
                     } 
                     $response['status'] = 'success';
                 $response['data'] = $finalOrderData;
                   // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                
                public function getSalesReport() {

                    $model = $this->model;
                    
                    $data = $_POST;
                    if (empty($data)) 
                    { 
                        $q = $this->db->select('user_id,SUM(total_price + tax) as totalValue,SUM(sales_expense) as total_sales_expense')->group_by('user_id')->where('is_deleted', 0);

                        $finalOrderData = $q->get('orders')->result_array();


                        if ($finalOrderData) {
                            for($k=0;$k<count($finalOrderData);$k++){
                                $invoiceData = $this->db->order_by('id',"desc")->limit(1)->where('user_id',$finalOrderData[$k]['user_id'])->get('orders')->row();

                                $multipleWhere2 = ['id' => $finalOrderData[$k]['user_id']];
                                $this->db->where($multipleWhere2);
                                $userData = $this->db->get("users")->result_array();
                                
                                $finalOrderData[$k]['company_name'] = $userData[0]['company_name'];
                                $finalOrderData[$k]['invoice_no'] = $invoiceData->invoice_no;

                                $finalOrderData[$k]['totalValue'] = $this->$model->getamount(ROUND($finalOrderData[$k]['totalValue'],2),'no','no');
                            }
                        }
                        else 
                        {
                            $finalOrderData = array();
                        }
                    } 
                    else 
                    {
                       $q= $this->db->select('user_id,SUM(total_price + tax) as totalValue,SUM(sales_expense) as total_sales_expense')->group_by('user_id')->where('created >=', $data['start_date']);
                        $this->db->where('created <=', $data['end_date']);
                        $this->db->where('is_deleted',0);

                        $q = $q->get('orders')->result();

                        for($k=0;$k<count($q);$k++) 
                        {
                            $invoiceData = $this->db->order_by('id',"desc")->limit(1)->where('user_id',$q[$k]->user_id)->get('orders')->row();
                           
                            $multipleWhere2 = ['id' => $q[$k]->user_id];
                            $this->db->where($multipleWhere2);
                            $userData = $this->db->get("users")->result_array();
                        
                            $q[$k]->company_name = $userData[0]['company_name'];
                            $q[$k]->invoice_no = $invoiceData->invoice_no;
                            $q[$k]->totalValue = $this->$model->getamount(ROUND($q[$k]->totalValue,2),'no','no');
                        }
                        $finalOrderData = $q;
                    } 
                    $response['status'] = 'success';
                    $response['data'] = $finalOrderData;
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function getProductsReport() {
                    
                $q = $this->db->select('order_id,product_id,SUM(quantity) as totalQuantity,SUM(price) as amount')->group_by('product_id');
                         
                 
                    $finalOrderData = $q->get('order_products')->result();
                    if ($finalOrderData) {
                        foreach ($finalOrderData as $key=>$value){

                        $multipleWhere2 = ['id' => $value->product_id];
                        $this->db->where($multipleWhere2);
                        $productData = $this->db->get("products")->result_array();
             
                        $multipleWhere3 = ['product_id' => $value->product_id];
                        $this->db->where($multipleWhere3);
                        $productCategoryData = $this->db->get("product_categories")->result_array();
              
                        $multipleWhere4 = ['id' => $productCategoryData[0]['cat_id']];
                        $this->db->where($multipleWhere4);
                        $categoryData = $this->db->get("categories")->result_array();
                        $totalQuantity = $value->totalQuantity;
                                        $nestedData['product_name'] =$productData[0]['name'];
                                        $nestedData['design_no'] =$productData[0]['design_no'];
                                        $nestedData['size'] =$productData[0]['size'];
                                        $nestedData['category'] =$categoryData[0]['name'];
                                        //$nestedData['purchase_price'] =$productData[0]['purchase_expense'];
                                        $nestedData['quantity'] = $productData[0]['quantity'];
                                        $nestedData['sold_quantity'] = $value->totalQuantity;
                                        $nestedData['balance_quantity'] =$productData[0]['quantity']-$totalQuantity;
                                        $nestedData['total_amount_balance'] =$value->amount;
                    $data[] = $nestedData;
                }
    
                    } else {
                        $data = array();
                    }
                    $response['status'] = 'success';
                  $response['data'] = $data;
                   // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
        
        public function android_ios_notification($data,$type)
        {
            $url = 'https://fcm.googleapis.com/fcm/send';
            //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
            if($type=="Android")
            {
                $server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
    }
            if($type=="Ios")
            {
               $server_key="AIzaSyA-sjPOj001dkK6gHJztu4taMJeYXLBDrM";
               // $server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
            }
            //header with content_type api key
            $headers = array(
                'Content-Type: application/json',
                'Authorization:key='.$server_key
            );
            //CURL request to route notification to FCM connection server (provided by Google)
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($ch);
            // echo "----".$result;exit;
            if ($result === FALSE) {
                //die('Oops! FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
        }
        public function update_last_activity() {
            $data = $_POST;
            $userData = array(
                        'last_activity' => date('Y-m-d h:i:s'),
                        );
            $this->db->where('id',$this->user_id);
            $this->db->update('users',$userData);
            $response['status'] = 'success';
            $response['message'] = 'Last activity updated successfully';
            echo json_encode($response);
            exit();
        }
    }
?>