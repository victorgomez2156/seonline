<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Sistemas extends REST_Controller
{
	function __construct(){
    	parent::__construct(); 
		//$this->load->database('default');
        $this->load->library('form_validation');   
    	$this->load->model('Sistemas_model');
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
  	 public function get_sistemas_get()
    {
		$data = $this->Sistemas_model->all_sistemas();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_sistemas_active_get()
    {
		$data = $this->Sistemas_model->all_sistemas_active();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_sistemas_disabled_get()
    {
		$data = $this->Sistemas_model->all_sistemas_disabled();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_all_sistemas_get()
    {
		$data = $this->Sistemas_model->all_sistemas();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_all_departamentos_get()
    {
		$data = $this->Sistemas_model->all_departamentos();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function create_sistemas_post()
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
			$this->Sistemas_model->actualizar($objSalida->id,$objSalida->nombre_sistema,$objSalida->estatus,$objSalida->url_sistema);
		}
		else
		{
			$id = $this->Sistemas_model->agregar($objSalida->nombre_sistema,$objSalida->estatus,$objSalida->url_sistema);
			$objSalida->id=$id;				
		}		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblsistemas','Insert',$objSalida->id,$this->input->ip_address(),'Registro de sistemas');	
		$this->response($objSalida);
    }
    public function delete_sistemas_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$id = $this->get('id');
		$bOk = $this->Sistemas_model->eliminar($id);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblsistemas','Delete',$id,$this->input->ip_address(),'Borrando de sistemas');
		$this->response($bOk);
    }
}
?>