<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Notificaciones extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   
    	$this->load->model('Usuarios_model');
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
     public function get_notificaciones_count_get()
    {
		$data = $this->Usuarios_model->count_notificaciones_get();
		if (!empty($data))
		{		
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function get_notificaciones_get()
    {
		$data = $this->Usuarios_model->notificaciones_get();
		if (!empty($data))
		{		
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    /*public function validar_asistencia_anterior_post()
    {
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcontrolasistencia','Update',$objSalida->id,$this->input->ip_address(),'Actualizando Asistencia Por Admin');
		//$estatus='3';
		//$resultado = $this->Usuarios_model->update_asistencia($objSalida->id,$estatus);
			//$resultado_final=array('resultado'=>$resultado,'status'=>'OK','type'=>$objSalida->type);
		$this->response($objSalida);
		//$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcontrolasistencia','Update',$objSalida->id,$this->input->ip_address(),'Actualizando //Asistencia Por Admin');			
		$this->db->trans_complete();
    }*/
     public function validar_asistencia_anterior_post()
    {
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();
		if($objSalida->type==3)
		{
			$hora_entrada=$objSalida->fecha_entrada_break_sin_transformar." ".$objSalida->horario_entrada;
			$resultado = $this->Usuarios_model->update_break($objSalida->id,3,$hora_entrada);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tblbreaks','Update',$objSalida->id,$this->input->ip_address(),'Confirmando Operación Admin');
			$this->db->trans_complete();	
			$this->response($objSalida);
		}
		if($objSalida->type==4)
		{
			$hora_salida=$objSalida->fecha_salida_asistencia_sin_transformar." ".$objSalida->horario_salida;
			$resultado = $this->Usuarios_model->update_asistencia($objSalida->id,3,$hora_salida);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcontrolasistencia','Update',$objSalida->id,$this->input->ip_address(),'Confirmando Operación Admin');
			$this->db->trans_complete();	
			$this->response($objSalida);
		}
		if($objSalida->type==6)
		{
			$hora_entrada=$objSalida->fecha_entrada_reunion_sin_transformar." ".$objSalida->horario_entrada;
			$resultado = $this->Usuarios_model->update_reunion($objSalida->id,3,$hora_entrada);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcontrolasistencia','Update',$objSalida->id,$this->input->ip_address(),'Confirmando Operación Admin');
			$this->db->trans_complete();	
			$this->response($objSalida);
		}
		
    }
   
  	 
}
?>