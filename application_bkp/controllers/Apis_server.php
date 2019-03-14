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
                    $headers = apache_request_headers();
                   // echo '<pre>';
                  //  print_r($headers); exit;
                    $actionName = $this->router->fetch_method();
                    $this->db->select('*');
                    $this->db->where('value', $headers['x_api_key']);
                    $q = $this->db->get('x_api_keys');
                    $apiKeyData = $q->result_array();
                    if (count($apiKeyData) == 0) {
                        $response['status'] = 'failure';
                        $response['message'] = 'API Key is not matching';
                        // Returning back the response in JSON
                        echo json_encode($response);
                        exit();
                    }
                    
                    if ($actionName == 'refreshToken') {
                        $this->user_id = $headers['user_id'];
                    } elseif ($actionName != 'userLogin' && $actionName != 'userRegister' && $actionName != 'forgotpassword') {
                        if ((isset($headers['user_id']) && (!empty($headers['user_id']))) && (isset($headers['firebase_token']) && (!empty($headers['firebase_token'])))) {
                        $this->db->select('*');
                        $this->db->where('user_id', $headers['user_id']);
                        $this->db->where('firebase_token', $headers['firebase_token']);
                        $this->db->where('login_status', 1);
                        $q = $this->db->get('user_login_details');
                        $userLoginData = $q->result_array();
                        if (count($userLoginData) == 0) {
                            $response['status'] = 'failure';
                            $response['message'] = 'Wrong token used';
                            // Returning back the response in JSON
                            echo json_encode($response);
                            exit();
                        }
                        $this->user_id = $headers['user_id'];
                        $this->firebase_token = $headers['firebase_token'];
                        } else {
                            $response['status'] = 'failure';
                            $response['message'] = 'Please provide proper headers';
                            // Returning back the response in JSON
                            echo json_encode($response);
                            exit();
                        }
                    } else {
                        if ($actionName != 'forgotpassword') {
                            if(isset($headers['firebase_token']) && (!empty($headers['firebase_token']))) {

                                $this->firebase_token = $headers['firebase_token'];
                            } else {
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
                    if ((isset($data['device_id']) && (!empty($data['device_id']))) && (isset($data['device_type']) && (!empty($data['device_type']))) && (isset($data['phone_no']) && (!empty($data['phone_no']))) && (isset($data['company_name']) && (!empty($data['company_name']))) && (isset($data['company_address']) && (!empty($data['company_address']))) && (isset($data['contact_person_name']) && (!empty($data['contact_person_name']))) && (isset($data['vat_number']) && (!empty($data['vat_number']))) && (isset($data['email']) && (!empty($data['email']))) && (isset($data['password']))) {
                        
                        // Checking Email exist in our application
                        
                        $this->db->where('email',$data['email']);
                        $users = $this->db->get('users');
                        $checkEmailExist = $users->result_array();
                        
                        $this->db->where('email',$data['email']);
                        $adminUsers = $this->db->get('admin_users');
                        $checkAdminEmailExist = $users->result_array();

                        if (count($checkEmailExist)<1 && count($checkAdminEmailExist)<1) {
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
                            if ($adminUserdata) {
                                for ($k=0;$k<count($adminUserdata);$k++) {
                                    if ($adminUserdata[$k]['device_type'] == 1) {
                                        // For Android
                                        $arr = array(
		    "registration_ids" => array($adminUserdata[$k]['firebase_token']),
		    "notification" => [
		        "body" => "{'notification_type':1,'company_name': $companyName,'contact_person_name': $contactPersonName,'company_add': $companyAdd,'email': $email,'vat_number': $vatNumber,'phone_no': $phone_no,'created':$created}",
		        "title" => "New User Registered",
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
		//echo "----".$result;
		if ($result === FALSE) {
		    //die('Oops! FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
                                    } else {
                                        // For IOS
                                    }
                                }
                            }
                            
                            
                            $userData['id'] = $lastInsertedUserId;
                            $response['data'] = $userData;
                        } else {
                            // If email al'Error']['codeready exists
                            $response['status'] = 'failure';
                            $response['message'] = 'This email already exists. Please provide new email Id or login with existing one';
                        }
                    } else {
                
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
                    if ((isset($data['device_id']) && (!empty($data['device_id']))) && (isset($data['device_type']) && (!empty($data['device_type']))) && (isset($data['email']) && (!empty($data['email']))) && (isset($data['password']) && (!empty($data['password'])))){
                            
                        $this->db->select('*');
                        $this->db->where('email', $data['email']);
                        $this->db->where('password', md5($data['password']));
                        $q = $this->db->get('users');
                        $userdata = $q->result_array();
                        if ($userdata) {
                            if ($userdata[0]['is_deleted'] == 1) {
                                $response['status'] = 'failure';
                                $response['message'] = 'Your account is deleted. Please contact Administrator.';
                            } elseif($userdata[0]['status'] == 0) {
                                $response['status'] = 'failure';
                                $response['message'] = 'Your account is inactivated. Please contact Administrator.';
                            } else {
                                $response['status'] = 'success';
                                $response['message'] = 'You are successfully logged in.';
                                $response['data']= $userdata[0];
                                $response['role']= 1;
                                
                                // Adding data in user login details table
                            
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
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->Port = 587;
                            $mail->SMTPAuth = true;
                            $mail->Username = 'info.emailtest1@gmail.com';
                            $mail->Password = 'rwnzucezczusfezs';
                            $mail->setFrom('info.emailtest1@gmail.com', 'Test Admin');
                            $mail->Subject = "Reset Password";
                            $mail->MsgHTML('Your new password is "'.$randomPassword.'"');
                            $mail->addAddress($data['email']);
                            $mail->send();
                            /*if (!$mail->send()) {

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
                                $categories[$k]['image']= base_url().'/assets/uploads/'.$categories[$k]['image'];
                            } else {
                                $categories[$k]['image']= '';
                            }
                        }
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
                
                public function getSubCategories() {
                    
                    $data = $_POST;
                    if ((isset($data['category_id']) && (!empty($data['category_id'])))) {
                        $this->db->select('*');
                        $this->db->where('status', 1);
                        $this->db->where('is_deleted', 0);
                        $this->db->where('category_id', $data['category_id']);
                        $q = $this->db->get('sub_categories');
                        $sub_categories = $q->result_array();

                        if ($sub_categories) {
                            for ($k=0;$k<count($sub_categories);$k++) {
                                if (!empty($sub_categories[$k]['image'])) {
                                    $sub_categories[$k]['image']= base_url().'/assets/uploads/'.$sub_categories[$k]['image'];
                                } else {
                                    $sub_categories[$k]['image'] = '';
                                }
                            }
                            $response['data']= $sub_categories;
                        } else {
                              // If any of the mandatory parameters are missing
                              $response['status'] = 'success';
                            $response['message'] = 'No Sub Categories found';
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide category';
                    }
                    // Returning back the response in JSON
                    echo json_encode($response);
                    exit();
                }
                
                public function getProducts() {
                   
                    $data = $_POST;
                    if ((isset($data['cat_id']) && (!empty($data['cat_id'])))) {
                        if (isset($data['sub_cat_id']) && (!empty($data['sub_cat_id']))) {
                            $this->db->select('u.*');
                            $this->db->from('product_categories as s');
                            $this->db->where('u.is_deleted =', 0);
                            $this->db->where('u.status =', 1);
                            $this->db->where('s.cat_id', $data['cat_id']);
                            $this->db->where('s.sub_cat_id', $data['sub_cat_id']);
                            $this->db->join('products as u', 'u.id = s.product_id');
                            $productData = $this->db->get()->result_array();
                        } else {
                            $this->db->select('u.*');
                            $this->db->from('product_categories as s');
                            $this->db->where('u.is_deleted =', 0);
                            $this->db->where('u.status =', 1);
                            $this->db->where('s.cat_id', $data['cat_id']);
                            $this->db->join('products as u', 'u.id = s.product_id');
                            $productData = $this->db->get()->result_array();
                        }
                    } else {
                        $this->db->select('*');
                        $this->db->where('status', 1);
                        $this->db->where('is_deleted', 0);
                        $q = $this->db->get('products');
                        $productData = $q->result_array();
                    }
                    
                      $productData = array_map("unserialize", array_unique(array_map("serialize", $productData)));
                            $productData = array_values($productData);
                             //  echo '<pre>';
                         // print_r($productData); exit;
                     if ($productData) {
                         
                            for($i=0;$i<count($productData);$i++) {
                               $categoryString = '';
                                $productData[$i]['image']= base_url().'/assets/uploads/'.$productData[$i]['image'];
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
                                
                                $productData[$i]['categories_name']= $categoryString;
                                
                                $this->db->select('s.*');
                                $this->db->from('product_categories as s');
                                $this->db->where('sc.is_deleted =', 0);
                                $this->db->where('sc.status =', 1);
                                $this->db->where('s.product_id', $productData[$i]['id']);
                                $this->db->join('sub_categories as sc', 'sc.id = s.sub_cat_id');
                                $subcategoryData = $this->db->get()->result_array();
                                $subCategoryName = array();
                                for($k=0;$k<count($subcategoryData);$k++) {
                                        $this->db->select('name');
                                        $this->db->where('status', 1);
                                        $this->db->where('is_deleted', 0);
                                        $this->db->where('id', $subcategoryData[$k]['sub_cat_id']);
                                        $q = $this->db->get('sub_categories');
                                        $subCategoryies = $q->result_array();
                                        $subCategoryName[] = $subCategoryies[0]['name'];
                                }
                                $subCategoryName = array_values(array_unique($subCategoryName));
                                $subCategoryString = implode(',',$subCategoryName);
                                $productData[$i]['sub_categories_name']= $subCategoryString;
                            }
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
                        
                        $this->db->select('*');
                        $this->db->where('status', 1);
                        $this->db->where('is_deleted', 0);
                        $this->db->where('id', $data['product_id']);
                        $q = $this->db->get('products');
                        $productData = $q->result_array();
               
                        if ($productData) {
                            
                            $productData[0]['image']= base_url().'/assets/uploads/'.$productData[0]['image'];
                            
                            $response['data'] = $productData;
                        } else {
                            $response['status'] = 'failure';
                            $response['message'] = 'Product is either deleted or supended';
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide category and sub category';
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
                    $data = $_POST;
                    if ((isset($data['product_id']) && (!empty($data['product_id']))) && (isset($data['quantity']) && (!empty($data['quantity']))) && (isset($data['price']) && (!empty($data['price']))) && (isset($data['tax']) && (!empty($data['tax']))) && (isset($data['total_price']) && (!empty($data['total_price'])))) {
                        
                        // Checking Email exist in our application
                        
                     
                            $orderData = array(
      
                                    'product_id' => $data['product_id'],
                                    'user_id' => $this->user_id,
                                    'quantity' => $data['quantity'],
                                    'price' => $data['price'],
                                    'tax' => $data['tax'],
                                    'total_price' => $data['total_price'],
                                    'created' => date('Y-m-d h:i:s'),
                            );
                            $this->$model->insert('orders',$orderData);
                            $lastInsertedOrderId = $this->db->insert_id();
                            
                            $this->db->select('*');
                            $this->db->where('login_status', 1);
                            $this->db->where('role', 2);
                            $q = $this->db->get('user_login_details');
                            $adminUserdata = $q->result_array();
                            
                            $productId = $data['product_id'];
                            $userId = $this->user_id;
                            $quantity = $data['quantity'];
                            $price = $data['price'];
                            $total_price = $data['total_price'];
                            $tax = $data['tax'];
                            $created = date('Y-m-d h:i:s');

                            if ($adminUserdata) {
                                for ($k=0;$k<count($adminUserdata);$k++) {
                                    if ($adminUserdata[$k]['device_type'] == 1) {
                                        // For Android
                                        $arr = array(
		    "registration_ids" => array($adminUserdata[$k]['firebase_token']),
		    "notification" => [
		        "body" => "{'notification_type':2,'product_id': $productId,'user_id': $userId,'quantity': $quantity,'price': $price,'total_price': $total_price,'tax': $tax,'created':$created}",
		        "title" => "New Order Added",
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
		//echo "----".$result;
		if ($result === FALSE) {
		    //die('Oops! FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
                                    } else {
                                        // For IOS
                                    }
                                }
                            }
                            
                            
                            $orderData['id'] = $lastInsertedOrderId;
                            $response['data'] = $orderData;
                    } else {
                
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide product id, quantity, price, tax and total price';
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
                            $orderData[$i]['image']= base_url().'/assets/uploads/'.$orderData[$i]['image'];
                        }
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
                        
                        $dataUser['login_status'] = 0;
                        $this->db->set('login_status', $dataUser['login_status']);
                        $this->db->where('user_id',$this->user_id);
                        $this->db->where('firebase_token',$this->firebase_token);
                        $this->db->where('role',$data['role']);
                        $this->db->update('user_login_details',$dataUser);
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
                            $orderData[0]['image']= base_url().'/assets/uploads/'.$orderData[0]['image'];
                            $response['data'] = $orderData;
                        } else {
                            $response['status'] = 'failure';
                            $response['message'] = 'No order details found';
                        }
                    } else {
                        // If any of the mandatory parameters are missing
                        $response['status'] = 'failure';
                        $response['message'] = 'Please provide category and sub category';
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
                            $orderData[$i]['image']= base_url().'/assets/uploads/'.$orderData[$i]['image'];
                        }
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
		    "registration_ids" => array('ez3pt-a7bNw:APA91bGK8fXX7-NY4-Ams2ZYEwrRbEdDiG3vc-p5foj__pmWHcv3USwf5D_4rGjJTTUxj0qmQPE1HE51GWzweJZShm0QX1FGwjzvGzj_VuEFOiTBGM7Nb-fFPkMq9vvTWuq9b9d2nfLj'),
		    "notification" => [
		        "body" => "{'notification_type':1,'company_name':'IOS'}",
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
                
                function sendIOSGCM() {
                    
                    $arr = array(
		    "registration_ids" => array('fEOz1KhgT7s:APA91bFDymYI7iQZn2K0xEOimw-9lV8SPUaf5O4j7ZwjWFF_2R7HArck2DhjNiymwya7kWAuYRfuar9qmHUEa6osuc5FYV7_hNPEyGnE7SZHXge4-eLHjw7WxWP0spIHGbP65A6upDgQ'),
		    "notification" => [
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
	}
?>
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
                    $headers = apache_request_headers();
                   // echo '<pre>';
                  //  print_r($headers); exit;
                    $actionName = $this->router->fetch_method();
                    $this->db->select('*');
