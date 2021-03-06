<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Dashboard_model extends CI_Model {

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
        //dashboard order count
        

        // All order Data.
        function get_OrderDatatables($where) {
            
            // $this->db->select($this->orders_table.'.id,SUM('.$this->orders_table.'.total_price * '.$this->orders_table.'.tax / 100 + '.$this->orders_table.'.total_price) as invoiceAmount');

            $this->db->select($this->orders_table.'.id,SUM('.$this->orders_table.'.total_price + '.$this->orders_table.'.tax ) as invoiceAmount');

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

            return $count;
        }
        function count_price($where) {
            
            // $this->db->select('SUM('.$this->orders_table.'.total_price * '.$this->orders_table.'.tax / 100 + '.$this->orders_table.'.total_price) as invoiceAmount');

            $this->db->select('SUM('.$this->orders_table.'.total_price + '.$this->orders_table.'.tax) as invoiceAmount');


            $this->db->from($this->orders_table);
            if(!empty($where)){
                $this->db->where($where);
            }
            $this->db->where($this->orders_table.'.is_deleted',0);
            $allorderData=$this->db->get();
            $result = $allorderData->row();
            return $result;
        }
       /* function get_OrderDatatables($where) {
            
            $this->db->select('*');

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

            return $count;
        }
*/
        // Get invoice paid total and unpaid amount
        public function get_invoiceAmount()
        {
            $this->db->select('SUM('.$this->orders_table.'.total_price) as invoiceAmount,SUM(IF('.$this->orders_table.'.invoice_status = 1,'.$this->orders_table.'.total_price,0.00)) as paidAmount,SUM(IF('.$this->orders_table.'.invoice_status = 0,'.$this->orders_table.'.total_price,0.00))as unpaidAmount');

            $this->db->from($this->orders_table);

            $Amountdata = $this->db->get()->row();
            
            return $Amountdata;
        }
        function lowdata(){
            $stocklimit=Stock_Reminder;
            $this->db->select('ROUND((o.quantity*'.$stocklimit.')/100),p.quantity-SUM(o.quantity) as s_quantity');
            $this->db->having('ROUND((p.quantity*'.$stocklimit.')/100)>=p.quantity-SUM(o.quantity)');
            $this->db->select('o.id,o.order_id,o.product_id,SUM(o.quantity) as totalQuantity,SUM(o.price) as amount,p.name,p.design_no,p.size,p.quantity,p.quantity,c.name AS cate_name,AVG(ph.purchase_rate) as purchase_expense,p.sold_quantity');
            $this->db->from('order_products o');
            $this->db->join('products p','p.id=o.product_id','left');
            $this->db->join('product_categories pc','pc.product_id=o.product_id','left');
            //product history table avrage price
            $this->db->join('product_purchase_history ph','ph.product_id=o.product_id','left');
            $this->db->join('categories c','c.id=pc.cat_id','left');
            $this->db->where('p.is_deleted',0);
            $this->db->where('c.is_deleted',0);
            $this->db->or_where('ph.product_id',null);
            $this->db->limit($limit, $start);
            $this->db->group_by('o.product_id');
            $listInfo=$this->db->get()->num_rows();
            return $listInfo;
        }
        function get_usertables($where) {
            
            $this->db->select('*');
            $this->db->from($this->users_table);
            if(!empty($where)){
                $this->db->where($where);
            }
            $this->db->where($this->users_table.'.is_deleted',0);
            //$this->db->where($this->users_table.'.status',1);
            $allorderData = $this->db->get();
            $result = $allorderData->result_array();
            $count = $allorderData->num_rows();
            return $count;
        }
        function  latest_orders($where){
            $this->db->select($this->orders_table.'.id,'.$this->orders_table.'.user_id ,'.$this->orders_table.'.tax,'.$this->orders_table.'.total_price,'.$this->orders_table.'.lpo_no,'.$this->orders_table.'.do_no,'.$this->orders_table.'.invoice_no,'.$this->orders_table.'.sales_expense,'.$this->orders_table.'.cargo,'.$this->orders_table.'.cargo_number,'.$this->orders_table.'.location,'.$this->orders_table.'.mark,'.$this->orders_table.'.invoice_status,'.$this->orders_table.'.status,'.$this->orders_table.'.is_deleted,'.$this->orders_table.'.created,'.$this->orders_table.'.modified,'.$this->users_table.'.company_name,'.$this->users_table.'.id as UsertableID');
            $this->db->from($this->orders_table);
            $this->db->join($this->users_table,$this->orders_table.'.user_id = '.$this->users_table.'.id');
             $this->db->where($this->orders_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.status',1);
            if(isset($where) && $where!=''){
                $this->db->where($this->orders_table.'.invoice_status',0);
            }

            $this->db->group_by($this->orders_table.'.id');
            $this->db->limit(5);
            $this->db->order_by($this->orders_table . '.id', "desc");
            $query = $this->db->get();
             return $query->result_array();
        }
        //For best selling by product
        function selling_product($order_by){
           $this->db->select('o.id,o.order_id,o.product_id,SUM(o.quantity) as totalQuantity,SUM(o.price) as amount,p.name,p.design_no,p.size,p.quantity,c.name AS cate_name,p.quantity-SUM(o.quantity) as s_quantity,AVG(ph.purchase_rate) as purchase_expense');
          $this->db->from('order_products o');
          $this->db->join('products p','p.id=o.product_id','left');
          $this->db->join('product_categories pc','pc.product_id=o.product_id','left');
          $this->db->join('categories c','c.id=pc.cat_id','left');
          //where condition
          //product history table avrage price
          $this->db->join('product_purchase_history ph','ph.product_id=o.product_id','left');
          $this->db->where('p.is_deleted',0);
          $this->db->where('c.is_deleted',0);
          $this->db->or_where('ph.product_id',null);
          $this->db->limit($limit, $start);
          $this->db->group_by('o.product_id');
            $this->db->order_by('totalQuantity',' desc');
            $this->db->limit(5);
            $allorderData = $this->db->get();
            $count = $allorderData->result_array();
            return $count;

        }
        // Fro dashboard best seller by amount
        function best_seller (){
            $this->db->select('o.id,o.user_id,SUM(o.total_price + o.tax) as totalValue,SUM(o.sales_expense) as total_sales_expense,o.invoice_no,u.company_name,u.contact_person_name,o.created');
            $this->db->from('orders as o');
            $this->db->join('users as u', 'u.id = o.user_id','left');
            $this->db->where('o.is_deleted', 0);  
            $this->db->where('u.is_deleted',0); 
            $this->db->where('u.status',1);   
            $this->db->limit(5);
            $this->db->order_by('totalValue','desc');
            $this->db->group_by('o.user_id');
            $allorderData = $this->db->get();
            $count = $allorderData->result_array();
            return $count;

        }
    }