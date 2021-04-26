<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
defined('BASEPATH') OR exit('No direct script access allowed');

class SampleRequest extends CI_Controller {

	public $msgName = "Sample Request";
	public $view = "sample_request";
	public $controller = "SampleRequest";
	public $primary_id = "id";
	public $table = "sample_requests";
	public $msgDisplay ='Sample Request';
	public $model;

	public function __construct() {

		parent::__construct();
		date_default_timezone_set('Asia/Dubai');

        $this->model = "My_model";
        $this->load->model('samples_model');
        $this->load->library('session'); 

        if (!in_array(6,$this->userhelper->current('rights'))) {
            $this->session->set_flashdata('ff','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>No Rights for this module</div>');
            redirect('Change_password');
        }

        /****** if adminuser is blocked then redirect to login page start*****/
        $dbuserid=$this->session->userdata['logged_in']['id'];
        $check_userlogin=$this->db->select('status')->from('admin_users')->where('id',$dbuserid)->where('status',1)->get();
        // adminuser is blocked
        if ($check_userlogin->num_rows() == 0) {
            $this->session->set_flashdata('dispMessage','<span class="7"><div class="alert alert-danger"><strong>Invalid Login Credential!</strong></div></span>');
            redirect('Adminpanel');
        }
        /****** if adminuser is blocked then redirect to login page end*****/
	}
	
    public function index() {
                   
        $this->userhelper->current('logged_in')['is_logged'] = 1;
        //Add meta title
        $data['meta_tital'] = 'Sample Request | PNP Building Materials Trading L.L.C';
        $data['msgName'] = $this->msgName;
        $data['primary_id'] = $this->primary_id;
        $data['controller'] = $this->controller;
        $data['view'] = $this->view;
        $data['msgDisplay'] = $this->msgDisplay;

        $this->db->where('status',1);
        $this->db->where('is_deleted',0);
        $data['activeUsers'] = $this->db->where('status',1)->where('is_deleted',0)->get("users")->result_array();
        $this->db->where('status',1);
        $this->db->where('is_deleted',0);
        $data['activeProducts'] = $this->db->where('status',1)->where('is_deleted',0)->get("products")->result_array();
        $this->load->view($this->view.'/manage',$data);
    }

    public function server_data() {

        $model = $this->model;
        // Column array
        $columnArray = array(
            1 => 'users.company_name' ,
            2 => 'sample_requests.product_id' ,
            3 => 'sample_requests.tax' ,
            4 => 'sample_requests.cargo' ,
            5 => 'sample_requests.cargo_number' ,
            6 => 'sample_requests.location',
            7 => 'sample_requests.mark' ,
            8 => 'sample_requests.status',
            9 => 'sample_requests.created' ,
        );

        $model = $this->model;
        $data = array();
        $srNo = $startNo + 1;
        $q = $this->db->get('sample_requests')->result();

        foreach ($q as $key=>$value) {
            
            $id = $this->primary_id;
            $multipleWhere2 = ['id' => $value->user_id];
            $this->db->where($multipleWhere2);
            $userData = $this->db->get("users")->result_array();
    
            $view = base_url($this->controller.'/view/'.$this->utility->encode($value->$id));

            $nestedData['id'] = $srNo;
            $nestedData['user_name'] = $userData[0]['company_name'];
            $nestedData['product_id'] = $value->product_id;
            $nestedData['tax'] = $value->tax;
            $nestedData['cargo'] = $value->cargo;
            $nestedData['cargo_number'] = $value->cargo_number;
            $nestedData['location'] = $value->location;
            $nestedData['mark'] = $value->mark;
            
            if ($value->status == 0) { 
                $nestedData['status'] = 'Pending';
            } elseif($value->status == 1) {
                $nestedData['status'] ='In Progress';
            } else {
                $nestedData['status'] ='Completed';
            }
            $nestedData['manage'] = "<a href='$view' class='btn btn-primary btn-sm' style='padding:8px;' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";

            $data[] = $nestedData;
            $srNo++;
        }
        echo json_encode($data);
    }

    function newsample() {
        $this->msgName = "New Sample Request";
        $data['activecustomer'] = $this->db->where('status',1)->get("users")->result_array();
        $data['activeProducts'] = $this->db->where('status',1)->where('is_deleted',0)->get("products")->result_array();
        $this->load->view($this->view.'/newsamplerequest',$data);
    }

    function submitRequest() {

        $model = $this->model;
        $sampleData = array();

        $sampleData = array(
            'user_id' => $_POST['usersList'],
            'product_id' => $_POST['productsList'],
            'tax' => Vat,
            'cargo' => $_POST['cargo'],
            'cargo_number' => $_POST['cargo_number'],
            'location' => $_POST['location'],
            'mark' => $_POST['mark'],
            'status' => $_POST['status'],
            'created' => date('Y-m-d h:i:s')
        );
        $this->$model->insert('sample_requests',$sampleData);  
        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button> Sample Request has been added successfully!</div>');
        redirect($this->controller);
    }
}
        
                
                
            