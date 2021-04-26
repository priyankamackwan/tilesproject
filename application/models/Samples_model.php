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
            
            if($user_id!="" && $role!="") {
                $this->db->select($this->samples_table.'.id,'.$this->samples_table.'.user_id ,'.$this->samples_table.'.location,'.$this->samples_table.'.created,'.$this->users_table.'.company_name,'.$this->samples_table.'.tax');
            }else{    
                $this->db->select($this->samples_table.'.id,'.$this->samples_table.'.user_id ,'.$this->samples_table.'.tax,'.$this->samples_table.'.cargo,'.$this->samples_table.'.cargo_number,'.$this->samples_table.'.location,'.$this->samples_table.'.mark,'.$table.'.status,'.$this->samples_table.'.is_deleted,'.$this->samples_table.'.created,'.$this->samples_table.'.modified,'.$this->users_table.'.company_name,'.$this->users_table.'.id as UsertableID');
            }

            $this->db->from($this->samples_table);
            $this->db->join($this->users_table,$this->samples_table.'.user_id = '.$this->users_table.'.id');
           
            if($user_id!="" && $role!=""){
                if($role==1){
                    $this->db->where($this->samples_table.'.user_id',$user_id);
                } else {
                    $this->db->where($this->samples_table.'.admin_id',$user_id);
                    $this->db->where($this->samples_table.'.admin_id!=',0);
                }
            }

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
        function view_all_order($id){
            $this->db->select('order_products.id,order_products.order_id,order_products.product_id,products.name,products.design_no,order_products.id as item_id,order_products.status as item_status,order_products.quantity,order_products.price,order_products.status,orders.user_id,products.name,users.company_name,users.contact_person_name,orders.sales_expense,orders.delivery_date,orders.payment_date,orders.status,orders.invoice_status,users.client_type,products.cash_rate,products.credit_rate,products.walkin_rate,products.flexible_rate,orders.cargo,orders.cargo_number,orders.location,orders.mark,orders.total_price,orders.tax,orders.tax_percentage,order_products.rate,orders.lpo_no,orders.do_no,orders.invoice_no,legacy_invoice_no');
            // Select from Order prodcuts main table
            $this->db->from('order_products');
            $this->db->join('orders','order_products.order_id=orders.id','left');
            $allorderData = $this->db->get();
            $result = $allorderData->result_array();
            return $result;
        }
       
}