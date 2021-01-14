<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Oficinas extends REST_Controller
{
	function __construct(){
    	parent::__construct(); 
		//$this->load->database('default');
        $this->load->library('form_validation');   
    	$this->load->model('Oficinas_model');
    	$this->load->model('Auditoria_model');    			
		$this->load->helper('cookie');
		$this->load->library('user_agent');  
        $this->load->helper('form');
        $this->load->helper('url');  

		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
    }
  	 public function get_office_get()
    {
		$data = $this->Oficinas_model->all_office();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_office_active_get()
    {
		$data = $this->Oficinas_model->all_office_active();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_office_disabled_get()
    {
		$data = $this->Oficinas_model->all_office_disabled();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_all_oficinas_get()
    {
		$data = $this->Oficinas_model->all_office();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function create_office_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
			
		$this->db->trans_start();	
		
		if (isset($objSalida->id))
		{
			$this->Oficinas_model->actualizar($objSalida->id,$objSalida->nombre_oficina,$objSalida->estatus);
		}
		else
		{
			$id = $this->Oficinas_model->agregar($objSalida->nombre_oficina,$objSalida->estatus);
			$objSalida->id=$id;				
		}		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbloficinas','Insert',$objSalida->id,$this->input->ip_address(),'Registro de oficinas');	
		$this->response($objSalida);
    }
    public function delete_office_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$id = $this->get('id');
		$bOk = $this->Oficinas_model->eliminar($id);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbloficinas','Delete',$id,$this->input->ip_address(),'Borrando de Oficina');
		$this->response($bOk);
    }
}
?>