<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
defined('BASEPATH') OR exit('No direct script access allowed');

	class Order extends CI_Controller
	{
		public $msgName = "Sales Orders";
		public $view = "order";
		public $controller = "Order";
		public $primary_id = "id";
		public $table = "orders";
		public $msgDisplay ='order';
		public $model;

		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set('Asia/Dubai');
            $this->model = "My_model";
            $this->load->model('orders_model');
            $this->load->library('session');       
            if (!in_array(6,$this->userhelper->current('rights'))) {
                $this->session->set_flashdata('ff','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>No Rights for this module</div>');
                redirect('Change_password');
            }

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
		public function index() {
                      //  echo '<pre>';
                   // print_r($this->session);die;
            $this->userhelper->current('logged_in')['is_logged'] = 1;
            //Add meta title
            $data['meta_tital']='Sales Orders | PNP Building Materials Trading L.L.C';
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
			$data['view'] = $this->view;
            $data['msgDisplay'] = $this->msgDisplay;
             
            // temp query

           /* $update =  $this->db->get('orders')->result_array();
            foreach ($update as $key => $value) {
                $this->db->where('order_id',$value['id']);
                $this->db->update('order_products',['status' => $value['status']]);
            }*/

            $this->db->where('status',1);
            $this->db->where('is_deleted',0);
            $data['activeUsers'] = $this->db->where('status',1)->where('is_deleted',0)->get("users")->result_array();

            $this->db->where('status',1);
            $this->db->where('is_deleted',0);
            $data['activeProducts'] = $this->db->where('status',1)->where('is_deleted',0)->get("products")->result_array();

            //get oder is placed by


            // Get all Amounts of Invoice. 
            //$data['totalAmounts'] = $this->orders_model->get_payment_history('');
			$this->load->view($this->view.'/manage',$data);
        }
                
		public function server_data() {
            $model = $this->model;


            // Column array
            $columnArray = array(
                1 => 'users.company_name' ,
                2 => 'orders.lpo_no' ,
                3 => 'orders.do_no' ,
                4 => 'orders.invoice_no' ,
                5 => 'orders.legacy_invoice_no' ,
                6 => 'orders.placed_by',
                7 => 'orders.sales_expense' ,
                8 => 'orders.total_price',
                9 => 'orders.invoice_status' ,
                10 => 'orders.status',
                11 => 'orders.created' ,
            );

            /*$columnArray = array(
                0 => 'users.company_name' ,
                1 => 'orders.lpo_no' ,
                2 => 'orders.do_no' ,
                3 => 'orders.invoice_no' ,
                4 => 'orders.sales_expense' ,
                5 => 'orders.invoice_status' ,
                6 => 'orders.status',
                7 => 'orders.created' ,
            );*/

            // Limit 
            $limit = $this->input->post('length');

            // Starting from
            $start = $this->input->post('start');

            // Order by
            $order = $columnArray[$this->input->post('order')[0]['column']];

            // set default order
            $dir = $this->input->post('order')[0]['dir'];

            $tableFieldData = [];

            $where = $whereDate ='';
            //date change 
            $whereDatechange='no';

            // User username for filter
            $username = $this->input->post('userName');
        
            // User productId for filter
            $productId = $this->input->post('productId');

            // User salesOrderDate for filter
            $salesOrderDate = $this->input->post('salesOrderDate');

            // User invoiceStatus for filter
            $invoiceStatus = $this->input->post('invoiceStatus');

            // User status for filter
            $status = $this->input->post('status');

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

                $whereDate .= '(DATE_FORMAT(orders.created,"%Y-%m-%d") BETWEEN "'.$_POST['startdate'].'" AND "'.$_POST['enddate'].'")';
                $whereDatechange='yes';
            }
            // }else{
            //     //Current month start-end date
            //     $cMFirstDay = date("Y-m-d", strtotime("first day of this month"));
            //     $cMLastDay = date("Y-m-d", strtotime("last day of this month"));

            //     $whereDate .= '(DATE_FORMAT(orders.created,"%Y-%m-%d") BETWEEN "'.$cMFirstDay.'" AND "'.$cMLastDay.'")';
            // }
            
            if(!empty($invoiceStatus)){
                
                if(strtolower($invoiceStatus) == 'paid'){
                    $invoice_status = 1;
                }elseif (strtolower($invoiceStatus) == 'unpaid') {
                    $invoice_status = 0;
                }elseif (strtolower($invoiceStatus) == 'parpaid') {
                    $invoice_status = 2;
                }
                
                if($where == null){
                    $where .= 'orders.invoice_status = "'.$invoice_status.'"';
                }else{
                    $where .= ' AND orders.invoice_status = "'.$invoice_status.'" ';
                }
            }
           
            if(!empty($status)){

                if(strtolower($status) == 'pending'){
                    $order_status = 0;
                    $table="order_products";
                }elseif (strtolower($status) == 'inprogress') {
                    $order_status = 1;
                    $table="order_products";
                }elseif (strtolower($status) == 'delivered') {
                    $order_status = 2;
                    $table="order_products";
                }

                if($where == null){
                    $where .= 'order_products.status = "'.$order_status.'"';
                }else{
                    $where .= ' AND order_products.status = "'.$order_status.'"';
                }
            }else{
                $table="orders";
            }

            // Get all records count. 
            $totalData = $this->orders_model->get_OrderDatatables('','','','',$where,'','',$whereDate,$table);

            $totalFiltered = $totalData['count'];

            // Filter data using serach.
            if(!empty($this->input->post('search')['value']))
            {
                if($where != null){
                    $where.= ' AND ';
                }
                $invoice_status=$status=strtolower($this->input->post('search')['value']);
                if(strtolower($this->input->post('search')['value']) == 'paid'){
                    $invoice_status = 1;
                }elseif (strtolower($this->input->post('search')['value']) == 'unpaid') {
                    $invoice_status = 0;
                }
                
                if(strtolower($this->input->post('search')['value']) == 'pending'){
                    $status = 0;
                }elseif (strtolower($this->input->post('search')['value']) == 'inprogress') {
                    $status = 1;
                }elseif (strtolower($this->input->post('search')['value']) == 'delivered') {
                    $status = 2;
                }

                // Serch bar value
                $search=$this->input->post('search')['value'];

                $where .= '(users.company_name LIKE "'.$search.'%" or ';

                $where .= 'orders.lpo_no LIKE "%'.$search.'%" or ';

                $where .= 'orders.do_no LIKE "%'.$search.'%" or ';

                $where .= 'orders.invoice_no LIKE "%'.$search.'%" or ';
                //Legacy Invoice Number 
                $where .= 'orders.legacy_invoice_no LIKE "%'.$search.'%" or ';

                $where .= 'orders.sales_expense LIKE "%'.$search.'%" or ';

                $where .= 'orders.invoice_status LIKE "'.$invoice_status.'%" or ';

                $where .= 'orders.status LIKE "'.$status.'%" )';
            }
            //echo $where;exit;
            if($where == NULL){
                
                // Get all records with limit for data table.
                $AlltotalFiltered = $this->orders_model->get_OrderDatatables($limit,$start,$order,$dir,'','','',$whereDate,$table);
                // Get all Amounts of Invoice.
                $totalProductAmounts = $this->orders_model->get_invoiceAmount_for_product();
                $totalAmounts=0;
                foreach ($totalProductAmounts as $key => $value) {
                    $totalTax=($value['total_rate']*$value['tax_percentage'])/100;
                    $productInvoiceAmount= $value['total_rate'] + $totalTax;
                    $totalAmounts = $totalAmounts + $productInvoiceAmount; 
                }
                //Get current Month amount
                $totalProductAmountsCurrentMonth = $this->orders_model->get_invoiceAmount_for_product('',$whereDate,$whereDatechange,'current');
                $totalAmountsCurrentMonth=0;
                foreach ($totalProductAmountsCurrentMonth as $key => $value) {
                    $totalTax=($value['total_rate']*$value['tax_percentage'])/100;
                    $productInvoiceAmount= $value['total_rate'] + $totalTax;
                    $totalAmountsCurrentMonth = $totalAmountsCurrentMonth + $productInvoiceAmount; 
                }

                //total history paymnet amount
                $get_payment_history_all = $this->orders_model->get_payment_history();

                $get_payment_history_currnet_month = $this->orders_model->get_payment_history('current','',$whereDate,$whereDatechange);
                
            }else{
                
                // Get all records with limit and using search for data table.
                $AlltotalFiltered = $this->orders_model->get_OrderDatatables($limit,$start,$order,$dir,$where,'','',$whereDate,$table);
                      
                // Get all records count using search for data table.
                $totalFiltered = $this->orders_model->get_OrderDatatables('','','','',$where,'','',$whereDate,$table);

                $totalFiltered = $totalFiltered['count'];
                // Get all Amounts of Invoice using where conidtion
                $totalProductAmounts = $this->orders_model->get_invoiceAmount_for_product($where);
                $totalAmounts=0;
                foreach ($totalProductAmounts as $key => $value) {
                    $totalTax=($value['total_rate']*$value['tax_percentage'])/100;
                    $productInvoiceAmount= $value['total_rate'] + $totalTax;
                    $totalAmounts = $totalAmounts + $productInvoiceAmount; 
                }
               
                //Get current Month amount
                $totalProductAmountsCurrentMonth = $this->orders_model->get_invoiceAmount_for_product($where,$whereDate,$whereDatechange,'current');
                $totalAmountsCurrentMonth=0;
                foreach ($totalProductAmountsCurrentMonth as $key => $value) {
                    $totalTax=($value['total_rate']*$value['tax_percentage'])/100;
                    $productInvoiceAmount= $value['total_rate'] + $totalTax;
                    $totalAmountsCurrentMonth = $totalAmountsCurrentMonth + $productInvoiceAmount; 
                }
               
                //total history paymnet amount
                $get_payment_history_all = $this->orders_model->get_payment_history('all',$where);

                $get_payment_history_currnet_month = $this->orders_model->get_payment_history('current',$where,$whereDate,$whereDatechange);
            }

            // Initialized blank array to push data of data table.
            $data = array();

            // Check for empty records.
            if(!empty($AlltotalFiltered['result'])){
                
                $startNo = $_POST['start'];

                // Set serial number by 1.
                $srNo = $startNo + 1;
                
                    $model=$this->model;
                foreach ($AlltotalFiltered['result'] as $AlltotalFilteredKey => $SingleOrderData){
                    //print_r($SingleOrderData);
                    
                    if($SingleOrderData['placed_by']=="admin") // if order is placed by admin then display admin name
                    {
                        $adminid=$SingleOrderData['admin_id'];
                        $admindbdata=$this->db->select('first_name,last_name')->from('admin_users')->where('id',$adminid)->get()->result_array();
                        $placed_by_name=$admindbdata[0]['first_name'].' '.$admindbdata[0]['last_name'];
                    }
                    else
                    {
                        $placed_by_name=$SingleOrderData['contact_person_name'];
                    }
                    
                   
                    // View Page Link.
                    $view = base_url($this->controller.'/view/'.$this->utility->encode($SingleOrderData['id']));
                    $edit = base_url($this->controller.'/edit/'.$this->utility->encode($SingleOrderData['id']));
                    $delete = base_url($this->controller.'/remove/'.$this->utility->encode($SingleOrderData['id']));

                    // Download Link.
                    $download = base_url($this->controller.'/download/'.$this->utility->encode($SingleOrderData['id']));

                    // Download Invoice Link.
                    $downloadinvoice = base_url($this->controller.'/downloadinvoice/'.$this->utility->encode($SingleOrderData['id']));

                    // Download LPO Link.
                    $downloadlpo = base_url($this->controller.'/downloadlpo/'.$this->utility->encode($SingleOrderData['id']));

                    // Set serial number.
                    $tabledata['id'] = $srNo;

                    // User Company Name.
                    $tabledata['company_name'] = $SingleOrderData['company_name'];

                    // Create LPO link for table.
                    $tabledata['lpo_no'] = '<a href="'.$downloadlpo.'" target="_blank"><b>'.$SingleOrderData['lpo_no'].'</b></a>';

                    // Create DP link for table.
                    $tabledata['do_no'] ='<a href="'.$download.'" target="_blank"><b>'.$SingleOrderData['do_no'].'</b></a>';

                    // Create Invoice link for table.
                    $tabledata['invoice_no'] ='<a href="'.$downloadinvoice.'" target="_blank"><b>'.$SingleOrderData['invoice_no'].'</b></a>';

                    $tabledata['legacy_invoice_no'] = $SingleOrderData['legacy_invoice_no'];
                    

                    $tabledata['placed_by'] = $placed_by_name;

                    $tabledata['sales_expense'] =$SingleOrderData['sales_expense'];
                    $tax=($SingleOrderData['total_rate']*$SingleOrderData['tax_percentage'])/100;
                    $tabledata['total_price'] = $this->My_model->getamount(round($SingleOrderData['total_rate'] + $tax,2));
                    //$tabledata['total_price'] =$SingleOrderData['total_rate']+$tax;
                    // Checking invoice stauts.
                    if ($SingleOrderData['invoice_status'] == 0) { 

                        $tabledata['invoice_status'] = 'Unpaid';

                    } elseif($SingleOrderData['invoice_status'] == 1) {

                        $tabledata['invoice_status'] ='Paid';
                    
                    } elseif($SingleOrderData['invoice_status'] == 2) {

                        $tabledata['invoice_status'] ='Partial Paid';

                    }

                    // Checking Delivery Status.
                    if ($SingleOrderData['status'] == 0) {

                        $tabledata['status'] = 'Pending';

                    } elseif($SingleOrderData['status'] == 1) {

                        $tabledata['status'] ='In Progress';

                    } else {

                        $tabledata['status'] ='Delivered';
                    }

                    // Created date for sales order.
                    $tabledata['created'] =$this->$model->date_conversion($SingleOrderData['created'],'d/m/Y H:i:s');


                    // Manage buttons.
                   /* if($SingleOrderData['status']==2 && $SingleOrderData['invoice_status']==1) // if order status is completed and status is paid then no need to display edit and delete button.
                    {
                        $tabledata['manage'] = "<a href='".$view."' class='btn btn-info btn-sm' style='padding:8px;' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";
                    }
                    else
                    {//*/
                        $tabledata['manage'] = "<a href='".$view."' class='btn btn-info btn-sm' style='padding:8px;' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>&nbsp;<a href='$edit' class='btn btn-primary btn-sm' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Edit'><i class='glyphicon glyphicon-pencil'></i></a>&nbsp;<a href='$delete' class='btn btn-danger btn-sm confirm-delete' style='padding: 9px;margin-top:1px;' data-toggle='tooltip' title='Delete' ><i class='fa fa-trash'></i></a>";
                    //}

                    // Push table data in to array.
                    $data[] = $tabledata;

                    
                    

                    // Increment serial number by 1.
                    $srNo++;
                }
            }

            //total top amount for all orders
            // Total invoice mamount logic change invoiceAmount is tax with 0
            //$totalInvoiceAmount=$totalAmounts->invoiceAmount + $totalAmounts->invoiceAmountWithTax;

            $totalInvoiceAmount=$totalAmounts;

            //Total paid amount from paymnet hostory table
            $totalPaidAmount=$get_payment_history_all->historypaidamount;

            //Total unpaid amount total invoice amount - total paid amount
            $totalUnPaidAmount=$totalInvoiceAmount - $totalPaidAmount;

            $totalInvoiceAmountCurrentMonth=$totalAmountsCurrentMonth;


            //Total paid amount from paymnet hostory table
            $totalPaidAmountCurrentMonth=$get_payment_history_currnet_month->historypaidamount;

            //Total unpaid amount total invoice amount - total paid amount
            $totalUnPaidAmountCurrentMonth=$totalInvoiceAmountCurrentMonth - $totalPaidAmountCurrentMonth;

            // Combine all data in json with top amount passed
            $json_data = array(
                "draw"            => intval($this->input->post('draw')), 
                "recordsTotal"    => intval($totalData['count']), 
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data,
                "invoiceAmount"   => $this->$model->getamount(round($totalInvoiceAmount,2),'yes'),
                "paidAmount"      => $this->$model->getamount(round($totalPaidAmount,2),'yes'),
                "unpaidAmount"    => $this->$model->getamount(round($totalUnPaidAmount,2),'yes'),
                "totalInvoiceAmountCurrentMonth" => $this->$model->getamount(round($totalInvoiceAmountCurrentMonth,2),'yes'),
                "totalPaidAmountCurrentMonth" => $this->$model->getamount(round($totalPaidAmountCurrentMonth,2),'yes'),
                "totalUnPaidAmountCurrentMonth" => $this->$model->getamount(round($totalUnPaidAmountCurrentMonth,2),'yes'),
            );

            // Convert all data into Json
            echo json_encode($json_data);
           
			// $model = $this->model;
                      
            //            // echo $this->model; exit;
			// $order_col_id = $_POST['order'][0]['column'];
                     
			// $order = $_POST['columns'][$order_col_id]['data'] . ' ' . $_POST['order'][0]['dir'];
                 
			// $s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
      
			// $totalData = $this->$model->countTableRecords($this->table,array('is_deleted'=>0));
    
			// $start = $_POST['start'];
			// $limit = $_POST['length'];

            // $q = $this->db->select('*')->where('is_deleted', 0);
       
		
            // if(empty($s))
			// {
			// 	if(!empty($order))
			// 	{
			// 		$q = $q->order_by($order);
			// 	}
			// 	$q = $q->limit($limit, $start)->get($this->table)->result();
 
			// 	$totalFiltered = $totalData;
			// }
			// else
			// {
			// 	$q = $q->like('orders.sales_expense', $s, 'both');
			// 	if(!empty($order))
			// 	{
			// 		$q = $q->order_by($order);
			// 	}
			// 	//->limit($limit, $start)
			// 	$q = $q->get($this->table)->result();

			// 	$totalFiltered = count($q);
			// }
			
             
			// $data = array();
			// if(!empty($q))
			// {
            //                    $startNo = $_POST['start'];
            //                 $srNo = $startNo + 1;
			// 	foreach ($q as $key=>$value)
			// 	{
			// 		$id = $this->primary_id;
                              
                    
            //              $multipleWhere2 = ['id' => $value->user_id];
            //             $this->db->where($multipleWhere2);
            //             $userData = $this->db->get("users")->result_array();
           
            //                             $view = base_url($this->controller.'/view/'.$this->utility->encode($value->$id));
            //                             $download = base_url($this->controller.'/download/'.$this->utility->encode($value->$id));
            //                             $downloadinvoice = base_url($this->controller.'/downloadinvoice/'.$this->utility->encode($value->$id));
            //                             $downloadlpo = base_url($this->controller.'/downloadlpo/'.$this->utility->encode($value->$id));

			// 		$nestedData['id'] = $srNo;
            //                             $nestedData['user_name'] =$userData[0]['company_name'];
            //                             $nestedData['lpo_no'] ="<a href='$downloadlpo'><b>$value->lpo_no</b></a>";
            //                             $nestedData['do_no'] ="<a href='$download'><b>$value->do_no</b></a>";
            //                             $nestedData['invoice_no'] ="<a href='$downloadinvoice'><b>$value->invoice_no</b></a>";
            //                             $nestedData['sales_expense'] =$value->sales_expense;
            //                              if ($value->invoice_status == 0) { 
            //                                 $nestedData['invoice_status'] = 'Unpaid';
            //                             } elseif($value->invoice_status == 1) {
            //                                 $nestedData['invoice_status'] ='Paid';
            //                             } 
            //                             if ($value->status == 0) { 
            //                                 $nestedData['status'] = 'Pending';
            //                             } elseif($value->status == 1) {
            //                                 $nestedData['status'] ='In Progress';
            //                             } else {
            //                                 $nestedData['status'] ='Completed';
            //                             }
            //                             // $nestedData['manage'] = "<a href='$view' class='btn btn-warning btn-xs'>View</a>";
            //                             $nestedData['manage'] = "<a href='$view' class='btn btn-primary btn-sm' style='padding:8px;' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";

			// 		$data[] = $nestedData;
            //                             $srNo++;
			// 	}
			// }

			// $json_data = array(
			// 			"draw"            => intval($this->input->post('draw')),
			// 			"recordsTotal"    => intval($totalData),
			// 			"recordsFiltered" => intval($totalFiltered),
			// 			"data"            => $data
			// 			);
			// echo json_encode($json_data);
		}
                
		public function add() {   
            //Add meta title
            $data['meta_tital']='Sales Orders | PNP Building Materials Trading L.L.C';
			$data['action'] = "insert";
			$model = $this->model;
            $data['controller'] = $this->controller;
			$this->load->view($this->view.'/form',$data);
		}
                
		public function insert() {
                  
			$model = $this->model;
			$name = $this->input->post('name');
            $description = $this->input->post('description');      
			$data = array(
				'name' => $name,
                'description' => $description,
                'created' => date('Y-m-d h:i:s'),
			);
			$this->$model->insert($this->table,$data);
			$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$name.' has been added successfully!</div>');
			redirect($this->controller);
		}

        // For edit order
		public function edit($id){
        
            $model = $this->model;
            $id = $this->utility->decode($id);
            //Add meta title
            $data['meta_tital']='Sales Orders | PNP Building Materials Trading L.L.C';
            $data['action'] = "update";
            $data['msgName'] = $this->msgName;
            $data['primary_id'] = $this->primary_id;
            $data['controller'] = $this->controller;
            $data['activeProducts'] = $this->db->get("products")->result_array();
            $data['payment_history'] = $this->db->where('order_id',$id)->order_by('payment_history.id','desc')->get("payment_history")->result_array();
            $data['activecustomer'] = $this->db->where('status',1)->get("users")->result_array();
            $data['id']=$id;
            $model = $this->model;
            $data ['result'] = $this->orders_model->view_all_order($id);
              // Previous ann Next Button (03-03-2021)
            $ninv = $this->db->where('id  >',$id)->limit(1)->get('orders')->row();
            if(!empty($ninv)) {
                $next = $ninv->invoice_no;
                $data['next'] = $next;
            }else  {
                $ninvs = $this->db->where('id',$id)->limit(1)->get('orders')->row();
                $next = $ninvs->invoice_no;
                $data['next'] = $next;
            }
            $pinv =  $this->db->where('id  <',$id)->order_by('id','desc')->get('orders')->row();
            if(!empty($pinv)) {
                $prev = $pinv->invoice_no;
                $data['prev'] = $prev;
            }else  {
                $pinvs = $this->db->where('id',$id)->limit(1)->get('orders')->row();
                $prev = $pinvs->invoice_no;
                $data['prev'] = $prev;
            }
            $this->load->view($this->view.'/form',$data);
        }
                
        public function view($id) {
            
			$model = $this->model;
			$id = $this->utility->decode($id);
            //Add meta title
            $data['meta_tital']='Sales Orders | PNP Building Materials Trading L.L.C';
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
			$model = $this->model;
        
			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
            $multipleWhere = ['order_id' => $id];
            $this->db->where($multipleWhere);
            $data['Product'] = $this->db->get("order_products")->result_array();
                for($k=0;$k<count($data['Product']);$k++) {

                    $productIdArray = $data['Product'][$k]['product_id'];
                    $multipleWhere2 = ['id' => $productIdArray];
                    $this->db->where($multipleWhere2);
                    $productData= $this->db->get("products")->result_array();
                    $productNameArray[] = $productData[0]['name'];
                    $designNoArray[] = $productData[0]['design_no'];
                    $quantityArray[]= $data['Product'][$k]['quantity'];
                    $priceArray[]= $data['Product'][$k]['price'];
                    $rateArray[]= $data['Product'][$k]['rate'];
                }

            $data['productData'] = array();
                for($p=0;$p<count($productNameArray);$p++) {
                    $data['productData'][$p]['name']= $productNameArray[$p];
                    $data['productData'][$p]['design_no']= $designNoArray[$p];
                     $data['productData'][$p]['quantity']= $quantityArray[$p];
                     $data['productData'][$p]['price']= $priceArray[$p];
                     $data['productData'][$p]['rate']= $rateArray[$p];
                }
                       
            $multipleWhere2 = ['id' => $data ['result'][0]->user_id];
            $this->db->where($multipleWhere2);
            $data['User'] = $this->db->get("users")->result_array();
            $data['customer_lpo'] = $this->db->select('customer_lpo')->from('orders')->where('id',$id)->get()->result_array();
            $data['payment_history'] = $this->db->where('order_id',$id)->order_by('payment_history.id','desc')->get("payment_history")->result_array();
            // Previous and Next Button (03-03-2021)
            $ninv = $this->db->where('id  >',$id)->limit(1)->get('orders')->row();
            if(!empty($ninv)) {
                $next = $ninv->invoice_no;
                $data['next'] = $next;
            }else  {
                $ninvs = $this->db->where('id',$id)->limit(1)->get('orders')->row();
                $next = $ninvs->invoice_no;
                $data['next'] = $next;
            }
            $pinv =  $this->db->where('id  <',$id)->order_by('id','desc')->get('orders')->row();
            if(!empty($pinv)) {
                $prev = $pinv->invoice_no;
                $data['prev'] = $prev;
            }else  {
                $pinvs = $this->db->where('id',$id)->limit(1)->get('orders')->row();
                $prev = $pinvs->invoice_no;
                $data['prev'] = $prev;
            }
			$this->load->view($this->view.'/view',$data);
		}
        
                
                
        public function downloadinvoice($id) {
              
			$model = $this->model;
			$id = $this->utility->decode($id);
            //Add meta title
            $data['meta_tital']='Sales Orders | PNP Building Materials Trading L.L.C';
                        
                          $multipleWhere = ['id' =>$id];
                        $this->db->where($multipleWhere);
                        $ordersData= $this->db->get("orders")->result_array();
                      // echo '<pre>';
                       // print_r($ordersData); exit;
                        $do_no = $ordersData[0]['do_no'];
                        $createdData = explode(' ',$ordersData[0]['created']);
                        $finalDate = $this->$model->date_conversion($createdData[0],'d-M-Y');
                        
                         $multipleWhere = ['id' =>$ordersData[0]['user_id']];
                        $this->db->where($multipleWhere);
                        $userData= $this->db->get("users")->result_array();
                      //  echo '<pre>';
                        //print_r($userData); exit;
                        
                             $multipleWhere = ['order_id' => $id];
                        $this->db->where($multipleWhere);
                        $productOrder = $this->db->get("order_products")->result_array();
                    // echo '<pre>';
                     // print_r($productOrder); exit;
                      $finalOrderData = array();
                      $subTotal = 0;
                      for($k=0;$k<count($productOrder);$k++) {
                              $productIdArray = $productOrder[$k]['product_id'];
                            $multipleWhere2 = ['id' => $productIdArray];
                        $this->db->where($multipleWhere2);
                        $productData= $this->db->get("products")->result_array();
                        
                        $finalOrderData[$k]['description'] = $productData[0]['name'];
                        $finalOrderData[$k]['size'] = $productData[0]['size'];
                        $finalOrderData[$k]['design_no'] = $productData[0]['design_no'];
                        
                        //product price from order products table
                        $finalOrderData[$k]['amount'] = $productOrder[$k]['price'];
                        $finalOrderData[$k]['rate'] = $productOrder[$k]['rate'];
                        
                       /*if ($userData[0]['client_type'] == 1) {
                            $finalOrderData[$k]['rate'] = $productData[0]['cash_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 2) {
                            $finalOrderData[$k]['rate'] = $productData[0]['credit_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 3) {
                            $finalOrderData[$k]['rate'] = $productData[0]['walkin_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 4) {
                            $finalOrderData[$k]['rate'] = $productData[0]['flexible_rate'];
                        }*/
                        
                        
                        if ($productData[0]['unit'] == 1) {
                            $finalOrderData[$k]['unit'] = 'CTN';
                        }
                        
                        
                        if ($productData[0]['unit'] == 2) {
                            $finalOrderData[$k]['unit'] = 'SQM';
                        }
                        if ($productData[0]['unit'] == 3) {
                            $finalOrderData[$k]['unit'] = 'PCS';
                        }
                        if ($productData[0]['unit'] == 4) {
                            $finalOrderData[$k]['unit'] = 'SET';
                        }
                        $finalOrderData[$k]['quanity'] = $productOrder[$k]['quantity'];
                        // $finalOrderData[$k]['amount'] = $productOrder[$k]['quantity']*$finalOrderData[$k]['rate'];

                        $finalOrderData[$k]['amount'] = $productOrder[$k]['price'];
                        
                        $subTotal = $subTotal+ $finalOrderData[$k]['amount'];
                      }
                      // $vat = $subTotal* Vat/100;
                      //tax from order table
                      // $vat = $subTotal * $ordersData[0]['tax']/100;

                      $vat = $ordersData[0]['tax'];
                      $tax_percentage = $ordersData[0]['tax_percentage'];
                      $tax = ($subTotal * $vat ) / 100;
                      $finalTotal = $subTotal + $tax;
                      $address = "Saja'a Industrial Area, Sharjah, U.A.E";
                        include 'TCPDF/tcpdf.php';
$pdf = new TCPDF();
        
$pdf->AddPage('P', 'A4');
$html = '<html>
<head>Tax Invoice</head>
<body>
<p align="center"><img src = "'.base_url().'image1.png"></p>
<h2><b><p align="center" style="margin-top:5px;">Tax Invoice</p></b></h2>
<table  cellspacing="2px" style="width:100%;"><tr><td style="width:100%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Invoice No. : '.$ordersData[0]['invoice_no'].'</td><td style="width:40%; text-align:right;">Customer : '.$userData[0]['company_name'].'</td> </tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Tel. : '.$userData[0]['phone_no'].'</td><td style="width:40%; text-align:right;">LPO : '.$ordersData[0]['lpo_no'].'</td> </tr></table>';

if(trim($ordersData[0]['customer_lpo'])!='') { // if customer lpo is exist then display it.
$html.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;"></td><td style="width:40%; text-align:right;">Customer LPO No. : '.$ordersData[0]['customer_lpo'].'</td> </tr></table>'; }

$html.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer VAT # : '.$userData[0]['vat_number'].'</td><td style="width:40%; text-align:right;">VAT ID # : 100580141800003</td> </tr></table>
<br><br/>
<table style="width:100%;" border="1"><tr><th style="text-align: center" width="5%">SR No.</th><th style="text-align: center" width="31%">DESCRIPTION</th><th style="text-align: center" width="10%">SIZE</th><th style="text-align: center" width="10%">DESIGN</th><th style="text-align: center" width="10%">UNIT</th><th style="text-align: center" width="13%">QUANTITY</th><th style="text-align: center" width="10%">RATE</th><th style="text-align: center" width="11%">AMOUNT</th></tr>';
$count = 0;
for($p=0;$p<count($finalOrderData);$p++) {
    $count++;
    $html .= '<tr><td style="text-align: center">'.$count.'</td><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td><td style="text-align: right">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: right">'.round($finalOrderData[$p]['rate'],2).'</td><td style="text-align: right">'.round($finalOrderData[$p]['amount'],2).'</td></tr>';
                          }
                          $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">SubTotal</td><td style="text-align: right">'.round($subTotal,2).'</td></tr>
                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat '.$tax_percentage.'%</td><td style="text-align: right">'.round($vat,2).'</td></tr>
                                  
<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Grand Total(AED)</td><td style="text-align: right">'.round($finalTotal,2).'</td></tr></table>
    <br><br/>
                                  <table style="width:100%;" border="1"><tr><th style="text-align:center">Terms and Conditions</th></tr>
                                  <tr><td>1) Goods subject to lien of seller till full payment is made by buyer.</td></tr>
                                  <tr><td>2) NO CLAIM for shortage/damage will be entertained after 24 hours of delivery.</td></tr>
                                  <tr><td>3) Payment should be made by cash or A/C payees cheque only in the name of our company.</td></tr>
                                  <tr><td></td></tr>
</table><br><br/>
<table style="width:100%;"><tr><td width="50%";>Buyer Signature:</td><td width="50%";>For PNP Building Materials Trading L.L.C</td></tr></table>
<br><br/><br><br/>
<table style="width:100%;"><tr><td style="text-align:center">Tel: 06-5952061/ Mob: 055-8532631/050-4680842 | '.$address.'</td></tr>
                            <tr><td style="text-align:center">Website: www.pnptiles.com | Email: info@pnptiles.com</td></tr></table>';
$html .='</body></html>';
//Add meta title
$pdf->SetTitle('Tax Invoice | PNP Building Materials Trading L.L.C');
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($ordersData[0]['invoice_no'].'.pdf','D');
                        
                        
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;
                      /*  $multipleWhere = ['id' => $value->product_id];
                        $this->db->where($multipleWhere);
                        $data['Product'] = $this->db->get("products")->result_array();
                    
                         $multipleWhere2 = ['id' => $value->user_id];
                        $this->db->where($multipleWhere2);
                        $data['User'] = $this->db->get("orders")->result_array(); */

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
   
                        $multipleWhere = ['id' => $data ['result'][0]->product_id];
                        $this->db->where($multipleWhere);
                        $data['Product'] = $this->db->get("products")->result_array();
                    
                        $multipleWhere2 = ['id' => $data ['result'][0]->user_id];
                        $this->db->where($multipleWhere2);
                        $data['User'] = $this->db->get("users")->result_array();

                      //  print_r($data); exit;
			$this->load->view($this->view.'/view',$data);
		}
                
                
           public function downloadlpo($id) {
                    
			$model = $this->model;
			$id = $this->utility->decode($id);
                        
                          $multipleWhere = ['id' =>$id];
                        $this->db->where($multipleWhere);
                        $ordersData= $this->db->get("orders")->result_array();
                      // echo '<pre>';
                       // print_r($ordersData); exit;
                        $do_no = $ordersData[0]['do_no'];
                        $createdData = explode(' ',$ordersData[0]['created']);
                        //$finalDate = date("d-M-Y", strtotime($createdData[0]));
                        $finalDate = $this->$model->date_conversion($createdData[0],'d-M-Y');
                        
                         $multipleWhere = ['id' =>$ordersData[0]['user_id']];
                        $this->db->where($multipleWhere);
                        $userData= $this->db->get("users")->result_array();
                      //  echo '<pre>';
                        //print_r($userData); exit;
                        
                             $multipleWhere = ['order_id' => $id];
                        $this->db->where($multipleWhere);
                        $productOrder = $this->db->get("order_products")->result_array();
                    // echo '<pre>';
                     // print_r($productOrder); exit;
                      $finalOrderData = array();
                      $subTotal = 0;
                      for($k=0;$k<count($productOrder);$k++) {
                              $productIdArray = $productOrder[$k]['product_id'];
                            $multipleWhere2 = ['id' => $productIdArray];
                        $this->db->where($multipleWhere2);
                        $productData= $this->db->get("products")->result_array();
                        
                        $finalOrderData[$k]['description'] = $productData[0]['name'];
                        $finalOrderData[$k]['size'] = $productData[0]['size'];
                        $finalOrderData[$k]['design_no'] = $productData[0]['design_no'];
                        
                        //product price from order products table
                        $finalOrderData[$k]['amount'] = $productOrder[$k]['price'];
                        $finalOrderData[$k]['rate'] = $productOrder[$k]['rate'];

                        
                       /*if ($userData[0]['client_type'] == 1) {
                            $finalOrderData[$k]['rate'] = $productData[0]['cash_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 2) {
                            $finalOrderData[$k]['rate'] = $productData[0]['credit_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 3) {
                            $finalOrderData[$k]['rate'] = $productData[0]['walkin_rate'];
                        }
                        
                        if ($userData[0]['client_type'] == 4) {
                            $finalOrderData[$k]['rate'] = $productData[0]['flexible_rate'];
                        }*/
                        
                        
                        if ($productData[0]['unit'] == 1) {
                            $finalOrderData[$k]['unit'] = 'CTN';
                        }
                        
                        
                        if ($productData[0]['unit'] == 2) {
                            $finalOrderData[$k]['unit'] = 'SQM';
                        }
                        if ($productData[0]['unit'] == 3) {
                            $finalOrderData[$k]['unit'] = 'PCS';
                        }
                        if ($productData[0]['unit'] == 4) {
                            $finalOrderData[$k]['unit'] = 'SET';
                        }
                        $finalOrderData[$k]['quanity'] = $productOrder[$k]['quantity'];
                        // $finalOrderData[$k]['amount'] = $productOrder[$k]['quantity']*$finalOrderData[$k]['rate'];

                        $finalOrderData[$k]['amount'] = $productOrder[$k]['price'];
                        
                        $subTotal = $subTotal+ $finalOrderData[$k]['amount'];
                      }
                      // $vat = $subTotal * Vat/100;
                      //tax from order table
                      // $vat = $subTotal * $ordersData[0]['tax']/100;

                      $vat =$ordersData[0]['tax'];
                      $tax_percentage =$ordersData[0]['tax_percentage'];
                      
                      $tax = ($subTotal * $vat ) / 100;
                      $finalTotal = $subTotal + $tax;
                      $address = "Saja'a Industrial Area, Sharjah, U.A.E";
                        include 'TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage('P', 'A4');
$html = '<html>
<body>
<p align="center"><img src = "'.base_url().'image1.png"></p>
<h2><b><p align="center" style="margin-top:5px;">Local Purchase Order</p></b></h2>
<table style="width:100%;"><tr><td style="width:100%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:40%;">From</td><td style="width:60%; text-align:center;">To</td> </tr></table>
<table style="width:100%;"><tr><td style="width:40%;">Buyer : '.$userData[0]['company_name'].'</td><td style="width:60%; text-align:right;">Seller : PNP BUILDING MATERIAL TRADING LLC </td></tr></table>
<table style="width:100%;"><tr><td style="width:40%;">Tel. : '.$userData[0]['phone_no'].'</td><td style="width:60%; text-align:right;">Tel. : +97143531040 / +971558532631</td> </tr></table>';

if(trim($ordersData[0]['customer_lpo'])!="") { // if customer lpo is exist then display it.
$html.='<table style="width:100%;"><tr><td style="width:40%;">LPO : '.$ordersData[0]['lpo_no'].'</td><td style="width:60%; text-align:right;">Address : INDUSTRIAL AREA 2,</td></tr></table>
<table style="width:100%;"><tr><td style="width:40%;">Customer LPO No. : '.$ordersData[0]['customer_lpo'].'</td><td style="width:60%; text-align:right;">RAS AL KHOR, PO BOX: 103811 DUBAI-UAE</td> </tr>
    <tr><td style="width:100%; text-align:right;">Email : info@pnptiles.com</td></tr></table>
    <br><br/>'; } else {

$html.='<table style="width:100%;"><tr><td style="width:40%;">LPO : '.$ordersData[0]['lpo_no'].'</td><td style="width:60%; text-align:right;">Address : INDUSTRIAL AREA 2,<br/>
    RAS AL KHOR, PO BOX: 103811 DUBAI-UAE</td> </tr>
    <tr><td style="width:100%; text-align:right;">Email : info@pnptiles.com</td></tr></table>
    <br><br/>';
}


$html.='<table style="width:100%;"><tr><td style="width:60%;">Customer VAT # : '.$userData[0]['vat_number'].'</td><td style="width:40%; text-align:right;">VAT ID # : 100580141800003</td> </tr></table>
<br><br/>
<table style="width:100%;" border="1"><tr><th style="text-align:center" width="5%" >SR No.</th><th style="text-align: center" width="30%">DESCRIPTION</th><th style="text-align: center" width="10%">SIZE</th><th style="text-align: center" width="10%">DESIGN</th><th style="text-align: center" width="10%">UNIT</th><th style="text-align: center" width="13%">QUANTITY</th><th style="text-align: center" width="10%">RATE</th><th style="text-align: center" width="12%">AMOUNT</th></tr>';
$count = 0;
for($p=0;$p<count($finalOrderData);$p++) {
    $count++;
    $html .= '<tr><td style="text-align: center">'.$count.'</td><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td><td style="text-align: right">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: right">'.round($finalOrderData[$p]['rate'],2).'</td><td style="text-align: right">'.round($finalOrderData[$p]['amount'],2).'</td></tr>';
                                
                          }
                          $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">SubTotal</td><td style="text-align: right">'.round($subTotal,2).'</td></tr>
                                  
                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat '.$tax_percentage.'%</td><td style="text-align: right">'.round($vat,2).'</td></tr>
                                  
<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Grand Total(AED)</td><td style="text-align: right">'.round($finalTotal,2).'</td></tr></table>
    <br><br/>
                                  <table style="width:100%;" border="1"><tr><th style="text-align:center">Terms and Conditions</th></tr>
                                  <tr><td>1) Goods subject to lien of seller till full payment is made by buyer.</td></tr>
                                  <tr><td>2) NO CLAIM for shortage/damage will be entertained after 24 hours of delivery.</td></tr>
                                  <tr><td>3) Payment should be made by cash or A/C payees cheque only in the name of our company.</td></tr>
                                  <tr><td></td></tr>
</table><br><br/>
<table style="width:100%;"><tr><td width="50%";>Buyer Signature:</td><td width="50%";>For PNP Building Materials Trading L.L.C</td></tr></table>
<br><br/><br><br/>';
$html .='</body></html>';
//Add meta title
$pdf->SetTitle('Local Purchase Order | PNP Building Materials Trading L.L.C');
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($ordersData[0]['lpo_no'].'.pdf','D');
                        
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;
                      /* $multipleWhere = ['id' => $value->product_id];
                        $this->db->where($multipleWhere);
                        $data['Product'] = $this->db->get("products")->result_array();
                    
                         $multipleWhere2 = ['id' => $value->user_id];
                        $this->db->where($multipleWhere2);
                        $data['User'] = $this->db->get("orders")->result_array(); */

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
   
                        $multipleWhere = ['id' => $data ['result'][0]->product_id];
                        $this->db->where($multipleWhere);
                        $data['Product'] = $this->db->get("products")->result_array();
                    
                        $multipleWhere2 = ['id' => $data ['result'][0]->user_id];
                        $this->db->where($multipleWhere2);
                        $data['User'] = $this->db->get("users")->result_array();

                      // print_r($data); exit;
			$this->load->view($this->view.'/view',$data);
		}
                
                    public function download($id) {
                    
			$model = $this->model;
			$id = $this->utility->decode($id);
                        
                          $multipleWhere = ['id' =>$id];
                        $this->db->where($multipleWhere);
                        $ordersData= $this->db->get("orders")->result_array();
                      // echo '<pre>';
                       // print_r($ordersData); exit;
                        $do_no = $ordersData[0]['do_no'];
                        $createdData = explode(' ',$ordersData[0]['created']);
                        //$finalDate = date("d-M-Y", strtotime($createdData[0]));
                        $finalDate = $this->$model->date_conversion($createdData[0],'d-M-Y');
                        
                         $multipleWhere = ['id' =>$ordersData[0]['user_id']];
                        $this->db->where($multipleWhere);
                        $userData= $this->db->get("users")->result_array();
                      //  echo '<pre>';
                       // print_r($userData); exit;
                        
                             $multipleWhere = ['order_id' => $id];
                        $this->db->where($multipleWhere);
                        $productOrder = $this->db->get("order_products")->result_array();
                     // echo '<pre>';
                     // print_r($productOrder); exit;
                      $finalOrderData = array();
                      for($k=0;$k<count($productOrder);$k++) {
                              $productIdArray = $productOrder[$k]['product_id'];
                            $multipleWhere2 = ['id' => $productIdArray];
                        $this->db->where($multipleWhere2);
                        $productData= $this->db->get("products")->result_array();
                        
                        $finalOrderData[$k]['description'] = $productData[0]['name'];
                        $finalOrderData[$k]['size'] = $productData[0]['size'];
                        $finalOrderData[$k]['design_no'] = $productData[0]['design_no'];
                        if ($productData[0]['unit'] == 1) {
                            $finalOrderData[$k]['unit'] = 'CTN';
                        }
                        if ($productData[0]['unit'] == 2) {
                            $finalOrderData[$k]['unit'] = 'SQM';
                        }
                        if ($productData[0]['unit'] == 3) {
                            $finalOrderData[$k]['unit'] = 'PCS';
                        }
                        if ($productData[0]['unit'] == 4) {
                            $finalOrderData[$k]['unit'] = 'SET';
                        }
                        $finalOrderData[$k]['quanity'] = $productOrder[$k]['quantity'];
                      }
                  
                        //echo $id; exit;
                       $address = "Saja'a Industrial Area, Sharjah, U.A.E";
                        include 'TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage('P', 'A4');
$html = '<html>
<head>Delivery Note</head>
<body>
<p align="center"><img src = "'.base_url().'image1.png"></p>
<h2><b><p align="center" style="margin-top:5px;">Delivery Note</p></b></h2>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">D.O. No. : '.$do_no.'</td><td style="width:40%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer : '.$userData[0]['company_name'].'</td><td style="width:40%; text-align:right;">Tel : '.$userData[0]['phone_no'].'</td></tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">LPO No. : '.$ordersData[0]['lpo_no'].'</td><td style="width:40%; text-align:right;">Invoice No. : '.$ordersData[0]['invoice_no'].'</td></tr></table>';

if(trim($ordersData[0]['customer_lpo'])!=="") { // if customer lpo is exist then display it.
$html.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer LPO No. : '.$ordersData[0]['customer_lpo'].'</td><td style="width:40%; text-align:right;"></td></tr></table>'; }

 $html.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Cargo : '.$ordersData[0]['cargo'].'</td><td style="width:40%; text-align:right;">Cargo Number : '.$ordersData[0]['cargo_number'].'</td></tr></table>  
 <table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Location : '.$ordersData[0]['location'].'</td><td style="width:40%; text-align:right;">Mark : '.$ordersData[0]['mark'].'</td></tr></table><br><br/>
<table style="width:100%;"><tr><td style="width:60%;">THE FOLLOWING ITEMS HAVE BEEN DELIVERED</td></tr></table><br/>
<table style="width:100%;" border="1"><tr><th style="text-align: center" width="60%">DESCRIPTION</th><th style="text-align: center" width="10%">SIZE</th><th style="text-align: center" width="10%">DESIGN</th><th style="text-align: center" width="10%">QUANTITY</th><th style="text-align: center" width="10%">UNIT</th></tr>';
for($p=0;$p<count($finalOrderData);$p++) {
    $html .= '<tr><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td></tr>';
                                
                          }
                          $html .= '<tr><td></td><td></td><td colspan="2"></td><td></td></tr></table>';

$html .= '<table style="width:100%;"><tr><td style="width:60%;">Received the above goods in good condition</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:50%;">Receivers Sign : </td><td style="width:50%; ">Delivered By [Sign] : </td></tr></table> 
<br><br/>
<table style="width:100%;"><tr><td style="width:50%;">Name : </td><td style="width:50%;">Name : </td></tr></table>
<br>
<table style="width:100%;"><tr><td style="width:100%;">Mobile : </td></tr></table>
<br><br/><br><br/><br>
<table style="width:100%;"><tr><td style="text-align:center">Tel: 06-5952061/ Mob: 055-8532631/050-4680842 | '.$address.'</td></tr>
    <tr><td style="text-align:center">Website: www.pnptiles.com | Email: info@pnptiles.com</td></tr></table>

</body></html>';
//Add meta title
$pdf->SetTitle('Delivery Note | PNP Building Materials Trading L.L.C');
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($do_no.'.pdf','D');
                        
                        
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;
                      /*  $multipleWhere = ['id' => $value->product_id];
                        $this->db->where($multipleWhere);
                        $data['Product'] = $this->db->get("products")->result_array();
                    
                         $multipleWhere2 = ['id' => $value->user_id];
                        $this->db->where($multipleWhere2);
                        $data['User'] = $this->db->get("orders")->result_array(); */

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
   
                        $multipleWhere = ['id' => $data ['result'][0]->product_id];
                        $this->db->where($multipleWhere);
                        $data['Product'] = $this->db->get("products")->result_array();
                    
                        $multipleWhere2 = ['id' => $data ['result'][0]->user_id];
                        $this->db->where($multipleWhere2);
                        $data['User'] = $this->db->get("users")->result_array();

                      //  print_r($data); exit;
			$this->load->view($this->view.'/view',$data);
		}

        //update          
		public function Update() {

			$model = $this->model;
			$id = $this->input->post('id');
			$sales_expense = $this->input->post('sales_expense');
            $status = $this->input->post('status');
            $invoice_status = $this->input->post('invoice_status');
            $txt_deliverydate = $this->input->post('txt_deliverydate');
            $txt_paymentdate = $this->input->post('txt_paymentdate');
            $txt_deliverydate=date('Y-m-d H:i:00',strtotime($txt_deliverydate));
            $txt_paymentdate=date('Y-m-d H:i:00',strtotime($txt_paymentdate));

			$data = array(
                'sales_expense' => $sales_expense,
                'status' => $status,
                'invoice_status' => $invoice_status,
                'delivery_date' => $txt_deliverydate,
                'payment_date' => $txt_paymentdate
			);
			$where = array($this->primary_id=>$id);
			$this->$model->update($this->table,$data,$where);              
			$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Order has been updated successfully!</div>');
			redirect($this->controller);
		}
        // For order sales update
        public function Update_order() {

            $model = $this->model;
            // Order id
            $id = $this->input->post('id');
            // For post array and quantity
            // Contatc personr name
            $username = $this->input->post('username');
            //price 
            //$price = $this->input->post('price');
            // client type for amount
            $client_type = $this->input->post('client_type');
            $cargo = $this->input->post('cargo');
            $cargo_number = $this->input->post('cargo_number');
            $location = $this->input->post('location');
            $mark = $this->input->post('mark');
            //for total amount 
            $total_order_price=0;
            $product_arr=$quantity_arr=array();
            $old_product_array=$old_product_quantity=array();
            $erro_product=array();
            
            //Price array for update
            $priceArr=array();

            //Rate array for update
            $rateArr=array();
            $quantity_update=array();
            //Store request data in array for quantity and product 
            $product_count=$this->input->post('ordercount');
            for($i=1;$i<=$product_count;$i++){
                $p_id=$this->input->post('product_id'.$i);;
               $quantity=$this->input->post('quantity_'.$i);
                //Price store in array product item id wise
                $price=$this->input->post('price_'.$i);

                //Rate store in array product item id wise
                $rate=$this->input->post('rate_'.$i);
                $product_arr[$p_id]=$p_id;
                if(array_key_exists($p_id, $quantity_arr)){
                    $total_quantity=$quantity+$quantity_arr[$p_id];
                    $quantity_arr[$p_id]=$total_quantity;
                }else{
                    $quantity_arr[$p_id]=$quantity;
                }
                
                //price array set for item
                if(array_key_exists($p_id, $priceArr)){

                    if(isset($priceArr[$p_id]) && $priceArr[$p_id]!='' && $priceArr[$p_id]!=$price){
                        $totalprice=$price+$priceArr[$p_id];
                        $priceArr[$p_id]=$totalprice;
                    }else{
                        $priceArr[$p_id]=$price;
                    }
                }else{
                    $priceArr[$p_id]=$price;
                }

                //rate array set for item
                if(array_key_exists($p_id, $rateArr)){
                    //avreage arte
                    $rateArr[$p_id]=$priceArr[$p_id]/$quantity_arr[$p_id];
                }else{
                    $rateArr[$p_id]=$rate;
                }

                
            }
            //remove blank array exist
            $product_arr = array_filter($product_arr); 
            $quantity_arr = array_filter($quantity_arr); 
            //price array
            $priceArr = array_filter($priceArr); 

            //rate array
            $rateArr = array_filter($rateArr); 
            

            //Old order array from database 
            $all_order=$this->orders_model->view_all_order($id);
            
            foreach ($all_order as $key => $value) {

                // store on array for quantity and product 
                $old_product_array[$value['product_id']]=$value['product_id'];
                $old_product_quantity[$value['product_id']]=$value['quantity'];
                $total_sold=$check_quantity->sold_quantity;

                //price form form input to update
                $price=$priceArr[$value['product_id']];

                //rate form form input to update
                $rate=$rateArr[$value['product_id']];



                // fetch quantity from product table
                $check_quantity=$this->orders_model->check_items_quantity($value['product_id']);
                // rate type for calculate amount
                /*
                if(isset($client_type) && $client_type!='' && $client_type=="cash_rate"){

                    $rate_type=$check_quantity->cash_rate;

                }elseif(isset($client_type) && $client_type!='' && $client_type=="credit_rate"){

                    $rate_type=$check_quantity->credit_rate;

                }elseif(isset($client_type) && $client_type!='' && $client_type=="walkin_rate"){

                    $rate_type=$check_quantity->walkin_rate;

                }elseif(isset($client_type) && $client_type!='' && $client_type=="flexible_rate"){
                        $rate_type=$check_quantity->flexible_rate;
                    
                }
                */
                //Check quantity is updated or not
                if($quantity_arr[$value['product_id']]> $value['quantity']){
                    $update_sold_quantity=$quantity_arr[$value['product_id']]-$value['quantity'];
                    $update_oprator='+';
                    $total_check_q=$quantity_arr[$value['product_id']]-$value['quantity'];
                }elseif($quantity_arr[$value['product_id']]< $value['quantity']){
                    $update_sold_quantity=$value['product_id']-$quantity_arr[$value['quantity']];
                    $update_oprator='-';
                    $total_check_q=$value['quantity']-$quantity_arr[$value['product_id']];
                }elseif($quantity_arr[$value['product_id']]==$value['quantity']){
                    $total_check_q=$quantity_arr[$value['product_id']];
                }
                //echo $rate_type.' '.$quantity_arr[$value['product_id']];
                // total of all product amount
                $amount=$quantity_arr[$value['product_id']] * $price;
               
                $total_order_price+=$amount; 
                    // Check total quantity and buy quantity and if old + new quantity same not to update
                if($check_quantity->quantity > $total_check_q && $quantity_arr[$value['product_id']]!=$value['quantity']){

                    //Update solde quantity in product table
                    $this->orders_model->update_items('products','sold_quantity',$value['product_id'],$total_check_q,$update_oprator); 
                    
                    //Update price according to client type
                    /*
                    $price_update = array(
                            'price'=>$rate_type
                            );
                    $where_update = array('product_id'=>$$value['product_id'],'order_id'=>$id);
                    $this->My_model->update('order_products',$price_update,$where_update);
                    */

                    //Update solde quantity in order product table
                    $this->orders_model->update_order_items('order_products','quantity',$value['product_id'],$total_check_q,$update_oprator,$id);
                    
                }/*else{
                    $this->session->set_flashdata('dispMessage','<span class="7"><div class="alert alert-danger"><strong>Some Item quantity Is Not Available</strong></div></span>');
                    redirect($this->controller.'/edit/'.$this->utility->encode($id));
                    $erro_product[$value['product_id']]=$value['product_id'];
                } */ 
                //Update price 
                $price_update = array(
                            'price'=>$price,
                            'rate'=>$rate
                            );
                $where_update = array('product_id'=>$value['product_id'],'order_id'=>$id);
                $this->My_model->update('order_products',$price_update,$where_update);
                //echo $this->db->last_query();die();
            }
            // item removed  or delted   update sold quantity
            $array_remove=array_diff($old_product_array, $product_arr);
            if(isset($array_remove) && $array_remove!='' && count($array_remove) >0){
                foreach ($array_remove as $key => $value) { 
                    // Fetch single data from order products
                    $single_datas=$this->orders_model->single_items($value,$id); 
                    $remove_amount=  $single_datas->price * $single_datas->quantity;
                    //minus for reove items
                    $total_order_price=$total_order_price-$remove_amount;
                    // Update removed items sold wuantity
                    $this->orders_model->update_items('products','sold_quantity',$value,$single_datas->quantity,'-');

                    // Delete item from order products table
                    if(isset($old_product_array[$key]) && $old_product_array[$key]!='' && $old_product_array[$key]==$value){
                        $this->db->where('product_id', $old_product_array[$key]);
                        $this->db->where('order_id', $id);
                        $this->db->delete('order_products');
                    }
                }
            }
            //for new item added update in sold quantity
            $array_added=array_diff($product_arr, $old_product_array);
            if(isset($array_added) && $array_added!='' && count($array_added) >0){
                foreach ($array_added as $key => $value) {
                    $check_quantity=$this->orders_model->check_items_quantity($value);
                    //price form form input to update
                    $price=$priceArr[$value];
                    //rate form form input to update
                    $rate=$rateArr[$value];
                    // insert in order prodcuts table
                    $insert_data=array('order_id'=>$id,
                                        'product_id'=>$value,
                                        'quantity'=>$quantity_arr[$value],
                                        'price'=>$price,
                                        'rate' =>$rate
                    );

                    $this->$model->insert('order_products',$insert_data);
                   // echo $this->db->last_query();die();
                    $this->orders_model->update_items('products','sold_quantity',$value,$quantity_arr[$value],'+');
                }
            }
            // For check data old data is updated or not
            $inv_status = $this->db->where('id',$id)->get('orders')->row();          
            $sales_expense = $this->input->post('sales_expense');
            $status = $this->input->post('status');
            $invoice_status =  (!empty($this->input->post('invoice_status'))) ? $this->input->post('invoice_status') : $inv_status->invoice_status;
            $delivery_date = $this->input->post('deliverydate');
            $payment_date = $this->input->post('paymentdate');
            //total price
            $total_price = $this->input->post('total_price');

            $delivery_date=date('Y-m-d H:i:s',strtotime($delivery_date));
            $payment_date=date('Y-m-d H:i:s',strtotime($payment_date));

            $tax= $this->input->post('tax');
            $tax_percentage = $this->input->post('tax_percentage');

            //add leagacy invoice number
            $legacy_invoice_no = $this->input->post('legacy_invoice_no');
            
            // find old customer
            $this->db->select('*');
            $this->db->from('orders oo');
            $this->db->join('users u','u.id=oo.user_id');
            $this->db->where('oo.id',$id);
            $oldorder = $this->db->get()->row();
           
            if(!empty($oldorder)) {
                if($oldorder->user_id==$username){
                  $username = $oldorder->user_id;
                  $company_name = $oldorder->company_name;
                }else {

                    $username;
                    $model = $this->model;
                    $orderData = array();
                    // new customer fetch record
                    $this->db->where('id',$username);
                    $userdata = $this->db->get('users')->result_array();
                  
                    // email required field sent 
                    $company_name = $userdata[0]['company_name'];
                    $phone_no = $userdata[0]['phone_no'];
                    $vat_number = $userdata[0]['vat_number'];
                    $company_address = $userdata[0]['company_address'];
                    $email =  $userdata[0]['email'];
                 

                    $data['meta_tital']='Sales Orders | PNP Building Materials Trading L.L.C';
                    // fetch old order
                    $multipleWhere = ['id' =>$id];
                    $this->db->where($multipleWhere);
                    $ordersData= $this->db->get("orders")->result_array();

                    $do_no = $ordersData[0]['do_no'];
                    $invoice = $ordersData[0]['invoice_no'];
                    $createdData = explode(' ',$ordersData[0]['created']);
                    $finalDate = $this->$model->date_conversion($createdData[0],'d-M-Y');
                    // order fetch all items
                    $multipleWhere = ['order_id' => $id];
                    $this->db->where($multipleWhere);
                    $productOrder = $this->db->get("order_products")->result_array();
                   
                    $finalOrderData = array();
                    $subTotal = 0;
                    for($k=0;$k<count($productOrder);$k++) {
                        $productIdArray = $productOrder[$k]['product_id'];
                        $multipleWhere2 = ['id' => $productIdArray];
                        $this->db->where($multipleWhere2);
                        $productData= $this->db->get("products")->result_array();
                    
                        $finalOrderData[$k]['description'] = $productData[0]['name'];
                        $finalOrderData[$k]['size'] = $productData[0]['size'];
                        $finalOrderData[$k]['design_no'] = $productData[0]['design_no'];
                    
                        //product price from order products table
                        $finalOrderData[$k]['amount'] = $productOrder[$k]['price'];
                        $finalOrderData[$k]['rate'] = $productOrder[$k]['rate'];
                    
                    
                        if ($productData[0]['unit'] == 1) {
                            $finalOrderData[$k]['unit'] = 'CTN';
                        }
                        
                        
                        if ($productData[0]['unit'] == 2) {
                            $finalOrderData[$k]['unit'] = 'SQM';
                        }
                        if ($productData[0]['unit'] == 3) {
                            $finalOrderData[$k]['unit'] = 'PCS';
                        }
                        if ($productData[0]['unit'] == 4) {
                            $finalOrderData[$k]['unit'] = 'SET';
                        }
                        $finalOrderData[$k]['quanity'] = $productOrder[$k]['quantity'];
                        // $finalOrderData[$k]['amount'] = $productOrder[$k]['quantity']*$finalOrderData[$k]['rate'];

                        $finalOrderData[$k]['amount'] = $productOrder[$k]['price'];
                        
                        $subTotal = $subTotal+ $finalOrderData[$k]['amount'];
                    }
                    $vat = $ordersData[0]['tax'];
                    $tax_percentage = $ordersData[0]['tax_percentage'];
                    $tax = ($subTotal * $vat ) / 100;
                    $finalTotal = $subTotal + $tax;

                    // generate PDF

                    $address = "Saja'a Industrial Area, Sharjah, U.A.E";
                    include 'TCPDF/tcpdf.php';
                    $pdf = new TCPDF();
        
$pdf->AddPage('P', 'A4');
$html = '<html>
<head>Tax Invoice</head>
<body>
<p align="center"><img src = "'.base_url().'image1.png"></p>
<h2><b><p align="center" style="margin-top:5px;">Tax Invoice</p></b></h2>
<table  cellspacing="2px" style="width:100%;"><tr><td style="width:100%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Invoice No. : '.$ordersData[0]['invoice_no'].'</td><td style="width:40%; text-align:right;">Customer : '.$company_name.'</td> </tr></table>
<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Tel. : '.$phone_no.'</td><td style="width:40%; text-align:right;">LPO : '.$ordersData[0]['lpo_no'].'</td> </tr></table>';

if(trim($ordersData[0]['customer_lpo'])!='') { // if customer lpo is exist then display it.
$html.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;"></td><td style="width:40%; text-align:right;">Customer LPO No. : '.$ordersData[0]['customer_lpo'].'</td> </tr></table>'; }

$html.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer VAT # : '.$vat_number.'</td><td style="width:40%; text-align:right;">VAT ID # : 100580141800003</td> </tr></table>
<br><br/>
<table style="width:100%;" border="1"><tr><th style="text-align: center" width="5%">SR No.</th><th style="text-align: center" width="31%">DESCRIPTION</th><th style="text-align: center" width="10%">SIZE</th><th style="text-align: center" width="10%">DESIGN</th><th style="text-align: center" width="10%">UNIT</th><th style="text-align: center" width="13%">QUANTITY</th><th style="text-align: center" width="10%">RATE</th><th style="text-align: center" width="11%">AMOUNT</th></tr>';
$count = 0;
for($p=0;$p<count($finalOrderData);$p++) {
    $count++;
    $html .= '<tr><td style="text-align: center">'.$count.'</td><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td><td style="text-align: right">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: right">'.round($finalOrderData[$p]['rate'],2).'</td><td style="text-align: right">'.round($finalOrderData[$p]['amount'],2).'</td></tr>';
                          }
                          $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">SubTotal</td><td style="text-align: right">'.round($subTotal,2).'</td></tr>
                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat '.$tax_percentage.'%</td><td style="text-align: right">'.round($vat,2).'</td></tr>
                                  
<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Grand Total(AED)</td><td style="text-align: right">'.round($finalTotal,2).'</td></tr></table>
    <br><br/>
                                  <table style="width:100%;" border="1"><tr><th style="text-align:center">Terms and Conditions</th></tr>
                                  <tr><td>1) Goods subject to lien of seller till full payment is made by buyer.</td></tr>
                                  <tr><td>2) NO CLAIM for shortage/damage will be entertained after 24 hours of delivery.</td></tr>
                                  <tr><td>3) Payment should be made by cash or A/C payees cheque only in the name of our company.</td></tr>
                                  <tr><td></td></tr>
                    </table><br><br/>
                    <table style="width:100%;"><tr><td width="50%";>Buyer Signature:</td><td width="50%";>For PNP Building Materials Trading L.L.C</td></tr></table>
                    <br><br/><br><br/>
                    <table style="width:100%;"><tr><td style="text-align:center">Tel: 06-5952061/ Mob: 055-8532631/050-4680842 | '.$address.'</td></tr>
                                                <tr><td style="text-align:center">Website: www.pnptiles.com | Email: info@pnptiles.com</td></tr></table>';
                    $html .='</body></html>';

                    $pdf->writeHTML($html, true, false, true, false, '');
                    $filelocation = FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads';
                    $filename_invoice = str_replace('/','_', $invoice).'.pdf';
                    $fileNL_invoice = $filelocation.DIRECTORY_SEPARATOR.$filename_invoice;
                    $pdf->Output($fileNL_invoice, 'F');

                    $pdf = new TCPDF();
                    $pdf->AddPage('P', 'A4');
                    $html1 = '<html>
                    <head>Delivery Note</head>
                    <body>
                    <p align="center"><img src = "'.base_url().'image1.png"></p>
                    <h2><b><p align="center" style="margin-top:5px;">Delivery Note</p></b></h2>
                    <table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">D.O. No. : '.$do_no.'</td><td style="width:40%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
                    <table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer : '.$company_name.'</td><td style="width:40%; text-align:right;">Tel : '.$phone_no.'</td></tr></table>
                    <table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">LPO No. : '.$ordersData[0]['lpo_no'].'</td><td style="width:40%; text-align:right;">Invoice No. : '.$ordersData[0]['invoice_no'].'</td></tr></table>';

                    if(trim($ordersData[0]['customer_lpo'])!=="") { // if customer lpo is exist then display it.
                    $html1.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Customer LPO No. : '.$ordersData[0]['customer_lpo'].'</td><td style="width:40%; text-align:right;"></td></tr></table>'; }

                     $html1.='<table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Cargo : '.$ordersData[0]['cargo'].'</td><td style="width:40%; text-align:right;">Cargo Number : '.$ordersData[0]['cargo_number'].'</td></tr></table>  
                     <table cellspacing="2px" style="width:100%;"><tr><td style="width:60%;">Location : '.$ordersData[0]['location'].'</td><td style="width:40%; text-align:right;">Mark : '.$ordersData[0]['mark'].'</td></tr></table><br><br/>
                    <table style="width:100%;"><tr><td style="width:60%;">THE FOLLOWING ITEMS HAVE BEEN DELIVERED</td></tr></table><br/>
                    <table style="width:100%;" border="1"><tr><th style="text-align: center" width="60%">DESCRIPTION</th><th style="text-align: center" width="10%">SIZE</th><th style="text-align: center" width="10%">DESIGN</th><th style="text-align: center" width="10%">QUANTITY</th><th style="text-align: center" width="10%">UNIT</th></tr>';
                    for($p=0;$p<count($finalOrderData);$p++) {
                        $html1 .= '<tr><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td></tr>';
                                                    
                                              }
                                              $html1 .= '<tr><td></td><td></td><td colspan="2"></td><td></td></tr></table>';

                    $html1 .= '<table style="width:100%;"><tr><td style="width:60%;">Received the above goods in good condition</td></tr></table>
                    <br><br/>
                    <table style="width:100%;"><tr><td style="width:50%;">Receivers Sign : </td><td style="width:50%; ">Delivered By [Sign] : </td></tr></table> 
                    <br><br/>
                    <table style="width:100%;"><tr><td style="width:50%;">Name : </td><td style="width:50%;">Name : </td></tr></table>
                    <br>
                    <table style="width:100%;"><tr><td style="width:100%;">Mobile : </td></tr></table>
                    <br><br/><br><br/><br>
                    <table style="width:100%;"><tr><td style="text-align:center">Tel: 06-5952061/ Mob: 055-8532631/050-4680842 | '.$address.'</td></tr>
                        <tr><td style="text-align:center">Website: www.pnptiles.com | Email: info@pnptiles.com</td></tr></table>

                    </body></html>';

                     //Add meta title
                    $pdf->writeHTML($html1, true, false, true, false, '');
                    $filelocation = FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads';
                    $filename_do = str_replace('/','_', $do_no).'.pdf';

                    $fileNL_do = $filelocation.DIRECTORY_SEPARATOR.$filename_do;
                    $pdf->Output($fileNL_do, 'F');

                   
                    $orderData['invoice_url'] = base_url().'assets/uploads/'.$filename_invoice;
                    $orderData['do_url'] = base_url().'assets/uploads/'.$filename_do;

                    $mail = new PHPMailer;
                    $mail->isSMTP();                                     
                    $mail->Host = Mail_Host;                      
                    $mail->SMTPAuth = true;                               
                    $mail->Username = Mail_Username;     
                    $mail->Password = Mail_Password;                    
                    $mail->SMTPOptions = array(
                      'ssl' => array(
                      'verify_peer' => false,
                      'verify_peer_name' => false,
                        'allow_self_signed' => true
                        )
                    );                         
                    $mail->SMTPSecure = 'tls';                           
                    $mail->Port = 587;                                   
                    $mail->setFrom('pnpsales2019@gmail.com', 'Tiles Admin');
                    $mail->addAddress($email);              
                    $mail->isHTML(true);                                  
                    $mail->Subject = "New Order from $company_name";
                    $mail->AddAttachment($fileNL_invoice, $name = 'INVOICE',  $encoding = 'base64', $type = 'application/pdf');
                    $mail->AddAttachment($fileNL_do, $name = 'DO',  $encoding = 'base64', $type = 'application/pdf');
                    $mail->MsgHTML('
                                Dear Customer,<br/><br/>
    You have received a new Order from '.$company_name.'<br/>
    New order number is #'.$id.'<br/><br/>
    
    Order Grand Total is '.$finalTotal.'<br/><br/>
    
    Your order is now being processed.<br/>
    We are attaching a copy of LPO,DO and Invoice in this email. And your merchandise will be delivered to :<br/>
    '.$company_address.'<br/>
    '.$phone_no.'<br/><br/>
    
    For more order details and updates, please get in touch with us from our mobile application.<br/><br/>
    
    Best Regards,<br/>
    Customer Service<br/>
    www.pnptiles.com<br/><br/>
    
    This is an automatically generated mail.Please do not reply.If you have any queries regarding your account/order, please contact us.');
                    $mail->send();
                    
                }     
            } else {
                echo "No customer found!";
            } 

            $items = $this->db->get_where("order_products",array('order_id =' => $id))->result_array();
            $pending=0;
            foreach ($items as $key => $val) {
                if($val['status']==0) {
                    $pending = $pending + 1;
                }
            }
            if($pending!=0) {
                $current = date('Y-m-d H:i:s');
                $this->db->where('id',$id);
                $this->db->update('orders',['status' => 0,'delivery_date' => $current]);
            }else {
                $current = date('Y-m-d H:i:s');
                $this->db->where('id',$id);
                $this->db->update('orders',['status' => 2,'delivery_date' => $current]);
            }
            $intatus = $this->db->where('id',$id)->get('orders')->row(); 
            $status =   (!empty($this->input->post('invoice_status'))) ? $this->input->post('invoice_status') : $intatus->status;

            $data = array(
                    'sales_expense' => $sales_expense,
                    'status' => $status,
                    'invoice_status' => $invoice_status,
                    'delivery_date' => $delivery_date,
                   // 'payment_date' => $payment_date,
                    'total_price'=>$total_price,
                    'cargo'=>$cargo,
                    'cargo_number'=>$cargo_number,
                    'location'=>$location,
                    'mark'=>$mark,
                    'tax' =>$tax,
                    'tax_percentage' => $tax_percentage,
                    'legacy_invoice_no' => $legacy_invoice_no,
                    'user_id' => $username
                );
            $where = array($this->primary_id=>$id);
            $this->$model->update($this->table,$data,$where);
            //IF invoice status is unpaid all order payment data is deleted from payment hisory table
            if(isset($invoice_status) && $invoice_status!='' && $invoice_status==0){
                $this->db->where('order_id', $id);
                $delete=$this->db->delete('payment_history');
            }
            //End Of delete payment hisory
            $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$company_name.' has been updated successfully!</div>');
            redirect($this->controller);
        }
        // Delete sales order
		public function remove($id) {
			$model = $this->model;
            $company_name=array();
            $user_data_name='';
            //Order id
			$id = $this->utility->decode($id);
            //Fetch order 
            $delete_sales_order=$this->orders_model->view_all_order($id);
            foreach ($delete_sales_order as $key => $value) {
                if(isset($value['company_name']) && $value['company_name']!=''){
                    $user_data_name=$value['company_name'];
                }
                // Update sold quantity in products
                $this->orders_model->update_items('products','sold_quantity',$value['product_id'],$value['quantity'],'-');
                $this->db->where('product_id', $value['product_id']);
                $this->db->where('order_id', $value['order_id']);
                $this->db->delete('order_products');
            }
            //is delete 1 for order delete
            $this->db->set('is_deleted','1');
            $this->db->where('id',$id);
            $this->db->update('orders');
            //Delete From payment history table
            $this->db->where('order_id', $id);
            $delete=$this->db->delete('payment_history');
            
            $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$user_data_name.' has been deleted successfully!</div>');
            redirect($this->controller);	
		}
        public function inactive($id) {
                   
			$model = $this->model;
			$id = $this->utility->decode($id);

			$this->$model->select(array(),'categories',array('id'=>$id),'','');
            $this->db->set('status',0);
            $this->db->where('id',$id);
            $this->db->update('categories',$data);
            
            $this->db->select('name');
            $this->db->where('id', $id);
            $q = $this->db->get('categories');
            $userdata = $q->result_array();
            $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata['0']['name'].' has been blocked successfully!</div>');
            redirect($this->controller);	
		}
                
        public function active($id) {
                   
			$model = $this->model;
			$id = $this->utility->decode($id);

			$this->$model->select(array(),'categories',array('id'=>$id),'','');
            $this->db->set('status',1);
            $this->db->where('id',$id);
            $this->db->update('categories',$data);
            
            $this->db->select('name');
            $this->db->where('id', $id);
            $q = $this->db->get('categories');
            $userdata = $q->result_array();
            $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata['0']['name'].' has been activated successfully!</div>');
            redirect($this->controller);
		}
                
                
    public function addOrders() {

        $importFile = $_FILES['upload_orders']['name'];

        $ext = pathinfo($importFile,PATHINFO_EXTENSION);
		$image = time().'.'.$ext;

		$config['upload_path'] = 'assets/uploads/';
		$config['file_name'] = $image;
		$config['allowed_types'] = "xlsx|xls|csv";

		$this->load->library('upload', $config);
		$this->load->initialize($config);
		if($this->upload->do_upload('upload_orders')) // Order file uploaded successfully
        {
            $model = $this->model;
            require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
            require('spreadsheet-reader-master/SpreadsheetReader.php');

            $Reader = new SpreadsheetReader(FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads'.'/'.$image);

            $i=0;
            foreach ($Reader as $Row)
            {   
                if ($i!=0) //Headers has been skipped and start to insert value
                {
                    $this->db->select('*');
                    $this->db->where('email', $Row[0]);
                    $this->db->where('status',1); // user is active
                    $this->db->where('is_deleted',0); // user is not deleted
                    $q = $this->db->get('users');
                    $userData = $q->result_array();

                    if (!empty($userData) && count($userData) > 0) //if user is exist,active and not deleted
                    {   

                        $this->db->select('id');
                        $q = $this->db->get('orders');
                        $orderLast = $q->result_array();
                        $newOrder = end($orderLast)['id'] + 1;
                        
                        if (date('m') <= 3) {//Upto June 2014-2015
                            $financial_year = (date('y')-1) . '-' . date('y');
                        } else {//After June 2015-2016
                            $financial_year = date('y') . '-' . (date('y') + 1);
                        }

                        $lpo = 'LPO/'.$newOrder.'/'.$financial_year;
                        $do = 'DO/'.$newOrder.'/'.$financial_year;
                        $invoice = 'Invoice/'.$newOrder.'/'.$financial_year;
                         
                       	$data = array(
            			            'user_id' => $userData[0]['id'],
                                    'tax' => $Row[4],
                                    'total_price' => $Row[5],
            			            'lpo_no' => $lpo,
                                    'do_no' => $do,
                                    'invoice_no' => $invoice,
                                    'sales_expense' => $Row[6],
                                    'cargo' => $Row[7],
                                    'cargo_number' => $Row[8],
                                    'location' => $Row[9],
                                    'mark' => $Row[10],
                                    'invoice_status' => $Row[11],
                                    'tax_percentage' => $Row[12],
                                    'legacy_invoice_no' => $Row[13],
                                    'created' => date('Y-m-d h:i:s'),
                		);

                        $this->$model->insert('orders',$data); 
                        $lastInsertedOrderId = $this->db->insert_id();

                        $countProducts = explode(',', $Row[1]);
                        $countQuantity = explode(',', $Row[2]);
                        $countPrice = explode(',', $Row[3]);
                
                        for($k=0;$k<count($countPrice);$k++)
                        {
                            
                            $this->db->select('*');
                            $this->db->where('id', $countProducts[$k]);
                            $q = $this->db->get('products');
                            $productData = $q->result_array();
                            //add rate in order product table
                            if ($userData[0]['client_type'] == 1) {
                                $rateAdd = $productData[0]['cash_rate'];
                            }
                            else if ($userData[0]['client_type'] == 2) {
                                $rateAdd = $productData[0]['credit_rate'];
                            }
                            else if ($userData[0]['client_type'] == 3) {
                                $rateAdd = $productData[0]['walkin_rate'];
                            }
                            else if ($userData[0]['client_type'] == 4 || $userData[0]['client_type'] == 0) {
                                $rateAdd = $productData[0]['flexible_rate'];
                            }
                            
                            $orderProductData = array(
                                    'order_id' => $lastInsertedOrderId,
                                    'product_id' =>$productData[0]['id'],
                                    'quantity' => $countQuantity[$k],
                                    'price' => $countPrice[$k],
                                    'rate'  => $rateAdd
                            );
                            $this->$model->insert('order_products',$orderProductData);
                            $updatedSoldQuantity = $productData[0]['sold_quantity'] + $countQuantity[$k]; 
                            $this->db->set('sold_quantity',$updatedSoldQuantity);
                            $this->db->where('id',$productData[0]['id']);
                            $this->db->update('products',$newdata);                            
                        }
                    }
                    else // invalid email id or user is inactive or deleted
                    {
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Invalid email id or user is deleted</div>');
                        redirect($this->controller);
                    }
                }
                $i++;
            }

            $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Orders has been imported successfully!</div>');
            redirect($this->controller);
        }
        else // Order file not uploaded successfully
        {
            //$error = $this->upload->display_errors();

            $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Orders has been not imported successfully!</div>');
            redirect($this->controller);
        }
    }

    public function uploadOrders(){
        //Add meta title
        $data['meta_tital']='Sales Orders | PNP Building Materials Trading L.L.C';
		$this->load->view($this->view.'/uploadOrders',$data);
    }
    //Popup for partially paid order
    //payment_id is payment history table id
    function ajax_order_payment($payment_id=null,$action='insert',$totalPaidAmount=null){

        $order_id=$this->input->post('order_id');
        $payment_id=$this->input->post('payment_id');
        $action=$this->input->post('action');
        $totalPaidAmount=$this->input->post('totalPaidAmount');
        
        $data['payment_history']=$this->orders_model->payment_history($order_id,$payment_id,$action);
        $data['order_id']=$order_id;
        $data['totalPaidAmount']=$totalPaidAmount;
        $paymentHistoryHtml = $this->load->view($this->view.'/payment_history',$data,true);
        echo json_encode($paymentHistoryHtml);
        exit();
    }
    //inserted and Update payment history  data  payment_history table
    function update_order_payment(){

        $action=$payment_id='';
        $message="Something went wrong..Try after sometime";
        $status='fail';
        
        $payment_id=$this->input->post('payment_id');
        $action=$this->input->post('action');
        $paymentdate=$this->input->post('paymentdate');
        $payment_date=date('Y-m-d H:i:s',strtotime($paymentdate));
        $payment_mode=$this->input->post('payment_mode');
        $reference=$this->input->post('reference');
        $amount=$this->input->post('amount');
        $id=$this->input->post('id');

        if(isset($action) && $action!='' && $action='edit'){
            $paymentDataUdpate = array(      
                        'order_id' => $id,
                        'amount' => $amount,
                        'reference'=>$reference,
                        'payment_mode' =>  $payment_mode,
                        'payment_date' => $payment_date,
                );
            $this->db->where('order_id',$id);
            $this->db->where('id',$payment_id);
            $this->db->update('payment_history',$paymentDataUdpate);
            $inv = $_POST['inv']; 
            $am = array();
            $am = explode(" ",$inv);
            $this->db->where('order_id',$id);
            $q = $this->db->get('payment_history');
            $data = $q->result_array();
            $sum = 0;
            foreach ($data as $key => $value) {
                $sum = $sum + $value['amount'];
            }
            $sum = number_format((float)$sum, 2, '.', '');
            if(!empty($data)){
                if($sum==str_replace(',', '', $am[1])) {
                    $sta = 1;
                }elseif($sum!=$am[1]){
                    $sta = 2 ;
                }
            }else{
                $sta = 0;
            }
            $message='Payment Updated Successfully'; 
            $status='success';

        }else{

            $am = array();
            $am = explode(" ",$inv);
            $this->db->where('order_id',$id);
            $q = $this->db->get('payment_history');
            $data = $q->result_array();
            $sum = 0;
            foreach ($data as $key => $value) {
                $sum = $sum + $value['amount'];
            }
            $sum = number_format((float)$sum, 2, '.', '');
            if(!empty($data)){
                if($sum==str_replace(',', '', $am[1])) {
                    $sta = 1;
                }elseif($sum!=$am[1]){
                    $sta = 2 ;
                }
            }else{
                $sta = 0;
            }

            $paymentData = array(
                        'order_id' => $id,
                        'amount' => $amount,
                        'payment_mode' =>  $payment_mode,
                        'reference'=>$reference,
                        'payment_date' => $payment_date,
                );
            $insert=$this->db->insert('payment_history',$paymentData);
            
            if($insert){
                $inv = $_POST['inv']; 
                $am = array();
                $am = explode(" ",$inv);
                $this->db->where('order_id',$id);
                $q = $this->db->get('payment_history');
                $data = $q->result_array();
                $sum = 0;
                foreach ($data as $key => $value) {
                    $sum = $sum + $value['amount'];
                }
                $sum = number_format((float)$sum, 2, '.', '');
                if(!empty($data)){
                    if($sum==str_replace(',', '', $am[1])) {
                        $sta = 1;
                    }elseif($sum!=$am[1]){
                        $sta = 2 ;
                    }
                }else{
                    $sta = 0;
                }
                $message='Payment Done Successfully'; 
                $status='success';
            }
        }
        $orderPayment_date=array('payment_date' => $payment_date,'invoice_status' => $sta);
        $this->db->where('id',$id);
        $this->db->update('orders',$orderPayment_date);
        echo json_encode(array("status"=>$status,"message"=>$message));
        exit;
    }
    
    // Delete payment from history from table payment_history
    public function removePayment() {  
        $message="Something went wrong..Try after sometime";
        $status='fail';

        $payment_id=$this->input->post('payment_id');
        $order_id=$this->input->post('order_id');
        $this->db->where('id', $payment_id);
        $this->db->where('order_id', $order_id);
        $delete=$this->db->delete('payment_history');
        if($delete){
            $message='Payment Deleted Successfully..'; 
            $status='success';   
        }        
        echo json_encode(array("status"=>$status,"message"=>$message));
        exit;
    }
    
    // item status update
    public function price_fetch1() { 

        foreach($_POST['checked'] as $page_id) {
            $this->db->where('id',$page_id);
            $order_status = $this->db->update('order_products',['status' => 2]);
        }
        $order_id = $_POST['id'];
        $items = $this->db->get_where("order_products",array('order_id =' => $order_id))->result_array();
        $pending=0;
        foreach ($items as $key => $val) {
            if($val['status']==0) {
                $pending = $pending + 1;
            }
        }
        if($pending!=0) {
            $this->db->where('id',$order_id);
            $this->db->update('orders',['status' => 0]);
        }else {
            $current = date('Y-m-d H:i:s');
            $this->db->where('id',$order_id);
            $this->db->update('orders',['status' => 2,'delivery_date' => $current]);
        }
        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Order Delivery Status Updated Successfully....</div>');
        if($order_status){
            $message='Order Delivery Status Updated Successfully....'; 
            $status='success';   
        }        
        echo json_encode(array("status"=>$status,"message"=>$message));
        exit;
    } 

    // price fetch on add items
    function price_fetch(){
        $message="Something went wrong..Try after sometime";
        $status='fail';
        //Product id from onchange event
        $itemId=$this->input->post('itemId');
        $client_type=$this->input->post('client_type');
        //if client type blank default flexible rate
        if(isset($client_type) && $client_type!=''){
            $client_type=$client_type;
        }else{
            $client_type="flexible_rate";
        }
        
        $this->db->select($client_type);
        $this->db->from('products');
        $this->db->where('products.is_deleted',0);
        $this->db->where('id', $itemId);
        $priceData = $this->db->get()->row();
        if(isset($priceData) && $priceData!='' && count($priceData)> 0){
            $message=$priceData->$client_type;
            $qty=$priceData->quantity; 
            $status='success';   
        }        
        echo json_encode(array("status"=>$status,"price"=>$message,"qty"=>$qty));
        exit;
    }

    function newratefetch(){
        $message="Something went wrong..Try after sometime";
        $status='fail';
        //Product id from onchange event
        $itemId = $this->input->post('itemId');
        $user_id = $this->input->post('users_id');
        $q = $this->db->where('id',$user_id)->get('users')->row();
        if(!empty($q->client_type==1)){
            $rate = $this->db->where('cash_rate',1)->get('products')->row();
            $price = $rate->cash_rate;
            $client_type = 'cash_rate';
        }elseif(!empty($q->client_type==2)){
            $rate = $this->db->where('credit_rate',2)->get('products')->row();
            $price = $rate->credit_rate;
            $client_type =  'credit_rate';
        }elseif(!empty($q->client_type==3)){
            $rate = $this->db->where('walkin_rate',3)->get('products')->row();
            $price = $rate->walkin_rate;
            $client_type = 'walkin_rate';
        }elseif(!empty($q->client_type==4)){
            $rate = $this->db->where('flexible_rate',4)->get('products')->row();
            $price = $rate->flexible_rate;
            $client_type = 'flexible_rate';
        }else{
            $client_type='flexible_rate';
        }

        if(isset($client_type) && $client_type!=''){
            $client_type=$client_type;
        }else{
            $client_type="flexible_rate";
        }

        $this->db->select($client_type.',quantity');
        $this->db->from('products');
        $this->db->where('products.is_deleted',0);
        $this->db->where('id', $itemId);
        $priceData = $this->db->get()->row();
        if(isset($priceData) && $priceData!='' && count($priceData)> 0){
            $message=$priceData->$client_type;
            $qty =  $priceData->quantity;
            $status='success';   
        }        
        echo json_encode(array("status"=>$status,"price"=>$message,"qty"=>$qty));
        exit;
    }

    function next() {

        $id = intval($this->input->post('id'));
        $this->db->select("*");
        $this->db->from('orders');
        //$this->db->join('users','users.id = orders.user_id');
        //$this->db->order_by('users.company_name','desc');
        $query = $this->db->where('orders.id  >',$id)->limit(1)->get()->row();
        if(!empty($query)){
            $status ="success";
            echo json_encode(array("status"=>$status,"url"=>$this->utility->encode($query->id)));
            exit();
        }else {
            $status ="fail";
            $lastinv = $this->db->where('id',$id)->get('orders')->row();
            echo json_encode(array("status"=>$status,"inv"=> $lastinv->invoice_no));
            exit();
        }
        exit();
    }

    function previous() {
        $id = intval($this->input->post('id'));
        $query = $this->db->where('id  <',$id)->order_by('id','desc')->get('orders')->row();
        if(!empty($query)){
            $status ="success";
            echo json_encode(array("status"=>$status,"url"=>$this->utility->encode($query->id)));
            exit();
        }else {
            $status ="fail";
            $lastinv = $this->db->where('id',$id)->get('orders')->row();
            echo json_encode(array("status"=>$status,"inv"=> $lastinv->invoice_no));
            exit();
        }
        exit();
    }

    function neworder() {
       
        $this->msgName = "New Order";
        $id = $this->utility->decode($id);
        //Add meta title
        $data['meta_tital']='New Order | PNP Building Materials Trading L.L.C';
        $data['action'] = "insert";
        $data['msgName'] = $this->msgName;
        $data['primary_id'] = $this->primary_id;
        $data['controller'] = $this->controller;
        $model = $this->model;
        $data['activecustomer'] = $this->db->where(['status'=> 1,'is_deleted'=> 0])->get("users")->result_array();
        $data['activeProducts'] = $this->db->where(['status'=> 1,'is_deleted'=> 0])->get("products")->result_array();
        $this->load->view($this->view.'/neworder',$data);
    }

    function fetchitem() {

        $userid = intval($this->input->post('userid'));
        $pid = intval($this->input->post('id'));
        $queryrate = $this->db->where('id',$userid)->get('users');
        $result = $queryrate->result_array();

        $productData = array(); 

        if($result[0]['client_type']==1){ // Cash
            $productData = $this->db->select('cash_rate')->from('products')->where('id',$pid)->where('status',1)->where('is_deleted',0)->get()->row();
            $rate=$productData->cash_rate;
        }elseif($result[0]['client_type']==2){ //  Credit
            $productData = $this->db->select('credit_rate')->from('products')->where('id',$pid)->where('status',1)->where('is_deleted',0)->get()->row();
            $rate=$productData->credit_rate;
        }elseif($result[0]['client_type']==3){ // Walkin
            $productData = $this->db->select('walkin_rate')->from('products')->where('id',$pid)->where('status',1)->where('is_deleted',0)->get()->row();
            $rate=$productData->walkin_rate;
        }elseif($result[0]['client_type']==4){  // Flexible Rate
            $productData = $this->db->select('flexible_rate')->from('products')->where('id',$pid)->where('status',1)->where('is_deleted',0)->get()->row();
            $rate=$productData->flexible_rate;
        }

        $query = $this->db->where('id',$pid)->get('products')->row();

        if(!empty($query)){
            $status ="success";
            echo json_encode(array("status"=>$status,"item"=>$query,"rate"=>$rate));
            exit();
        }else {
            $status ="fail";
            echo json_encode(array("status"=>$status));
            exit();
        }
        exit();
    }

    function fetchitemqty() {
        $id = intval($this->input->post('id'));
        $query = $this->db->where('id',$id)->get('products')->row();
        if(!empty($query)){
            $status ="success";
            echo json_encode(array("status"=>$status,"item"=>$query));
            exit();
        }else {
            $status ="fail";
            echo json_encode(array("status"=>$status));
            exit();
        }
        exit();
    }

    function placeorder() {
        
        $model = $this->model;
        $orderData = array();
        $this->db->select('id');              
        $q = $this->db->get('orders');               
        $orderLast = $q->result_array();
        
        if(count($orderLast) == 0){
            $newOrder = invoiceincrement;
        }else{
            $newOrder = end($orderLast)['id'] + 1;
        }
              
        if (date('m') <= 3) {//Upto June 2014-2015
            $financial_year = (date('y')-1) . '-' . date('y');
        } else {//After June 2015-2016
            $financial_year = date('y') . '-' . (date('y') + 1);
        }
        
        $multipleWhere = ['id' =>  $_POST['username']];
        $this->db->where($multipleWhere);
        $userData= $this->db->get("users")->result_array();

        $lpo = 'LPO/'.$newOrder.'/'.$financial_year;
        $do = 'DO/'.$newOrder.'/'.$financial_year;
        $invoice = 'Invoice/'.$newOrder.'/'.$financial_year;
        $customer_lpo = null;       
        $orderData = array(
                'user_id' => $_POST['username'],
                'lpo_no' => $lpo,
                'do_no' => $do,
                'invoice_no' => $invoice,
                'tax' => Vat,
                'tax_percentage' => Vat,
                'total_price' => $_POST['total_price'],
                'cargo' => $_POST['cargo'],
                'cargo_number' => $_POST['cargo_number'],
                'location' => $_POST['location'],
                'mark' => $_POST['mark'],
                'placed_by'=> "Admin",
                'customer_lpo'=> $_POST['clpo'],
                'admin_id'=> $this->session->userdata['logged_in']['role_id'],
                'invoice_status' => 0,
                'created' => date('Y-m-d h:i:s')
        );
        
        $this->$model->insert('orders',$orderData);  
        $lastInsertedOrderId = $this->db->insert_id();              
        $product_count=$this->input->post('ordercount');
        
        for($i=1;$i<=$product_count;$i++){

            $p_id=$this->input->post('product_id'.$i);;
            $quantity=$this->input->post('quantity_'.$i);
            $price=$this->input->post('price_'.$i);
            $rate=$this->input->post('rate_'.$i);
            $product_arr[$p_id]=$p_id;
            if(array_key_exists($p_id, $quantity_arr)){
                $total_quantity=$quantity+$quantity_arr[$p_id];
                $quantity_arr[$p_id]=$total_quantity;
            }else{
                $quantity_arr[$p_id]=$quantity;
            }
            if(array_key_exists($p_id, $priceArr)){
                if(isset($priceArr[$p_id]) && $priceArr[$p_id]!='' && $priceArr[$p_id]!=$price){
                    $totalprice=$price+$priceArr[$p_id];
                    $priceArr[$p_id]=$totalprice;
                }else{
                    $priceArr[$p_id]=$price;
                }
            }else{
                $priceArr[$p_id]=$price;
            }
            if(array_key_exists($p_id, $rateArr)){
                $rateArr[$p_id]=$priceArr[$p_id]/$quantity_arr[$p_id];
            }else{
                $rateArr[$p_id]=$rate;
            }
            $product_orde = array(
                'order_id'  => $lastInsertedOrderId,
                'product_id'=> $product_arr[$p_id],
                'quantity'  => $quantity_arr[$p_id],
                'price'     => $priceArr[$p_id],
                'rate'      => $rateArr[$p_id],
                'created'   => date('Y-m-d h:i:s')
            );
            $this->$model->insert('order_products', $product_orde);
        }

        $this->db->select('*');
        $this->db->where('order_id',$lastInsertedOrderId);
        $q = $this->db->get('order_products');
        $oldprod = $q->result_array();
        
        foreach ($oldprod as $key => $value) {
            
            $this->db->select('*');
            $this->db->where('id',$value['product_id']);
            $q = $this->db->get('products');
            $productData = $q->result_array();

            foreach ($productData as $key => $val) {
                $oldSoldQuantity = $val['sold_quantity'];
                $newSoldQuantity = $oldSoldQuantity + $value['quantity'];
                $qtyavailable = $val['quantity'] - $value['quantity'];
                $data = array(
                    'sold_quantity' => $newSoldQuantity,
                    'quantity' =>  $qtyavailable
                );
                $this->db->where(['id' => $value['product_id']]);
                $this->db->update('products',$data);
            }
        }
       
        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userData[0]['company_name'].' has been added successfully!</div>');
        redirect($this->controller);
        
    }

    function tooltip() {

        $pid = intval($this->input->post('pid'));
        $userid = intval($this->input->post('uid'));
        $queryrate = $this->db->where('id',$userid)->get('users');
        $result = $queryrate->result_array();
        $productData = array();
        $query = $this->db->where('id',$pid)->get('products')->row();
        if(!empty($query)){
            $status ="success";
            echo json_encode(array("status"=>$status,"item"=>$query));
            exit();
        }else {
            $status ="fail";
            echo json_encode(array("status"=>$status));
            exit();
        }
        exit();
    }

}


            