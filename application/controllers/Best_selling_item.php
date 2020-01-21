<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Best_selling_item extends CI_Controller
  {
    public $msgName = "Order";
    public $view = "best_selling_item";
    public $controller = "Best_selling_item";
    public $primary_id = "id";
    public $table = "order_products";
    public $msgDisplay ='order';
    public $model;

    public function __construct()
    {
                    
      parent::__construct();
      date_default_timezone_set('Asia/Kolkata');
      $this->model = "My_model";
   
      if (!in_array(4,$this->userhelper->current('rights'))) {
        $this->session->set_flashdata('ff','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>No Rights for this module</div>');
        redirect('Change_password');
      }
    }
    public function index() {
      $this->userhelper->current('logged_in')['is_logged'] = 1;
      //Add meta title
      $data['meta_tital']='Best Selling Items | PNP Building Materials Trading L.L.C';
      $data['msgName'] = $this->msgName;
      $data['primary_id'] = $this->primary_id;
      $data['controller'] = $this->controller;
      $data['view'] = $this->view;
      $data['msgDisplay'] = $this->msgDisplay;
      // Add for dispaly in filter
      $data['activeProducts'] = $this->db->where('is_deleted',0)->get("products")->result_array();
      $data['product_categories'] = $this->db->where('is_deleted',0)->get("categories")->result_array();
      // accroding to according to role wise
      if ($this->userhelper->current('role_id') ==1) {
        $this->load->view($this->view.'/manage',$data);
     } else {
         $this->load->view($this->view.'/manage_sub',$data);
     }
    }
                
    public function server_data() {
      //for sorting column
      $columnArray = array(
                1 => 'p.name',
                2 => 'p.design_no',
                3 => 'p.size',
                4 => 'cate_name',
                5 => 'p.purchase_expense' ,
                6 => 'p.quantity' ,
                7 => 'totalQuantity',
                8 => 's_quantity',
                9 => 'amount',
            );
      // Order by
      $order = $columnArray[$this->input->post('order')[0]['column']];

      // set default order
      $dir = $this->input->post('order')[0]['dir'];
                    
      $model = $this->model;
                        
      
      $productid=$s=$cat_id=$where='';
      //$order_col_id = $_POST['order'][0]['column'];
                     
      //$order = $_POST['columns'][$order_col_id]['data'] . ' ' . $_POST['order'][0]['dir'];

      $s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
      $startDate = $_POST['columns'][1]['search']['value'];
      $endDate = $_POST['columns'][2]['search']['value'];

      $productid = $this->input->post('productid');
      $cat_id = $this->input->post('cat_id');
      if(!empty($productid)){
        if($where == null){
          $where .= 'LOWER(p.id) = "'.strtolower($productid).'" ';
        }else{
          $where .= ' AND LOWER(p.id) = "'.strtolower($productid).'" ';
        }
      }
      if(!empty($cat_id)){

                if($where == null){
                    $where .= 'c.id ="'.$cat_id.'"';
                }else{
                    $where .= ' AND c.id ="'.$cat_id.'"';
                }
            }
        if(isset($s) && $s!=''){
          if($where != null){
            $where .='AND';  
          }
          $where .= '(p.name LIKE "'.$s.'%" or ';

                $where .= 'p.size LIKE "%'.$s.'%" or ';

                $where .= 'p.quantity LIKE "%'.$s.'%" or ';

                $where .= 'c.name LIKE "%'.$s.'%" or ';

                $where .= 'p.design_no LIKE "%'.$s.'%"  ';

                $where .= 'OR `ph`.`product_id` IS NULL ) ';
        }
      // Total count 
      $totalData = $this->$model->product_report_table_tecords($where,$low_stock);
                       
      $start = $_POST['start'];
      $limit = $_POST['length'];

                        
      $this->db->select('o.id,o.order_id,o.product_id,SUM(o.quantity) as totalQuantity,SUM(o.price) as amount,p.name,p.design_no,p.size,p.purchase_expense,p.quantity,c.name AS cate_name,p.quantity-SUM(o.quantity) as s_quantity,AVG(ph.purchase_rate) as totalPurchaseExpense,p.sold_quantity');
      $this->db->from('order_products o');
      $this->db->join('products p','p.id=o.product_id','left');
      $this->db->join('product_purchase_history ph','ph.product_id=o.product_id','left');
      $this->db->join('product_categories pc','pc.product_id=o.product_id','left');
      $this->db->join('categories c','c.id=pc.cat_id','left');
      $this->db->where('p.is_deleted',0);
      $this->db->where('c.is_deleted',0);
      if(!empty($where)){
        $this->db->where($where);
      }else {
        if(!empty($s)){
          // $this->db->like('o.total_price', $s, 'both');
           $this->db->or_like('p.name', $s, 'both');
        }
      }
      //product history null
      if(empty($where)){
        $this->db->or_where('ph.product_id',null);
      }
      $this->db->limit($limit, $start);
      $this->db->group_by('o.product_id');

      //order by
      if(isset($order) && $order!=''){
        $this->db->order_by($order,$dir);
      }else{
        $this->db->order_by('s_quantity','desc');  
      }
      
      $q=$this->db->get()->result_array();  

      $data = array();
                 
      if(!empty($q))
      {
        $startNo = $_POST['start'];
        $srNo = $startNo + 1;
        foreach ($q as $key=>$value)
        {
          $id = $this->primary_id;
          $nestedData['id'] = $srNo;
          $nestedData['product_name'] =$value['name'];
          $nestedData['design_no'] =$value['design_no'];
          $nestedData['size'] =$value['size'];
          $nestedData['category'] =$value['cate_name'];
          $nestedData['purchase_expense'] =$this->$model->getamount(round($value['totalPurchaseExpense'],2));
          $nestedData['quantity'] =round($value['quantity'],2);
          $nestedData['sold_quantity'] = round($value['sold_quantity'],2);
          $nestedData['total_left_quantity'] =round($value['quantity']-$value['sold_quantity'],2);
          $nestedData['amount'] =$this->$model->getamount(round($value['totalPurchaseExpense'] *$nestedData['total_left_quantity'],2));
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