<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	function __construct(){
		parent::__construct(); 
		$this->load->model('Dashboard_model');
		$this->load->model('My_model');
	}
	public  function index(){
		//$this->userhelper->current('logged_in')['is_logged'] = 1;
		$data['tatal_orders']=$this->Dashboard_model->get_OrderDatatables($where='');
		$data['unpaid_orders']=$this->Dashboard_model->get_OrderDatatables('orders.invoice_status=0');
		$data['all_user'] = $this->db->where('is_deleted',0)->get("users")->num_rows();
		$data['lowdata'] = $this->Dashboard_model->lowdata();
		
		$data['latest_orders'] = $this->Dashboard_model->latest_orders('');
		$data['unpaid_l_orders'] = $this->Dashboard_model->latest_orders('1');
		$data['sold_quantity'] = $this->Dashboard_model->selling_product('products.sold_quantity');
		$data['sold_amount'] = $this->Dashboard_model->best_seller();
        $this->load->view($this->view.'dashboard/view',$data);;
      }
    public  function orderStatistics($period=''){
    	$orderStatistics=array();
    	$period=$_REQUEST['period'];
    	if(isset($period) && $period!='' && $period=="week"){
    		$newTime = strtotime('-1 week');
    	}
    	if(isset($period) && $period!='' && $period=="month"){
    		$newTime = strtotime('-1 month');
    	}
    	if(isset($period) && $period!='' && $period=="year"){
    		$newTime = strtotime('-1 year');
    	}
    		$to_date =date("Y-m-d");
		    
	    $from_date  = date('Y-m-d', $newTime);
    	$from_date = new DateTime($from_date);
		$to_date = new DateTime($to_date);
		// day array
		$i=0;
		if(isset($period) && $period!='' && $period!="year"){

			for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {

				$startdate=$date->format('Y-m-d');
				$where = '(DATE_FORMAT(orders.created,"%Y-%m-%d") BETWEEN "'.$startdate.'" AND "'.$startdate.'")';
				$rr=$this->Dashboard_model->get_OrderDatatables($where);
				$count_price=$this->Dashboard_model->count_price($where);
				if(isset($period) && $period!='' && $period=="week"){
					$orderStatistics[$i]['date']=$date->format('d F');
				}
				if(isset($period) && $period!='' && $period=="month"){
					$orderStatistics[$i]['date']=$date->format('d F');
    			}
    			if(isset($period) && $period!='' && $period=="year"){
    				$orderStatistics[$i]['date']=$date->format('F Y');
	    			}
	  				
	  				$orderStatistics[$i]['value']=$rr;
	  				$orderStatistics[$i]['amount']=$this->My_model->getamount(round($count_price->invoiceAmount,2));
	  				
	  				$i++;
				}
			}else{
				
				for ($date = $from_date; $date <= $to_date; $date->modify('+1 month')) {

					$startdate=$date->format('Y-m');
					$where = '(DATE_FORMAT(orders.created,"%Y-%m") BETWEEN "'.$startdate.'" AND "'.$startdate.'")';
					$rr=$this->Dashboard_model->get_OrderDatatables($where);
					$count_price=$this->Dashboard_model->count_price($where);
					if(isset($period) && $period!='' && $period=="week"){
						$orderStatistics[$i]['date']=$date->format('d F');
					}
					if(isset($period) && $period!='' && $period=="month"){
						$orderStatistics[$i]['date']=$date->format('d F');
	    			}
	    			if(isset($period) && $period!='' && $period=="year"){
	    				$orderStatistics[$i]['date']=$date->format('F Y');
	    			}
  				
  					$orderStatistics[$i]['value']=$rr;
  					$orderStatistics[$i]['amount']=$this->My_model->getamount(round($count_price->invoiceAmount,2));
  					$i++;
					}
				}
    	
    	echo json_encode($orderStatistics);
	}
	public  function userStatistics($period=''){
    	$orderStatistics=array();
    	$period=$_REQUEST['period'];
    	if(isset($period) && $period!='' && $period=="week"){
    		$newTime = strtotime('-1 week');
    	}
    	if(isset($period) && $period!='' && $period=="month"){
    		$newTime = strtotime('-1 month');
    	}
    	if(isset($period) && $period!='' && $period=="year"){
    		$newTime = strtotime('-1 year');
    	}
    		$to_date =date("Y-m-d");
		    
	    $from_date  = date('Y-m-d', $newTime);
    	$from_date = new DateTime($from_date);
		$to_date = new DateTime($to_date);
		// day array
		$i=0;
		if(isset($period) && $period!='' && $period!="year"){

			for ($date = $from_date; $date <= $to_date; $date->modify('+1 day')) {

				$startdate=$date->format('Y-m-d');
				$where = '(DATE_FORMAT(users.created,"%Y-%m-%d") BETWEEN "'.$startdate.'" AND "'.$startdate.'")';
				$rr=$this->Dashboard_model->get_usertables($where);
				if(isset($period) && $period!='' && $period=="week"){
					$orderStatistics[$i]['date']=$date->format('d F');
				}
				if(isset($period) && $period!='' && $period=="month"){
					$orderStatistics[$i]['date']=$date->format('d F');
    			}
    			if(isset($period) && $period!='' && $period=="year"){
    				$orderStatistics[$i]['date']=$date->format('F Y');
	    			}
	  				
	  				$orderStatistics[$i]['value']=$rr;
	  				$i++;
				}
			}else{
				
				for ($date = $from_date; $date <= $to_date; $date->modify('+1 month')) {
					$startdate=$date->format('Y-m');
					$where = '(DATE_FORMAT(users.created,"%Y-%m") BETWEEN "'.$startdate.'" AND "'.$startdate.'")';
					$rr=$this->Dashboard_model->get_usertables($where);
					if(isset($period) && $period!='' && $period=="week"){
						$orderStatistics[$i]['date']=$date->format('d F');
					}
					if(isset($period) && $period!='' && $period=="month"){
						$orderStatistics[$i]['date']=$date->format('d F');
	    			}
	    			if(isset($period) && $period!='' && $period=="year"){
	    				$orderStatistics[$i]['date']=$date->format('F Y');
	    			}
  				
  					$orderStatistics[$i]['value']=$rr;
  					$i++;
					}
				}
    	echo json_encode($orderStatistics);
	}
	
}