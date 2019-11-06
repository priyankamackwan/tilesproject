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
			$this->db->select('o.id,o.order_id,o.product_id,SUM(o.quantity) as totalQuantity,SUM(o.price) as amount,p.name,p.design_no,p.size,p.purchase_expense,p.quantity,p.quantity,c.name AS cate_name');
			$this->db->from('order_products o');
			$this->db->join('products p','p.id=o.product_id','left');
			$this->db->join('product_categories pc','pc.product_id=o.product_id','left');
			$this->db->join('categories c','c.id=pc.cat_id','left');
			if(isset($condition) && $condition!=''){
				$this->db->where($condition);
			}
			$this->db->group_by('o.product_id');
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
            $this->db->group_by('o.product_id');
            $this->db->having('ROUND((p.quantity*'.$stocklimit.')/100)>=p.quantity-SUM(o.quantity)');
            $this->db->order_by('p.name,p.design_no asc');
            if(!empty($condition)){
                $this->db->where($condition);
            }
            $query = $this->db->get()->num_rows();
			return $query;
		}

		public function date_conversion($date,$format)
		{
			$new_time='';
			$date=trim($date);
			$format=trim($format);
			//$newdate=date($format,strtotime($date));
			$new_date = date('d/m/Y',strtotime($date));
			if(isset($format) && $format!='' && $format=="d/m/Y H:i:s"){
				$new_time = date('H:i:s',strtotime($date));
			}
			return $new_date.'<br> '.$new_time;
		}
		// balance amount and quantity
		public function balance_quantity(){
			$this->db->select('SUM(p.quantity-o.quantity) as totalQuantity,SUM(o.price) as amount,p.purchase_expense,p.quantity');
			$this->db->from('order_products o');
			$this->db->join('products p','p.id=o.product_id','left');
			$this->db->group_by('o.product_id');

			$balance_quantity=$this->db->get()->result_array(); 
			//echo $this->db->last_query();
			return $balance_quantity;
		}
		function getamount($amount)
		{
		   if ( strpos( $amount, "." ) !== false ) {
		       $new_amount=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount);
		   }else{
		       $new_amount=preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $amount).'.00';
		   }
		   return '₹ '.$new_amount;
		}
		//best seller count 
		public function best_seller_count($where){
			$this->db->select('o.id,o.user_id,SUM(o.total_price) as totalValue,SUM(o.sales_expense) as total_sales_expense,o.invoice_no,u.company_name,u.contact_person_name,o.created');
			$this->db->from('orders as o');
			$this->db->join('users as u', 'u.id = o.user_id','left');
			$this->db->where('o.is_deleted', 0); 
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->group_by('o.user_id');
			$best_seller=$this->db->get()->num_rows(); 
			//echo $this->db->last_query();
			return $best_seller;
		}
	}
?>