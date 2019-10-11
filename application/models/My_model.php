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
            if(isset($s) && $s!=''){
	            $this->db->like('p.name', $s, 'both');
	            $this->db->or_like('p.design_no', $s, 'both');
	            $this->db->or_like('p.size', $s, 'both');
	        }
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
		public function order_list(){
			$this->db->select('o.id,o.user_id,u.company_name,u.contact_person_name');
            $this->db->from('orders as o');
            $this->db->join('users as u', 'u.id = o.user_id','left');
            $this->db->where('o.is_deleted', 0);
            $query = $this->db->get()->result_array();
			return $query;
		}
		public function customer_reportTableRecords($condition)
		{
			$this->db->select('o.*,u.company_name,u.contact_person_name');
			$this->db->from('orders as o');
			$this->db->join('users as u', 'u.id = o.user_id','left');
			$this->db->where('o.is_deleted', 0);
			if(isset($condition) && $condition!=''){
				$this->db->where($condition);
			}
            $query = $this->db->get()->num_rows();
			return $query;
		}
	}
?>