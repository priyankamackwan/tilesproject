<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class User extends CI_Controller
	{
		public $msgName = "Contacts";
		public $view = "user";
		public $controller = "User";
		public $primary_id = "id";
		public $table = "users";
		public $msgDisplay = "user_msg";
		public $model;

		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set('Asia/Kolkata');
			$this->model = "My_model";

			/****** if adminuser is blocked then redirect to login page start*****/
            $dbuserid=$this->session->userdata['logged_in']['id'];

            $check_userlogin=$this->db->select('status')->from('admin_users')->where('id',$dbuserid)->where('status',1)->get();
            if ($check_userlogin->num_rows() == 0) // adminuser is blocked
            {
                $this->session->set_flashdata('dispMessage','<span class="7"><div class="alert alert-danger"><strong>Invalid Login Credential!</strong></div></span>');
                redirect('Adminpanel');
            }
            /****** if adminuser is blocked then redirect to login page end*****/

		}
		public function index()
		{
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
			$data['view'] = $this->view;
			$data['msgDisplay'] = $this->msgDisplay;
			//Add for display in filter dropdown
			$data['all_user'] = $this->db->get("users")->result_array();
			$this->load->view($this->view.'/manage',$data);
		}
		public function server_data()
		{
			$model = $this->model;
			// Define blank
			$where =$company_name=$client_type = $status= '';

			$order_col_id = $_POST['order'][0]['column'];
			$order = $_POST['columns'][$order_col_id]['data'] . ' ' . $_POST['order'][0]['dir'];

			$s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
                        $statusFilter = $_POST['columns'][2]['search']['value'];
			$totalData = $this->$model->countTableRecords($this->table,array('is_deleted'=>0));

			$start = $_POST['start'];
			$limit = $_POST['length'];

			//Fetch from filter and in where condition
			$company_name = $this->input->post('company_name');
			$status = $this->input->post('status');
			$client_type = $this->input->post('client_type');
			

			if(!empty($company_name)){

                if($where == null){
                    $where .= 'LOWER(company_name) = "'.strtolower($company_name).'" ';
                }else{
                    $where .= ' AND LOWER(company_name) = "'.strtolower($company_name).'" ';
                }
            }
            if(!empty($status)){

                if($status == 4){
                    $status = 0;
                }

                if($where == null){
                    $where .= 'status = "'.$status.'"';
                }else{
                    $where .= ' AND status = "'.$status.'"';
                }
            }
            if(!empty($client_type)){
                if($where == null){
                    $where .= 'client_type = "'.$client_type.'"';
                }else{
                    $where .= ' AND client_type = "'.$client_type.'"';
                }
            }
            // Add new condition for serach datatable serach box
            if(!empty($s)){
            	if($where != null){
                    $where.= ' AND ';
                }
            	$where .= '(users.company_name LIKE "'.$s.'%" or ';
            	$where .= 'users.contact_person_name LIKE "'.$s.'%" or ';
            	$where .= 'users.email LIKE "'.$s.'%" or ';
            	//$where .= 'users.client_type LIKE "'.$s.'%" or ';
            	$where .= 'users.vat_number LIKE "'.$s.'%" or ';
            	$where .= 'users.phone_no LIKE "'.$s.'%" )';
            }
            if($statusFilter == 1) {
            	$statusFilter=0;
            }elseif($statusFilter == 2) {
            	$statusFilter=1;
            }elseif($statusFilter == 3) {
            	$statusFilter=2;
            }
            elseif($statusFilter == 4) {
            	$statusFilter=3;
            }
            if(!empty($statusFilter)){
            	if($where != null){
                    $where.= ' AND ';
                }
            	$where .= '(users.status LIKE "'.$statusFilter.'%" )';
            }
            // End New condition
            //$where For filter data
            		  if(!empty($where)){
            		  	
            		  	$s='';
            		  	$q = $this->db->select('*')->where('is_deleted', 0)->where($where);
            		  }
                      elseif (empty($statusFilter)){
                            $q = $this->db->select('*')->where('is_deleted', 0);
                        } elseif($statusFilter == 1) {
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('status', 0);
                        } elseif($statusFilter == 2) {
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('status',1);
                        }  elseif($statusFilter == 3) {
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('status',2);
                        } elseif($statusFilter == 4) {
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('status',3);
                        }else {
                            $q = $this->db->select('*')->where('is_deleted', 0);
                        }
                        
			if(empty($s))
			{
				if(!empty($order))
				{
					$q = $q->order_by('users.'.$order);
				}
				$q = $q->limit($limit, $start)->get($this->table)->result();
				$totalFiltered = $totalData;

				// add query for totalFiltered count for filter
				if(!empty($where)){
					 $totalFiltered = $this->db->select('*')->where('is_deleted', 0)->where($where)->get($this->table)->num_rows();
				}
			}
			else
			{
				$q = $q->like('users.company_name', $s, 'both');
				$q = $q->or_like('users.contact_person_name', $s, 'both');
				$q = $q->or_like('users.email', $s, 'both');
                $q = $q->or_like('users.vat_number', $s, 'both');
                $q = $q->or_like('users.phone_no', $s, 'both');
				if(!empty($order))
				{
					$q = $q->order_by($order);
				}
				//->limit($limit, $start)
				$q = $q->get($this->table)->result();

				$totalFiltered = count($q);
			}
			//print_r($q);
			$data = array();
			if(!empty($q))
			{
                $startNo = $_POST['start'];
                $srNo = $startNo + 1;
				foreach ($q as $key=>$value)
				{
					$model = $this->model;
					$id = $this->primary_id;
					
                                        if ($value->status == 0){
                                            $accept = base_url($this->controller.'/acceptform/'.$this->utility->encode($value->$id));
                                            $reject = base_url($this->controller.'/reject/'.$this->utility->encode($value->$id));
											// $statusText = 'Pending';
											$statusText = 'Pending <br /><a href="'.$accept.'" class="btn btn-success btn-xs" style="padding: 8px;margin-top:1px;" data-toggle="tooltip" title="Accept"><i class="fa fa-check"></i></a>&nbsp;<a href="'.$reject.'" class="btn btn-danger btn-xs" data-toggle="tooltip" style="padding: 8px;margin-top:1px;" title="Reject"><i class="fa fa-ban"></i></a>';
                                        }
                                        if ($value->status == 3) {
                                            $statusText = 'Rejected';
                                        }
                                        $view = base_url($this->controller.'/view/'.$this->utility->encode($value->$id));
                                        if ($value->status == 1) {
                                            $statusText = 'Active';
                                            $accept = base_url($this->controller.'/acceptform/'.$this->utility->encode($value->$id));
                                            $statusAction = base_url($this->controller.'/inactive/'.$this->utility->encode($value->$id));
                                        } elseif($value->status == 2) {
                                            $statusText = 'Block';
                                            $statusAction = base_url($this->controller.'/active/'.$this->utility->encode($value->$id));
                                        }
                                        $delete = base_url($this->controller.'/remove/'.$this->utility->encode($value->$id));
                                        $view = base_url($this->controller.'/view/'.$this->utility->encode($value->$id));
					$nestedData['id'] = $srNo;
					$nestedData['company_name'] ="<a href='$view'><b>$value->company_name</b></a>";
					$nestedData['contact_person_name'] = $value->contact_person_name;
                                        $nestedData['email'] = $value->email;
                                        $nestedData['phone_no'] = $value->phone_no;
					$nestedData['vat_number'] = $value->vat_number;
                                        if ($value->client_type == 1) {
                                            $nestedData['client_type'] = 'Cash';
                                        } elseif($value->client_type == 2) {
                                            $nestedData['client_type'] = 'Credit';
                                        } elseif($value->client_type == 3) {
                                            $nestedData['client_type'] = 'Walkin';
                                        } else {
                                            $nestedData['client_type'] = 'Flexible Rate';
                                        }
                    $nestedData['created'] = $this->$model->date_conversion($value->created,'d/m/Y H:i:s');
					$nestedData['status'] = $statusText;
                                        if ($value->status == 0) {
											// $nestedData['manage'] = "<a href='$accept' class='btn  btn-warning  btn-xs'>Accept</a><a href='$reject' class='btn btn-danger btn-xs' >Reject</a><a href='$delete' class='btn  btn-warning  btn-xs confirm-delete-user'>Delete</a>";
											
											$nestedData['manage'] = "<a href='$delete' class='btn  btn-danger  btn-sm confirm-delete-user' style='padding: 8px;margin-top:1px;'><i class='fa fa-trash'></i></a>";

										} elseif ($value->status == 1){
											// $nestedData['manage'] = "<a href='$accept' class='btn  btn-warning  btn-xs'>Edit</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Block</a><a href='$delete' class='btn  btn-warning  btn-xs confirm-delete-user'>Delete</a>";
											
											$nestedData['manage'] = '<a href="'.$view.'" style="padding: 8px;margin-top:1px;" class="btn btn-primary   btn-xs "  title="View"><i class="fa fa-eye"></i></a>&nbsp;<a class="btn btn-sm btn-info" href="'.$accept.'" style="padding: 8px;margin-top:1px;" data-toggle="tooltip" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;<a href="'.$statusAction.'" class="btn btn-warning btn-xs confirm-statuschange" style="padding: 8px;margin-top:1px;" data-toggle="tooltip" title="Block"><i class="fa fa-ban"></i></a>&nbsp;<a href="'.$delete.'" style="padding: 8px;margin-top:1px;" class="btn btn-danger btn-xs confirm-delete-user" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                                        } elseif ($value->status == 2) {
											// $nestedData['manage'] = "<a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Active</a><a href='$delete' class='btn  btn-warning  btn-xs confirm-delete-user'>Delete</a>";
											
											$nestedData['manage'] = '<a href="'.$view.'" style="padding: 8px;margin-top:1px;" class="btn btn-primary   btn-xs "  title="View"><i class="fa fa-eye"></i></a>&nbsp;<a style="padding: 8px;margin-top:1px;" href="'.$statusAction.'" class="btn btn-success btn-sm confirm-statuschange" data-toggle="tooltip" title="Active"><i class="fa fa-check"></i></a>&nbsp;<a href="'.$delete.'" style="padding: 8px;margin-top:1px;" class="btn btn-danger btn-xs confirm-delete-user" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
                                        } else {
											// $nestedData['manage'] = "<a href='$delete' class='btn  btn-warning  btn-xs confirm-delete'>Delete</a>";

											$nestedData['manage'] = '<a href="'.$view.'" style="padding: 8px;margin-top:1px;" class="btn btn-primary   btn-xs "  title="View"><i class="fa fa-eye"></i></a>&nbsp;<a style="padding: 8px;margin-top:1px;" href="'.$delete.'" class="btn btn-danger btn-sm confirm-delete" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
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
           
			$first_name = $this->input->post('first_name');
                        $last_name = $this->input->post('last_name');
                        $email = $this->input->post('email');
			$number = $this->input->post('number');
                        $gender = $this->input->post('gender');
                        $age_group = $this->input->post('age_group');
			$data = array(
				'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $email,
				'mobile_no' => $number,
                                'gender' => $gender,
                                'age_group' => $age_group,

			);
			$this->$model->insert($this->table,$data);
			$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$this->msgName.' Insert Successfully!</div>');
			redirect($this->controller);
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
			$a = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');

			$this->load->view($this->view.'/view',$data);
		}

                
        public function inactive($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
			$this->$model->select(array(),'users',array('id'=>$id),'','');
                        $this->db->set('status',2);
                        $this->db->where('id',$id);
                        $this->db->update('users',$data);
                        
                         $this->db->select('company_name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('users');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata[0]['company_name'].' has been blocked successfully!</div>');
                        redirect($this->controller);	
		}
               
                
        public function active($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
                          
			$this->$model->select(array(),'users',array('id'=>$id),'','');
                        $this->db->set('status',1);
                        $this->db->where('id',$id);
                        $this->db->update('users',$data);
                        
                         $this->db->select('company_name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('users');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata[0]['company_name'].' has been activated successfully!</div>');
                        redirect($this->controller);	
		}
                
        public function accept(){
			$model = $this->model;
                        $id = $this->input->post('id');
                        $client_type = $this->input->post('client_type');
                        // Add new fileds for update
                       $company_name = $this->input->post('company_name');
                       $contact_person_name = $this->input->post('contact_person_name');
                       $email = $this->input->post('email');
                       $phone_no = $this->input->post('phone_no');
                       $vat_number = $this->input->post('vat_number');
                       $company_address = $this->input->post('company_address');
                       $data=array(
                       			'company_name' => $company_name,
                       			'company_address' => $company_address,
                       			'contact_person_name' => $contact_person_name,
                       			'vat_number' => $vat_number,
                       			'phone_no' => $phone_no,
                       			'email' => $email,
                       			'client_type' => $client_type,
                       			'modified'	=> date('Y-m-d h:i:s')
                       		);
			$this->$model->select(array(),'users',array('id'=>$id),'','');
                        $this->db->set('status',1);
                        //$this->db->set('client_type',$client_type);
                        $this->db->where('id',$id);
                        $this->db->update('users',$data);
                        $this->db->select('company_name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('users');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata[0]['company_name'].' has been approved successfully!</div>');
                        redirect($this->controller);	
		}

                
        public function acceptform($id)
        {
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
			$data['action'] = "block";
            $data['id'] = $id;
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
			/* OLd Query
                         $this->db->select('client_type');
                        $this->db->where('id', $id);
                        $q = $this->db->get('users');
                        $userdata = $q->result_array();
        $data['client_type'] = $userdata[0]['client_type'];
        				*/

			$this->db->select('*');
			$this->db->where('id', $id);
			$q = $this->db->get('users');
			$data['user_data'] = $q->row();
			$this->load->view($this->view.'/acceptform',$data);
		}
                
        public function reject($id) 
        {
                    
			$model = $this->model;
			$id = $this->utility->decode($id);
            $this->$model->select(array(),'users',array('id'=>$id),'','');
            $this->db->set('status',3);
            $this->db->where('id',$id);
            $this->db->update('users',$data);
            
            $this->db->select('company_name');
            $this->db->where('id', $id);
            $q = $this->db->get('users');
            $userdata = $q->result_array();
            $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata[0]['company_name'].' has been rejected successfully!</div>');
            redirect($this->controller);
		}
            

        public function remove($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
			$this->$model->select(array(),'users',array('id'=>$id),'','');
                        
            $this->db->where('user_id', $id);
            $this->db->delete('orders'); 
            
            $this->db->where('id', $id);
            $this->db->delete('users'); 
            
           
            $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Contact has been deleted successfully!</div>');
            redirect($this->controller);
		}
                
        public function addUsers() {
                                  // Report all errors
				error_reporting(E_ALL);
				ini_set("error_reporting", E_ALL);
					$importFile = $_FILES['upload_contacts']['name'];

					$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

					if(!in_array($_FILES["upload_contacts"]["type"],$allowedFileType))
					{
						
						$this->session->set_flashdata('imagetype','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>File type not valid</div>');
						redirect($this->controller.'/uploadContacts');	
					}
                    
                    $ext = pathinfo($importFile,PATHINFO_EXTENSION);
			$image = time().'.'.$ext;

			$config['upload_path'] = 'assets/uploads/';
			$config['file_name'] = $image;
			// $config['allowed_types'] = "jpeg|jpg|png|gif|xlsx|xls";
			$config['allowed_types'] = "txt|csv|xlsx|xls";
			
			$this->load->library('upload', $config);
			$this->load->initialize($config);
			$this->upload->do_upload('upload_contacts');
                      
	$model = $this->model;
	require('spreadsheet-reader-master'.DIRECTORY_SEPARATOR.'php-excel-reader'.DIRECTORY_SEPARATOR.'excel_reader2.php');

	require('spreadsheet-reader-master'.DIRECTORY_SEPARATOR.'SpreadsheetReader.php');
	
	ini_set("include_path", '/home/pnp1/php:' . ini_get("include_path") );
	
	//echo FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads'.'/'.$image;die;
	$Reader = new SpreadsheetReader(FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads'.'/'.$image);

	//die("here123");
	//FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads'.'/'.$image;

    $i=0;
	foreach ($Reader as $Row)
	{
		if($i!=0)
		{
			if($Row[$i]=="")
			{
				break;
			}
			else
			{
	        	$data = array(
						'company_name' => $Row[0],
						'company_address' => $Row[1],
						'contact_person_name' => $Row[2],
						'vat_number' => $Row[3],
						'email' => $Row[4],
						'phone_no' => $Row[5],
						'password' => md5($Row[6]),
						'client_type' => $Row[7],
						'created' => date('Y-m-d H:i:s')
				);
				$this->$model->insert('users',$data);		        
			}
		}
		$i++;       
	}

    	$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Contacts has been imported successfully!</div>');
       	redirect($this->controller);	
    }
    
    public function uploadContacts()
    {
		$this->load->view($this->view.'/uploadContacts',array());
    }
}
?>