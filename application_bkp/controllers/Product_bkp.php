<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Product extends CI_Controller
	{
		public $msgName = "Product";
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
                    
                      if (!in_array(4,$this->userhelper->current('rights'))) {
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
   
			$this->load->view($this->view.'/manage',$data);
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

					$nestedData['id'] = $key+1;
					$nestedData['name'] = "<a href='$view'><b>$value->name</b></a>";
                                        $nestedData['price'] = $value->price;
                                        $nestedData['quantity'] = $value->quantity;
					$nestedData['status'] = $statusText;
                                        if ($value->status == 1){
                                            $nestedData['manage'] = "<a href='$edit' class='btn  btn-warning  btn-xs'>Edit</a><a href='$delete' class='btn btn-danger btn-xs confirm-delete' >Delete</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Inactive</a>";
                                        } else {
                                            $nestedData['manage'] = "<a href='$edit' class='btn  btn-warning  btn-xs'>Edit</a><a href='$delete' class='btn btn-danger btn-xs confirm-delete' >Delete</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Active</a>";
                                        }
					

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
                        $price = $this->input->post('price');
                        $quantity = $this->input->post('quantity');
                        $cat_id = $this->input->post('categories');
                        $sub_cat_id = $this->input->post('subcategories');
                        $img = $_FILES['image']['name'];
                      
                        $ext = pathinfo($img,PATHINFO_EXTENSION);
			$image = time().'.'.$ext;

			$config['upload_path'] = 'assets/uploads/';
			$config['file_name'] = $image;
			$config['allowed_types'] = "jpeg|jpg|png|gif";

			$this->load->library('upload', $config);
			$this->load->initialize($config);
			$this->upload->do_upload('image');
			$data = array(
				'name' => $name,
                                'size' => $size,
                                'price' => $price,
                                'image' => $image,
                                'quantity' => $quantity,
                                'created' => date('Y-m-d h:i:s'),
			);
			$this->$model->insert($this->table,$data);
                        $insert_id = $this->db->insert_id();
                        $dataSub = array();
                        for ($i=0;$i<count($sub_cat_id);$i++) {
                            $multipleWhere = ['id' => $sub_cat_id[$i]];
                            $this->db->where($multipleWhere);
                            $categoryData = $this->db->get("sub_categories")->result_array();
                            $dataSub[$i]['sub_cat_id'] = $sub_cat_id[$i];
                            $dataSub[$i]['cat_id'] = $categoryData[0]['category_id'];
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
                                        $arr = array(
		    "registration_ids" => array($userData[$k]['firebase_token']),
		    "notification" => [
		        "body" => "{'notification_type':4,'name': $name,'size': $size,'price': $price,'quantity': $quantity,'created':$created}",
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
                        $price = $this->input->post('price');
                        $quantity = $this->input->post('quantity');
                        $categories = $this->input->post('categories[]');
                        $subcategories = $this->input->post('subcategories[]');
                      
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
                                'size' => $size,
                                'price' => $price,
                                'image' => $image,
                                'quantity' => $quantity,
                                'modified'=> date('Y-m-d h:i:s')

			);
			$where = array($this->primary_id=>$id);
			$this->$model->update($this->table,$data,$where);
                        
                        $this->db->where('product_id', $id);  
                        $this->db->delete('product_categories');  
                        $dataSub = array();
                        for ($i=0;$i<count($subcategories);$i++) {
                            $multipleWhere = ['id' => $subcategories[$i]];
                            $this->db->where($multipleWhere);
                            $categoryData = $this->db->get("sub_categories")->result_array();
                            $dataSub[$i]['sub_cat_id'] = $subcategories[$i];
                            $dataSub[$i]['cat_id'] = $categoryData[0]['category_id'];
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
    
	}
?>