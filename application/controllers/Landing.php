<?php
	if(! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Landing extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			date_default_timezone_set("Asia/Kolkata");
			$this->load->library('form_validation');
			
			
		}
		public function index()
		{
			echo 'Landing'; exit;
			
		}
	}
?>