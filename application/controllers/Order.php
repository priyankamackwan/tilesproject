<?php
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
			date_default_timezone_set('Asia/Kolkata');
            $this->model = "My_model";
            $this->load->model('orders_model');
                    
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
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
			$data['view'] = $this->view;
            $data['msgDisplay'] = $this->msgDisplay;
             
            $this->db->where('status',1);
            $this->db->where('is_deleted',0);
            $data['activeUsers'] = $this->db->get("users")->result_array();

            $this->db->where('status',1);
            $this->db->where('is_deleted',0);
            $data['activeProducts'] = $this->db->get("products")->result_array();

            //get oder is placed by


            // Get all Amounts of Invoice. 
            $data['totalAmounts'] = $this->orders_model->get_invoiceAmount();
        
			$this->load->view($this->view.'/manage',$data);
        }
                
		public function server_data() {

            // Column array
            $columnArray = array(
                0 => 'users.company_name' ,
                1 => 'orders.lpo_no' ,
                2 => 'orders.do_no' ,
                3 => 'orders.invoice_no' ,
                4 => 'orders.placed_by',
                5 => 'orders.sales_expense' ,
                6 => 'orders.invoice_status' ,
                7 => 'orders.status',
                8 => 'orders.created' ,
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

            $where = '';

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

                if($where == null){
                    $where .= '(DATE_FORMAT(orders.created,"%Y-%m-%d") BETWEEN "'.$_POST['startdate'].'" AND "'.$_POST['enddate'].'")';
                }else{
                    $where .= ' AND (DATE_FORMAT(orders.created,"%Y-%m-%d") BETWEEN "'.$_POST['startdate'].'" AND "'.$_POST['enddate'].'")';
                }
            }
            
            if(!empty($invoiceStatus)){
                
                if(strtolower($invoiceStatus) == 'paid'){
                    $invoice_status = 1;
                }elseif (strtolower($invoiceStatus) == 'unpaid') {
                    $invoice_status = 0;
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
                }elseif (strtolower($status) == 'inprogress') {
                    $order_status = 1;
                }elseif (strtolower($status) == 'completed') {
                    $order_status = 2;
                }

                if($where == null){
                    $where .= 'orders.status = "'.$order_status.'"';
                }else{
                    $where .= ' AND orders.status = "'.$order_status.'"';
                }
            }

            // Get all records count. 
            $totalData = $this->orders_model->get_OrderDatatables();

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
                }elseif (strtolower($this->input->post('search')['value']) == 'completed') {
                    $status = 2;
                }

                // Serch bar value
                $search=$this->input->post('search')['value'];

                $where .= '(users.company_name LIKE "'.$search.'%" or ';

                $where .= 'orders.lpo_no LIKE "%'.$search.'%" or ';

                $where .= 'orders.do_no LIKE "%'.$search.'%" or ';

                $where .= 'orders.invoice_no LIKE "%'.$search.'%" or ';

                $where .= 'orders.sales_expense LIKE "%'.$search.'%" or ';

                $where .= 'orders.invoice_status LIKE "'.$invoice_status.'%" or ';

                $where .= 'orders.status LIKE "'.$status.'%" )';
            }
            //echo $where;exit;
            if($where == NULL){
                
                // Get all records with limit for data table.
                $AlltotalFiltered = $this->orders_model->get_OrderDatatables($limit,$start,$order,$dir);
                
            }else{
                
                // Get all records with limit and using search for data table.
                $AlltotalFiltered =  $this->orders_model->get_OrderDatatables($limit,$start,$order,$dir,$where);
                      
                // Get all records count using search for data table.
                $totalFiltered = $this->orders_model->get_OrderDatatables('','','','',$where);

                $totalFiltered = $totalFiltered['count'];
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
                    
                    if($SingleOrderData['placed_by']=="admin") // if order is placed by admin then disply admin name
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
                    $tabledata['lpo_no'] = '<a href="'.$downloadlpo.'"><b>'.$SingleOrderData['lpo_no'].'</b></a>';

                    // Create DP link for table.
                    $tabledata['do_no'] ='<a href="'.$download.'"><b>'.$SingleOrderData['do_no'].'</b></a>';

                    // Create Invoice link for table.
                    $tabledata['invoice_no'] ='<a href="'.$downloadinvoice.'"><b>'.$SingleOrderData['invoice_no'].'</b></a>';

                    $tabledata['placed_by'] = $placed_by_name;

                    $tabledata['sales_expense'] =$SingleOrderData['sales_expense'];

                    // Checking invoice stauts.
                    if ($SingleOrderData['invoice_status'] == 0) { 

                        $tabledata['invoice_status'] = 'Unpaid';

                    } elseif($SingleOrderData['invoice_status'] == 1) {

                        $tabledata['invoice_status'] ='Paid';
                    } 

                    // Checking Delivery Status.
                    if ($SingleOrderData['status'] == 0) {

                        $tabledata['status'] = 'Pending';

                    } elseif($SingleOrderData['status'] == 1) {

                        $tabledata['status'] ='In Progress';

                    } else {

                        $tabledata['status'] ='Completed';
                    }

                    // Created date for sales order.
                    $tabledata['created'] =$this->$model->date_conversion($SingleOrderData['created'],'d/m/Y H:i:s');
                    //$tabledata['created']=date('d/m/Y',strtotime($SingleOrderData['created']));

                    // Manage buttons.
                    $tabledata['manage'] = "<a href='".$view."' class='btn  btn-primary  btn-sm' style='padding:8px;' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";

                    // Push table data in to array.
                    $data[] = $tabledata;

                    // Increment serial number by 1.
                    $srNo++;
                }
            }

            // Combine all data in json
            $json_data = array(
                "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval($totalData['count']),  
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data   
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

            //             $q = $this->db->select('*')->where('is_deleted', 0);
       
		
            //             if(empty($s))
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
            //                             // $nestedData['manage'] = "<a href='$view' class='btn  btn-warning  btn-xs'>View</a>";
            //                             $nestedData['manage'] = "<a href='$view' class='btn  btn-primary  btn-sm' style='padding:8px;' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";
                                     

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
                    //echo '3'; exit;
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
                
		public function edit($id) {
                    
			$model = $this->model;
			$id = $this->utility->decode($id);
                        //echo $id; exit;
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
			$this->load->view($this->view.'/form',$data);
		}
                
            public function view($id) {
                    
			$model = $this->model;
			$id = $this->utility->decode($id);

            //echo $id;
            //exit();
                       // echo $id; exit;
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
                        }

                        $data['productData'] = array();
                        for($p=0;$p<count($productNameArray);$p++) {
                            $data['productData'][$p]['name']= $productNameArray[$p];
                            $data['productData'][$p]['design_no']= $designNoArray[$p];
                             $data['productData'][$p]['quantity']= $quantityArray[$p];
                             $data['productData'][$p]['price']= $priceArray[$p];
                        }
                       
                        $multipleWhere2 = ['id' => $data ['result'][0]->user_id];
                        $this->db->where($multipleWhere2);
                        $data['User'] = $this->db->get("users")->result_array();

                        //$this->db->select('customer_lpo')->from('orders')->where('id',$id)->get()->result_array();
                        $data['customer_lpo'] = $this->db->select('customer_lpo')->from('orders')->where('id',$id)->get()->result_array();

                      //  print_r($data); exit;
			$this->load->view($this->view.'/view',$data);
		}
        // Fro show all orders
        public function view_all_order($id) {
                    
            $model = $this->model;
            $id = $this->utility->decode($id);
            $data ['result'] =  $this->orders_model->view_all_order($id);
            $this->load->view($this->view.'/view_all_order',$data);
        }
                
                
            public function downloadinvoice($id) {
              
			$model = $this->model;
			$id = $this->utility->decode($id);
                        
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
                        
                        if ($userData[0]['client_type'] == 1) {
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
                        }
                        
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
                        $finalOrderData[$k]['amount'] = $productOrder[$k]['quantity']*$finalOrderData[$k]['rate'];
                        
                        $subTotal = $subTotal+ $finalOrderData[$k]['amount'];
                      }
                      $vat = $subTotal*5/100;
                      $finalTotal = $subTotal+$vat;
                        include 'TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage('P', 'A4');
$html = '<html>
<head>Tax Invoice</head>
<body>
<img src = "'.base_url().'image.png">
<h2><b><p align="center">Tax Invoice</p></b></h2>
<table style="width:100%;"><tr><td style="width:100%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">Invoice No. : '.$ordersData[0]['invoice_no'].'</td><td style="width:40%; text-align:right;">Customer : '.$userData[0]['company_name'].'</td> </tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">Tel. : '.$userData[0]['phone_no'].'</td><td style="width:40%; text-align:right;">LPO : '.$ordersData[0]['lpo_no'].'</td> </tr></table>
<br><br/>';

if(trim($ordersData[0]['customer_lpo'])!='') { // if customer lpo is exist then display it.
$html.='<table style="width:100%;"><tr><td style="width:60%;"></td><td style="width:40%; text-align:right;">Customer LPO No. : '.$ordersData[0]['customer_lpo'].'</td> </tr></table>
<br><br/>'; }

$html.='<table style="width:100%;"><tr><td style="width:60%;">Customer VAT # : '.$userData[0]['vat_number'].'</td><td style="width:40%; text-align:right;">VAT ID # : 100580141800003</td> </tr></table>
<br><br/>
<table style="width:100%;" border="1"><tr><th style="text-align: center" width="5%">SR No.</th><th style="text-align: center" width="35%">DESCRIPTION</th><th style="text-align: center" width="10%">SIZE</th><th style="text-align: center" width="10%">DESIGN</th><th style="text-align: center" width="10%">UNIT</th><th style="text-align: center" width="10%">QUANTITY</th><th style="text-align: center" width="10%">RATE</th><th style="text-align: center" width="10%">AMOUNT</th></tr>';
$count = 0;
for($p=0;$p<count($finalOrderData);$p++) {
    $count++;
    $html .= '<tr><td style="text-align: center">'.$count.'</td><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td><td style="text-align: right">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: right">'.round($finalOrderData[$p]['rate'],2).'</td><td style="text-align: right">'.round($finalOrderData[$p]['amount'],2).'</td></tr>';
                                
                          }
                          $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">SubTotal</td><td style="text-align: right">'.round($subTotal,2).'</td></tr>
                                  
                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat 5%</td><td style="text-align: right">'.round($vat,2).'</td></tr>
                                  
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
<table style="width:100%;"><tr><td style="text-align:center">Tel: 055-8532631/050-4680842 | Website: www.pnptiles.com | Email: info@pnptiles.com</td></tr>
                            <tr><td style="text-align:center">Industrial Area 2, Ras Al Khor, P.O Box: 103811, Dubai, U.A.E</td></tr></table>';
$html .='</body></html>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($ordersData[0]['invoice_no'], 'I');
                        
                        
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
                        
                        if ($userData[0]['client_type'] == 1) {
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
                        }
                        
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
                        $finalOrderData[$k]['amount'] = $productOrder[$k]['quantity']*$finalOrderData[$k]['rate'];
                        
                        $subTotal = $subTotal+ $finalOrderData[$k]['amount'];
                      }
                      $vat = $subTotal*5/100;
                      $finalTotal = $subTotal+$vat;
                        include 'TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage('P', 'A4');
$html = '<html>
<body>
<h2><b><p align="center">Local Purchase Order</p></b></h2>
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
                                  
                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat 5%</td><td style="text-align: right">'.round($vat,2).'</td></tr>
                                  
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

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($ordersData[0]['lpo_no'], 'I');
                        
                        
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
                        include 'TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage('P', 'A4');
$html = '<html>
<head>Delivery Note</head>
<body>
<img src ="'.base_url().'image.png">
<h2><b><p align="center">Delivery Note</p></b></h2>
<table style="width:100%;"><tr><td style="width:60%;">D.O. No. : '.$do_no.'</td><td style="width:40%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">Customer : '.$userData[0]['company_name'].'</td><td style="width:40%; text-align:right;">Tel : '.$userData[0]['phone_no'].'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">LPO No. : '.$ordersData[0]['lpo_no'].'</td><td style="width:40%; text-align:right;">Invoice No. : '.$ordersData[0]['invoice_no'].'</td></tr></table>
    <br><br/>';

if(trim($ordersData[0]['customer_lpo'])!=="") { // if customer lpo is exist then display it.
$html.='<table style="width:100%;"><tr><td style="width:60%;">Customer LPO No. : '.$ordersData[0]['customer_lpo'].'</td><td style="width:40%; text-align:right;"></td></tr></table>
<br><br/>'; }

 $html.='<table style="width:100%;"><tr><td style="width:60%;">Cargo : '.$ordersData[0]['cargo'].'</td><td style="width:40%; text-align:right;">Cargo Number : '.$ordersData[0]['cargo_number'].'</td></tr></table>  
    <br><br/>
 <table style="width:100%;"><tr><td style="width:60%;">Location : '.$ordersData[0]['location'].'</td><td style="width:40%; text-align:right;">Mark : '.$ordersData[0]['mark'].'</td></tr></table>     
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">THE FOLLOWING ITEMS HAVE BEEN DELIVERED</td></tr></table>
<table style="width:100%;" border="1"><tr><th style="text-align: center" width="60%">DESCRIPTION</th><th style="text-align: center" width="10%">Size</th><th style="text-align: center" width="10%">Design</th><th style="text-align: center" width="10%">quantity</th><th style="text-align: center" width="10%">Unit</th></tr>';
for($p=0;$p<count($finalOrderData);$p++) {
    $html .= '<tr><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td></tr>';
                                
                          }
                          $html .= '<tr><td></td><td></td><td colspan="2"></td><td></td></tr></table>';

$html .= '<table style="width:100%;"><tr><td style="width:60%;">Received the above goods in good condition</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:50%;">Receivers Sign : </td><td style="width:50%; ">Delivered By [Sign] : </td></tr></table>     
<br><br/>
<table style="width:100%;"><tr><td style="width:50%;">Name : </td><td style="width:50%;">Name : </td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:100%;">Mobile : </td></tr></table>
<br><br/><br><br/><br><br/>
<table style="width:100%;"><tr><td style="text-align:center">Tel: 055-8532631/050-4680842 | Website: www.pnptiles.com | Email: info@pnptiles.com</td></tr>
                            <tr><td style="text-align:center">Industrial Area 2, Ras Al Khor, P.O Box: 103811, Dubai, U.A.E</td></tr></table>

</body></html>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($do_no, 'I');
                        
                        
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
                
		public function Update() {
                    
			$model = $this->model;

			$id = $this->input->post('id');
                     //  echo $id; exit;
			$sales_expense = $this->input->post('sales_expense');
                        $status = $this->input->post('status');
                        $invoice_status = $this->input->post('invoice_status');
                        //echo $sales_expense; exit;
			$data = array(

                            'sales_expense' => $sales_expense,
                            'status' => $status,
                            'invoice_status' => $invoice_status,


			);
			$where = array($this->primary_id=>$id);
			$this->$model->update($this->table,$data,$where);
                             
			//$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$name.' has been updated successfully!</div>');
			redirect($this->controller);
		}
		public function remove($id) {
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
                         
			$this->$model->select(array(),'categories',array('id'=>$id),'','');
                        $this->db->set('is_deleted',1);
                        $this->db->where('id',$id);
                        $this->db->update('categories',$data);
                        
                        $this->db->select('name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('categories');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata['0']['name'].' has been deleted successfully!</div>');
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
			$config['allowed_types'] = "jpeg|jpg|png|gif|xlsx|xls";

			$this->load->library('upload', $config);
			$this->load->initialize($config);
			$this->upload->do_upload('upload_orders');
	$model = $this->model;
require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');

	require('spreadsheet-reader-master/SpreadsheetReader.php');

	$Reader = new SpreadsheetReader(FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads'.'/'.$image);
          
          $i=0;
	foreach ($Reader as $Row)
	{
         
            if ($i !=0) {
             $this->db->select('*');
                        $this->db->where('email', $Row[0]);
                        $q = $this->db->get('users');
            $userData = $q->result_array();
       
               if ($userData){
                   
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
                    'created' => date('Y-m-d h:i:s'),
			);
			$this->$model->insert('orders',$data); 
                        
                        $lastInsertedOrderId = $this->db->insert_id();
                   
                        $countProducts = explode(',', $Row[1]);
                        $countQuantity = explode(',', $Row[2]);
                        $countPrice = explode(',', $Row[3]);
                     
                        for($k=0;$k<count($countPrice);$k++) {
                            
                              $this->db->select('*');
                        $this->db->where('design_no', $countProducts[$k]);
                        $q = $this->db->get('products');
            $productData = $q->result_array();
                            
                              $orderProductData = array(
                                    'order_id' => $lastInsertedOrderId,
                                    'product_id' =>$productData[0]['id'],
                                    'quantity' => $countQuantity[$k],
                              'price' => $countPrice[$k],
                            );
                            $this->$model->insert('order_products',$orderProductData);
              
                     
                       $updatedSoldQuantity = $productData[0]['sold_quantity'] + $countQuantity[$k]; 
                        $this->db->set('sold_quantity',$updatedSoldQuantity);
                        $this->db->where('id',$productData[0]['id']);
                        $this->db->update('products',$newdata);
                        }
                        
	}
            } 
            $i++;
        }
        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Orders has been imported successfully!</div>');
       redirect($this->controller);	
    }
    
            public function uploadOrders(){
       

			$this->load->view($this->view.'/uploadOrders',array());
    }
                
	}
?>