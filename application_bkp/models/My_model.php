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
	}
?>