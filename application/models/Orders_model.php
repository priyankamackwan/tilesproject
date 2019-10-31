<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
    class Orders_model extends CI_Model {

        // Globle variable (Tables and  Modales)
        var $orders_table = 'orders';
        var $users_table = 'users';
        var $order_products_table = 'order_products';
        var $products_table = 'products';

        // Constructor
        public function __construct() {
            parent::__construct();
            // $this->load->database();
        }

        // All order Data.
        function get_OrderDatatables($limit = NUll,$start = NUll,$order = NUll,$dir = NUll,$where = NULL) {
            
           //$this->db->select($this->orders_table.'.id,'.$this->orders_table.'.user_id ,'.$this->orders_table.'.tax,'.$this->orders_table.'.total_price,'.$this->orders_table.'.lpo_no,'.$this->orders_table.'.do_no,'.$this->orders_table.'.invoice_no,'.$this->orders_table.'.sales_expense,'.$this->orders_table.'.cargo,'.$this->orders_table.'.cargo_number,'.$this->orders_table.'.location,'.$this->orders_table.'.mark,'.$this->orders_table.'.invoice_status,'.$this->orders_table.'.status,'.$this->orders_table.'.is_deleted,'.$this->orders_table.'.created,'.$this->orders_table.'.modified,'.$this->users_table.'.company_name,'.$this->users_table.'.id as UsertableID');

            $this->db->select($this->orders_table.'.id,'.$this->orders_table.'.user_id ,'.$this->orders_table.'.tax,'.$this->orders_table.'.total_price,'.$this->orders_table.'.lpo_no,'.$this->orders_table.'.do_no,'.$this->orders_table.'.invoice_no,'.$this->orders_table.'.sales_expense,'.$this->orders_table.'.cargo,'.$this->orders_table.'.cargo_number,'.$this->orders_table.'.location,'.$this->orders_table.'.mark,'.$this->orders_table.'.invoice_status,'.$this->orders_table.'.status,'.$this->orders_table.'.is_deleted,'.$this->orders_table.'.created,'.$this->orders_table.'.modified,'.$this->users_table.'.company_name,'.$this->users_table.'.id as UsertableID,'.$this->orders_table.'.placed_by,'.$this->orders_table.'.admin_id,'.$this->users_table.'.contact_person_name');

            // Select from Order main table
            $this->db->from($this->orders_table);

            $this->db->join($this->users_table,$this->orders_table.'.user_id = '.$this->users_table.'.id');

            $this->db->join($this->order_products_table,$this->order_products_table.'.order_id = '.$this->orders_table.'.id');
            
            if(!empty($where)){
                
                // Filter condition to add where
                $this->db->where($where);
            }

            // Record Limit
            if(!empty($limit)){
                
                $this->db->limit($limit,$start);
                $this->db->order_by($order,$dir); 

            }else{

                // Order by new order
                $this->db->order_by($this->orders_table . '.id', "desc");
            }

            $this->db->where($this->orders_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.status',1);

            $this->db->group_by($this->orders_table.'.id');

            $allorderData = $this->db->get();
            
            $result = $allorderData->result_array();
            
            //Get all records count
            $count = $allorderData->num_rows();

            return array('result' => $result,'count' => $count);
        }

        // Get invoice paid total and unpaid amount
        public function get_invoiceAmount()
        {
            $this->db->select('SUM('.$this->orders_table.'.total_price) as invoiceAmount,SUM(IF('.$this->orders_table.'.invoice_status = 1,'.$this->orders_table.'.total_price,0.00)) as paidAmount,SUM(IF('.$this->orders_table.'.invoice_status = 0,'.$this->orders_table.'.total_price,0.00))as unpaidAmount');

            $this->db->from($this->orders_table);

            $Amountdata = $this->db->get()->row();
            
            return $Amountdata;
        }
        //Fetch for all order in edit page
        function view_all_order($id){
            $this->db->select('order_products.id,order_products.order_id,order_products.product_id,products.name,products.design_no,order_products.quantity,order_products.price,orders.user_id,products.name,users.company_name,users.contact_person_name,orders.sales_expense,orders.delivery_date,orders.payment_date,orders.status,orders.invoice_status,users.client_type,products.cash_rate,products.credit_rate,products.walkin_rate,products.flexible_rate');

            // Select from Order prodcuts main table
            $this->db->from('order_products');

            $this->db->join('orders','order_products.order_id=orders.id','left');

            $this->db->join('products','products.id=order_products.product_id','left');

            $this->db->join('users','users.id=orders.user_id','left');

            $this->db->where('order_products.order_id',$id);
            
            $allorderData = $this->db->get();
            
            $result = $allorderData->result_array();
            return $result;

        }
        // Update on delete
        //oprator is for increse(+) and decrease(-) quantity
        function update_items($table_name,$fieldname,$product_id, $quantity,$oprator){
            // update  current  quantity - deleted
             $this->db->set($fieldname, $fieldname.$oprator.$quantity, FALSE);
             $this->db->where($table_name.'.id',$product_id);
             $this->db->update($table_name);
             return true;
        }
        // Update order from prodcut id
        function update_order_items($table_name,$fieldname,$product_id, $quantity,$oprator){
            // update  current  quantity - deleted
             $this->db->set($fieldname, $fieldname.$oprator.$quantity, FALSE);
             $this->db->where($table_name.'.product_id',$product_id);
             $this->db->update($table_name);
             return true;
        }
        // items quntity ftech data
        function check_items_quantity($id){
            $this->db->select('*');
            $this->db->from('products');
            $this->db->where('id',$id);
            $data=$this->db->get()->row();
            return $data; 
        }
        // single prodcut from product id
        function single_items($id){
            $this->db->select('*');
            $this->db->from('order_products');
            $this->db->where('product_id',$id);
            $data=$this->db->get()->row();
            return $data; 
        }
        
    }