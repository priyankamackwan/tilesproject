<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Low_stock extends CI_Controller
    {
        public $msgName = "Order";
        public $view = "low_stock";
        public $controller = "Low_stock";
        public $primary_id = "id";
        public $table = "order_products";
        public $msgDisplay ='order';
        public $model;

        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set('Asia/Dubai');
            $this->model = "My_model";

            if (!in_array(4,$this->userhelper->current('rights'))) {
            $this->session->set_flashdata('ff','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>No Rights for this module</div>');
            redirect('Change_password');
            }
        }
        public function index() {
            $this->userhelper->current('logged_in')['is_logged'] = 1;
            $data['msgName'] = $this->msgName;
            $data['primary_id'] = $this->primary_id;
            $data['controller'] = $this->controller;
            $data['view'] = $this->view;
            $data['msgDisplay'] = $this->msgDisplay;
              // Add for dispaly in filter
            $data['activeProducts'] = $this->db->get("products")->result_array();
   
            $this->load->view($this->view.'/manage',$data);
        }
                
        public function server_data() {
            $model = $this->model;
            $productid=$s=$cat_id=$where='';
            $order_col_id = $_POST['order'][0]['column'];
                     
            $order = $_POST['columns'][$order_col_id]['data'] . ' ' . $_POST['order'][0]['dir'];

            $s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
            $startDate = $_POST['columns'][1]['search']['value'];
            $endDate = $_POST['columns'][2]['search']['value'];
            $productid = $this->input->post('productid');
            $cat_id = $this->input->post('cat_id');
            // Add for where condition for filter
            if(!empty($productid)){
                if($where == null){
                    $where .= 'LOWER(p.id) = "'.strtolower($productid).'" ';
                }else{
                    $where .= ' AND LOWER(p.id) = "'.strtolower($productid).'" ';
                }
            }
            // Serach text condition
            if(isset($s) && $s!='' ){  
                if($where != null){
                    $where.= ' AND ';
                }
                $where .= '(p.name LIKE "'.$s.'%" or ';
                $where .= 'p.design_no LIKE "'.$s.'%" or ';
                $where .= 'p.size LIKE "'.$s.'%" or ';
                $where .= 'p.credit_rate LIKE "'.$s.'%" or ';
                $where .= 'p.quantity LIKE "'.$s.'%" )';
            }
            // Total count 
            $totalData = $this->$model->low_product_counts($where);
                       
            $start = $_POST['start'];
            $limit = $_POST['length'];

            $stocklimit=Stock_Reminder;
            $this->db->select('p.name,p.design_no,p.size,p.sold_quantity,p.quantity,ROUND((o.quantity*'.$stocklimit.')/100),p.quantity-SUM(o.quantity) as s_quantity');
            $this->db->from('products AS p');
            $this->db->join('order_products AS o','p.id=o.product_id');
            $this->db->where('p.status',1);
            $this->db->group_by('o.product_id');
            $this->db->having('ROUND((p.quantity*'.$stocklimit.')/100)>=p.quantity-SUM(o.quantity)');
            $this->db->order_by('p.quantity-SUM(o.quantity) asc');
            if(!empty($where)){
                $this->db->where($where);
            }
            $this->db->limit($limit, $start);
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
                    $nestedData['quantity'] =$value['quantity'];
                    $nestedData['sold_quantity'] = $value['sold_quantity'];
                    $nestedData['total_left_quantity'] =$value['s_quantity'];
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