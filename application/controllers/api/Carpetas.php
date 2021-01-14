<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Carpetas extends REST_Controller
{
	function __construct(){
    	parent::__construct(); 
		//$this->load->database('default');
        $this->load->library('form_validation');   
    	$this->load->model('Carpetas_model');
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
  	 public function get_carpetas_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$data = $this->Carpetas_model->all_carpetas();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function obtener_detalles_perfiles_get()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$hperfil=$this->get('hcarpeta');
		$data = $this->Carpetas_model->detalle_perfiles($hperfil);
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_carpetas_active_get()
    {
		$data = $this->Carpetas_model->all_carpetas_active();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_carpetas_disabled_get()
    {
		$data = $this->Carpetas_model->all_carpetas_disabled();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_all_carpetas_get()
    {
		$data = $this->Carpetas_model->all_carpetas();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_all_departamentos_get()
    {
		$data = $this->Carpetas_model->all_departamentos();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function create_carpetas_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$detalle=$objSalida->detalle_perfiles;	
		$this->db->trans_start();	
		
		if (isset($objSalida->id))
		{
			$this->Carpetas_model->delete_perfiles($objSalida->id);
			$this->Carpetas_model->actualizar($objSalida->id,$objSalida->nombre_carpeta,$objSalida->estatus);
			foreach ($detalle as $record):
			{			
				$this->Carpetas_model->agregar_detalle_perfil_carpetas($objSalida->id,$record->id);			
			}
			endforeach;	
		}
		else
		{
			$id = $this->Carpetas_model->agregar($objSalida->nombre_carpeta,$objSalida->estatus);
			$objSalida->id=$id;
			foreach ($detalle as $record):
			{			
				$this->Carpetas_model->agregar_detalle_perfil_carpetas($objSalida->id,$record->id);			
			}
			endforeach;			
		}
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcarpetas','Insert',$objSalida->id,$this->input->ip_address(),'Registro de carpetas');	
		$this->response($objSalida);
    }
    public function delete_carpetas_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$id = $this->get('id');
		$bOk = $this->Carpetas_model->eliminar($id);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcarpetas','Delete',$id,$this->input->ip_address(),'Borrando de Carpetas');
		$this->response($bOk);
    }
}
?>