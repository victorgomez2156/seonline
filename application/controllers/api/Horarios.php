<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
class Horarios extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		$this->load->database('default');
        $this->load->library('form_validation');   
    	//$this->load->model('Usuarios_model');
    	$this->load->model('Auditoria_model');
    	$this->load->model('Horarios_model');		
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
	public function buscar_datos_usuarios_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();	

		$search_data_empleado=$this->Horarios_model->search_empleado_data($objSalida->usuario);
		$search_data_vacaciones=$this->Horarios_model->search_vacaciones_data($objSalida->usuario);
		$search_days_laborables=$this->Horarios_model->search_days_laborables_data($objSalida->usuario);
		if($search_data_empleado==false)
		{
			//$objSalida->data_empleado=$search_data_empleado;
			$objSalida->estatus_contrato=NULL;
			$objSalida->fecha_fin_contrato=NULL;
			$objSalida->fecha_inicio_contrato=NULL;
			$objSalida->fecha_perioro_prueba=NULL;
			$objSalida->hcontrato=NULL;	
		}
		else
		{
			//$objSalida->data_empleado=$search_data_empleado;
			$objSalida->estatus_contrato=$search_data_empleado->estatus_contrato;
			$objSalida->fecha_fin_contrato=$search_data_empleado->fecha_fin_contrato;
			$objSalida->fecha_inicio_contrato=$search_data_empleado->fecha_inicio_contrato;
			$objSalida->fecha_perioro_prueba=$search_data_empleado->fecha_perioro_prueba;
			$objSalida->hcontrato=$search_data_empleado->hcontrato;			
		}
		if($search_data_vacaciones==false)
		{
			//$objSalida->vaciones=$search_data_vacaciones;
			$objSalida->dias_vacaciones=NULL;
			$objSalida->estatus_vacaciones=NULL;
			$objSalida->fecha_vacaciones_desde=NULL;
			$objSalida->fecha_vacaciones_hasta=NULL;
			$objSalida->hvacaciones=NULL;	
		}
		else
		{
			//$objSalida->vacaciones=$search_data_vacaciones;
			$objSalida->dias_vacaciones=$search_data_vacaciones->dias_vacaciones;
			$objSalida->estatus_vacaciones=$search_data_vacaciones->estatus_vacaciones;
			$objSalida->fecha_vacaciones_desde=$search_data_vacaciones->fecha_desde;
			$objSalida->fecha_vacaciones_hasta=$search_data_vacaciones->fecha_hasta;
			$objSalida->hvacaciones=$search_data_vacaciones->hvacaciones;
		}
		if($search_days_laborables==false)
		{
			$objSalida->detalle_dia_laborable=false; 
		}
		else
		{
			$objSalida->detalle_dia_laborable=$search_days_laborables;
		}
		//$objSalida->prueba=false;
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblhorarios','Insert',1,$this->input->ip_address(),'Consultando Horarios de Empleados');	
		$this->response($objSalida);
	}
    public function all_days_laborables_get()
    {
        $datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$data = $this->Horarios_model->get_all_dias_laborables();
		if (!empty($data)){
			$this->response($data);
			return true;
		}
		$this->response(false);		
    }
    public function Consultar_Historico_Vacaciones_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$data=$this->Horarios_model->buscar_historico_vacaciones($objSalida);		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetallevacacionesusuarios','Search',$objSalida,$this->input->ip_address(),'Consultando Historico de Vacaciones');	
		$this->response($data);
    }
    public function actualizar_historico_vacaciones_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		
		$resultado=$this->Horarios_model->actualizar_vacaciones_extras($objSalida->hvacaciones,$objSalida->estatus);	
		
		//var_dump($objSalida);		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetallevacacionesusuarios','Update',$objSalida->hvacaciones,$this->input->ip_address(),'Actualizando Vacaciones');	
		$this->response($resultado);
    }
    public function adicionar_vacaciones_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$id=$this->Horarios_model->adicionar_vacaciones_extras($objSalida->dias_vacaciones1,$objSalida->fecha_vacaciones_desde1,$objSalida->fecha_vacaciones_hasta1,$objSalida->huser,$objSalida->estatus_vacaciones1);		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tbldetallevacacionesusuarios','Insert',$id,$this->input->ip_address(),'Adicionando Vacaciones');	
		$this->response($objSalida);
    }
    public function guardar_horarios_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$detalle_dia_laborable = $objSalida->final_laborable;		
		$this->db->trans_start();	
		if (isset($objSalida->hcontrato))
		{
			$this->Horarios_model->eliminar_dias_laborables($objSalida->hcontrato,$objSalida->usuario);

			$this->Horarios_model->actualizar_contrato($objSalida->hcontrato,$objSalida->fecha_inicio_contrato,$objSalida->fecha_perioro_prueba,$objSalida->fecha_fin_contrato,$objSalida->usuario,$objSalida->estatus_contrato);
			if (empty($objSalida->hvacaciones) && $objSalida->estatus_vacaciones!=NULL)
			{
				$vacaciones=$this->Horarios_model->agregar_vacaciones($objSalida->fecha_vacaciones_desde,$objSalida->fecha_vacaciones_hasta,$objSalida->dias_vacaciones,$objSalida->usuario,$objSalida->estatus_vacaciones,$objSalida->hcontrato);
			}
			else
			{
				$this->Horarios_model->actualizar_vacaciones($objSalida->hvacaciones,$objSalida->fecha_vacaciones_desde,$objSalida->fecha_vacaciones_hasta,$objSalida->dias_vacaciones,$objSalida->usuario,$objSalida->estatus_vacaciones,$objSalida->hcontrato);
			}
			foreach ($detalle_dia_laborable as $record):
			{
				$this->Horarios_model->agregar_detalle_horarios($record->id,$record->dia_laborable,$record->orden,$objSalida->hcontrato,$objSalida->usuario,$record->hora_entrada,$record->hora_salida);							
			}
			endforeach;
			/*		
			//$this->Horarios_model->actualizar_horas_laborales($objSalida->id,$objSalida->hora_entrada,$objSalida->duracion_almuerzo,$objSalida->hora_salida,$objSalida->break_1,$objSalida->break_2);			
			*/
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcontratos','Update',$objSalida->hcontrato,$this->input->ip_address(),'Actualización de Contrato y Horarios a Empleado');
		}
		else
		{	
			$contrato=$this->Horarios_model->agregar_contratos($objSalida->fecha_inicio_contrato,$objSalida->fecha_perioro_prueba,$objSalida->fecha_fin_contrato,$objSalida->usuario,$objSalida->estatus_contrato);			
			$objSalida->hcontrato=$contrato;
			if($objSalida->estatus_vacaciones!=null && $objSalida->hvacaciones==null)
			{
				$vacaciones=$this->Horarios_model->agregar_vacaciones($objSalida->fecha_vacaciones_desde,$objSalida->fecha_vacaciones_hasta,$objSalida->dias_vacaciones,$objSalida->usuario,$objSalida->estatus_vacaciones,$objSalida->hcontrato);
			}
			foreach ($detalle_dia_laborable as $record):
			{
				$this->Horarios_model->agregar_detalle_horarios($record->id,$record->dia_laborable,$record->orden,$objSalida->hcontrato,$objSalida->usuario,$record->hora_entrada,$record->hora_salida);								
			}
			endforeach;
			/*
			$id = $this->Horarios_model->agregar_horarios($objSalida->hora_entrada,$objSalida->duracion_almuerzo,$objSalida->hora_salida,$objSalida->usuario,$objSalida->break_1,$objSalida->break_2);
			*/	
			$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcontratos','Insert',$objSalida->hcontrato,$this->input->ip_address(),'Asignacion de Contrato y Horarios a Empleado');						
		}		
		$this->db->trans_complete();		
		$this->response($objSalida);
    }
    

  	/*public function buscar_datos_usuarios_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);		}
		$objSalida = json_decode(file_get_contents("php://input"));				
		$this->db->trans_start();		
		$huser=$objSalida->usuario;
		$buscando_horario=$this->obtener_horarios($objSalida->usuario);
		if (empty($buscando_horario))
		{
			$this->response(false);
			return false;
		}
		$objSalida=$buscando_horario;
		$objSalida->detalle_dia_laborable = $this->obtener_detalle_dias_laborales($objSalida->id);
		$fechas_contratos=$this->Horarios_model->buscar_fechas_contratos($huser);
		if($fechas_contratos!=false)
		{
			$objSalida->fecha_inicio_contrato=$fechas_contratos->fecha_inicio_contrato;
			$objSalida->fecha_perioro_prueba=$fechas_contratos->fecha_perioro_prueba;
			$objSalida->fecha_fin_contrato=$fechas_contratos->fecha_fin_contrato;
			$objSalida->hcontrato=$fechas_contratos->hcontrato;
			$objSalida->estatus_contrato=$fechas_contratos->estatus;
		}

		$fecha_vacaciones=$this->Horarios_model->buscar_fechas_vacaciones($huser);
		if($fecha_vacaciones!=false)
		{
			$objSalida->fecha_vacaciones_desde=$fecha_vacaciones->fecha_desde;
			$objSalida->fecha_vacaciones_hasta=$fecha_vacaciones->fecha_hasta;
			$objSalida->dias_vacaciones=$fecha_vacaciones->dias_vacaciones;
			$objSalida->hvacaciones=$fecha_vacaciones->hvacaciones;
			$objSalida->estatus_vacaciones=$fecha_vacaciones->estatus;
		}
		else
		{
			$objSalida->fecha_vacaciones_desde=NULL;
			$objSalida->fecha_vacaciones_hasta=NULL;
			$objSalida->dias_vacaciones=NULL;
			$objSalida->hvacaciones=NULL;
			$objSalida->estatus_vacaciones=NULL;
		}
		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblhorarios','Insert',$huser,$this->input->ip_address(),'Consultando Horarios de Usuarios');	
		$this->response($objSalida);
    }
    	
    	
  	public function obtener_horarios($huser)
    {
    	 $datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$detalleG = $this->Horarios_model->get_horarios($huser);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
	public function obtener_detalle_dias_laborales($hhoriario)
    {
    	 $datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$detalleG = $this->Horarios_model->get_detalle_dias_laborables($hhoriario);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
  	
   public function all_days_laborables_get()
    {
        $datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}		
		$data = $this->Horarios_model->get_all_dias_laborables();
		if (!empty($data)){
			$this->response($data);
			return true;
		}
		$this->response(false);		
    }*/
}
?>