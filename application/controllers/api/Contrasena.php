<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Contrasena extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		//$this->load->database('default');
        $this->load->library('form_validation');   
    	$this->load->model('Contrasenas_model');
    	$this->load->model('Auditoria_model');
    	//$this->load->model('Register_model');		
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
     public function traer_resultado_get()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$id=$this->get('id');
		$data = $this->Contrasenas_model->buscar_credenciales($id);
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);

    }
      public function buscar_accion_credencial_users_get()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$users_creden=$this->get('users_creden');
		$data = $this->Contrasenas_model->buscar_credenciales_repeat($users_creden);
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);

    }

    public function consultar_sistemas_get()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$data = $this->Contrasenas_model->get_all_sistemas($this->session->userdata('id'));
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);

    }
    public function consulta_sistemas_users_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();	
		
		$data_viene=$this->Contrasenas_model->get_all_sistemas($objSalida->huser);	
		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetalleaccesosistemas','Search',$objSalida->huser,$this->input->ip_address(),'Consultando Acceso Sistemas');	
		$this->response($data_viene);
    }
     public function accion_credencial_users_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$update_credencial_users=$this->Contrasenas_model->update_accion_credencial($objSalida->usuario_sistema,$objSalida->contrasena_sin_codificar,$objSalida->notas,$objSalida->id,$objSalida->id_principal,$objSalida->hdetalleaccesosistema);			
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetalleaccesosistemas','Search',$objSalida->id,$this->input->ip_address(),'Actualizando Credencial Usuarios');	
		$this->response($objSalida);
    }
     public function agregar_systems_users_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();	
		if($objSalida->no_registrado==false)
		{
			
			$id=$this->Contrasenas_model->add_systems_users($objSalida->id,$objSalida->huser);
			if(empty($objSalida->notas))
			{
				$notas=NULL;
			}
			else
			{
				$notas=$objSalida->notas;
			}

			$credenciales=$this->Contrasenas_model->add_credenciales_users($id,$objSalida->usuario_sistema,$objSalida->contrasena,$notas,$objSalida->coordinador,$objSalida->usuario);
			$this->db->trans_complete();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetalleaccesosistemas','Insert',$objSalida->huser,$this->input->ip_address(),'Agregando Sistema con credenciales');	
			$this->response($objSalida);
			return false;
		}
		else
		{			
			if(empty($objSalida->url_sistema))
			{
				$url=NULL;
			}
			else
			{
				$url=$objSalida->url_sistema;
			}
			if(empty($objSalida->notas))
			{
				$notas=NULL;
			}
			else
			{
				$notas=$objSalida->notas;
			}
			$hsistema=$this->Contrasenas_model->add_systems($objSalida->nombre_sistema,$url);
			$haccesosistema=$this->Contrasenas_model->add_systems_users($hsistema,$objSalida->huser);
			$credenciales=$this->Contrasenas_model->add_credenciales_users($haccesosistema,$objSalida->usuario_sistema,$objSalida->contrasena,$notas,$objSalida->coordinador,$objSalida->usuario);
			$this->db->trans_complete();
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetalleaccesosistemas','Insert',$objSalida->huser,$this->input->ip_address(),'Registrando Sistema y Credenciales');
			$this->response($objSalida);
			return false;			
		}
    }
    public function actualizar_credencial_usuario_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();	
		if($objSalida->usuario==1)
		{
			$objSalida->contrasena_sistema=$objSalida->contrasena_sin_codificar;
		}
		if($objSalida->usuario==0)
		{
			$objSalida->contrasena_sin_codificar=$objSalida->contrasena_sistema;
		}
		$resultado=$this->Contrasenas_model->update_credencial($objSalida->id,$objSalida->hdetalleaccesosistema,$objSalida->usuario_sistema,$objSalida->contrasena_sistema,$objSalida->notas,$objSalida->usuario_sistema);
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetalleaccesosistemas','Update',$objSalida->id,$this->input->ip_address(),'Actualizando Credenciales');	
		$this->response($resultado);
    }
     public function get_all_usuarios_get()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$data = $this->Contrasenas_model->get_all_users();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);

    }
     public function get_all_sistemas_get()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$data = $this->Contrasenas_model->get_all_systems();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);

    }
     public function filtrar_datos_get()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$id=$this->get('id');
		$coordinador=$this->get('coordinador');
		$usuario=$this->get('usuario');
		$data = $this->Contrasenas_model->get_datos_filtrados($id,$coordinador,$usuario);
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);

    }
    public function buscar_contrasenas_sistemas_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$data_viene=$this->Contrasenas_model->buscar_credenciales($objSalida->id);
		if(empty($data_viene))
		{
			$this->response(false);
			return false;
		}		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetalleaccesosistemas','Search',$objSalida->id,$this->input->ip_address(),'Consultando Credenciales');	
		$this->response($data_viene);
    }
    public function status_action_users_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();
		if($objSalida->quien_ve==1)
		{
			$update_status=$this->Contrasenas_model->update_status_coordinador($objSalida->id_credencial,$objSalida->id_principal,$objSalida->estatus);
			$objSalida->resultado=$update_status;
		}
		else
		{
			$update_status=$this->Contrasenas_model->update_status_usuario($objSalida->id_credencial,$objSalida->id_principal,$objSalida->estatus);
			$objSalida->resultado=$update_status;
		}
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcredencialessistemas','Update',$objSalida->id_credencial,$this->input->ip_address(),'Actualizando Estatus Credenciales');	
		$this->response($objSalida);
    }
    public function agregar_credenciales_users_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		
		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		if(empty($objSalida->id_credencial))
		{
			$id=$this->Contrasenas_model->agregar_credencial($objSalida->contrasena_sistema,$objSalida->coordinador,$objSalida->huser,$objSalida->id_principal,$objSalida->notas,$objSalida->usuario,$objSalida->usuario_sistema);
			$objSalida->id_credencial=$id;
		}
		else
		{
			$this->response("Para Actualizar");
		}
				
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcredencialessistemas','Insert',$objSalida->id_principal,$this->input->ip_address(),'Agregado de Credenciales');	
		$this->response($objSalida);
    }
     public function verificar_credencial_sistema_post()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();
		
		$data=$this->Contrasenas_model->comprobar_usuario_sistemas_credencial($objSalida->usuario_sistema);	
		if($data==true)
		{
			$this->response(true);
			$this->db->trans_complete();	
		}
		else
		{
			$this->response(false);
			$this->db->trans_complete();	
		}
    }
  
}
?>