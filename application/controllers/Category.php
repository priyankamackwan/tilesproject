<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Category extends CI_Controller
	{
		public $msgName = "Item Groups";
		public $view = "category";
		public $controller = "Category";
		public $primary_id = "id";
		public $table = "categories";
		public $msgDisplay ='category';
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
		public function index()
		{
                      //  echo '<pre>';
                   // print_r($this->session);die;
                   $this->userhelper->current('logged_in')['is_logged'] = 1;
            //Add meta title
			$data['meta_tital']='Item Groups | PNP Building Materials Trading L.L.C';
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
                         
				$q = $q->like('categories.name', $s, 'both');
                   
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
					$nestedData['name'] = "<a href='$view'><b>$value->name</b></a>";
					$base_url = base_url();

					if (!empty($value->image) && file_exists(FCPATH.'assets/uploads/'.$value->image)) {
						$image = "<img width='50px' height='50px' src='$base_url/assets/uploads/$value->image' style='background-color:navy;' >";
					// }
					// if (!empty($value->image)) {
					
					} else {
						$image = "<img width='50px' height='50px' src='$base_url/assets/default.png' style='background-color:navy;' alt='No image'>";
					} 
					// Set image   
					$nestedData['image']= $image;				
					$nestedData['status'] = $statusText;
                                        if ($value->status == 1){
											// $nestedData['manage'] = "<a href='$edit' class='btn  btn-warning  btn-xs'>Edit</a><a href='$delete' class='btn btn-danger btn-xs confirm-delete' >Delete</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Inactive</a>";
											
											$nestedData['manage'] = "<a href='$edit' class='btn  btn-primary  btn-sm' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Edit'><i class='glyphicon glyphicon-pencil'></i></a>&nbsp;<a href='$delete' class='btn btn-danger btn-sm confirm-delete' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Delete' ><i class='fa fa-trash'></i></a>&nbsp;<a href='$statusAction' class='btn  btn-warning  btn-sm confirm-statuschange' style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Inactive'><i class='fa fa-ban'></i></a>";
                                        } else {
											// $nestedData['manage'] = "<a href='$edit' class='btn  btn-warning  btn-xs'>Edit</a><a href='$delete' class='btn btn-danger btn-xs confirm-delete' >Delete</a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'>Active</a>";

											$nestedData['manage'] = "<a href='$edit' class='btn  btn-primary  btn-sm'><i class='glyphicon glyphicon-pencil'></i></a>&nbsp;<a href='$delete' class='btn btn-danger btn-sm confirm-delete' ></a><a href='$statusAction' class='btn  btn-warning  btn-xs confirm-statuschange'style='padding: 8px;margin-top:1px;' data-toggle='tooltip' title='Delete' ><i class='fa fa-trash'></i></a>";
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
			//Add meta title
			$data['meta_tital']='Item Groups | PNP Building Materials Trading L.L.C';
			$data['action'] = "insert";
			$model = $this->model;
                        $data['controller'] = $this->controller;

			$this->load->view($this->view.'/form',$data);
		}
		public function insert()
		{
                  
			$model = $this->model;
			$name = $this->input->post('name');
                        $description = $this->input->post('description');
                        $img = $_FILES['image']['name'];
                      
                        $ext = pathinfo($img,PATHINFO_EXTENSION);

            //make directory
            if (!file_exists('assets/uploads/')) {
				mkdir('assets/uploads/', 0755, TRUE);
			}            
			$image = time().'.'.$ext;

			$config['upload_path'] = 'assets/uploads/';
			$config['file_name'] = $image;
			$config['allowed_types'] = "jpeg|jpg|png|gif";

			$this->load->library('upload', $config);
			$this->load->initialize($config);
			$this->upload->do_upload('image');
                        
			$data = array(

				'name' => $name,
                                'description' => $description,
                                'image' => $image,
                                'created' => date('Y-m-d h:i:s'),
			);
			$this->$model->insert($this->table,$data);
                        
                        $this->db->select('*');
                        $this->db->where('login_status', 1);
                        $this->db->where('role', 1);
                        $q = $this->db->get('user_login_details');
                        $userData = $q->result_array();
                        $created = date('Y-m-d h:i:s');
                        $androidToken = $iosToken=array();
                        if ($userData) {
                            for ($k=0;$k<count($userData);$k++) {
                                if ($userData[$k]['device_type'] == 1) {
                                    $androidToken[] = $userData[$k]['firebase_token'];
                                }else{
                                	$iosToken[] = $userData[$k]['firebase_token'];
                                }
                            }
                        }
                        //  echo '<pre>';print_r($androidToken);
                        if(count($androidToken)>0){
                            // For Android
                            $notificationArray = array(
                                "notification_type" => 3,
                                "name" => $name,
                                "description" => $description,
                                "created" => $created,
                            );
                                        
                            $arr = array(
		                        "registration_ids" => $androidToken,
		                        "data" => [
		                            "body" => $notificationArray,
		                            "title" => "New Item Group Added",
		                            // "icon" => "ic_launcher"
		                        ],
		                        // "data" => json_encode(array())
		                    );
    	                     $data = json_encode($arr);
                             $this->android_ios_notification($data,"Android");
                    		/*//FCM API end-point
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
                            // echo '<pre>';print_r($result);
                            // echo curl_error($ch);
                            // die;
                    		//echo "----".$result;
                    		if ($result === FALSE) {
                    		    //die('Oops! FCM Send Error: ' . curl_error($ch));
                    		}
		                    curl_close($ch);
                                //     } else {
                                //         // For IOS
                                //     }
                                // }*/
                            }
                            if(count($iosToken) > 0) 
                        {
                                     	//for ios
	 							$notificationArray = array(
	                                "notification_type" => 3,
	                                "name" => $name,
	                                "description" => $description,
	                                "created" => $created,
	                            );
	                            /* OLd array            
	                            $arr = array(
			                        "registration_ids" => $iosToken,
			                        "notification" => [
			                            "body" => $notificationArray,
			                            "title" => "New Category Added",
			                            'priority' => 'high',
			                            // "icon" => "ic_launcher"
			                        ],
			                    );
			                    */ 
			                    // New ios notification
			                    $arr = array(
                                            "registration_ids" => $iosToken,
                                                "notification" => [
                                            "body" => "",
                                           	// "body" => $notificationArray,
                                            //"title" => "New Category Added",
                                            "title" => "Item Group ‘'".$name."'’ is added. Please click to check the new category.",
                                            ],
                                            "priority"=> "high",
                                            "content_available"=> true,
                                            "mutable_content"=> true,
                                            "data" => $notificationArray
                                        );
			                     $data = json_encode($arr);
                                $this->android_ios_notification($data,"Ios");
                        }
                        
                        
			$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$name.' has been added successfully!</div>');
			redirect($this->controller);
		}
		public function edit($id)
		{
                    
			$model = $this->model;
			//Add meta title
			$data['meta_tital']='Item Groups | PNP Building Materials Trading L.L.C';
			$id = $this->utility->decode($id);
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;
			$model = $this->model;

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
			$this->load->view($this->view.'/form',$data);
		}
                
                public function view($id)
		{
                    
			$model = $this->model;
			$id = $this->utility->decode($id);
			//Add meta title
			$data['meta_tital']='Item Groups | PNP Building Materials Trading L.L.C';
                        //echo $id; exit;
			$data['action'] = "update";
			$data['msgName'] = $this->msgName;
			$data['primary_id'] = $this->primary_id;
			$data['controller'] = $this->controller;

			$model = $this->model;
	

			$data ['result'] = $this->$model->select(array(),$this->table,array($this->primary_id=>$id),'','');
			$this->load->view($this->view.'/view',$data);
		}
		public function Update()
		{
			$model = $this->model;

			$id = $this->input->post('id');
			//make directory
            if (!file_exists('assets/uploads/')) {
				mkdir('assets/uploads/', 0755, TRUE);
			}
                      //  echo $id; exit;
			$name = $this->input->post('name');
                        $description = $this->input->post('description');
                  
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
                                'description' => $description,
                                'image' => $image,
                                'modified'=> date('Y-m-d h:i:s')

			);
			$where = array($this->primary_id=>$id);
			$this->$model->update($this->table,$data,$where);
                             
			$this->session->set_flashdata($this->msgDisplay,'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>'.$name.' has been updated successfully!</div>');
			redirect($this->controller);
		}
		public function remove($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
                        
                      /*  $this->db->select('id');
                       $this->db->where('cat_id', $id);
                        $q = $this->db->get('product_categories');
                        $productData = $q->result_array(); */
                        
                        $this->db->select('u.id, s.product_id');
                        $this->db->from('product_categories as s');
                        $this->db->where('u.is_deleted =', 0);
                        $this->db->where('s.cat_id', $id);
                        $this->db->join('products as u', 'u.id = s.product_id');
                        $productData = $this->db->get()->result_array();
       
       
                        if (count($productData) == 0) {
                            
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
                        } else {
                            $this->session->set_flashdata('dispMessage','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Please delete products related to this category first!</div>');
                            redirect($this->controller);
                        }
		}
                
       
                
                public function inactive($id)
		{
                   
			$model = $this->model;
			$id = $this->utility->decode($id);
                        
                       $this->db->select('u.id, s.product_id');
                        $this->db->from('product_categories as s');
                        $this->db->where('u.is_deleted =', 0);
                        $this->db->where('s.cat_id', $id);
                        $this->db->join('products as u', 'u.id = s.product_id');
                        $productData = $this->db->get()->result_array();
                        
                        $this->db->select('id');
                        $this->db->where('category_id', $id);
                        $this->db->where('is_deleted', 0);
                        $q = $this->db->get('sub_categories');
                        $subData = $q->result_array();
                        
                        if (count($subData) ==0 && count($productData) == 0) {
                            
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
                        } else {
                            $this->session->set_flashdata('dispMessage','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>Please delete subcategories and products related to this category first!</div>');
                            redirect($this->controller);
                        }
                  
				
		}
                
                public function active($id)
		{
                   
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
                
                    public function checkname()
		{
			$id = $this->input->post('id');
			$name = $this->input->post('name');
			$action = $this->input->post('action');
			if($action == 'update')
			{
                            
				$check_query = $this->db->select('*')->where_not_in('id',$id)->where('name',$name)->where('is_deleted',0)->get($this->table)->result();
			}
			else
			{
				$check_query = $this->db->select('*')->where('name',$name)->where('is_deleted',0)->get($this->table)->result();
			}

                       
			if(count($check_query) > 0)
			{
				echo "false";
			}
			else
			{
				echo "true";
			}
		}
		public function android_ios_notification($data,$type)
        {
            $url = 'https://fcm.googleapis.com/fcm/send';
            //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
            if($type=="Android")
            {
                $server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
	}
            if($type=="Ios")
            {
               $server_key="AIzaSyA-sjPOj001dkK6gHJztu4taMJeYXLBDrM";
               // $server_key = 'AAAA22AuYrc:APA91bEEpsym7Vr7cEDmOJVVdgwhxL91vZxp1bsMCoklAq3NBErrPliuxBsQKt-4i7cuXRAZ-6sb4rq-bX1zs63D_FTVZzrJU_dVNQA0C_PGZbAXehDVMk9QsiEA4qLheGCKRCcV5g3H';
            }
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
            // echo "----".$result;exit;
            if ($result === FALSE) {
                //die('Oops! FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);

        }
	}
?>