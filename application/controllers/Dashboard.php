<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	function __construct(){
		parent::__construct(); 
		$this->load->model('Dashboard_model');
		// $this->load->library('session');
		// $this->load->helper('url');
		// $this->load->database(); 
		// $this->load->model('leave_model');
	}
	public  function index(){
		//$this->userhelper->current('logged_in')['is_logged'] = 1;
		$data['tatal_orders']=$this->Dashboard_model->get_OrderDatatables('orders',$where='');
		$data['unpaid_orders']=$this->Dashboard_model->get_OrderDatatables('orders','status=0');
		$data['all_user'] = $this->db->get("users")->num_rows();
        $this->load->view($this->view.'dashboard/view',$data);;
      }
      
}