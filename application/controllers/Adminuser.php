<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Adminuser extends CI_Controller
	{
		public $msgName = "Admin Users";
		public $view = "adminuser";
		public $controller = "Adminuser";
		public $primary_id = "id";
		public $table = "admin_users";
		public $msgDisplay = "admin_user_msg";
		public $model;

		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set('Asia/Kolkata');
			$this->model = "My_model";

		}
		public function index()
		{     
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
			$data['view'] = $this->view;
			$data['msgDisplay'] = $this->msgDisplay;
			$this->load->view($this->view.'/manage',$data);
		}
		public function server_data()
		{
                       
			$model = $this->model;

			$order_col_id = $_POST['order'][0]['column'];
			$order = $_POST['columns'][$order_col_id]['data'] . ' ' . $_POST['order'][0]['dir'];

			$s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
                        $statusFilter = $_POST['columns'][2]['search']['value'];
			$totalData = $this->$model->countTableRecords($this->table,array('is_deleted'=>0,'role_id'=>2));

			$start = $_POST['start'];
			$limit = $_POST['length'];
                         if (empty($statusFilter)){
                           
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('role_id', 2);
                        } elseif($statusFilter == 1) {
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('status', 1)->where('role_id', 2);
                        } elseif($statusFilter == 2) {
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('status',0)->where('role_id', 2);
                        } else {
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('role_id', 2);
                        }
               
			if(empty($s))
			{
				if(!empty($order))
				{
					$q = $q->order_by('admin_users.'.$order);
				}
				$q = $q->limit($limit, $start)->get($this->table)->result();
				$totalFiltered = $totalData;
			}
			else
			{
				$q = $q->like('admin_users.first_name', $s, 'both')->where('role_id', 2);
				$q = $q->or_like('admin_users.last_name', $s, 'both')->where('role_id', 2);
				$q = $q->or_like('admin_users.email', $s, 'both')->where('role_id', 2);
                                $q = $q->or_like('admin_users.mobile_no', $s, 'both')->where('role_id', 2);
				if(!empty($order))
				{
					$q = $q->order_by($order);
				}
				//->limit($limit, $start)
				$q = $q->get($this->table)->result();

				$totalFiltered = count($q);
			}
			$data = array();
			if(!empty($q))
			{
                            $startNo = $_POST['start'];
                            $srNo = $startNo + 1;
				foreach ($q as $key=>$value)
				{
					$model = $this->model;
					$id = $this->primary_id;
					// show rights
					$rights='';
					$add_coma='';
					$rightsArray=explode(',', $value->rights);
					if (in_array(3, $rightsArray)){ 

						if($rights!=''){ $add_coma=' , ';}
						$rights .=$add_coma.'Client ';
					}
					if(in_array(4, $rightsArray)){
						if($rights!=''){ $add_coma=' , ';}
						$rights .=$add_coma.'Item Grpup';
					}
					if(in_array(5, $rightsArray)){
						if($rights!=''){ $add_coma=' , ';}
						$rights .=$add_coma.'Item ';
					}
					if(in_array(6, $rightsArray)){ 
						if($rights!=''){ $add_coma=' , ';}
						$rights .=$add_coma.'Order ';
					}
					// End of rights
					if($value->created=="0000-00-00 00:00:00") // if date is not set
					{
						$date_value="00/00/0000"."<br>"." 00:00:00";
					}
					else
					{
						$date_value=$this->$model->date_conversion($value->created,'d/m/Y H:i:s');
					}
					
					$edit = base_url($this->controller.'/edit/'.$this->utility->encode($value->$id));
                                        if ($value->status == 1){
                                            $statusText = 'Active';
                                            $statusAction = base_url($this->controller.'/inactive/'.$this->utility->encode($value->$id));
                                        } else {
                                            $statusText = 'Block';
                                            $statusAction = base_url($this->controller.'/active/'.$this->utility->encode($value->$id));
                                        }
					$delete = base_url($this->controller.'/remove/'.$this->utility->encode($value->$id));
                                        $view = base_url($this->controller.'/view/'.$this->utility->encode($value->$id));
					$nestedData['id'] = $srNo;
					$nestedData['first_name'] = "<a href='$view'><b>$value->first_name</b></a>";
					$nestedData['last_name'] = $value->last_name;
                                        $nestedData['email'] = $value->email;
					$nestedData['mobile_no'] = $value->mobile_no;
					//Admin User rights
					$nestedData['rights']=$rights;
					$nestedData['created'] = $date_value;
					$nestedData['status'] = $statusText;
                                        if ($value->status == 1){
											// $nestedData['manage'] = "<a href='$edit' class='btn  btn-warning  btn-xs'>Edit</a><a href='$delete' class='btn btn-danger btn-xs confirm-delete' >Delete</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Block</a>";
											
											$nestedData['manage'] = "<a class='btn btn-sm btn-primary' href='".$edit."' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Edit'><i class='glyphicon glyphicon-pencil'></i></a>&nbsp;<a href='".$delete."' style='padding: 8px;margin-top:1px;' class='btn btn-danger btn-xs confirm-delete' data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange' style='padding: 8px;margin-top:1px;margin-left: 3px;' data-toggle='tooltip' title='Block'><i class='fa fa-ban'></i></a>";
											
											
                                        } else {
                                            //$nestedData['manage'] = "<a href='$edit' class='btn  btn-warning  btn-xs'>Edit</a>&nbsp;<a href='$delete' class='btn btn-danger btn-xs confirm-delete' >Delete</a>&nbsp;<a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Active</a>";
                                            $nestedData['manage'] = "<a class='btn btn-sm btn-primary' href='".$edit."' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Edit'><i class='glyphicon glyphicon-pencil'></i></a>&nbsp;<a href='".$delete."' style='padding: 8px;margin-top:1px;' class='btn btn-danger btn-xs confirm-delete' data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a>&nbsp;<a href='$statusAction' class='btn  btn-success  btn-xs confirm-statuschange' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Unblock'><i class='fa fa-check'></i></a>";
                                        }
					$data[] = $nestedData;
                                        $srNo++;
				}
			}
     //  echo '<pre>';
                    //    print_r($data); exit;
			$json_data = array(
						"draw"            => intval($this->input->post('draw')),
						"recordsTotal"    => intval($totalData),
						"recordsFiltered" => intval($totalFiltered),
						"data"            => $data
						);
			echo json_encode($json_data);
		}
		public function add()
		{
			$data['action'] = "insert";

			$model = $this->model;

			$data['controller'] = $this->controller;

			$this->load->view($this->view.'/form',$data);
		}
		public function insert()
		{
            $model = $this->model; 
            $data['post'] = $this->input->post();
			$msg_set='';          
			$first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
			$number = $this->input->post('number');
			//Check email exist or not	
			$check_email = $this->db->select('*')->where('email',$email)->where('is_deleted',0)->get($this->table)->result();
			//Check contact number exist or not
			$check_number = $this->db->select('*')->where('mobile_no',$number)->where('is_deleted',0)->get($this->table)->result();
			//if email and mobile no not exist in database then insert admin user.
			if(count($check_email) > 0 || count($check_number) > 0){
				if(count($check_email) > 0){
					$msg_set .='<p>Email Exist.</p>';
				}
				if(count($check_number) > 0){
					$msg_set .='<p>Contact Number Exist.</p>';
				}
				$this->session->set_flashdata($this->msgDisplay,'<span class="7"><div class="alert alert-danger" style=margin-top:15px;"><strong>'.$msg_set.'</strong></div></span>');

				$model = $this->model;

				$data['controller'] = $this->controller;

				$data['action'] = "insert";

				$model = $this->model;

				$data['controller'] = $this->controller;

				$this->load->view($this->view.'/form',$data);
			}else{
                $permissionArray = array();
                if (!empty($this->input->post('user'))){
                  array_push($permissionArray,$this->input->post('user'));
                }
                if (!empty($this->input->post('category'))){
                    array_push($permissionArray,$this->input->post('category'));
                }
                 if (!empty($this->input->post('product'))){
                    array_push($permissionArray,$this->input->post('product'));
                }
                if (!empty($this->input->post('order'))){
                    array_push($permissionArray,$this->input->post('order'));
                }
                $permissions = implode(',', $permissionArray);
				$data = array(
						'first_name' => $first_name,
	                    'last_name' => $last_name,
	                    'email' => $email,
						'mobile_no' => $number,
	                    'password' => md5($this->input->post('password')),
	                    'rights' => $permissions,
	                    'created' => date('Y-m-d H:i:s'),
				);
				$this->$model->insert($this->table,$data);
				$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$first_name.' '.$last_name.' has been added successfully!</div>');
				redirect($this->controller);
			}
			
		}
		public function edit($id)
		{
			$model = $this->model;
			$id = $this->utility->decode($id);
                      
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;
                        

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
                        //echo '<pre>';
                       // print_r($data ['result']); exit;
			$this->load->view($this->view.'/form',$data);
		}
                
        public function view($id)
		{
			$model = $this->model;
			$id = $this->utility->decode($id);
                      
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;
                        

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
                        //echo '<pre>';
                       // print_r($data ['result']); exit;
			$this->load->view($this->view.'/view',$data);
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
                    
            $this->db->select('*');
            $this->db->where('email', $email);
            if(isset($id) && $id!=''){
            	$this->db->where_not_in('id',$id);
            }
            //$q = $this->db->get('users');
            $q = $this->db->get($this->table);
            //echo $this->db->last_query();
            $userData = $q->result_array();
			if(count($check_query) > 0 || count($userData) > 0)
			{
				echo "false";
			}
			else
			{
				echo "true";
			}
		}
                
        public function checknumber()
		{
			$id = $this->input->post('id');
			$number = $this->input->post('number');
			$action = $this->input->post('action');
                    //  echo $action; exit;

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

		public function update()
		{
			$model = $this->model;

			$id = $this->input->post('id');
			$msg_set='';
			$first_name = $this->input->post('first_name');
                        $last_name = $this->input->post('last_name');
                        $email = $this->input->post('email');
			$number = $this->input->post('number');
			//Check email exist or not	
			$check_email = $this->db->select('*')->where_not_in('id',$id)->where('email',$email)->where('is_deleted',0)->get($this->table)->result();
			//Check contact number exist or not
			$check_number = $this->db->select('*')->where_not_in('id',$id)->where('mobile_no',$number)->where('is_deleted',0)->get($this->table)->result();
			//if email and mobile no not exist in database then insert admin user.
			if(count($check_email) > 0 || count($check_number) > 0){
				if(count($check_email) > 0){
					$msg_set .='<p>Email Exist.</p>';
				}
				if(count($check_number) > 0){
					$msg_set .='<p>Contact Number Exist.</p>';
				}
				$this->session->set_flashdata($this->msgDisplay,'<span class="7"><div class="alert alert-danger" style=margin-top:15px;"><strong>'.$msg_set.'</strong></div></span>');
				$data['action'] = "update";

				$model = $this->model;

				$data['controller'] = $this->controller;

				redirect($this->controller.'/edit/'.$this->utility->encode($id));
			}
			else{
                        $permissionArray = array();

                       
                        if (!empty($this->input->post('user'))){
                          array_push($permissionArray,$this->input->post('user'));
                        }
                        if (!empty($this->input->post('category'))){
                            array_push($permissionArray,$this->input->post('category'));
                        }
                           if (!empty($this->input->post('product'))){
                            array_push($permissionArray,$this->input->post('product'));
                        }
                        
                        if (!empty($this->input->post('order'))){
                            array_push($permissionArray,$this->input->post('order'));
                        }
                        $permissions = implode(',', $permissionArray);
                        
	
			$data = array(
				'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $email,
				'mobile_no' => $number,
                            'password' => md5($this->input->post('new_password')),
                                'rights' => $permissions,
			);
			$where = array($this->primary_id=>$id);
			$this->$model->update($this->table,$data,$where);
    
			$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$first_name.' '.$last_name.' has been updated successfully!</div>');
			redirect($this->controller);
			}
		}
		public function remove($id)
		{
			$model  = $this->model;
			$id = $this->utility->decode($id);
              
                        $this->$model->select(array(),'admin_users',array('id'=>$id),'','');
                        $this->db->set('is_deleted',1);
                        $this->db->where('id',$id);
                        $this->db->update('admin_users',$admindata);
                        
                        $this->db->select('first_name, last_name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('admin_users');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata[0]['first_name'].' '.$userdata[0]['last_name'].' has been deleted successfully!</div>');
                        redirect($this->controller);
      
		}

        public function blockform($id)
		{
			$model = $this->model;
			$id = $this->utility->decode($id);
			$data['action'] = "block";
                        $data['id'] = $id;
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
                        $this->db->select('first_name, last_name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('admin_users');
                        $admindata = $q->result_array();

                        $data['first_name'] = $admindata[0]['first_name'];
                        $data['last_name'] = $admindata[0]['last_name'];
			$this->load->view($this->view.'/blockform',$data);
		}
                public function inactive($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
			$this->$model->select(array(),'admin_users',array('id'=>$id),'','');
                        $this->db->set('status',0);
                        $this->db->where('id',$id);
                        $this->db->update('admin_users',$adminData);
                        $this->db->select('first_name, last_name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('admin_users');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata[0]['first_name'].' '.$userdata[0]['last_name'].' has been blocked successfully!</div>');
                        redirect($this->controller);	
		}
                
                public function active($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
                        
			$this->$model->select(array(),'admin_users',array('id'=>$id),'','');
                        $this->db->set('status',1);
                        $this->db->where('id',$id);
                        $this->db->update('admin_users',$admindata);
                        
                        $this->db->select('first_name, last_name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('admin_users');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata[0]['first_name'].' '.$userdata[0]['last_name'].' has been activated successfully!</div>');
                        redirect($this->controller);	
		}
	}
?>