<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends MY_Controller
{
	function __construct()
	{
    	parent::__construct();      
        $this->load->helper('url'); 	
		$this->load->database('default');
        $this->load->library('form_validation'); 
        $this->load->library('user_agent');
		$this->load->helper('cookie');
		$this->load->model('Usuarios_model');

		/*$cookie_Pref=$this->input->cookie('PREFF');
		if($cookie_Pref=="null")
		{
			redirect(base_url("Equipo_Frecuente"));
		}*/
    }
	public function index() 
	{ 
		if ($this->agent->is_browser())
		{
	        $agent = $this->agent->browser(); 
	        $version= $this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
			$agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
	        $agent = $this->agent->mobile();
		}
		else
		{
	        $agent = 'Unidentified User Agent';
		}
		$ip=$this->input->ip_address();
		$os=$this->agent->platform();
		/*$name   = 'PREFF';
			        $value  = 'null';
			        $expire = time()+297353000;
			        $path  = '/';
			        $secure = TRUE;
        			setcookie($name,$value,$expire,$path);*/	 		
		
		//$cookie_Pref=$this->input->cookie('PREFF');

		/*if($cookie_Pref==null)
		{
			redirect(base_url("Equipo_Frecuente"));
		}
		else
		{*/
			$this->render();	
			//$this->load->view('view_dashboard');
		//}

		//$this->render();		
	}
	
}
?>