<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Dubai");
	}
	public function index()
	{   
		$this->session->sess_destroy();
                $this->session->set_flashdata('logout_msg','<span class="7"><div class="alert alert-danger"><strong>Logout Successfully!</strong></div></span>');
		redirect('Adminpanel');
	}
}

