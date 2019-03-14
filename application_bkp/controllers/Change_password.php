<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Change_password extends CI_Controller
	{
			public $msgName = "Change Password";
			public $view = "change_password";
			public $controller = "Change_password";
			public $table = "admin_users";
			public $primary_id = "id";
			public $msgDisplay ='Change_msg';
			public $model;
			
		public function __construct()
		{

			parent::__construct();
			date_default_timezone_set("Asia/Kolkata");
			$this->model = "My_model";
		}
		public function index()
		{
                //   echo '<pre>';
                  // print_r($this->userhelper->current('logged_in')); exit;
                    
                      
			$data['controller'] = $this->controller;
			$data['msgName'] = $this->msgName;
			$data['btn'] = "Update";
			$data['action'] = "Update";
			$this->load->view($this->view.'/form',$data);
		}
		public function Update()
		{
                      //  echo 'dds'; exit;
			$model = $this->model;
			$id = $this->input->post('id');
                        
			$newpassword = md5($this->input->post('newpassword'));
			
			$data = array(
				'password' => $newpassword
			);
			$where = array($this->primary_id=>$id);
			
			$this->$model->update($this->table,$data,$where);
 
                            $session_arr = array(
							"id" => $this->userhelper->current('id'),
							"first_name" => $this->userhelper->current('first_name'),
                                                        "last_name" => $this->userhelper->current('last_name'),
                                                        "email" => $this->userhelper->current('email'),
							"mobile_no" => $this->userhelper->current('mobile_no'),
                                                        "role_id" => $this->userhelper->current('role_id'),
                                                        "rights" => $this->userhelper->current('rights'),
                                                        "is_logged" => 1,
							"session_id" => session_id()
						);
						$this->session->set_userdata('logged_in',$session_arr);
                                                $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Password Changed Successfully!</div>');
			if (in_array(2,$this->userhelper->current('rights'))) {
                                                        redirect('Businessuser');
                                                    } elseif(in_array(3,$this->userhelper->current('rights'))) {
                                                    redirect('User');
                                                    } elseif(in_array(4,$this->userhelper->current('rights'))) {
                                                    redirect('Category');
                                                    } elseif(in_array(5,$this->userhelper->current('rights'))) {
                                                    redirect('Store');
                                                    } elseif(in_array(6,$this->userhelper->current('rights'))) {
                                                    redirect('Faq');
                                                    }
		}
		public function checkpassword()
		{
			$model = $this->model;
			$id = $this->input->post('id');
			$oldpassword = md5($this->input->post('oldpassword'));
			
			$check_user = $this->db->select('*')->where($this->primary_id,$id)->where('password',$oldpassword)->get('admin_users')->result();
			
			if(count($check_user) > 0)
			{
				echo (json_encode(true));
			}
			else
			{
				echo (json_encode(false));
				//echo (json_encode(array("false" => false, "q" => $query)));
			}
			exit;
		}
	}
?>