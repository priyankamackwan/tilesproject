<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Edit_profile extends CI_Controller
	{
			public $msgName = "Edit Profile";
			public $view = "edit_profile";
			public $controller = "Edit_profile";
			public $table = "admin_users";
			public $primary_id = "id";
			public $msgDisplay ='edit_profile';
			public $model;
			
		public function __construct()
		{

			parent::__construct();
			date_default_timezone_set("Asia/Kolkata");
			$this->model = "My_model";
		}
		public function index()
		{
                        $model = $this->model;
			$id = $this->userhelper->current('id');
                      
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;
                   

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
			$this->load->view($this->view.'/form',$data);
		}
		public function Update()
		{
                      //  echo 'dds'; exit;
			$model = $this->model;
			$id = $this->input->post('id');
                        
			$id = $this->input->post('id');
			$first_name = $this->input->post('first_name');
                        $last_name = $this->input->post('last_name');
                        $email = $this->input->post('email');
			$number = $this->input->post('number');
			$data = array(
				'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $email,
				'mobile_no' => $number,
			);
			$where = array($this->primary_id=>$id);
			$this->$model->update($this->table,$data,$where);
                        $activityData = array(
				'module_id' => 1,
                                'entity_id' => $id,
                                'activity_id' => 8,
                                'admin_id' => $this->userhelper->current('id'),
                                'created' => date('Y-m-d h:i:s'),
			);
                        $this->db->insert('admin_activities',$activityData);
                        //echo $this->msgDisplay; exit;
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Profile Updated Successfully!</div>');
			redirect('Category');
		}
			public function checknumber()
		{
			$id = $this->input->post('id');
			$number = $this->input->post('number');
			$action = $this->input->post('action');
                      
			if($action == 'update')
			{
                            
				$check_query = $this->db->select('*')->where_not_in('id',$id)->where('mobile_no',$number)->where('is_deleted',0)->get($this->table)->result();
			}
			else
			{
				$check_query = $this->db->select('*')->where('mobile_no',$number)->where('is_deleted',0)->get($this->table)->result();
			}

                       
			if(count($check_query) > 0)
			{
				echo "false";
			}
			else
			{
				echo "true";
			}
		}
                
                   public function checkemail()
		{
			$id = $this->input->post('id');
			$email = $this->input->post('email');
			$action = $this->input->post('action');
                      
			if($action == 'update')
			{
                            
				$check_query = $this->db->select('*')->where_not_in('id',$id)->where('email',$email)->where('is_deleted',0)->get($this->table)->result();
			}
			else
			{
				$check_query = $this->db->select('*')->where('email',$email)->where('is_deleted',0)->get($this->table)->result();
			}

                       
			if(count($check_query) > 0)
			{
				echo "false";
			}
			else
			{
				echo "true";
			}
		}
	}
?>