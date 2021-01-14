<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Usuarios extends REST_Controller
{
	function __construct(){
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   
    	$this->load->model('Usuarios_model');
    	$this->load->model('Auditoria_model');
    	$this->load->model('Register_model');		
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
  	 public function filtrar_por_departamentos_get()
    {
		$hdepartamento=$this->get('hdepartamento');
		$data = $this->Usuarios_model->get_filtro_departamentos($hdepartamento);
		if (!empty($data))
		{
			//$data->count=$this->Usuarios_model->count_carpetas_perfiles($hdepartamento);
			$this->response($data);
			return true;
		}

		$this->response(false);
    }
    public function filtrar_por_perfiles_post()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();	
		$data=$this->Usuarios_model->count_carpetas_perfiles($objSalida);	
		//$data = $this->Usuarios_model->get_filtro_departamentos($objSalida);
		//var_dump($data);

		if ($data->total_carpetas<=0)
		{			
			$this->response(false);
			return false;
		}
		$data->detalles = $this->Usuarios_model->get_filtro_departamentos($objSalida);
		//$data->count=$this->Usuarios_model->count_carpetas_perfiles($objSalida);

		$this->db->trans_complete();			
		$this->response($data);
    }
     public function buscar_borrar_acceso_credenciales_post()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();	
		$data=$this->Usuarios_model->buscar_id_detalle_acceso($objSalida->hsistema,$objSalida->huser);			
		$borrar_sistema_credenciales=$this->Usuarios_model->borrar_sistemas_credenciales($data->id);
		if($borrar_sistema_credenciales==true)
		{
			$resultado=array('status'=>true,'response'=>$borrar_sistema_credenciales);
			$this->db->trans_complete();			
			$this->response($resultado);
		}

    }
     public function Cambiar_Contrasena_post()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();	
		$update_contrasena=$this->Usuarios_model->update_contrasena($objSalida->huser,md5($objSalida->contrasena_nueva));		
		if($update_contrasena==true)
		{
			//$resultado=array('status'=>true,'response'=>$update_contrasena);
			$this->db->trans_complete();			
			$this->response($update_contrasena);
		}

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
		
		$data=$this->Usuarios_model->comprobar_usuario_sistemas_credencial($objSalida->usuario_sistema);	
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
    public function count_carpetas_post()
    {
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();	
		$data=$this->Usuarios_model->count_carpetas_perfiles($objSalida);	
		$this->db->trans_complete();			
		$this->response($data);
    }
    
    
     public function asignar_carpetas_automaticas_get()
    {
		$hperfil=$this->get('hperfil');
		$data = $this->Usuarios_model->get_asignacion_folders_automatic($hperfil);
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function buscar_contrasena_level_get()
    {
		$id=$this->get('id');
		$data = $this->Usuarios_model->get_contrasena_level($id);
		if (!empty($data))
		{
			$this->response($data);
			//return true;
		}
		$this->response(false);
    }
     public function traer_departamentos_get()
    {
		$data = $this->Usuarios_model->get_departamentos();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
 	public function traer_sistemas_get()
    {
		$data = $this->Usuarios_model->get_sistemas();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function traer_controladores_get()
    {
		$data = $this->Usuarios_model->get_controladores();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function get_users_get()
    {
		$data = $this->Usuarios_model->all_users();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_users_active_get()
    {
		$data = $this->Usuarios_model->all_users_active();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_users_disabled_get()
    {
		$data = $this->Usuarios_model->all_users_disabled();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
     public function get_all_oficinas_get()
    {
		$data = $this->Usuarios_model->all_office();
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }   
     public function comprobar_dni_get()
    {
		$correo_electronico = $this->get('correo_electronico');
        $data = $this->Usuarios_model->get_dni_users($correo_electronico);
		if (empty($data))
		{
			$this->response(false);
			return false;
		}
		$data->detalle_controlador = $this->obtener_detalle_controladores($data->id);		
		$data->count_total_controladores = $this->contar_controladores($data->id);		
		$this->response($data);
		//return true;
    }
   
     public function obtener_detalle($id)
    {
    	$detalleG = $this->Usuarios_model->get_detalle_carpeta_all($id);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
	 public function obtener_detalle_departamento($id)
    {
    	$detalleG = $this->Usuarios_model->get_detalle_departamento_all($id);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
	public function obtener_detalle_sistemas($id)
    {
    	$detalleG = $this->Usuarios_model->get_detalle_sistema_all($id);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
	public function obtener_detalle_controladores($id)
    {
    	$detalleG = $this->Usuarios_model->get_detalle_controladores_all($id);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
	 public function contar_departamentos($id)
    {
    	$data = $this->Usuarios_model->get_count_departamentos($id);
		if (!empty($data))
		{
			return $data->total_departamentos;			
		}
		$this->response(false);
	}
	public function contar_carpetas($id)
    {
    	$data = $this->Usuarios_model->get_count_carpetas($id);
		if (!empty($data))
		{
			return $data->total_carpetas;			
		}
		$this->response(false);
	}
	 public function contar_sistemas($id)
    {
    	$data = $this->Usuarios_model->get_count_sistemas($id);
		if (!empty($data))
		{
			return $data->total_sistemas;			
		}
		$this->response(false);
	}
	public function contar_controladores($id)
    {
    	$data = $this->Usuarios_model->get_count_controladores($id);
		if (!empty($data))
		{
			return $data->total_controladores;			
		}
		$this->response(false);
	}
     public function comprobar_usuario_get()
    {
    	$usuario=$this->get('usuario');
		$data = $this->Usuarios_model->get_users_comprobar($usuario);
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
      public function buscar_detalle_get()
    {
		$huser = $this->get('huser');
        $data->detalle = $this->obtener_detalle($huser);
		if (empty($data->detalle))
		{
			$this->response(false);
			return false;
		}
		/*$data->detalle = $this->obtener_detalle($data->id);
		$data->detalle_departamentos = $this->obtener_detalle_departamento($data->id);
		$data->count_total_departamentos = $this->contar_departamentos($data->id);
		$data->count_total_carpetas = $this->contar_carpetas($data->id);*/		
		$this->response($data);
		//return true;
    }
     public function comprobar_correo_get()
    {
    	$correo_electronico=$this->get('correo_electronico');
		$data = $this->Usuarios_model->get_email_comprobar($correo_electronico);
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
    }
    public function crear_usuario_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$detalle_controlador=$objSalida->detalle_controlador;
		$this->db->trans_start();		
		if (isset($objSalida->id))
		{
			
			$this->Usuarios_model->eliminar_all_detalle($objSalida->id);
			$this->Usuarios_model->actualizar($objSalida->id,$objSalida->nombres,$objSalida->apellidos,$objSalida->usuario,$objSalida->correo_electronico,$objSalida->nivel,$objSalida->hoficina,$objSalida->bloqueado);			
			if($detalle_controlador!=false)
			{
				foreach ($detalle_controlador as $record_controlador):
				{
					$this->Usuarios_model->agregar_acceso_controlador_masivo($record_controlador->controller,$objSalida->id,$objSalida->key);	
				}
			endforeach;
			}
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tblusuarios','Update',$objSalida->id,$this->input->ip_address(),'Actualización de Usuarios');

		}
		else
		{
			$generate = $this->Register_model->new_api_key($level = false, $ignore_limits = false,$is_private_key = false, $ip_addresses = $this->input->ip_address());
			$id = $this->Usuarios_model->agregar($objSalida->nombres,$objSalida->apellidos,$objSalida->usuario,$objSalida->correo_electronico,$objSalida->nivel,md5($objSalida->contrasena),$objSalida->re_contrasena,$objSalida->hoficina,$objSalida->bloqueado,$generate);
			$objSalida->id=$id;
			$update=$this->Register_model->update_key($generate,$id);
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tblusuarios','Insert',$objSalida->id,$this->input->ip_address(),'Registro de Usuarios');
			if($detalle_controlador!=false)
			{
				foreach ($detalle_controlador as $record_controlador):
				{
				$this->Usuarios_model->agregar_acceso_controlador_masivo($record_controlador->controller,$objSalida->id,$generate);		
				}
			endforeach;
			}
					
		}		
		$this->db->trans_complete();			
		$this->response($objSalida);
    }
    public function agregar_credenciales_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();
		$id=$this->Usuarios_model->agregar_credenciales_sistemas($objSalida->hdetalleaccesosistema,$objSalida->usuario_sistema,$objSalida->contrasena_sistema,$objSalida->notas,$objSalida->coordinador,$objSalida->usuario);
		$objSalida->id=$id;
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcredenciales','Insert',$objSalida->id,$this->input->ip_address(),'Agregando credenciales a usuario.');
		$this->db->trans_complete();			
		$this->response($objSalida);
    }
    public function borrar_usuario_delete()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$id = $this->get('id');
		$bOk = $this->Usuarios_model->eliminar($id);
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblusuarios','Delete',$id,$this->input->ip_address(),'Borrando Usuarios del sistema');
		$this->response($bOk);
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
     public function validar_asistencia_anterior_post()
    {
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();		
		$estatus=3;
		$resultado = $this->Usuarios_model->update_asistencia($objSalida->id,$estatus);
			//$resultado_final=array('resultado'=>$resultado,'status'=>'OK','type'=>$objSalida->type);
		$this->response($resultado);
		//$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcontrolasistencia','Update',$objSalida->id,$this->input->ip_address(),'Actualizando Asistencia Por Admin');			
		$this->db->trans_complete();
    }
}
?>