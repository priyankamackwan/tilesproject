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

        // All order Data. date condition change
        function get_OrderDatatables($limit = NUll,$start = NUll,$order = NUll,$dir = NUll,$where = NULL,$user_id = NUll,$role = NUll,$whereDate = NULL,$table = NULL) {    
            
           //$this->db->select($this->orders_table.'.id,'.$this->orders_table.'.user_id ,'.$this->orders_table.'.tax,'.$this->orders_table.'.total_price,'.$this->orders_table.'.lpo_no,'.$this->orders_table.'.do_no,'.$this->orders_table.'.invoice_no,'.$this->orders_table.'.sales_expense,'.$this->orders_table.'.cargo,'.$this->orders_table.'.cargo_number,'.$this->orders_table.'.location,'.$this->orders_table.'.mark,'.$this->orders_table.'.invoice_status,'.$this->orders_table.'.status,'.$this->orders_table.'.is_deleted,'.$this->orders_table.'.created,'.$this->orders_table.'.modified,'.$this->users_table.'.company_name,'.$this->users_table.'.id as UsertableID');

            //my balance
  
        if($user_id!="" && $role!="") // required parameters for android and ios
        {
            $this->db->select($this->orders_table.'.id,'.$this->orders_table.'.user_id ,'.$this->orders_table.'.total_price,'.$this->orders_table.'.invoice_no,'.$this->orders_table.'.location,'.$this->orders_table.'.invoice_status,'.$this->orders_table.'.created,'.$this->users_table.'.company_name,'.$this->orders_table.'.tax,'.$this->orders_table.'.legacy_invoice_no');

            
        }else{    

            $this->db->select($this->orders_table.'.id,'.$this->orders_table.'.user_id ,'.$this->orders_table.'.tax,'.$this->orders_table.'.total_price,'.$this->orders_table.'.lpo_no,'.$this->orders_table.'.do_no,'.$this->orders_table.'.invoice_no,'.$this->orders_table.'.sales_expense,'.$this->orders_table.'.cargo,'.$this->orders_table.'.cargo_number,'.$this->orders_table.'.location,'.$this->orders_table.'.mark,'.$this->orders_table.'.invoice_status,'.$table.'.status,'.$this->orders_table.'.is_deleted,'.$this->orders_table.'.created,'.$this->orders_table.'.modified,'.$this->users_table.'.company_name,'.$this->users_table.'.id as UsertableID,'.$this->orders_table.'.placed_by,'.$this->orders_table.'.admin_id,'.$this->users_table.'.contact_person_name,'.$this->orders_table.'.legacy_invoice_no,sum('.$this->order_products_table.'.price) as total_rate,'.$this->orders_table.'.tax_percentage');
        }

            // Select from Order main table
            $this->db->from($this->orders_table);

            $this->db->join($this->users_table,$this->orders_table.'.user_id = '.$this->users_table.'.id');

            $this->db->join($this->order_products_table,$this->order_products_table.'.order_id = '.$this->orders_table.'.id');
            
            if(!empty($where)){
                
                // Filter condition to add where
                $this->db->where($where);
            }
            if(!empty($whereDate)){
                
                // Filter condition to add where
                $this->db->where($whereDate);
            }

            // Record Limit
            if(!empty($limit)){
                
                $this->db->limit($limit,$start);
                $this->db->order_by($order,$dir); 

            }else{

                // Order by new order
                $this->db->order_by($this->orders_table . '.id', "desc");
            }
            if($user_id!="" && $role!="")
            {
                if($role==1)
                {
                    $this->db->where($this->orders_table.'.user_id',$user_id);
                    //$this->db->where($this->orders_table.'.admin_id',0);
                }
                else
                {
                    $this->db->where($this->orders_table.'.admin_id',$user_id);
                    $this->db->where($this->orders_table.'.admin_id!=',0);
                }
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

        // Get invoice paid total and unpaid amount and current date
        public function get_invoiceAmount($where=null,$whereDate=null,$whereDatechange='no',$monthType='all')
        {
            $cMFirstDay=$cMLastDay='';
            // $this->db->select($this->orders_table.'.id,('.$this->orders_table.'.total_price) as invoiceAmount,(IF('.$this->orders_table.'.invoice_status = 1,'.$this->orders_table.'.total_price,0.00)) as paidAmount,(IF('.$this->orders_table.'.invoice_status = 0,'.$this->orders_table.'.total_price,0.00))as unpaidAmount');

            //order total price * tax
            $this->db->select($this->orders_table.'.id,
                (sum(order_products.price) + orders.tax ) as invoiceAmount');

            //$this->db->select($this->orders_table.'.id,('.$this->orders_table.'.total_price + orders.tax ) as invoiceAmountWithTax,'.$this->orders_table.'.total_price as invoiceAmount');


            $this->db->from($this->orders_table);
            $this->db->join($this->users_table,$this->orders_table.'.user_id = '.$this->users_table.'.id');

            $this->db->join($this->order_products_table,$this->order_products_table.'.order_id = '.$this->orders_table.'.id');
            $this->db->where($this->orders_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.status',1);
            if(!empty($where)){
                
                // Filter condition to add where
                $this->db->where($where);
            }
            if($whereDatechange=='yes' && !empty($whereDate)){
                    $this->db->where($whereDate);
            }
            //date selected for top arted amount this month not for all
            // if(isset($monthType) && $monthType!='' && $monthType=="current"){
            //     if($whereDatechange=='yes' && !empty($whereDate)){
            //         $this->db->where($whereDate);
            //     }else{
            //         //default for current month 
            //         $cMFirstDay = date("Y-m-d", strtotime("first day of this month"));
            //         $cMLastDay = date("Y-m-d", strtotime("last day of this month"));

            //         $whereBetweenDate .= '(DATE_FORMAT(orders.created,"%Y-%m-%d") BETWEEN "'.$cMFirstDay.'" AND "'.$cMLastDay.'")';
            //         $this->db->where($whereBetweenDate);
            //     }
            // }
            $this->db->group_by($this->orders_table.'.id');
            $subQuery =  $this->db->get_compiled_select();
            
            // $rr=$this->db->select('sum(invoiceAmount) as invoiceAmount,sum(paidAmount) as paidAmount,sum(unpaidAmount) as unpaidAmount')->
            //     from('('.$subQuery.') as tess');

            //$rr=$this->db->select('sum(invoiceAmount) as invoiceAmount,sum(invoiceAmountWithTax) as invoiceAmountWithTax')->
              //  from('('.$subQuery.') as tess');

            $rr=$this->db->select('sum(invoiceAmount) as invoiceAmount')->
                from('('.$subQuery.') as tess');


            $Amountdata = $this->db->get()->row();
            return $Amountdata;
        }
        /*
        // Get invoice paid total and unpaid amount and current date
        public function currentmonth_invoiceAmount($where=null)
        {
            $cMFirstDay=$cMLastDay='';
            // $this->db->select($this->orders_table.'.id,('.$this->orders_table.'.total_price * orders.tax) as invoiceAmount,(IF('.$this->orders_table.'.invoice_status = 1,'.$this->orders_table.'.total_price,0.00)) as paidAmount,(IF('.$this->orders_table.'.invoice_status = 0,'.$this->orders_table.'.total_price,0.00))as unpaidAmount');

            //order total price * tax
            $this->db->select($this->orders_table.'.id,('.$this->orders_table.'.total_price * orders.tax) as invoiceAmountWithTax,(IF('.$this->orders_table.'.tax = 0,'.$this->orders_table.'.total_price,0.00))as invoiceAmount');

            $this->db->from($this->orders_table);
            $this->db->join($this->users_table,$this->orders_table.'.user_id = '.$this->users_table.'.id');

            $this->db->join($this->order_products_table,$this->order_products_table.'.order_id = '.$this->orders_table.'.id');
            $this->db->where($this->orders_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.status',1);
            if(!empty($where)){
                
                // Filter condition to add where
                $this->db->where($where);
            }
            $cMFirstDay = date("Y-m-d", strtotime("first day of this month"));
            $cMLastDay = date("Y-m-d", strtotime("last day of this month"));

            $whereData .= '(DATE_FORMAT(orders.created,"%Y-%m-%d") BETWEEN "'.$cMFirstDay.'" AND "'.$cMLastDay.'")';
            $this->db->where($whereData);
            $this->db->group_by($this->orders_table.'.id');
            $subQuery =  $this->db->get_compiled_select();
            
            // $rr=$this->db->select('sum(invoiceAmount) as invoiceAmount,sum(paidAmount) as paidAmount,sum(unpaidAmount) as unpaidAmount')->
            //     from('('.$subQuery.') as tess');

            $rr=$this->db->select('sum(invoiceAmount) as invoiceAmount,sum(invoiceAmountWithTax) as invoiceAmountWithTax')->
                from('('.$subQuery.') as tess');
                
            $Amountdata = $rr->get()->row();
            return $Amountdata;
        }
        */
        //Fetch for all order in edit page
        function view_all_order($id){
            $this->db->select('order_products.id,order_products.order_id,order_products.product_id,products.name,products.design_no,order_products.id as item_id,order_products.status as item_status,order_products.quantity,order_products.price,order_products.status,orders.user_id,products.name,users.company_name,users.contact_person_name,orders.sales_expense,orders.delivery_date,orders.payment_date,orders.status,orders.invoice_status,users.client_type,products.cash_rate,products.credit_rate,products.walkin_rate,products.flexible_rate,orders.cargo,orders.cargo_number,orders.location,orders.mark,orders.total_price,orders.tax,orders.tax_percentage,order_products.rate,orders.lpo_no,orders.do_no,orders.invoice_no,legacy_invoice_no');

            // Select from Order prodcuts main table
            $this->db->from('order_products');

            $this->db->join('orders','order_products.order_id=orders.id','left');

            $this->db->join('products','products.id=order_products.product_id','left');

            $this->db->join('users','users.id=orders.user_id','left');

            $this->db->where('order_products.order_id',$id);
            
            $this->db->order_by('order_products.order_id','asc');

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
        function update_order_items($table_name,$fieldname,$product_id, $quantity,$oprator,$order_id){
            // update  current  quantity - deleted
             $this->db->set($fieldname, $fieldname.$oprator.$quantity, FALSE);
             $this->db->where($table_name.'.product_id',$product_id);
             if(isset($order_id) && $order_id!=''){
                $this->db->where('order_id',$order_id);   
             }
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
        function single_items($id,$order_id){
            $this->db->select('*');
            $this->db->from('order_products');
            $this->db->where('product_id',$id);
            $this->db->where('order_id',$order_id);
            $data=$this->db->get()->row();
            return $data; 
        }
        //payment_id is payment history and join from ordertbale for total price
        function payment_history($order_id,$payment_id,$action){
            $this->db->select('orders.id,sum(payment_history.amount) as paidamount,orders.total_price,orders.tax');
            $this->db->from('orders');
            $this->db->join('payment_history','payment_history.order_id=orders.id','left');
            if(isset($action) && $action!='' && $action=="edit"){
                $this->db->select('payment_history.id as payment_id,payment_history.amount,payment_history.payment_mode,reference,payment_history.payment_date');
                $this->db->where('payment_history.id',$payment_id);
            }
            $this->db->where('payment_history.order_id',$order_id);
            $this->db->or_where('payment_history.order_id',null);
            $this->db->where('orders.id',$order_id);
            $this->db->where($this->orders_table.'.is_deleted',0);
            $Amountdata = $this->db->get()->row();
            return $Amountdata;
        }
        //fetch paid amount from payment history
        function get_payment_history($monthType='all',$where=null,$whereDate=null,$whereDatechange='no'){
            $this->db->select('payment_history.amount as historypaidamount');
            $this->db->from('payment_history');
            $this->db->join('orders','orders.id=payment_history.order_id','left');
            $this->db->join($this->users_table,$this->orders_table.'.user_id = '.$this->users_table.'.id');
            $this->db->join($this->order_products_table,$this->order_products_table.'.order_id = '.$this->orders_table.'.id');
            $this->db->where($this->orders_table.'.is_deleted',0);
            $this->db->where($this->users_table.'.is_deleted',0);
            $this->db->where($this->users_table.'.status',1);
            if(!empty($where)){                
                // Filter condition to add where
                $this->db->where($where);
            }
            if($whereDatechange=='yes' && !empty($whereDate)){
                    $this->db->where($whereDate);
            }
            //date selected for top arted amount this month not for all
            // if(isset($monthType) && $monthType!='' && $monthType=="current"){
            //     if($whereDatechange=='yes' && !empty($whereDate)){
            //         $this->db->where($whereDate);
            //     }else{
            //         //default for current month 
            //         $cMFirstDay = date("Y-m-d", strtotime("first day of this month"));
            //         $cMLastDay = date("Y-m-d", strtotime("last day of this month"));

            //         $whereBetweenDate .= '(DATE_FORMAT(orders.created,"%Y-%m-%d") BETWEEN "'.$cMFirstDay.'" AND "'.$cMLastDay.'")';
            //         $this->db->where($whereBetweenDate);
            //     }
            // }
            $this->db->group_by('payment_history.id');
            $subQuery =  $this->db->get_compiled_select();
            $rr=$this->db->select('sum(historypaidamount) as historypaidamount')->
                from('('.$subQuery.') as tess');

            $Amountdata = $rr->get()->row();
            return $Amountdata;
        }
          /* NEW Changes*/
        // Get invoice paid total and unpaid amount and current date
        public function get_invoiceAmount_for_product($where=null,$whereDate=null,$whereDatechange='no',$monthType='all')
        {
           $this->db->select($this->orders_table.'.tax_percentage, sum('
            .$this->order_products_table.'.price) as total_rate' );
           $this->db->from($this->orders_table);

            $this->db->join($this->users_table,$this->orders_table.'.user_id = '.$this->users_table.'.id');

            $this->db->join($this->order_products_table,$this->order_products_table.'.order_id = '.$this->orders_table.'.id','LEFT');
            
            if(!empty($where)){
                
                // Filter condition to add where
                $this->db->where($where);
            }
            if(!empty($whereDate)){
                
                // Filter condition to add where
                $this->db->where($whereDate);
            }

          

            $this->db->where($this->orders_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.is_deleted',0);

            $this->db->where($this->users_table.'.status',1);

             $this->db->group_by($this->order_products_table.'.order_id');

            $allorderData = $this->db->get();
            
            $result = $allorderData->result_array();
            return $result;
        }
    }