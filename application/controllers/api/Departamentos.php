<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Departamentos extends REST_Controller
{
	function __construct(){
    	parent::__construct(); 
		//$this->load->database('default');
        $this->load->library('form_validation');   
    	$this->load->model('Departamentos_model');
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
  	 public function get_departamentos_get()
    {
		$data = $this->Departamentos_model->all_departamentos();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_departamentos_active_get()
    {
		$data = $this->Departamentos_model->all_departamentos_active();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_departamentos_disabled_get()
    {
		$data = $this->Departamentos_model->all_departamentos_disabled();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_all_Departamentos_get()
    {
		$data = $this->Departamentos_model->all_departamentos();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function create_departamentos_post()
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
			$this->Departamentos_model->actualizar($objSalida->id,$objSalida->nombre_departamento,$objSalida->estatus);
		}
		else
		{
			$id = $this->Departamentos_model->agregar($objSalida->nombre_departamento,$objSalida->estatus);
			$objSalida->id=$id;				
		}		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblDepartamentos','Insert',$objSalida->id,$this->input->ip_address(),'Registro de Departamentos');	
		$this->response($objSalida);
    }
    public function delete_departamentos_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$id = $this->get('id');
		$bOk = $this->Departamentos_model->eliminar($id);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblDepartamentos','Delete',$id,$this->input->ip_address(),'Borrando de Oficina');
		$this->response($bOk);
    }
}
?>