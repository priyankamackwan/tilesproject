<?php
/*
    By: Sneha Doshi
    On: 20-03-2018
    Note:
          File Created For Implementing General Functions That Will Be Used All Over Project
*/
//defined('BASEPATH') OR exit('No direct script access allowed');


class Userhelper
{


    protected $CI;
    protected $model ;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');

        $this->model = 'My_model';
    }

    /*  By: Sneha Doshi
        On: 20-03-2018
        Desc: Check If Session Is Set
    */
    public static function check_session()
    {

        $ci =& get_instance();
        $ci->load->database();
        $ci->load->library('session');

        $company_data =  $ci->db->get('company')->result();
        $company_name = $company_data[0]->name;

        if ( $ci->session->userdata($company_name))
		{
            return 1;
        }
        else
        {
            return 0;
        }


    }

    /*  By: Sneha Doshi
        On: 20-03-2018
        Desc: Access Company Details
    */
    public function company_detail()
    {
        $ci =$this->CI;
        $model = $this->model;
        $company_data = $ci->$model->select(array(),'company',array(),'');
        $return = [
            'name' =>$company_data[0]->name
        ];

        return $return;
    }

     /*  By: Sneha Doshi
        On: 20-03-2018
        Desc: Get Session Values
    */
    public function current($key = "")
     {
        $ci =$this->CI;
        $model = $this->model;

        //unset($ci->session->userdata['logged_in']['id']); 
        if (isset($ci->session->userdata['logged_in']['id'])) {
        $return = [

            "id" => $ci->session->userdata['logged_in']['id'],
            "first_name" => $ci->session->userdata['logged_in']['first_name'],
            "last_name" => $ci->session->userdata['logged_in']['last_name'],
            "mobile_no" => $ci->session->userdata['logged_in']['mobile_no'],
            "email" => $ci->session->userdata['logged_in']['email'],
            "role_id" => $ci->session->userdata['logged_in']['role_id'],
            "rights" => $ci->session->userdata['logged_in']['rights'],
            "is_logged" => $ci->session->userdata['logged_in']['is_logged'],
            "session_id" => session_id()
        ];
        if (!empty($key) && isset($return[$key])) {
            return $return[$key];
        }
        
        return $return;
        } else {
            redirect('Adminpanel');
        }
     }
     /*  By: Ravi Fefar
        On: 13-04-2018
        Desc: Get Restaurant List
    */
    public  function get_restaurant()
    {
		
        $ci =$this->CI;
        $model = $this->model;
		
		$comp_detail = $this->current();
		$role_id = $comp_detail['role_id'];
		$user_id = $comp_detail['id'];
		
        if($role_id == 1)
		{
			return $ci->$model->select(array(),'restaurant',array(),'');
		}
		else
		{
			return $ci->$model->select(array(),'restaurant',array('added_by'=>$user_id),'');
		}
    }
}
?>