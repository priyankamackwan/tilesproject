<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Best_seller extends CI_Controller
  {
    public $msgName = "Order";
    public $view = "best_seller";
    public $controller = "Best_seller";
    public $primary_id = "id";
    public $table = "order_products";
    public $msgDisplay ='order';
    public $model;

    public function __construct()
    {
                    
      parent::__construct();
      date_default_timezone_set('Asia/Dubai');
      $this->model = "My_model";
   
      if (!in_array(3,$this->userhelper->current('rights'))) {
        $this->session->set_flashdata('ff','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>No Rights for this module</div>');
        redirect('Change_password');
      }
    }
    public function index() {
      $this->userhelper->current('logged_in')['is_logged'] = 1;
      //Add meta title
      $data['meta_tital']='Best Seller | PNP Building Materials Trading L.L.C';
      $data['msgName'] = $this->msgName;
      $data['primary_id'] = $this->primary_id;
      $data['controller'] = $this->controller;
      $data['view'] = $this->view;
      $data['msgDisplay'] = $this->msgDisplay;
      // Add for dispaly in filter
      $data['all_user'] = $this->db->where('is_deleted',0)->get("users")->result_array();
      $this->load->view($this->view.'/manage',$data);
    }
                
    public function server_data() {
      //for sorting column
      $columnArray = array(
                1 => 'u.company_name',
                2 => 'u.contact_person_name',
                3 => 'totalValue',
            );
      // Order by
      $order = $columnArray[$this->input->post('order')[0]['column']];

      // set default order
      $dir = $this->input->post('order')[0]['dir'];
                    
      $model = $this->model;
      $company_name='';
      $company_name = $this->input->post('company_name');
      $s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
      if(!empty($company_name)){

        if($where == null){
            $where .= 'LOWER(u.company_name) = "'.strtolower($company_name).'" ';
        }else{
            $where .= ' AND LOWER(u.company_name) = "'.strtolower($company_name).'" ';
        }
      }
      if(isset($s) && $s!=''){
          if($where != null){
            $where .='AND';  
          }
          $where .= '(u.contact_person_name LIKE "'.$s.'%" or ';

          $where .= 'u.company_name LIKE "%'.$s.'%" ) ';
      }
      
      $totalData = $this->$model->best_seller_count($where);
                       
      $start = $_POST['start'];
      $limit = $_POST['length'];

                        
      $this->db->select('o.id,o.user_id,SUM(o.total_price * o.tax / 100 + o.total_price) as totalValue,SUM(o.sales_expense) as total_sales_expense,o.invoice_no,u.company_name,u.contact_person_name,o.created');
      $this->db->from('orders as o');
      $this->db->join('users as u', 'u.id = o.user_id','left');
      $this->db->where('o.is_deleted', 0); 
      $this->db->where('u.is_deleted', 0); 
      $this->db->where('u.status',1);
      if(!empty($where)){
        $this->db->where($where);
      }
      
      $this->db->limit($limit, $start);      
      $this->db->group_by('o.user_id');
      // $this->db->group_by('o.user_id');
      if(isset($order) && $order!=''){
        $this->db->order_by($order,$dir);
      }else{
        $this->db->order_by('totalValue','desc');
      }
      
      $q=$this->db->get()->result_array();  
      $data = array();
                 
      if(!empty($q)){
        $startNo = $_POST['start'];
        $srNo = $startNo + 1;
        foreach ($q as $key=>$value){

          $id = $this->primary_id;
          $nestedData['id'] = $srNo;
          $nestedData['company_name'] =$value['company_name'];
          $nestedData['contact_person_name'] =$value['contact_person_name'];
          $nestedData['totalValue'] =$this->$model->getamount(ROUND($value['totalValue'],2),'yes');
          $data[] = $nestedData;
          $srNo++;
        }
      }

      $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data"            => $data
            );
      echo json_encode($json_data);
    }                
  }
?>