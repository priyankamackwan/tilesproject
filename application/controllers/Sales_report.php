<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Sales_report extends CI_Controller
  {
    public $msgName = "Order";
    public $view = "sales_report";
    public $controller = "Sales_report";
    public $primary_id = "id";
    public $table = "orders";
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
      $model = $this->model; 
                           //  echo '<pre>';
                   // print_r($this->session);die;
                   $this->userhelper->current('logged_in')['is_logged'] = 1;
      $data['msgName'] = $this->msgName;
      $data['primary_id'] = $this->primary_id;
      $data['controller'] = $this->controller;
      $data['view'] = $this->view;
      $data['msgDisplay'] = $this->msgDisplay;
      // Add To display in filter
      $data['order_list'] = $this->$model->order_list('sales_report');
   
      $this->load->view($this->view.'/manage',$data);
    }
                
    public function server_data() {
                    
      $model = $this->model;
                      
                       // echo $this->model; exit;
      $company_name=$where=$startDate=$endDate='';
      $company_name = $this->input->post('company_name');
      // User salesOrderDate for filter
      $salesOrderDate = $this->input->post('salesOrderDate');
      $status = $this->input->post('status');
      if(isset($company_name) && $company_name!=''){
        if($where == null){
          $where .= 'LOWER(company_name) = "'.strtolower($company_name).'" ';
        }else{
            $where .= ' AND LOWER(company_name) = "'.strtolower($company_name).'" ';
        }
      }
      /*
      if(!empty($status)){
        if($status == "Paid"){
            $status = 1;
        }else{
          $status=0;
        }
        if($where == null){
            $where .= 'o.invoice_status = "'.$status.'"';
        }else{
            $where .= ' AND o.invoice_status = "'.$status.'"';
        }
      }
      if(!empty($startDate) || !empty($endDate))
      {
        if($where == null){
          $where .= '(o.created >= "'.$startDate.'" AND o.created <= "'.$endDate.'" )';
        }else{
            $where .= 'AND (o.created >= "'.$startDate.'" AND o.created <= "'.$endDate.'" )';
        }
      }*/
      if(!empty($salesOrderDate) && isset($_POST['startdate'])){

          if($where == null){
              $where .= '(DATE_FORMAT(o.created,"%Y-%m-%d") BETWEEN "'.$_POST['startdate'].'" AND "'.$_POST['enddate'].'")';
          }else{
              $where .= ' AND (DATE_FORMAT(o.created,"%Y-%m-%d") BETWEEN "'.$_POST['startdate'].'" AND "'.$_POST['enddate'].'")';
          }
      }
      // Serach text condition
       

      //$startDate = $_POST['columns'][1]['search']['value'];
     // $endDate = $_POST['columns'][2]['search']['value'];
      $order_col_id = $_POST['order'][0]['column'];
                     
      $order = $_POST['columns'][$order_col_id]['data'] . ' ' . $_POST['order'][0]['dir'];

      $s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
      // Filter data using serach.
      if(!empty($s)){
        if($where != null){
            $where.= ' AND ';
        }
            $where .= 'u.company_name LIKE "'.$s.'%"';
        // $where .= 'o.totalValue LIKE "'.$s.'%" or ';
        // $where .= 'o.total_sales_expense LIKE "'.$s.'%" )';
      }                  

                       // $startDate = $_POST['columns'][1]['search']['value'];
                        //$endDate = $_POST['columns'][2]['search']['value'];
      
      //$totalData = $this->$model->countTableRecords($this->table,array('is_deleted'=>0));
                       
      $start = $_POST['start'];
      $limit = $_POST['length'];
                        
                         /*if (empty($startDate) || empty($endDate)){
                            $q = $this->db->select('user_id,SUM(total_price) as totalValue,SUM(sales_expense) as total_sales_expense')->group_by('user_id')->where('is_deleted', 0);
                                if(empty($s))
      {
                           
        if(!empty($order))
        {
          $q = $q->order_by($order);
        }
        $q = $q->limit($limit, $start)->get($this->table)->result();
 
        $totalFiltered = count($q);
      }
      else
      {
                         
        $q = $q->like('orders.total_price', $s, 'both');
        if(!empty($order))
        {
          $q = $q->order_by($order);
        }
        //->limit($limit, $start)
        $q = $q->get($this->table)->result();

        $totalFiltered = count($q);
      }
                        }  else {
                            $q= $this->db->select('user_id,SUM(total_price) as totalValue,SUM(sales_expense) as total_sales_expense')->group_by('user_id')->where('created >=', $startDate);
                            $this->db->where('created <=', $endDate);
                               if(empty($s))
      {
                           
        if(!empty($order))
        {
          $q = $q->order_by($order);
        }
        $q = $q->get($this->table)->result();

        $totalFiltered = count($q);
      }
      else
      {
                         
        $q = $q->like('orders.total_price', $s, 'both');
        if(!empty($order))
        {
          $q = $q->order_by($order);
        }
        //->limit($limit, $start)
        $q = $q->get($this->table)->result();

        $totalFiltered = count($q);
      }
                        }
echo $this->db->last_query();*/
      $this->db->select('o.user_id,SUM(o.total_price) as totalValue,SUM(o.sales_expense) as total_sales_expense,o.invoice_no,u.company_name,u.contact_person_name,o.created');
      $this->db->from('orders as o');
      $this->db->join('users as u', 'u.id = o.user_id','left');
      $this->db->where('o.is_deleted', 0);   
      if(!empty($where)){
        $this->db->where($where);
      }
      /*if(!empty($order))
      {
        $this->db->order_by($order);
      }*/
      $this->db->group_by('o.user_id');
      $this->db->limit($limit, $start);

      $q=$this->db->get()->result_array();  
      $totalData=$this->$model->report_table_tecords($where,'sales_report');
      $data = array();
    
                    
      if(!empty($q))
      {
                               $startNo = $_POST['start'];
                            $srNo = $startNo + 1;
        foreach ($q as $key=>$value)
        {
          $id = $this->primary_id;
                                             
                    
                       /*  $multipleWhere2 = ['id' => $value->user_id];
                        $this->db->where($multipleWhere2);
                        $userData = $this->db->get("users")->result_array();
                        $invoiceData = $this->db->order_by('id',"desc")

    ->limit(1)
->where('user_id',$value->user_id)
    ->get('orders')

    ->row();*/
                        
          $nestedData['id'] = $srNo;
                                        $nestedData['company_name'] =$value['company_name'];
                                        $nestedData['created'] =$value['created'];
                                        $nestedData['invoice_no'] =$value['invoice_no'];
                                        $nestedData['total_price'] =$value['totalValue'];
                                        $nestedData['sales_expense'] =$value['total_sales_expense'];
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
                        $quantityArray[]= $data['Product'][$k]['quantity'];
                        }

                        $data['productData'] = array();
                        for($p=0;$p<count($productNameArray);$p++) {
                            $data['productData'][$p]['name']= $productNameArray[$p];
                             $data['productData'][$p]['quantity']= $quantityArray[$p];
                        }
                 
                        $multipleWhere2 = ['id' => $data ['result'][0]->user_id];
                        $this->db->where($multipleWhere2);
                        $data['User'] = $this->db->get("users")->result_array();

                      //  print_r($data); exit;
      $this->load->view($this->view.'/view',$data);
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
                        $finalDate = date("d-M-Y", strtotime($createdData[0]));
                        
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
<head>Delivery Note</head>
<body>
<img src ="http://tiles.thewebpatriot.com/image.png">
<h2><b><p align="center">Tax Invoice</p></b></h2>
<table style="width:100%;"><tr><td style="width:100%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:100%; text-align:right;">PNP BUILDING MATERIAL TRADING LLC<br>INDUSTRIAL AREA 2 , RAS AL KHOR<br>DUBAI, 103811, U.A.E<br>+97143531040 / +971558532631<br>Email: info@pnptiles.com</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">Invoice No. : '.$ordersData[0]['invoice_no'].'</td><td style="width:40%; text-align:right;">Customer : '.$userData[0]['company_name'].'</td> </tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">Tel. : '.$userData[0]['phone_no'].'</td><td style="width:40%; text-align:right;">LPO : '.$ordersData[0]['lpo_no'].'</td> </tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">Customer VAT # : '.$userData[0]['vat_number'].'</td><td style="width:40%; text-align:right;">VAT ID # : 100580141800003</td> </tr></table>
<br><br/>
<table style="width:100%;" border="1"><tr><th style="text-align: center">SR No.</th><th style="text-align: center">DESCRIPTION</th><th style="text-align: center">SIZE</th><th style="text-align: center">DESIGN</th><th style="text-align: center">UNIT</th><th style="text-align: center">QUANTITY</th><th style="text-align: center">RATE</th><th style="text-align: center">AMOUNT</th></tr>';
$count = 0;
for($p=0;$p<count($finalOrderData);$p++) {
    $count++;
    $html .= '<tr><td style="text-align: center">'.$count.'</td><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td><td style="text-align: center">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: center">'.$finalOrderData[$p]['rate'].'</td><td style="text-align: center">'.$finalOrderData[$p]['amount'].'</td></tr>';
                                
                          }
                          $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">SubTotal</td><td>'.$subTotal.'</td></tr>
                                  
                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat 5%</td><td>'.$vat.'</td></tr>
                                  
<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Grand Total(AED)</td><td>'.$finalTotal.'</td></tr></table>
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
$pdf->Output($ordersData[0]['invoice_no'], 'D');
                        
                        
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
                        $finalDate = date("d-M-Y", strtotime($createdData[0]));
                        
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
<head>Local Purchase Order</head>
<body>
<h2><b><p align="center">Local Purchase Order</p></b></h2>
<table style="width:100%;"><tr><td style="width:100%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:40%;">From</td><td style="width:60%; text-align:center;">To</td> </tr></table>
<table style="width:100%;"><tr><td style="width:40%;">Buyer : '.$userData[0]['company_name'].'</td><td style="width:60%; text-align:right;">Seller : PNP BUILDING MATERIAL TRADING LLC </td></tr></table>
<table style="width:100%;"><tr><td style="width:40%;">Tel. : '.$userData[0]['phone_no'].'</td><td style="width:60%; text-align:right;">Tel. : +97143531040 / +971558532631</td> </tr></table>
<table style="width:100%;"><tr><td style="width:40%;">LPO : '.$ordersData[0]['lpo_no'].'</td><td style="width:60%; text-align:right;">Address : INDUSTRIAL AREA 2,<br>
    RAS AL KHOR, PO BOX: 103811 DUBAI-UAE</td> </tr>
    <tr><td style="width:100%; text-align:right;">Email : info@pnptiles.com</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">Customer VAT # : '.$userData[0]['vat_number'].'</td><td style="width:40%; text-align:right;">VAT ID # : 100580141800003</td> </tr></table>
<br><br/>
<table style="width:100%;" border="1"><tr><th style="text-align: center">SR No.</th><th style="text-align: center">DESCRIPTION</th><th style="text-align: center">SIZE</th><th style="text-align: center">DESIGN</th><th style="text-align: center">UNIT</th><th style="text-align: center">QUANTITY</th><th style="text-align: center">RATE</th><th style="text-align: center">AMOUNT</th></tr>';
$count = 0;
for($p=0;$p<count($finalOrderData);$p++) {
    $count++;
    $html .= '<tr><td style="text-align: center">'.$count.'</td><td style="text-align: center">'.$finalOrderData[$p]['description'].'</td><td style="text-align: center">'.$finalOrderData[$p]['size'].'</td><td style="text-align: center">'.$finalOrderData[$p]['design_no'].'</td><td style="text-align: center">'.$finalOrderData[$p]['unit'].'</td><td style="text-align: center">'.$finalOrderData[$p]['quanity'].'</td><td style="text-align: center">'.$finalOrderData[$p]['rate'].'</td><td style="text-align: center">'.$finalOrderData[$p]['amount'].'</td></tr>';
                                
                          }
                          $html .= '<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">SubTotal</td><td>'.$subTotal.'</td></tr>
                                  
                                  <tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Vat 5%</td><td>'.$vat.'</td></tr>
                                  
<tr><td></td><td></td><td></td><td></td><td></td><td colspan="2" style="text-align: center">Grand Total(AED)</td><td>'.$finalTotal.'</td></tr></table>
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
$pdf->Output($ordersData[0]['lpo_no'], 'D');
                        
                        
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
                        $finalDate = date("d-M-Y", strtotime($createdData[0]));
                        
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
<img src ="http://tiles.thewebpatriot.com/image.png">
<h2><b><p align="center">Delivery Note</p></b></h2>
<table style="width:100%;"><tr><td style="width:60%;">D.O. No. : '.$do_no.'</td><td style="width:40%; text-align:right;">Date : '.$finalDate.'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">Customer : '.$userData[0]['company_name'].'</td><td style="width:40%; text-align:right;">Tel : '.$userData[0]['phone_no'].'</td></tr></table>
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">LPO No. : '.$ordersData[0]['lpo_no'].'</td><td style="width:40%; text-align:right;">Invoice No. : '.$ordersData[0]['invoice_no'].'</td></tr></table>
    <br><br/>
 <table style="width:100%;"><tr><td style="width:60%;">Cargo : '.$ordersData[0]['cargo'].'</td><td style="width:40%; text-align:right;">Cargo Number : '.$ordersData[0]['cargo_number'].'</td></tr></table>  
    <br><br/>
 <table style="width:100%;"><tr><td style="width:60%;">Location : '.$ordersData[0]['location'].'</td><td style="width:40%; text-align:right;">Mark : '.$ordersData[0]['mark'].'</td></tr></table>     
<br><br/>
<table style="width:100%;"><tr><td style="width:60%;">THE FOLLOWING ITEMS HAVE BEEN DELIVERED</td></tr></table>
<table style="width:100%;" border="1"><tr><th style="text-align: center">DESCRIPTION</th><th style="text-align: center">Size</th><th style="text-align: center">Design</th><th style="text-align: center">quantity</th><th style="text-align: center">Unit</th></tr>';
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
$pdf->Output($do_no, 'D');
                        
                        
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
                        //echo $sales_expense; exit;
      $data = array(

                            'sales_expense' => $sales_expense,
                            'status' => $status,


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
                
  }
?>