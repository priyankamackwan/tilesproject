<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class My_model extends CI_Model
	{	
		public function __construct()
		{
			parent::__construct();

		}		
		public function insert($table,$data)
		{
			$this->db->insert($table,$data);
		}
		
		public function countTableRecords($table,$condition)
		{
			$query =$this->db->where($condition)->get($table);
			return $query->num_rows();
		}
		// Add for product filter count
		public function filtercountTableRecords($condition,$s)
		{
			$this->db->select('*');
            $this->db->from('products as p');
            $this->db->join('product_categories as pc', 'pc.product_id = p.id');
            $this->db->join('categories as c', 'c.id = pc.cat_id');
            $this->db->where('p.is_deleted', 0);
            $this->db->where('c.is_deleted', 0);
            if(isset($condition) && $condition!=''){
				$this->db->where($condition);
            }
            /* Set In where
            if(isset($s) && $s!=''){
	            $this->db->like('p.name', $s, 'both');
	            $this->db->or_like('p.design_no', $s, 'both');
	            $this->db->or_like('p.size', $s, 'both');
	        }*/
	         $this->db->group_by('pc.product_id');
            $query = $this->db->get()->num_rows();
			return $query;
		}
		
		public function select($fields,$table,$condition,$orderField,$orderType='desc',$limit=null)
		{
			return $this->db->select($fields)->where($condition)->order_by($orderField,$orderType)->limit($limit)->get($table)->result();
		}
		
		public function update($table,$data,$where)
		{
			$query = $this->db->update($table,$data,$where);
			return $query;
		}
		
		public function delete($table,$where)
		{
			return $this->db->delete($table,$where);
		}
		
		public function db_query($query)
		{
			return $this->db->query($query)->result();
		}
		
		public function checkDuplicate($tableName,$condition)
		{
			$query = $this->db->get_where($tableName,$condition);
			return $query->num_rows();
		}
		// Add new for fetch order list displat in filter
		public function order_list($pagename){
			$this->db->select('o.id,o.user_id,u.company_name,u.contact_person_name');
            $this->db->from('orders as o');
            $this->db->join('users as u', 'u.id = o.user_id','left');
            $this->db->where('o.is_deleted', 0);
            $this->db->where('u.status', 1);
            $this->db->where('u.is_deleted', 0);
           // if(isset($pagename) && $pagename!=''){
            	//$this->db->group_by('o.user_id');
            	$this->db->group_by('u.id');
           // }
            $query = $this->db->get()->result_array();
			return $query;
		}
		//count for customer report Records
		public function report_table_tecords($condition,$sales_report)
		{
			$this->db->select('o.*,u.company_name,u.contact_person_name');
			$this->db->from('orders as o');
			$this->db->join('users as u', 'u.id = o.user_id','left');
			$this->db->where('o.is_deleted', 0);
			$this->db->where('u.is_deleted', 0);
			$this->db->where('u.status', 1);
			if(isset($condition) && $condition!=''){
				$this->db->where($condition);
			}
			if(isset($sales_report) && $sales_report=="sales_report"){
				$this->db->group_by('o.user_id');	
			}
            $query = $this->db->get()->num_rows();
			return $query;
		}
		public function product_report_table_tecords($condition,$low_stock)
		{
			// For low stock yes 
			if(isset($low_stock) && $low_stock!='' && $low_stock=='true'){
			//Low stock constant 25 %	
	          $stocklimit=Stock_Reminder;
	          $this->db->select('ROUND((o.quantity*'.$stocklimit.')/100),p.quantity-SUM(o.quantity) as s_quantity');
	          $this->db->having('ROUND((p.quantity*'.$stocklimit.')/100)>=p.quantity-SUM(o.quantity)');
	          $this->db->order_by('p.name asc');
	        } 
	        // End for low stock conidtion
			$this->db->select('o.id,o.order_id,o.product_id,SUM(o.quantity) as totalQuantity,SUM(o.price) as amount,p.name,p.design_no,p.size,p.quantity,p.quantity,c.name AS cate_name');
			$this->db->from('products p');
			$this->db->join('order_products o','o.product_id=p.id','left');
			$this->db->join('product_purchase_history ph','ph.product_id=p.id','left');
			$this->db->join('product_categories pc','pc.product_id=p.id','left');
			$this->db->join('categories c','c.id=pc.cat_id','left');
			$this->db->where('p.is_deleted',0);
      		$this->db->where('c.is_deleted',0);
			if(isset($condition) && $condition!=''){
				$this->db->where($condition);
			}
			$this->db->or_where('ph.product_id',null);
			$this->db->group_by('p.id');
            $query = $this->db->get()->num_rows();
			return $query;
		}
		// Count for low stock product less than 25 %
		public function low_product_counts($condition)
		{
			$stocklimit=Stock_Reminder;
			$this->db->select('p.name,p.design_no,p.size,p.sold_quantity,p.quantity,ROUND((o.quantity*'.$stocklimit.')/100),p.quantity-SUM(o.quantity)');
            $this->db->from('products AS p');
            $this->db->join('order_products AS o','p.id=o.product_id');
            $this->db->where('p.status',1);
            $this->db->where('p.is_deleted',0);
            $this->db->group_by('o.product_id');
            $this->db->having('ROUND((p.quantity*'.$stocklimit.')/100)>=p.quantity-SUM(o.quantity)');
            $this->db->order_by('p.name,p.design_no asc');
            if(!empty($condition)){
                $this->db->where($condition);
            }
            $query = $this->db->get()->num_rows();
			return $query;
		}

		public function date_conversion($date,$format,$break=''){
			if($break==''){
				$break='<br>';
			}
            $date_format='';
            $time_format='';
            $new_date='';
            $new_time='';
            $date=trim($date);
            $format=trim($format);
            $date_explode=explode(" ",$format); // explode format for various date and time format.
            $date_format=$date_explode[0];
            $time_format=$date_explode[1];
            if(isset($date_explode[2]) && $date_explode[2]!=''){
            	$time_format .= ' '.$date_explode[2];
            }
            $new_date = date($date_format,strtotime($date));
            $new_time = date($time_format,strtotime($date));
            return $new_date.$break.$new_time;
        }
		// balance amount and quantity
		public function balance_quantity($condition,$low_stock){
			// $this->db->select('SUM(p.quantity-o.quantity) as totalQuantity,SUM(o.price) as amount,p.purchase_expense,p.quantity');
			// $this->db->from('order_products o');
			// $this->db->join('products p','p.id=o.product_id','left');
			// $this->db->where('p.is_deleted',0);
			// $this->db->group_by('o.product_id');

			// $balance_quantity=$this->db->get()->result_array(); 
			// //echo $this->db->last_query();
			// return $balance_quantity;
			// For low stock yes 
			if(isset($low_stock) && $low_stock!='' && $low_stock=='true'){
			//Low stock constant 25 %	
	          $stocklimit=Stock_Reminder;
	          $this->db->select('ROUND((o.quantity*'.$stocklimit.')/100),p.quantity-SUM(o.quantity) as s_quantity');
	          $this->db->having('ROUND((p.quantity*'.$stocklimit.')/100)>=p.quantity-SUM(o.quantity)');
	        } 
	        // End for low stock conidtion
			$this->db->select('o.id,o.order_id,o.product_id,SUM(o.quantity) as totalQuantity,SUM(o.price) as amount,p.name,p.design_no,p.size,p.quantity,c.name AS cate_name,AVG(ph.purchase_rate) as purchase_expense,p.sold_quantity');
			$this->db->from('products p');
			$this->db->join('order_products o','o.product_id=p.id','left');
			$this->db->join('product_purchase_history ph','ph.product_id=p.id','left');
			$this->db->join('product_categories pc','pc.product_id=p.id','left');
			$this->db->join('categories c','c.id=pc.cat_id','left');
			$this->db->where('p.is_deleted',0);
      		$this->db->where('c.is_deleted',0);
			if(isset($condition) && $condition!=''){
				$this->db->where($condition);
			}
			// $this->db->or_where('ph.product_id',null);
			$this->db->group_by('p.id');
            $query = $this->db->get()->result_array();
            // echo $this->db->last_query();
			return $query;
		}
		function getamount($amount,$convert='no',$isCurrencyFormate='yes')
		{
			$firstCharacter='';
		   if ( strpos( $amount, "." ) !== false ) {
		       $new_amount=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount);
		   }else{
		       $new_amount=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount).'.00';
		   }
		   //$firstCharacter = substr($amount, 0, 1);
		   // if(isset($firstCharacter) && $firstCharacter!='' && $firstCharacter=="-" && $firstCharacter < 0){
		   // 		$amount = ltrim($amount, $firstCharacter);
		   // }
		   //length of amount and convert to lac and crore
		   $length = strlen(round($amount));
		    if($length>=6 && $length <=7){
		    	
		    	$decimal = (string)(round($amount) - floor(round($amount)));
		        $money = floor(round($amount));
		        $length = strlen($money);
		        $delimiter = '';
		        $money = strrev($money);

		        for($i=0;$i<$length;$i++){
		            if(( $i==3 || ($i%3==0))&& $i!=$length){
		                $delimiter .=',';
		            }
		            $delimiter .=$money[$i];
		        }
		        $result = strrev($delimiter);
		        $decimal = preg_replace("/0\./i", ".", $decimal);
		        $decimal = substr($decimal, 1, 3);
		        if( $decimal != '0'){
		            $result = $result.$decimal;
		        }
		        $currency = rtrim($result, ',').".00";
			   
		        //$currency=round($amount/100000,2).' Lac';
		    }else if($length>=8){
		        $currency= round($amount/10000000,2).' Cr.';
		    }else{
		    	$currency=$new_amount;
		    }
		    if(isset($convert) && $convert!='' && $convert=="yes" && $isCurrencyFormate=="yes"){
		    	return 'AED '.$firstCharacter.$currency;
		    }else if(isset($convert) && $convert!='' && $convert=="no" && $isCurrencyFormate=="no"){
		    	return $new_amount;
		    }else{
		    	return 'AED '.$new_amount;
		    }
		   
		}
		//best seller count 
		public function best_seller_count($where){
			$this->db->select('o.id,o.user_id,SUM(o.total_price) as totalValue,SUM(o.sales_expense) as total_sales_expense,o.invoice_no,u.company_name,u.contact_person_name,o.created');
			$this->db->from('orders as o');
			$this->db->join('users as u', 'u.id = o.user_id','left');
			$this->db->where('o.is_deleted', 0); 
			$this->db->where('u.is_deleted', 0);
			$this->db->where('u.status',1); 
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->group_by('o.user_id');
			$best_seller=$this->db->get()->num_rows(); 
			//echo $this->db->last_query();
			return $best_seller;
		}
		//expense report
		function expenseReport($where=null,$limit = NUll,$start = NUll,$order = NUll,$dir = NUll){
			$this->db->select('orders.id,invoice_no,total_price,orders.created,sales_expense,orders.tax');
			$this->db->from('orders');
			$this->db->join('users as u', 'u.id = orders.user_id','left');
			$this->db->where('orders.is_deleted', 0);
			$this->db->where('u.is_deleted', 0);
			$this->db->where('u.status', 1);
			if(isset($where) && $where!=''){
				$this->db->where($where);
			}
			if(!empty($limit)){
                
                $this->db->limit($limit,$start);
                $this->db->order_by($order,$dir); 

            }
            $allorderData = $this->db->get();
            $result = $allorderData->result_array();
            
            //Get all records count
            $count = $allorderData->num_rows();
            return array('result' => $result,'count' => $count);
			//return $query;

		}
		//purchase history data 
		function purchase_history($productId=NUll,$productHistoryId=NUll,$action='insert',$getRowArray="no"){
			$this->db->select('products.id,products.name,products.factor');
			if(isset($action) && $action!='' && $action=="edit"){
				$this->db->select('product_purchase_history.id as productHistoryId,product_purchase_history.purchase_rate,product_purchase_history.quantity,product_purchase_history.quantity_per_unit');
			}
            $this->db->from('products');
            $this->db->join('product_purchase_history','product_purchase_history.product_id=products.id','left');
            $this->db->where('products.is_deleted',0);
            
            if(isset($productHistoryId) && $productHistoryId!=''){
            	$this->db->where('product_purchase_history.id',$productHistoryId);
            }
            if(isset($productId) && $productId!=''){
            	$this->db->where('product_purchase_history.product_id',$productId);
            	$this->db->or_where('product_purchase_history.product_id',null);
            }         
            $this->db->where('products.id',$productId);
            if(isset($getRowArray) && $getRowArray!='' & $getRowArray=="yes"){
            	$purchaseData = $this->db->get()->row();
            }else{  
            	$purchaseData = $this->db->get()->result_array();
            }
            return $purchaseData;
		}
		//update item quantity on edit delete, update
		function updateItems($productId,$quantity,$oprator){
			$fieldname='quantity';
			$table_name='products';
            // update  current  quantity - deleted
             $this->db->set($fieldname, $fieldname.$oprator.$quantity, FALSE);
             $this->db->where($table_name.'.id',$productId);
             $this->db->update($table_name);
             return true;
        }
        // items quntity fetech data
        function check_items_quantity($table,$productId,$historyId=null){
            $this->db->select('quantity');
            $this->db->from($table);
            if(isset($historyId) && $historyId!=''){
            	$this->db->where('id',$historyId);	
            }
            if(isset($productId) && $productId!=''){
            	$this->db->where('product_id',$productId);	
            }            
            $data=$this->db->get()->row();
            return $data; 
        }

	}
?>