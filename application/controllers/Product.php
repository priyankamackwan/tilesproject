<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Product extends CI_Controller
	{
		public $msgName = "Item";
		public $view = "product";
		public $controller = "Product";
		public $primary_id = "id";
		public $table = "products";
		public $msgDisplay ='product';
		public $model;

		public function __construct()
		{
                    
			parent::__construct();
			date_default_timezone_set('Asia/Kolkata');
			$this->model = "My_model";
                    
                      if (!in_array(5,$this->userhelper->current('rights'))) {
                        $this->session->set_flashdata('ff','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>No Rights for this module</div>');
                        redirect('Change_password');
                      }
                      

		}
		public function index()
		{
                      //  echo '<pre>';
                   // print_r($this->session);die;
                   $this->userhelper->current('logged_in')['is_logged'] = 1;
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
			$data['view'] = $this->view;
			$data['msgDisplay'] = $this->msgDisplay;
   if ($this->userhelper->current('role_id') ==1) {
			$this->load->view($this->view.'/manage',$data);
   } else {
       $this->load->view($this->view.'/manage_sub',$data);
   }
		}
		public function server_data()
		{
                    
			$model = $this->model;
                      
                       // echo $this->model; exit;
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
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('status', 1);
                        } elseif($statusFilter == 2) {
                            $q = $this->db->select('*')->where('is_deleted', 0)->where('status',0);
                        } else {
                            $q = $this->db->select('*')->where('is_deleted', 0);
                        }
				
       
			if(empty($s))
			{
                           
				if(!empty($order))
				{
					$q = $q->order_by($order);
				}
				$q = $q->limit($limit, $start)->get($this->table)->result();
 
				$totalFiltered = $totalData;
			}
			else
			{
                         
				$q = $q->like('products.name', $s, 'both');
                                $q = $q->or_like('products.design_no', $s, 'both');
                                $q = $q->or_like('products.size', $s, 'both');
                   
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
					$id = $this->primary_id;
					$edit = base_url($this->controller.'/edit/'.$this->utility->encode($value->$id));
                                        $view = base_url($this->controller.'/view/'.$this->utility->encode($value->$id));
                                        if ($value->status == 1){
                                            $statusText = 'Active';
                                            $statusAction = base_url($this->controller.'/inactive/'.$this->utility->encode($value->$id));
                                        } else {
                                            $statusText = 'Inactive';
                                            $statusAction = base_url($this->controller.'/active/'.$this->utility->encode($value->$id));
                                        }
					$delete = base_url($this->controller.'/remove/'.$this->utility->encode($value->$id));

					$nestedData['id'] = $srNo;
                                        $nestedData['design_no'] = $value->design_no;
					$nestedData['name'] = "<a href='$view'><b>$value->name</b></a>";
                                        $test = base_url();
                                        if (!empty($value->image)) {
                                        $nestedData['image'] = "<img width='100px' height='100px' src='$test/assets/uploads/$value->image' style='background-color:navy;' >";
                                        } else {
                                            $nestedData['image'] = '';
                                        }   
                  
                                        $nestedData['quantity'] = $value->quantity;
                                        $nestedData['cash_rate'] = $value->cash_rate;
                                        $nestedData['credit_rate'] = $value->credit_rate;
                                        $nestedData['walkin_rate'] = $value->walkin_rate;
   
                                        $nestedData['size'] = $value->size;
                                        if ($value->unit == 1) {
                                            $nestedData['unit'] = 'CTN';
                                        } elseif($value->unit == 2) {
                                            $nestedData['unit'] = 'SQM';
                                        } elseif($value->unit == 3) {
                                            $nestedData['unit'] = 'PCS';
                                        } else {
                                            $nestedData['unit'] = 'SET';
                                        }
                                        
                                        $nestedData['purchase_expense'] = $value->purchase_expense;
					$nestedData['status'] = $statusText;
                                        if ($value->status == 1){
                                            $nestedData['manage'] = "<a href='$edit' class='btn  btn-warning  btn-xs'>Edit</a><a href='$delete' class='btn btn-danger btn-xs confirm-delete' >Delete</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Inactive</a>";
                                        } else {
                                            $nestedData['manage'] = "<a href='$edit' class='btn  btn-warning  btn-xs'>Edit</a><a href='$delete' class='btn btn-danger btn-xs confirm-delete' >Delete</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Active</a>";
                                        }
					

					$data[] = $nestedData;
                                        $srNo++;
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
		public function add()
		{
                    //echo '3'; exit;
			$data['action'] = "insert";
			$model = $this->model;
                        $data['controller'] = $this->controller;
                            $multipleWhere = ['status' => 1, 'is_deleted' => 0];
                        $this->db->where($multipleWhere);
                        $data['categories'] = $this->db->get("categories")->result_array();
			$this->load->view($this->view.'/form',$data);
		}
		public function insert()
		{
                  
			$model = $this->model;
			$name = $this->input->post('name');
                        $size = $this->input->post('size');
                        $quantity = $this->input->post('quantity');
                        $quantity_per = $this->input->post('quantity_per_unit');
                        $factor = $this->input->post('factor');
                        $cat_id = $this->input->post('categories');
                        $sub_cat_id = $this->input->post('subcategories');
                        $design_no = $this->input->post('design_no');
                        $cash_rate = $this->input->post('cash_rate');
                        $credit_rate = $this->input->post('credit_rate');
                        $walkin_rate = $this->input->post('walkin_rate');
                        $flexible_rate = $this->input->post('flexible_rate');
                        $unit = $this->input->post('unit');
                        $purchase_expense = $this->input->post('purchase_expense');
                        $img = $_FILES['image']['name'];
                      //  echo '<pre>';
                        //print_r($_FILES); exit;
                        $ext = pathinfo($img,PATHINFO_EXTENSION);
			$image = time().'.'.$ext;

			$config['upload_path'] = 'assets/uploads/';
			$config['file_name'] = $image;
			$config['allowed_types'] = "jpeg|jpg|png|gif";

			$this->load->library('upload', $config);
			$this->load->initialize($config);
			$this->upload->do_upload('image');
                        
                        $small_thumbnail_path = "assets/uploads/small/";
                        $this->createFolder($small_thumbnail_path);
                        $small_thumbnail = $small_thumbnail_path . $image;
                        $thumb1 = $this->createThumbnail($_FILES['image']['tmp_name'], $small_thumbnail,'jpg', 239, 238);
			$data = array(
				'name' => $name,
                                'design_no' => $design_no,
                                'cash_rate' => $cash_rate,
                                'credit_rate' => $credit_rate,
                                'walkin_rate' => $walkin_rate,
                                'flexible_rate' => $flexible_rate,
                                'purchase_expense' => $purchase_expense,
                                'size' => $size,
                                'unit' => $unit,
                                'image' => $image,
                                'quantity' => $quantity,
                            'quantity_per_unit' => $quantity_per,
                            'factor' => $factor,
                                'created' => date('Y-m-d h:i:s'),
			);
			$this->$model->insert($this->table,$data);
                        $insert_id = $this->db->insert_id();
                        $dataSub = array();
                        for ($i=0;$i<count($cat_id);$i++) {
                          
                            $dataSub[$i]['cat_id'] = $cat_id[$i];
                            $dataSub[$i]['product_id'] = $insert_id;
                            $dataSub[$i]['created'] = date('Y-m-d h:i:s');
                            $this->db->insert('product_categories',$dataSub[$i]);
                        }
                        
                         $this->db->select('*');
                        $this->db->where('login_status', 1);
                        $this->db->where('role', 1);
                        $q = $this->db->get('user_login_details');
                        $userData = $q->result_array();
                        $created = date('Y-m-d h:i:s');
                                                    if ($userData) {
                                for ($k=0;$k<count($userData);$k++) {
                                    if ($userData[$k]['device_type'] == 1) {
                                        // For Android
                                                $notificationArray = array(
                                            "notification_type" => 4,
                                            "name" => $name,
                                            "size" => $size,
                                            "quantity" => $quantity,
                                            "created" => $created,
                                        );
                                                
                                        $arr = array(
		    "registration_ids" => array($userData[$k]['firebase_token']),
		    "data"=> [
		        "body" => $notificationArray,
		        "title" => "New Product Added",
		        // "icon" => "ic_launcher"
		    ],
		    // "data" => json_encode(array())
		);
    	$data = json_encode($arr);
		//FCM API end-point
		$url = 'https://fcm.googleapis.com/fcm/send';
		//api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
		$server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
		//header with content_type api key
		$headers = array(
		    'Content-Type:application/json',
		    'Authorization:key='.$server_key
		);
		//CURL request to route notification to FCM connection server (provided by Google)
		
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
		//echo "----".$result;
		if ($result === FALSE) {
		    //die('Oops! FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
                                    } else {
                                        // For IOS
                                    }
                                }
                            }
                        
                        
			$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$name.' has been added successfully!</div>');
			redirect($this->controller);
		}
                
                public function createFolder($path)
{		
	if (!file_exists($path)) {
		mkdir($path, 0755, TRUE);
	}
}
                
                public function  createThumbnail($sourcePath, $targetPath, $file_type, $thumbWidth, $thumbHeight){
	
    $source = imagecreatefromjpeg($sourcePath);
	
    $width = imagesx($source);
	$height = imagesy($source);
	
	$tnumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
	
	imagecopyresampled($tnumbImage, $source, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
	
	if (imagejpeg($tnumbImage, $targetPath, 90)) {
	    imagedestroy($tnumbImage);
		imagedestroy($source);
		return TRUE;
	} else {
		return FALSE;
	}
}	
		public function edit($id)
		{
                    
			$model = $this->model;
			$id = $this->utility->decode($id);
                        //echo $id; exit;
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
                        
			$model = $this->model;

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
                      
                        $multipleWhere = ['product_id' => $data ['result'][0]->id];
                        $this->db->where($multipleWhere);
                        $data['selected_categories'] = $this->db->get("product_categories")->result_array();
                        
                        $this->db->where('status',1);
                        $this->db->where('is_deleted',0);
                        $q_maincategories = $this->db->get('categories');
                        $data['categories'] = $q_maincategories->result_array();
                        
              
                        $q_subcategories = $this->db->get('sub_categories');
                        $data['sub_categories'] = $q_subcategories->result_array();
                     //   echo '<pre>';
                      //  print_r($data); exit;
			$this->load->view($this->view.'/form',$data);
		}
                
                public function view($id)
		{
                    
			$model = $this->model;
			$id = $this->utility->decode($id);
                        //echo $id; exit;
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;
                        
                        $data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
                        $multipleWhere = ['product_id' => $data ['result'][0]->id];
                        $this->db->where($multipleWhere);
                        $data['selected_categories'] = $this->db->get("product_categories")->result_array();
                        
                        $this->db->where('status',1);
                        $this->db->where('is_deleted',0);
                        $q_maincategories = $this->db->get('categories');
                        $data['categories'] = $q_maincategories->result_array();
                        
              
                        $q_subcategories = $this->db->get('sub_categories');
                        $data['sub_categories'] = $q_subcategories->result_array();

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
			$this->load->view($this->view.'/view',$data);
		}
		public function Update()
		{
			$model = $this->model;

			$id = $this->input->post('id');
			$name = $this->input->post('name');
                        $size = $this->input->post('size');
          
                        $quantity = $this->input->post('quantity');
                        $categories = $this->input->post('categories[]');
                        $quantity_per = $this->input->post('quantity_per_unit');
                        $factor = $this->input->post('factor');
                        $design_no = $this->input->post('design_no');
                        $unit = $this->input->post('unit');
                        $cash_rate = $this->input->post('cash_rate');
                        $credit_rate = $this->input->post('credit_rate');
                        $walkin_rate = $this->input->post('walkin_rate');
                        $flexible_rate = $this->input->post('flexible_rate');
                        $purchase_expense = $this->input->post('purchase_expense');
                        if (!empty($_FILES['updated_image']['name'])) {
                            
                         $img = $_FILES['updated_image']['name'];
                      
                        $ext = pathinfo($img,PATHINFO_EXTENSION);
			$image = time().'.'.$ext;

			$config['upload_path'] = 'assets/uploads/';
			$config['file_name'] = $image;
			$config['allowed_types'] = "jpeg|jpg|png|gif";

			$this->load->library('upload', $config);
			$this->load->initialize($config);
			$this->upload->do_upload('updated_image');
                        } else {
                            $image = $this->input->post('old_image');
                        }
                 
                        
			$data = array(

				'name' => $name,
                                'design_no' => $design_no,
                                'cash_rate' => $cash_rate,
                                'credit_rate' => $credit_rate,
                                'walkin_rate' => $walkin_rate,
                            'flexible_rate' => $flexible_rate,
                                'purchase_expense' => $purchase_expense,
                                'size' => $size,
                                'quantity_per_unit' => $quantity_per,
                                'factor' => $factor,
                                'unit' => $unit,
                                'image' => $image,
                                'quantity' => $quantity,
                                'modified'=> date('Y-m-d h:i:s')

			);
			$where = array($this->primary_id=>$id);
			$this->$model->update($this->table,$data,$where);
                        
                        $this->db->where('product_id', $id);  
                        $this->db->delete('product_categories');  
                        $dataSub = array();

                        for ($i=0;$i<count($categories);$i++) {
       
                            $dataSub[$i]['cat_id'] = $categories[$i];
                            $dataSub[$i]['product_id'] = $id;
                            $dataSub[$i]['created'] = date('Y-m-d h:i:s');
                            $this->db->insert('product_categories',$dataSub[$i]);
                        }
			$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$name.' has been updated successfully!</div>');
			redirect($this->controller);
		}
		public function remove($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
                         
			$this->$model->select(array(),'products',array('id'=>$id),'','');
                        $this->db->set('is_deleted',1);
                        $this->db->where('id',$id);
                        $this->db->update('products',$data);
                        
                        $this->db->select('name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('products');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata['0']['name'].' has been deleted successfully!</div>');
                        redirect($this->controller);	
		}
                
       
                
                public function inactive($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
                  
			$this->$model->select(array(),'products',array('id'=>$id),'','');
                        $this->db->set('status',0);
                        $this->db->where('id',$id);
                        $this->db->update('products',$data);
                        
                        $this->db->select('name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('products');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata['0']['name'].' has been blocked successfully!</div>');
                        redirect($this->controller);	
		}
                
                public function active($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);

			$this->$model->select(array(),'products',array('id'=>$id),'','');
                        $this->db->set('status',1);
                        $this->db->where('id',$id);
                        $this->db->update('products',$data);
                        
                        $this->db->select('name');
                        $this->db->where('id', $id);
                        $q = $this->db->get('products');
                        $userdata = $q->result_array();
                        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$userdata['0']['name'].' has been activated successfully!</div>');
                        redirect($this->controller);	
		}
                
                public function addsubcategories(){
                    $cat = $this->input->post('value');
                    $sub_cat = $this->input->post('sub_cat');
                $this->db->select('*');
                  $this->db->where('status',1);
                   $this->db->where('is_deleted',0);
                $this->db->where_in('category_id', $cat);
                $query = $this->db->get('sub_categories');

                // and fetch result
                $res = $query->result(); // as object
                $res = $query->result_array(); // as array
                $term = '';

                for ($k=0;$k<count($res);$k++) { 
                    if (in_array($res[$k]['id'], $sub_cat)) {
                        $term.= "<option value='".$res[$k]['id']."' selected='selected'>".$res[$k]['name']."</option>";
                    } else {
                        $term.= "<option value='".$res[$k]['id']."'>".$res[$k]['name']."</option>";
                    }
                   
                }
                echo $term;
                
                }
                

    
                    public function addProducts() {
                    
                        
                        $importFile = $_FILES['upload_products']['name'];
                    
                    $ext = pathinfo($importFile,PATHINFO_EXTENSION);
			$image = time().'.'.$ext;

			$config['upload_path'] = 'assets/uploads/';
			$config['file_name'] = $image;
			$config['allowed_types'] = "jpeg|jpg|png|gif|xlsx|xls";

			$this->load->library('upload', $config);
			$this->load->initialize($config);
			$this->upload->do_upload('upload_products');
	$model = $this->model;
require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');

	require('spreadsheet-reader-master/SpreadsheetReader.php');

	$Reader = new SpreadsheetReader(FCPATH.'assets'.DIRECTORY_SEPARATOR.'uploads'.'/'.$image);
         $i=0;
	foreach ($Reader as $Row)
	{
               // echo '<pre>';
		//print_r($Row);
            if ($i !=0) {
                 $this->db->select('*');
                        $this->db->where('name', $Row[12]);
                        $q = $this->db->get('categories');
            $categoryData = $q->result_array();
            if ($categoryData) {
            	$data = array(
				'name' => $Row[0],
                                'design_no' => $Row[1],
                                'cash_rate' => $Row[2],
				'credit_rate' => $Row[3],
                                'walkin_rate' => $Row[4],
                                'size' => $Row[5],
                     'unit' =>$Row[6],
                     'purchase_expense' => $Row[7],
                     'image' => $Row[8],
                    'quantity' => $Row[9],
                    'factor' => $Row[10],
                    'quantity_per_unit' => $Row[11],
                    'flexible_rate' => $Row[13],      
			);
			$this->$model->insert('products',$data);
                        
                        $lastInsertedProductId = $this->db->insert_id();
                        
                          $productCategoryData = array(
                                    'product_id' => $lastInsertedProductId,
                                    'cat_id' =>$categoryData[0]['id'],
                                    'created' => date('Y-m-d h:i:s'),
                            );
                            $this->$model->insert('product_categories',$productCategoryData); 
            } else {
           
                	$categoryData = array(
				'name' => $Row[12],
			);
			$this->$model->insert('categories',$categoryData);
                    
                        $lastInsertedCategoryId = $this->db->insert_id();
                        
                        
                         	$data = array(
				'name' => $Row[0],
                                'design_no' => $Row[1],
                                'cash_rate' => $Row[2],
				'credit_rate' => $Row[3],
                                'walkin_rate' => $Row[4],
                                'size' => $Row[5],
                     'unit' => $Row[6],
                     'purchase_expense' => $Row[7],
                     'image' => $Row[8],
                    'quantity' => $Row[9],
                    'factor' => $Row[10],
                    'quantity_per_unit' => $Row[11],
                     'flexible_rate' => $Row[13],               
			);
			$this->$model->insert('products',$data);
                        
                        $lastInsertedProductId = $this->db->insert_id();
                        
                          $productCategoryData = array(
                                    'product_id' => $lastInsertedProductId,
                                    'cat_id' =>$lastInsertedCategoryId,
                                    'created' => date('Y-m-d h:i:s'),
                            );
                            $this->$model->insert('product_categories',$productCategoryData); 
            }
            }
            $i++;
	}
        $this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Products has been imported successfully!</div>');
       redirect($this->controller);	
    }
    
        public function uploadProducts(){
       

			$this->load->view($this->view.'/uploadProducts',array());
    }
     
    
	}
?>