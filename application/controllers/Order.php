<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Order extends CI_Controller
	{
		public $msgName = "Order";
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
                    
                      if (!in_array(4,$this->userhelper->current('rights'))) {
                        $this->session->set_flashdata('ff','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>No Rights for this module</div>');
                        redirect('Change_password');
                      }
                      

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
   
			$this->load->view($this->view.'/manage',$data);
		}
                
		public function server_data() {
                    
			$model = $this->model;
                      
                       // echo $this->model; exit;
			$order_col_id = $_POST['order'][0]['column'];
                     
			$order = $_POST['columns'][$order_col_id]['data'] . ' ' . $_POST['order'][0]['dir'];

			$s = (isset($_POST['search']['value'])) ? $_POST['search']['value'] : '';
                        
                        $statusFilter = $_POST['columns'][2]['search']['value'];
      
			$totalData = $this->$model->countTableRecords($this->table,array('is_deleted'=>0));
    
			$start = $_POST['start'];
			$limit = $_POST['length'];

                        $q = $this->db->select('*')->where('is_deleted', 0);
       
		
				//->limit($limit, $start)
				$q = $q->get($this->table)->result();

				$totalFiltered = count($q);
			
             
			$data = array();
			if(!empty($q))
			{
				foreach ($q as $key=>$value)
				{
					$id = $this->primary_id;
                                             $multipleWhere = ['id' => $value->product_id];
                        $this->db->where($multipleWhere);
                        $productData = $this->db->get("products")->result_array();
                    
                         $multipleWhere2 = ['id' => $value->user_id];
                        $this->db->where($multipleWhere2);
                        $userData = $this->db->get("users")->result_array();
           
                                        $view = base_url($this->controller.'/view/'.$this->utility->encode($value->$id));
                                        $download = base_url($this->controller.'/download/'.$this->utility->encode($value->$id));

					$nestedData['id'] = $key+1;
                                        $nestedData['user_name'] =$userData[0]['company_name'];
                                        $nestedData['lpo_no'] =$value->lpo_no;
                                        $nestedData['do_no'] =$value->do_no;
                                        $nestedData['invoice_no'] =$value->invoice_no;
                                        $nestedData['sales_expense'] =$value->sales_expense;
                                        $nestedData['manage'] = "<a href='$view' class='btn  btn-warning  btn-xs'>View</a><a href='$download' class='btn  btn-warning  btn-xs'>Download</a>";
                                     

					$data[] = $nestedData;

				}
			}

			$json_data = array(
						"draw"            => intval($this->input->post('draw')),
						"recordsTotal"    => intval($totalData),
						"recordsFiltered" => intval($totalFiltered),
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
                        $data['Product']['name'] = implode(',',$productNameArray);
                        $data['Product']['quantity'] = implode(',',$quantityArray);
                      
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
                        //echo $id; exit;
                        include 'TCPDF/tcpdf.php';
$pdf = new TCPDF();
$pdf->AddPage('P', 'A4');
$html = '<html>
<head>Delivery Note</head>
<body>
<img src ="http://tiles.thewebpatriot.com/image.png">
<h2><b><p align="center">Delivery Note</p></b></h2>
D.O. No. : '.$do_no.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date : '.$finalDate.'<br>
Customer : '.$userData[0]['company_name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel : '.$userData[0]['phone_no'].'<br>


<table border="1">
<tr><th>name</th>
<th>company</th></tr>
<tr>
<td>hello</td>
<td>xx technologies</td>
</tr>
</table>
</body>
</html>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output();
                        
                        
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