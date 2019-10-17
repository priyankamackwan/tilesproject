<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	function __construct(){
		parent::__construct(); 
		// $this->load->model('login_model');
		// $this->load->library('session');
		// $this->load->helper('url');
		// $this->load->database(); 
		// $this->load->model('leave_model');
	}
	public  function index(){
		//$this->userhelper->current('logged_in')['is_logged'] = 1;
        $this->load->view($this->view.'dashboard/view');;
      }
      
}