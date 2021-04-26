<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
    class Samples_model extends CI_Model {

        // Globle variable (Tables and  Modales)
        var $samples_table = 'sample_requests';
        var $users_table = 'users';
        var $products_table = 'products';
        // Constructor
        public function __construct() {
            parent::__construct();
        }
        
        // All order Data. date condition change
        function get_SampleDatatables() {    
               
            $this->db->select('*');
            $this->db->from($this->samples_table);
            $this->db->join($this->users_table,$this->samples_table.'.user_id = '.$this->users_table.'.id');
            $this->db->where($this->samples_table.'.is_deleted',0);
            $this->db->where($this->users_table.'.is_deleted',0);
            $this->db->where($this->users_table.'.status',1);
            $this->db->group_by($this->samples_table.'.id');
            $allsampleData = $this->db->get();
            $result = $allsampleData->result_array();
            $count = $allsampleData->num_rows();
            return array('result' => $result,'count' => $count);
        }

        //Fetch for all sample in edit page
        function view_all_sample_request($id){
            
            $this->db->select('sample_requests.id,sample_requests.product_id,sample_requests.user_id,sample_requests.status as item_status,sample_requests.tax,sample_requests.cargo,sample_requests.cargo_number,sample_requests.location,sample_requests.mark,products.name,users.company_name');
            // Select from Order prodcuts main table
            $this->db->from('sample_requests');
            $this->db->join('products','products.id=sample_requests.product_id','left');
            $this->db->join('users','users.id=sample_requests.user_id','left');
            $this->db->where('sample_requests.id',$id);
            $this->db->order_by('sample_requests.id','asc');
            $allorderData = $this->db->get();
            $result = $allorderData->result_array();
            return $result;

        }
       
}