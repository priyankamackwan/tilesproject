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
		public function product_report_table_tecords($condition)
		{
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
	}
?>