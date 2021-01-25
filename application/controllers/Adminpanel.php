<?php
	if(! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Adminpanel extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Dubai");
			$this->load->library('form_validation');
			
			
		}
		public function index()
		{
			$email = $this->input->post("email");
			$email = trim($email);
			$password = md5($this->input->post("txt_password"));
			$password = trim($password);
				
				/* Set Validations */
				$this->form_validation->set_rules("email", "email", "trim|required");
				$this->form_validation->set_rules("txt_password", "password", "trim|required");
				if ($this->form_validation->run() == FALSE)
				{
                                   // echo 'dd'; exit;
				   /* Validation Fails */
				   $this->load->view('login');
				}
				else
				{
                                  
					/* Validation Succeeds */

					/* Check If Username and Password is Correct*/


					$check_user = $this->db->select('*')->from('admin_users')->where('email',$email)->where('password', $password)->where('status','1')->get();
                                          //  echo '<pre>';
                                         //   print_r($check_user); exit;
                                       // echo $check_user->num_rows(); exit;
					if ($check_user->num_rows() > 0) //active user record is present
					{
                                          
						$user_row = $check_user->result();                                           
                        $rights = explode(',', $user_row[0]->rights);
						$session_arr = array(
							"id" => $user_row[0]->id,
							"first_name" => $user_row[0]->first_name,
                                                        "last_name" => $user_row[0]->last_name,
                                                        "email" => $user_row[0]->email,
							"mobile_no" => $user_row[0]->mobile_no,
                                                        "role_id" => $user_row[0]->role_id,
                                                        "rights" => $rights,
                                                        "is_logged" => $user_row[0]->is_logged,
							"session_id" => session_id()
						);
						$this->session->set_userdata('logged_in',$session_arr);
						// New redirect
						redirect('Dashboard');
													/* Old redirect
                                                    if(in_array(3,$rights)) {
                                                    redirect('User');
                                                    } elseif(in_array(4,$rights)) {
                                                    redirect('Category');
                                                    } elseif(in_array(5,$rights)) {
                                                    redirect('Product');
                                                    } elseif(in_array(6,$rights)) {
                                                    redirect('Order');
                                                    } else {
                                                        redirect('User');
                                                    }
                                                   */
						
					}
					else
					{
  
						$this->session->set_flashdata('dispMessage','<span class="7"><div class="alert alert-danger"><strong>Invalid Login Credential!</strong></div></span>');
						redirect('Adminpanel');
					}
				}

			
		}
	}
?>