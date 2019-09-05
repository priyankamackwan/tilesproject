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
			$totalData = $this->$model->countTableRecords($this->table,array('is_deleted'=>0));

			$start = $_POST['start'];
			$limit = $_POST['length'];
                      if (empty($statusFilter)){
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
                                            $statusText = 'Pending';
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
					$nestedData['status'] = $statusText;
                                        if ($value->status == 0) {
                                            $nestedData['manage'] = "<a href='$accept' class='btn  btn-warning  btn-xs'>Accept</a><a href='$reject' class='btn btn-danger btn-xs' >Reject</a><a href='$delete' class='btn  btn-warning  btn-xs confirm-delete-user'>Delete</a>";
                                        } elseif ($value->status == 1){
                                            $nestedData['manage'] = "<a href='$accept' class='btn  btn-warning  btn-xs'>Edit</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Block</a><a href='$delete' class='btn  btn-warning  btn-xs confirm-delete-user'>Delete</a>";
                                        } elseif ($value->status == 2) {
                                            $nestedData['manage'] = "<a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Active</a><a href='$delete' class='btn  btn-warning  btn-xs confirm-delete-user'>Delete</a>";
                                        } else {
                                            $nestedData['manage'] = "<a href='$delete' class='btn  btn-warning  btn-xs confirm-delete'>Delete</a>";
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
                       
			$this->$model->select(array(),'users',array('id'=>$id),'','');
                        $this->db->set('status',1);
                        $this->db->set('client_type',$client_type);
                        $this->db->where('id',$id);
                        $this->db->update('users',$data);
                        
                        $this->db->select('company_name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('users');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata[0]['company_name'].' has been approved successfully!</div>');
                        redirect($this->controller);	
		}
                
                    public function acceptform($id){
                   
				$model = $this->model;
			$id = $this->utility->decode($id);
			$data['action'] = "block";
                        $data['id'] = $id;
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
                         $this->db->select('client_type');
                        $this->db->where('id', $id);
                        $q = $this->db->get('users');
                        $userdata = $q->result_array();
        $data['client_type'] = $userdata[0]['client_type'];
			$this->load->view($this->view.'/acceptform',$data);
		}
                
                public function reject($id) {
                    
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
                                  
                    $importFile = $_FILES['upload_contacts']['name'];
                    
                    $ext = pathinfo($importFile,PATHINFO_EXTENSION);
			$image = time().'.'.$ext;

			$config['upload_path'] = 'assets/uploads/';
			$config['file_name'] = $image;
			$config['allowed_types'] = "jpeg|jpg|png|gif|xlsx";

			$this->load->library('upload', $config);
			$this->load->initialize($config);
			$this->upload->do_upload('upload_contacts');
                      
	$model = $this->model;
require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');

	require('spreadsheet-reader-master/SpreadsheetReader.php');

	$Reader = new SpreadsheetReader(FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads'.'/'.$image);

        $i=0;
	foreach ($Reader as $Row)
	{
            if ($i !=0) {
              
            
            	$data = array(
				'company_name' => $Row[0],
                                'company_address' => $Row[1],
                                'contact_person_name' => $Row[2],
				'vat_number' => $Row[3],
                                'email' => $Row[4],
                                'phone_no' => $Row[5],
                     'password' => md5($Row[6]),
                     'client_type' => $Row[7],

			);
			$this->$model->insert('Users',$data);
            } 
            $i++;
	}
        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Contacts has been imported successfully!</div>');
       redirect($this->controller);	
    }
    
    public function uploadContacts(){
       

			$this->load->view($this->view.'/uploadContacts',array());
    }
	}
?>