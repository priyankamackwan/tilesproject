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
            $order_col_id = $_POST['order'][0]['column'];
            $dir = $this->input->post('order')[0]['dir'];
            $tableFieldData = [];
            $where = $whereDate ='';
            //date change 
            $whereDatechange='no';
            $order = $_POST['columns'][$order_col_id]['data'] . ' ' . $_POST['order'][0]['dir'];
            $s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
            $statusFilter = $_POST['columns'][2]['search']['value'];
            $start = $_POST['start'];
            $limit = $_POST['length'];
            // User username for filter
            $username = $this->input->post('userName');
            // User productId for filter
            $productId = $this->input->post('productId');
            // User salesOrderDate for filter
            $salesOrderDate = $this->input->post('salesOrderDate');

            $Status = $this->input->post('Status');

            if(!empty($username)){
                if($where == null){
                    $where .= 'LOWER(users.company_name) = "'.strtolower($username).'" ';
                }else{
                    $where .= ' AND LOWER(users.company_name) = "'.strtolower($username).'" ';
                }
            }
            if(!empty($productId) && $productId > 0){
                if($where == null){
                    $where .= 'order_products.product_id = "'.$productId.'"';
                }else{
                    $where .= ' AND order_products.product_id = "'.$productId.'"';
                }
            }
            if(!empty($salesOrderDate) && isset($_POST['startdate'])){

                $whereDate .= '(DATE_FORMAT(sample_requests.created,"%Y-%m-%d") BETWEEN "'.$_POST['startdate'].'" AND "'.$_POST['enddate'].'")';
                $whereDatechange='yes';
            }
            if(!empty($Status)){
                
                if(strtolower($Status) == 'new'){
                    $smp_status = 1;
                }elseif (strtolower($Status) == 'approved') {
                    $smp_status = 2;
                }elseif (strtolower($Status) == 'cancelled') {
                    $smp_status = 3;
                }
                
                if($where == null){
                    $where .= 'sample_requests.status = "'.$smp_status.'"';
                }else{
                    $where .= ' AND sample_requests.status = "'.$smp_status.'" ';
                }
            }
            $totalData = $this->samples_model->get_SampleDatatables('','','','',$where,'','',$whereDate,$this->table);
            // Filter data using serach.
            if(!empty($this->input->post('search')['value']))
            {
                if($where != null){
                    $where.= ' AND ';
                }
                $status=$status=strtolower($this->input->post('search')['value']);
                if(strtolower($this->input->post('search')['value']) == 'new'){
                    $status = 1;
                }elseif (strtolower($this->input->post('search')['value']) == 'approved') {
                    $status = 2;
                }elseif (strtolower($this->input->post('search')['value']) == 'cancelled') {
                    $statuss = 3;
                }
                // Serch bar value
                $search=$this->input->post('search')['value'];

                $where .= '(users.company_name LIKE "'.$search.'%" or ';

                $where .= 'sample_requests.status LIKE "'.$status.'%" )';
            }
            $AlltotalFiltered = $this->samples_model->get_SampleDatatables($limit,$start,$dir,'','',$whereDate,$table);
            $totalFiltered = $totalData['count'];
            $this->$model->countTableRecords($this->table,array('is_deleted'=>0));
            $data = array();
            $q = $this->db->where(['is_deleted' => 0 ])->get("sample_requests")->result();
            
            if(!empty($q)) {

                $startNo = $_POST['start'];
                $srNo = $startNo + 1;

                foreach ($q as $key=>$value) {

                    $model = $this->model;
                    $id = $this->primary_id;

                    if($value->status=="1") {
                        $status = "New";
                    } else if($value->status=="2") {
                        $status = "Approved";
                    } else if($value->status=="3") {
                        $status = "Cancelled";
                    }

                    if($value->created=="0000-00-00 00:00:00") {
                        $date_value="00/00/0000"."<br>"." 00:00:00";
                    } else {
                        $date_value=$this->$model->date_conversion($value->created,'d/m/Y H:i:s');
                    }
                    
                    $edit = base_url($this->controller.'/edit/'.$this->utility->encode($value->$id));
                    $delete = base_url($this->controller.'/remove/'.$this->utility->encode($value->$id));
                    $view = base_url($this->controller.'/view/'.$this->utility->encode($value->$id));

                    $username = $this->db->where('id',$value->user_id)->get("users")->result();
                    $item = $this->db->where('id',$value->product_id)->get("products")->result();
                    $nestedData['id'] = $srNo;
                    $nestedData['product_id'] = $item[0]->name;
                    $nestedData['user_name'] = $username[0]->company_name;
                    $nestedData['tax'] = 
                    $nestedData['cargo'] = $value->cargo;$value->tax;
                    $nestedData['cargo_number']= $value->cargo_number;
                    $nestedData['location'] = $value->location;
                    $nestedData['mark'] = $value->mark;
                    $nestedData['status'] = $status;
                    $nestedData['created'] = $date_value;
                    
                    if ($value->status == 1){
                        $nestedData['manage'] = "<a class='btn btn-sm btn-primary' href='".$edit."' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Edit'><i class='glyphicon glyphicon-pencil'></i></a>&nbsp;<a href='".$delete."' style='padding: 8px;margin-top:1px;' class='btn btn-danger btn-xs confirm-delete' data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a>&nbsp;<a href='".$view."' class='btn btn-info btn-sm' style='padding:8px;' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";
                    } else {
                        $nestedData['manage'] = "<a class='btn btn-sm btn-primary' href='".$edit."' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Edit'><i class='glyphicon glyphicon-pencil'></i></a>&nbsp;<a href='".$delete."' style='padding: 8px;margin-top:1px;' class='btn btn-danger btn-xs confirm-delete' data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a>&nbsp;<a href='".$view."' class='btn btn-info btn-sm' style='padding:8px;' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";
                    }
                    $data[] = $nestedData;
                    $srNo++;
                }
            }

            $json_data = array(
                "draw"            => intval($this->input->post('draw')),
                "recordsTotal"    => intval($totalData['count']),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );
            echo json_encode($json_data);
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

    public function edit($id){
                  
            $model = $this->model;
            $id = $this->utility->decode($id);
            //Add meta title
            $data['meta_tital']='Sample Request | PNP Building Materials Trading L.L.C';
            $data['action'] = "update";
            $data['msgName'] = $this->msgName;
            $data['primary_id'] = $this->primary_id;
            $data['controller'] = $this->controller;
            $data['activeProducts'] = $this->db->get("products")->result_array();
            $data['activecustomer'] = $this->db->where('status',1)->get("users")->result_array();
            $data['id']=$id;
            $model = $this->model;
            $data ['result'] = $this->samples_model->view_all_sample_request($id);
              //Previous ann Next Button (03-03-2021)
              $ninv = $this->db->where('id  >',$id)->limit(1)->get('sample_requests')->row();
              if(!empty($ninv)) {
                $next = $ninv->id;
                $data['next'] = $next;
              }else  {
                $ninvs = $this->db->where('id',$id)->limit(1)->get('sample_requests')->row();
                $next = $ninvs->id;
                $data['next'] = $next;
              }
              $pinv =  $this->db->where('id  <',$id)->order_by('id','desc')->get('sample_requests')->row();
              if(!empty($pinv)) {
                $prev = $pinv->id;
                $data['prev'] = $prev;
              }else  {
                $pinvs = $this->db->where('id',$id)->limit(1)->get('sample_requests')->row();
                $prev = $pinvs->id;
                $data['prev'] = $prev;
              }
            $this->load->view($this->view.'/form',$data);
    }

    public function Update() {

        $model = $this->model;
        $id = $this->input->post('id');
        $username = $this->input->post('username');
        $product_id = $this->input->post('product_id');
        $tax = $this->input->post('tax');
        $cargo = $this->input->post('cargo');
        $cargo_number = $this->input->post('cargo_number');
        $location = $this->input->post('location');
        $mark = $this->input->post('mark');
        $status = $this->input->post('status');

        $data = array(
            'product_id' => $product_id,
            'user_id' => $username,
            'tax' => $tax,
            'cargo' => $cargo,
            'cargo_number' => $cargo_number,
            'location' => $location,
            'mark' => $mark,
            'status' => $status
        );
        $where = array($this->primary_id=>$id);
        $this->$model->update($this->table,$data,$where);
        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Sample Request has been updated successfully!</div>');
        redirect($this->controller);
    }

    public function remove($id) {

        $model = $this->model;
        $company_name=array();
        $user_data_name='';
        //id
        $id = $this->utility->decode($id);
        $delete_sample_request = $this->samples_model->view_all_sample_request($id);
        foreach ($delete_sample_request as $key => $value) {
            if(isset($value['company_name']) && $value['company_name']!=''){
                $user_data_name=$value['company_name'];
            }
        }
        //is delete 1 for order delete
        $this->db->set('is_deleted','1');
        $this->db->where('id',$id);
        $this->db->update('sample_requests'); 
        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$user_data_name.' has been deleted successfully!</div>');
        redirect($this->controller);    
    }

     public function view($id) {
            
            $model = $this->model;
            $id = $this->utility->decode($id);
            //Add meta title
            $data['meta_tital']='Sample Request | PNP Building Materials Trading L.L.C';
            $data['action'] = "update";
            $data['msgName'] = $this->msgName;
            $data['primary_id'] = $this->primary_id;
            $data['controller'] = $this->controller;

            $model = $this->model;

            $data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
            $data['activeProducts'] = $this->db->where('id',$data['result'][0]->product_id)->get("products")->result();
            $data['activecustomer'] = $this->db->where(['status'=> 1,'id' => $data['result'][0]->user_id])->get("users")->result();
            // Previous ann Next Button (03-03-2021)
              $ninv = $this->db->where('id  >',$id)->limit(1)->get('sample_requests')->row();
              if(!empty($ninv)) {
                $next = $ninv->id;
                $data['next'] = $next;
              }else  {
                $ninvs = $this->db->where('id',$id)->limit(1)->get('sample_requests')->row();
                $next = $ninvs->id;
                $data['next'] = $next;
              }
              $pinv =  $this->db->where('id  <',$id)->order_by('id','desc')->get('sample_requests')->row();
              if(!empty($pinv)) {
                $prev = $pinv->id;
                $data['prev'] = $prev;
              }else  {
                $pinvs = $this->db->where('id',$id)->limit(1)->get('sample_requests')->row();
                $prev = $pinvs->id;
                $data['prev'] = $prev;
              }
            $this->load->view($this->view.'/view',$data);
        }
        
    function next() {

        $id = intval($this->input->post('id'));
        $this->db->select("*");
        $this->db->from('sample_requests');
        //$this->db->join('users','users.id = orders.user_id');
        //$this->db->order_by('users.company_name','desc');
        $query = $this->db->where('sample_requests.id  >',$id)->limit(1)->get()->row();
        if(!empty($query)){
            $status ="success";
            echo json_encode(array("status"=>$status,"url"=>$this->utility->encode($query->id)));
            exit();
        }else {
            $status ="fail";
            $lastinv = $this->db->where('id',$id)->get('sample_requests')->row();
            echo json_encode(array("status"=>$status,"inv"=> $lastinv->id));
            exit();
        }
        exit();
    }

    function previous() {
        $id = intval($this->input->post('id'));
        $query = $this->db->where('id  <',$id)->order_by('id','desc')->get('sample_requests')->row();
        if(!empty($query)){
            $status ="success";
            echo json_encode(array("status"=>$status,"url"=>$this->utility->encode($query->id)));
            exit();
        }else {
            $status ="fail";
            $lastinv = $this->db->where('id',$id)->get('sample_requests')->row();
            echo json_encode(array("status"=>$status,"inv"=> $lastinv->id));
            exit();
        }
        exit();
    }

           
}
        
                
                
            