<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/REST_Controller.php');
require(APPPATH. 'third_party/PHPExcel.php');
require(APPPATH. 'third_party/PHPExcel/IOFactory.php');
class Consulta_Datos extends REST_Controller
{
	function __construct()
	{
    	parent::__construct(); 
		//$this->load->database('default');
        $this->load->library('form_validation');   
    	$this->load->model('Consultas_model');
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
   public function fecha_server_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();	
		$fecha=date('d-m-Y');
		$hora=date('G:i:s');
		$restar = date("d",strtotime($fecha.'- 1 day' ));
		$desde = date("d-m-Y",strtotime($fecha.'-'.$restar.' day' ));
		$date=new DateTime('now');
		$numero_dias=$date->format('t');		
		$array=array('fecha'=>$fecha,'hora'=>$hora,'desde'=>$desde,'numero_dias'=>$numero_dias,'date'=>$date);
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'SERVER','GET',1,$this->input->ip_address(),'Consultando Hora de Servidor');	
		$this->response($array);
    }
    public function buscar_datos_usuarios_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		//$detalle = $objSalida->detalle;		
		$this->db->trans_start();	
		$buscando_usuario = $this->Consultas_model->get_all_datos($objSalida->huser);
		if (empty($buscando_usuario))
		{
			$this->response(false);
			return false;
		}
		$data=$buscando_usuario;
		$data->departamentos=$this->Consultas_model->get_detalle_tabla_acceso_departamentos($buscando_usuario->id);
		$data->carpetas=$this->Consultas_model->get_detalle_tabla_acceso_carpetas($buscando_usuario->id);
		$data->sistemas=$this->Consultas_model->get_detalle_tabla_acceso_sistemas($buscando_usuario->id);
		//$data->sistemas=$this->obtener_detalle_sistemas($buscando_usuario->id);
		//$traer_departamentos=$this->Consultas_model->get_detalle_tabla_departamentos($buscando_usuario->id);		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblusuarios','Search',$buscando_usuario->id,$this->input->ip_address(),'Consultando datos por usuario');	
		$this->response($data);
    }
     public function buscar_detalles_breaks_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		//$detalle = $objSalida->detalle;		
		$this->db->trans_start();	
		$buscando_detalle = $this->Consultas_model->get_breaks_detalles($objSalida->hasistencia,$objSalida->huser);
		if (empty($buscando_detalle))
		{
			$this->response(false);
			return false;
		}
		$data=$buscando_detalle;		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblbreaks','Search',$objSalida->hasistencia,$this->input->ip_address(),'Consultando detalles de breaks');	
		$this->response($data);
    }
     public function reporte_general_all_empleados_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();	
		$buscando_detalle = $this->Consultas_model->get_reporte_general($objSalida->fecha_desde,$objSalida->fecha_hasta);
		if (empty($buscando_detalle))
		{
			$this->response(false);
			return false;
		}		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblcontrolasistencia','Search',0,$this->input->ip_address(),'Reporte General de Todos Los Empleados');	
		$this->response($buscando_detalle);
    }
     public function buscar_detalles_reuniones_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		//$detalle = $objSalida->detalle;		
		$this->db->trans_start();	
		$buscando_detalle = $this->Consultas_model->get_reuniones_detalles($objSalida->hasistencia,$objSalida->huser);
		if (empty($buscando_detalle))
		{
			$this->response(false);
			return false;
		}
		$data=$buscando_detalle;
		//$data->departamentos=$this->Consultas_model->get_detalle_tabla_acceso_departamentos($buscando_usuario->id);
		//$data->carpetas=$this->Consultas_model->get_detalle_tabla_acceso_carpetas($buscando_usuario->id);
		//$data->sistemas=$this->Consultas_model->get_detalle_tabla_acceso_sistemas($buscando_usuario->id);
		//$data->sistemas=$this->obtener_detalle_sistemas($buscando_usuario->id);
		//$traer_departamentos=$this->Consultas_model->get_detalle_tabla_departamentos($buscando_usuario->id);		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblreuniones','Search',$objSalida->hasistencia,$this->input->ip_address(),'Consultando detalles de Reuniones');	
		$this->response($data);
    }
     public function buscar_inactividades_users_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		//$detalle = $objSalida->detalle;		
		$this->db->trans_start();	
		$buscando_detalle = $this->Consultas_model->get_inactiviades_detalles($objSalida->hasistencia,$objSalida->huser);
		if (empty($buscando_detalle))
		{
			$this->response(false);
			return false;
		}
		$data=$buscando_detalle;
		//$data->departamentos=$this->Consultas_model->get_detalle_tabla_acceso_departamentos($buscando_usuario->id);
		//$data->carpetas=$this->Consultas_model->get_detalle_tabla_acceso_carpetas($buscando_usuario->id);
		//$data->sistemas=$this->Consultas_model->get_detalle_tabla_acceso_sistemas($buscando_usuario->id);
		//$data->sistemas=$this->obtener_detalle_sistemas($buscando_usuario->id);
		//$traer_departamentos=$this->Consultas_model->get_detalle_tabla_departamentos($buscando_usuario->id);		
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblinactividades','Search',$objSalida->hasistencia,$this->input->ip_address(),'Consultando detalles de inactividades');	
		$this->response($data);
    }
    public function buscar_asistencias_empleados_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();	
		$buscando_usuario = $this->Consultas_model->get_datos_users($objSalida->huser);
		if (empty($buscando_usuario))
		{
			$this->response(false);
			return false;
		}
		//$buscar_asistencia=$this->Consultas_model->get_asistencias($objSalida->huser);
		$data=$buscando_usuario;				
		//$data->asistencia_empleado=$buscar_asistencia;
		$this->db->trans_complete();		
		$this->response($data);
	}
	 public function buscar_reportes_asistencia_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		//$detalle = $objSalida->detalle;		
		$this->db->trans_start();	
		$buscando_usuario = $this->Consultas_model->get_asistencias($objSalida->id,$objSalida->desde,$objSalida->hasta);
		if (empty($buscando_usuario))
		{
			$this->response(false);
			return false;
		}
		$data=$buscando_usuario;
		$sum_asistencia=$this->Consultas_model->sum_asistencia($objSalida->id,$objSalida->desde,$objSalida->hasta);
		$arrayName = array('asistencia' =>$data , 'sum_asistencia' =>$sum_asistencia);		
		$this->db->trans_complete();
		//$this->Auditoria_model->agregar($this->session->userdata('id'),'tblusuarios','Search',$buscando_usuario->id,$this->input->ip_address(),'Consultando datos por usuario');	
		$this->response($arrayName);
    }

    public function buscar_usuarios_carpetas_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();
		$objSalida->carpetas_obtenidas=$this->Consultas_model->get_users_folders($objSalida->carpetas);
		if (empty($objSalida->carpetas_obtenidas))
		{
			$this->response(false);
			return false;
		}
		$objSalida->departamentos_pertenecen=$this->Consultas_model->get_users_room($objSalida->carpetas);				
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblusuarios','Insert',$objSalida->carpetas,$this->input->ip_address(),'Consultando datos por usuario');	
		$this->response($objSalida);
    }
     public function buscar_usuarios_departamentos_post()
    {
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();
		
		$objSalida->departamentos_usuarios1=$this->Consultas_model->get_users_departamentos($objSalida->hdepartamento);
		if (empty($objSalida->departamentos_usuarios1))
		{
			$this->response(false);
			return false;
		}
		$objSalida->carpetas_pertenecen=$this->Consultas_model->get_users_folders_pertenecen($objSalida->hdepartamento);				
		$this->db->trans_complete();
		$this->Auditoria_model->agregar($this->session->userdata('id'),'tblusuarios','Insert',$objSalida->hdepartamento,$this->input->ip_address(),'Consultando datos por usuario');	
		$this->response($objSalida);
    }
    	public function obtener_usuarios($huser)
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$detalleG = $this->Consultas_model->get_usuarios($huser);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		return $detalleG;
	}
   	public function obtener_detalle_departamentos($huser)
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$detalleG = $this->Consultas_model->get_detalle_tabla_acceso_departamentos($huser);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		foreach ($detalleG as $record):
			{
				$detalle = $record;
				$departamentos = $this->Consultas_model->get_departamentos($record->hdepartamento);				
				array_push($detalleFinal, $departamentos);
			}
		endforeach;	
		$detalleG = $detalleFinal;	
		return $detalleG;
	}
		public function obtener_detalle_carpetas($huser)
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$detalleG = $this->Consultas_model->get_detalle_tabla_acceso_carpetas($huser);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		foreach ($detalleG as $record):
			{
				$detalle = $record;
				$carpetas = $this->Consultas_model->get_carpetas($record->hdepartamento,$record->hcarpeta);				
				array_push($detalleFinal, $carpetas);
			}
		endforeach;	
		$detalleG = $detalleFinal;	
		return $detalleG;
	}
	public function obtener_detalle_sistemas($huser)
	{
		$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$detalleG = $this->Consultas_model->get_detalle_tabla_acceso_sistemas($huser);
		$detalleFinal = Array();
		if (empty($detalleG)){
			return false;
		}
		foreach ($detalleG as $record):
			{
				$detalle = $record;
				$sistemas = $this->Consultas_model->get_sistemas($record->hsistema);				
				array_push($detalleFinal, $sistemas);
			}
		endforeach;	
		$detalleG = $detalleFinal;	
		return $detalleG;
	}
	public function get_all_carpetas_get()
    {
        $datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		
		$data = $this->Consultas_model->list_folders();
		if (!empty($data)){
			$this->response($data);
			return true;
		}
		$this->response(false);
		
    }
    public function get_data_breaks_get()
    {
        $datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$id_asistencia=$this->get('id_asistencia');
		$data = $this->Consultas_model->get_all_breaks($id_asistencia);
		if (!empty($data))
		{
			$this->response($data);
			return true;
		}
		$this->response(false);
		
    }
    public function get_all_usuarios_get()
    {
        $datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		
		$data = $this->Consultas_model->list_users();
		if (!empty($data)){
			$this->response($data);
			return true;
		}
		$this->response(false);
		
    }
    public function get_all_departamentos_get()
    {
        $datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		
		$data = $this->Consultas_model->list_departamentos();
		if (!empty($data)){
			$this->response($data);
			return true;
		}
		$this->response(false);
		
    }
     public function Exportar_Excel_post()
    {
    	$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize'  => '15MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();		
		
		$asistencia=$this->Consultas_model->get_asistencia_rango_fecha($objSalida->huser,$objSalida->fecha_desde,$objSalida->fecha_hasta);
		$datos_del_usuario=$this->Consultas_model->datos_del_usuario($objSalida->huser);
		if (empty($objSalida))
		{
			$this->response(false);
			return false;
		}
		$fecha= date('Y-m-d_H:i:s');
		//$nombre_reporte= $fecha.".".$datos_del_usuario->nombres."_".$datos_del_usuario->apellidos."reporte.xls";
		
		$nombre_reporte='Informe_Asistencia:_'.$datos_del_usuario->nombres."_".$datos_del_usuario->apellidos.'_'.$fecha.".reporte.xls";


		$objSalida->nombre_reporte=$nombre_reporte;
		
		if($datos_del_usuario->dni==null)
		{
			$dni='Sin DNI Asignado';
		}
		else
		{
			$dni=$datos_del_usuario->dni;
		}	

		$objPHPExcel = new PHPExcel(); //nueva instancia		 
		$objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
		$objPHPExcel->getProperties()->setTitle("Informe de Asistencia"); //titulo				 
		//inicio estilos
		$titulo = new PHPExcel_Style(); //nuevo estilo
		$titulo->applyFromArray(
		  array('alignment' => array( //alineacion
		      'wrap' => false,
		      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
		    ),
		    'font' => array( //fuente
		      'bold' => true,
		      'size' => 20
		    )
		));
		 
		$subtitulo = new PHPExcel_Style(); //nuevo estilo
		 
		$subtitulo->applyFromArray(
		  array('fill' => array( //relleno de color
		      'type' => PHPExcel_Style_Fill::FILL_SOLID,
		      'color' => array('argb' => 'FFCCFFCC')
		    ),
		    'borders' => array( //bordes
		      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		    )
		));
		 
		$bordes = new PHPExcel_Style(); //nuevo estilo
		 
		$bordes->applyFromArray(
		  array('borders' => array(
		      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		    )
		));
		//fin estilos
		 
		$objPHPExcel->createSheet(0); //crear hoja
		$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora
		$objPHPExcel->getActiveSheet()->setTitle("Informe Asistencia"); //establecer titulo de hoja
		 
		//orientacion hoja
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		 
		//tipo papel
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		 
		//establecer impresion a pagina completa
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		//fin: establecer impresion a pagina completa
		 
		//establecer margenes
		$margin = 0.5 / 2.54; // 0.5 centimetros
		$marginBottom = 1.2 / 2.54; //1.2 centimetros
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
		//fin: establecer margenes
		 
		//incluir una imagen
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setPath('application/libraries/estilos/img/logo_web.png'); //ruta
		$objDrawing->setHeight(75); //altura
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); //incluir la imagen
		//fin: incluir una imagen
		//$objPHPExcel->getActiveSheet()->SetCellValue("E1", "Nombres & Apellidos");
		$objPHPExcel->getActiveSheet()->SetCellValue("A5", 'Escuela Abierta de Desarrollo en Ingeniería y Construcción, S.L.');
		$objPHPExcel->getActiveSheet()->mergeCells("A5:E5"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A5:E5"); 
		//establecer titulos de impresion en cada hoja
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);
		
		$objPHPExcel->getActiveSheet()->SetCellValue("A6", "Datos del Empleado");
		$objPHPExcel->getActiveSheet()->mergeCells("A6:E6"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A6:E6"); //establecer estilo 
		
		$objPHPExcel->getActiveSheet()->SetCellValue("A7", "Nombres & Apellidos:");
		$objPHPExcel->getActiveSheet()->mergeCells("A7:B7"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A7:B7");

		$objPHPExcel->getActiveSheet()->SetCellValue("A8", "DNI:");		
		$objPHPExcel->getActiveSheet()->mergeCells("A8:B8"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A8:B8");

		$objPHPExcel->getActiveSheet()->SetCellValue("A9", "Oficina:");		
		$objPHPExcel->getActiveSheet()->mergeCells("A9:B9"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A9:B9");

		$objPHPExcel->getActiveSheet()->SetCellValue("A10", "Fecha del Reporte:");
		$objPHPExcel->getActiveSheet()->mergeCells("A10:B10"); //unir celdas		
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A10:B10");

		$objPHPExcel->getActiveSheet()->SetCellValue("C7", $datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos);
		$objPHPExcel->getActiveSheet()->SetCellValue("C8", $dni);
		$objPHPExcel->getActiveSheet()->SetCellValue("C9", $datos_del_usuario->nombre_oficina);
		$objPHPExcel->getActiveSheet()->SetCellValue("C10", date('d/m/Y G:i:s'));
		$objPHPExcel->getActiveSheet()->mergeCells("C10:D10"); //unir celdas
		
		$objPHPExcel->getActiveSheet()->SetCellValue("A12", "Rango de Consulta:");
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A12");
		$objPHPExcel->getActiveSheet()->SetCellValue("A13", "Desde:");
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A13");
		$objPHPExcel->getActiveSheet()->SetCellValue("A14", "Hasta:");
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A14");
		$objPHPExcel->getActiveSheet()->SetCellValue("B13", $objSalida->fecha_desde);
		$objPHPExcel->getActiveSheet()->SetCellValue("B14", $objSalida->fecha_hasta);

		$fila=16;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "INFORME DE ASISTENCIA");
		$objPHPExcel->getActiveSheet()->mergeCells("A$fila:E$fila"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:E$fila"); //establecer estilo
		 
		//titulos de columnas
		$fila+=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'FECHA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'ENTRADA');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'SALIDA');		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'TOTAL DE HORAS');
		$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas	
		

		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:E$fila"); //establecer estilo
		$objPHPExcel->getActiveSheet()->getStyle("A$fila:E$fila")->getFont()->setBold(true); //negrita
		 
		//rellenar con contenido
		/*for ($i = 0; $i < 10; $i++) 
		{
		  $fila+=1;
		  $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Blog');
		  $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Kiuvox');
		 
		  //Establecer estilo
		  $objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:B$fila");
		 
		}*/
		for($i=0; $i<count($asistencia); $i++) 
		{
			 $fila+=1;
			$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $asistencia[$i]->fecha);
			$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $asistencia[$i]->horario_entrada);
			$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $asistencia[$i]->horario_salida);
			$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $asistencia[$i]->total_jornada);
			$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas
		}
		 
		//insertar formula
		/*$fila+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'SUMA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", '=1+2');*/
		 
		//recorrer las columnas
		foreach (range('A', 'E') as $columnID) {
		  //autodimensionar las columnas
		  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		 
		//establecer pie de impresion en cada hoja
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');
		 
		//*************Guardar como excel 2003*********************************
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); //Escribir archivo
		 
		// Establecer formado de Excel 2003
		header("Content-Type: application/vnd.ms-excel");
		 
		// nombre del archivo
		header('Content-Disposition: attachment; filename="informe asistencia.xls"');
		//**********************************************************************		 
		//****************Guardar como excel 2007*******************************
		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
		//
		//// Establecer formado de Excel 2007
		//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//
		//// nombre del archivo
		//header('Content-Disposition: attachment; filename="informe asistencia.xlsx"');
		//**********************************************************************
		//forzar a descarga por el navegador
		$objWriter->save('reportes/'.$nombre_reporte);
		$this->db->trans_complete();		
		$this->response($objSalida);
		exit;	
    }
     public function Exportar_Excel_Detallado_post()
    {
    	$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize'  => '15MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
    	$datausuario=$this->session->all_userdata();	
		if (!isset($datausuario['sesion_clientes']))
		{
			redirect(base_url(), 'location', 301);
		}
		$objSalida = json_decode(file_get_contents("php://input"));
		$this->db->trans_start();		
		
		$asistencia=$this->Consultas_model->get_asistencia_rango_fecha($objSalida->huser,$objSalida->fecha_desde,$objSalida->fecha_hasta);
		$datos_del_usuario=$this->Consultas_model->datos_del_usuario($objSalida->huser);
		if (empty($objSalida))
		{
			$this->response(false);
			return false;
		}
		$fecha= date('Y-m-d_H:i:s');
		//$nombre_reporte= $fecha.".".$datos_del_usuario->nombres."_".$datos_del_usuario->apellidos."reporte.xls";
		
		$nombre_reporte='Informe_Asistencia:_'.$datos_del_usuario->nombres."_".$datos_del_usuario->apellidos.'_'.$fecha.".Reporte_Detallado.xls";


		$objSalida->nombre_reporte=$nombre_reporte;
		
		if($datos_del_usuario->dni==null)
		{
			$dni='Sin DNI Asignado';
		}
		else
		{
			$dni=$datos_del_usuario->dni;
		}	
		$objPHPExcel = new PHPExcel(); //nueva instancia		 
		$objPHPExcel->getProperties()->setCreator("Powered by SomosTuWebMaster.es - 2019"); //autor
		$objPHPExcel->getProperties()->setTitle("Informe de Asistencia"); //titulo				 
		//inicio estilos
		$titulo = new PHPExcel_Style(); //nuevo estilo
		$titulo->applyFromArray(
		  array('alignment' => array( //alineacion
		      'wrap' => false,
		      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
		    ),
		    'font' => array( //fuente
		      'bold' => true,
		      'size' => 20
		    )
		));
		$subtitulo = new PHPExcel_Style(); //nuevo estilo		 
		$subtitulo->applyFromArray(
		  array('fill' => array( //relleno de color
		      'type' => PHPExcel_Style_Fill::FILL_SOLID,
		      'color' => array('argb' => 'FFCCFFCC')
		    ),
		    'borders' => array( //bordes
		      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		    )
		));		 
		$bordes = new PHPExcel_Style(); //nuevo estilo		 
		$bordes->applyFromArray(
		  array('borders' => array(
		      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		    )
		));
		//fin estilos		 
		$objPHPExcel->createSheet(0); //crear hoja
		$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora
		$objPHPExcel->getActiveSheet()->setTitle("Informe Asistencia"); //establecer titulo de hoja		 
		//orientacion hoja
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		 //tipo papel
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);		 
		//establecer impresion a pagina completa
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		//fin: establecer impresion a pagina completa
		 
		//establecer margenes
		$margin = 0.5 / 2.54; // 0.5 centimetros
		$marginBottom = 1.2 / 2.54; //1.2 centimetros
		$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);
		//fin: establecer margenes
		 
		//incluir una imagen
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setPath('application/libraries/estilos/img/logo_web.png'); //ruta imagen
		$objDrawing->setHeight(75); //altura
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); //incluir la imagen
		//fin: incluir una imagen
		//$objPHPExcel->getActiveSheet()->SetCellValue("E1", "Nombres & Apellidos");
		$objPHPExcel->getActiveSheet()->SetCellValue("A5", TITULO);
		$objPHPExcel->getActiveSheet()->mergeCells("A5:E5"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A5:E5"); 
		//establecer titulos de impresion en cada hoja
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 6);		
		$objPHPExcel->getActiveSheet()->SetCellValue("A6", "Datos del Empleado");
		$objPHPExcel->getActiveSheet()->mergeCells("A6:E6"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A6:E6"); //establecer estilo 		
		$objPHPExcel->getActiveSheet()->SetCellValue("A7", "Nombres & Apellidos:");
		$objPHPExcel->getActiveSheet()->mergeCells("A7:B7"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A7:B7");
		$objPHPExcel->getActiveSheet()->SetCellValue("A8", "DNI:");		
		$objPHPExcel->getActiveSheet()->mergeCells("A8:B8"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A8:B8");
		$objPHPExcel->getActiveSheet()->SetCellValue("A9", "Oficina:");		
		$objPHPExcel->getActiveSheet()->mergeCells("A9:B9"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A9:B9");
		$objPHPExcel->getActiveSheet()->SetCellValue("A10", "Fecha del Reporte:");
		$objPHPExcel->getActiveSheet()->mergeCells("A10:B10"); //unir celdas		
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A10:B10");
		$objPHPExcel->getActiveSheet()->SetCellValue("C7", $datos_del_usuario->nombres.' '.$datos_del_usuario->apellidos);
		$objPHPExcel->getActiveSheet()->SetCellValue("C8", $dni);
		$objPHPExcel->getActiveSheet()->SetCellValue("C9", $datos_del_usuario->nombre_oficina);
		$objPHPExcel->getActiveSheet()->SetCellValue("C10", date('d/m/Y G:i:s'));
		$objPHPExcel->getActiveSheet()->mergeCells("C10:D10"); //unir celdas		
		$objPHPExcel->getActiveSheet()->SetCellValue("A12", "Rango de Consulta:");
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A12");
		$objPHPExcel->getActiveSheet()->SetCellValue("A13", "Desde:");
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A13");
		$objPHPExcel->getActiveSheet()->SetCellValue("A14", "Hasta:");
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A14");
		$objPHPExcel->getActiveSheet()->SetCellValue("B13", $objSalida->fecha_desde);
		$objPHPExcel->getActiveSheet()->SetCellValue("B14", $objSalida->fecha_hasta);
		$fila=16;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "INFORME DE ASISTENCIA");
		$objPHPExcel->getActiveSheet()->mergeCells("A$fila:E$fila"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:E$fila"); //establecer estilo
		//titulos de columnas
		$fila+=1;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'FECHA');
		$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'ENTRADA');
		$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'SALIDA');		
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'TOTAL JORNADA');
		$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila"); //unir celdas	
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'BREAKS');
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'REUNIÓN');
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'INACTIVIDAD');
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'TOTAL LABORADO');
		$objPHPExcel->getActiveSheet()->mergeCells("I$fila:J$fila"); //unir celdas
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:J$fila"); //establecer estilo
		$objPHPExcel->getActiveSheet()->getStyle("A$fila:J$fila")->getFont()->setBold(true); //negrita		 
		//rellenar con contenido
		/*for ($i = 0; $i < 10; $i++) 
		{
		  $fila+=1;
		  $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'Blog');
		  $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Kiuvox');
		 
		  //Establecer estilo
		  $objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:B$fila");
		 
		}*/
		$acumulador_horas_jornada=0;
		$acumulador_minutos_jornada=0;
		$acumulador_segundos_jornada=0;	
		$acumulador_horas_breaks=0;
		$acumulador_minutos_breaks=0;
		$acumulador_segundos_breaks=0;
		$acumulador_horas_reunion=0;
		$acumulador_minutos_reunion=0;
		$acumulador_segundos_reunion=0;
		$acumulador_horas_inactividad=0;
		$acumulador_minutos_inactividad=0;
		$acumulador_segundos_inactividad=0;
		$acumulador_horas_laboradas=0;
		$acumulador_minutos_laboradas=0;
		$acumulador_segundos_laboradas=0;
		$total_jornada_acumulada=0;
		$total_breaks_acumulada=0;
		$total_reunion_acumulada=0;
		$total_inactividad_acumulada=0;
		$total_jornada_laborada_acumulada=0;
		for($i=0; $i<count($asistencia); $i++) 
		{
			$fila+=1;
			
			if($asistencia[$i]->total_jornada==null)
			{
				$asistencia_total_jornada='S/F';
			}
			else
			{
				$asistencia_total_jornada=$asistencia[$i]->total_jornada;
			}
			if($asistencia[$i]->breaks==null)
			{
				$asistencia_breaks='00:00:00';
			}
			else
			{
				$asistencia_breaks=$asistencia[$i]->breaks;
			}
			if($asistencia[$i]->reunion==null)
			{
				$asistencia_reunion='00:00:00';
			}
			else
			{
				$asistencia_reunion=$asistencia[$i]->reunion;
			}
			if($asistencia[$i]->inactividad==null)
			{
				$asistencia_inactividad='00:00:00';
			}
			else
			{
				$asistencia_inactividad=$asistencia[$i]->inactividad;
			}
			if($asistencia[$i]->type==4)
			{
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $asistencia[$i]->fecha);
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $asistencia[$i]->horario_entrada);
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $asistencia[$i]->horario_salida);
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $asistencia[$i]->total_jornada);
				$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila");//unir celdas
				$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $asistencia_breaks);
				$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $asistencia_reunion);
				$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $asistencia_inactividad);
				$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $asistencia[$i]->total_horas);

				$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:I$fila");

				$separar_total_jornada=0;
				$separar_total_jornada=explode(":",$asistencia[$i]->total_jornada);	
				$horas_jornada_suma=$separar_total_jornada[0];
				$minutos_jornada_suma=$separar_total_jornada[1];
				$segundos_jornada_suma=$separar_total_jornada[2];			
				$acumulador_horas_jornada=$acumulador_horas_jornada+$horas_jornada_suma;
				$acumulador_minutos_jornada=$acumulador_minutos_jornada+$minutos_jornada_suma;
				$acumulador_segundos_jornada=$acumulador_segundos_jornada+$segundos_jornada_suma;
				if($acumulador_horas_jornada==0 or $acumulador_horas_jornada<10)
		 		{
		 			$acumulador_horas_jornada='0'.$acumulador_horas_jornada;
		 		}		 		
		 		if($acumulador_minutos_jornada==0 or $acumulador_minutos_jornada<10)
		 		{
		 			$acumulador_minutos_jornada='0'.$acumulador_minutos_jornada;
		 		}
		 		if($acumulador_segundos_jornada==0 or $acumulador_segundos_jornada<10)
		 		{
		 			$acumulador_segundos_jornada='0'.$acumulador_segundos_jornada;
		 		}
		 		if($acumulador_segundos_jornada>=60)
		 		{
		 			$acumulador_minutos_jornada=$acumulador_minutos_jornada+1;
		 			$acumulador_segundos_jornada=$acumulador_segundos_jornada-60;
		 			if($acumulador_minutos_jornada==0 or $acumulador_minutos_jornada<10)
			 		{
			 			$acumulador_minutos_jornada='0'.$acumulador_minutos_jornada;
			 		}
			 		if($acumulador_segundos_jornada==0 or $acumulador_segundos_jornada<10)
			 		{
			 			$acumulador_segundos_jornada='0'.$acumulador_segundos_jornada;
			 		}
		 		}
		 		if($acumulador_minutos_jornada>=60)
		 		{
		 			$acumulador_horas_jornada=$acumulador_horas_jornada+1;
		 			$acumulador_minutos_jornada=$acumulador_minutos_jornada-60;
		 			if($acumulador_minutos_jornada==0 or $acumulador_minutos_jornada<10)
			 		{
			 			$acumulador_minutos_jornada='0'.$acumulador_minutos_jornada;
			 		}			 				
		 		}
				$total_jornada_acumulada=$acumulador_horas_jornada.':'.$acumulador_minutos_jornada.':'.$acumulador_segundos_jornada;

				$separar_total_breals=explode(":",$asistencia_breaks);	
				$horas_breaks_suma=$separar_total_breals[0];
				$minutos_breaks_suma=$separar_total_breals[1];
				$segundos_breaks_suma=$separar_total_breals[2];			
				
				$acumulador_horas_breaks=$acumulador_horas_breaks+$horas_breaks_suma;
				$acumulador_minutos_breaks=$acumulador_minutos_breaks+$minutos_breaks_suma;
				$acumulador_segundos_breaks=$acumulador_segundos_breaks+$segundos_breaks_suma;
				if($acumulador_horas_breaks==0 or $acumulador_horas_breaks<10)
		 		{
		 			$acumulador_horas_breaks='0'.$acumulador_horas_breaks;
		 		}
		 		if($acumulador_minutos_breaks==0 or $acumulador_minutos_breaks<10)
		 		{
		 			$acumulador_minutos_breaks='0'.$acumulador_minutos_breaks;
		 		}		 		
		 		if($acumulador_segundos_breaks==0 or $acumulador_segundos_breaks<10)
		 		{
		 			$acumulador_segundos_breaks='0'.$acumulador_segundos_breaks;
		 		}
		 		if($acumulador_segundos_breaks>=60)
		 		{
		 			$acumulador_minutos_breaks=$acumulador_minutos_breaks+1;
		 			$acumulador_segundos_breaks=$acumulador_segundos_breaks-60;
		 			if($acumulador_minutos_breaks==0 or $acumulador_minutos_breaks<10)
			 		{
			 			$acumulador_minutos_breaks='0'.$acumulador_minutos_breaks;
			 		}
			 		if($acumulador_segundos_breaks==0 or $acumulador_segundos_breaks<10)
			 		{
			 			$acumulador_segundos_breaks='0'.$acumulador_segundos_breaks;
			 		}
		 		}
		 		if($acumulador_minutos_breaks>=60)
		 		{
		 			$acumulador_horas_breaks=$acumulador_horas_breaks+1;
		 			$acumulador_minutos_breaks=$acumulador_minutos_breaks-60;
		 			if($acumulador_minutos_breaks==0 or $acumulador_minutos_breaks<10)
			 		{
			 			$acumulador_minutos_breaks='0'.$acumulador_minutos_breaks;
			 		}			 				
		 		}
				$total_breaks_acumulada=$acumulador_horas_breaks.':'.$acumulador_minutos_breaks.':'.$acumulador_segundos_breaks;

				$separar_total_reunion=explode(":",$asistencia_reunion);	
				$horas_reunion_suma=$separar_total_reunion[0];
				$minutos_reunion_suma=$separar_total_reunion[1];
				$segundos_reunion_suma=$separar_total_reunion[2];				
				$acumulador_horas_reunion=$acumulador_horas_reunion+$horas_reunion_suma;
				$acumulador_minutos_reunion=$acumulador_minutos_reunion+$minutos_reunion_suma;
				$acumulador_segundos_reunion=$acumulador_segundos_reunion+$segundos_reunion_suma;
				
				if($acumulador_horas_reunion==0 or $acumulador_horas_reunion<10)
		 		{
		 			$acumulador_horas_reunion='0'.$acumulador_horas_reunion;
		 		}
		 		if($acumulador_minutos_reunion==0 or $acumulador_minutos_reunion<10)
		 		{
		 			$acumulador_minutos_reunion='0'.$acumulador_minutos_reunion;
		 		}
		 		if($acumulador_segundos_reunion==0 or $acumulador_segundos_reunion<10)
		 		{
		 			$acumulador_segundos_reunion='0'.$acumulador_segundos_reunion;
		 		}
		 		if($acumulador_segundos_reunion>=60)
		 		{
		 			$acumulador_minutos_breaks=$acumulador_minutos_breaks+1;
		 			$acumulador_segundos_reunion=$acumulador_segundos_reunion-60;
		 			if($acumulador_minutos_breaks==0 or $acumulador_minutos_breaks<10)
			 		{
			 			$acumulador_minutos_breaks='0'.$acumulador_minutos_breaks;
			 		}
			 		if($acumulador_segundos_reunion==0 or $acumulador_segundos_reunion<10)
			 		{
			 			$acumulador_segundos_reunion='0'.$acumulador_segundos_reunion;
			 		}
		 		}
		 		if($acumulador_minutos_breaks>=60)
		 		{
		 			$acumulador_horas_breaks=$acumulador_horas_breaks+1;
		 			$acumulador_minutos_breaks=$acumulador_minutos_breaks-60;
		 			if($acumulador_minutos_breaks==0 or $acumulador_minutos_breaks<10)
			 		{
			 			$acumulador_minutos_breaks='0'.$acumulador_minutos_breaks;
			 		}			 				
		 		}
				
				$total_reunion_acumulada=$acumulador_horas_reunion.':'.$acumulador_minutos_reunion.':'.$acumulador_segundos_reunion;
				

				$separar_total_inactividad=explode(":",$asistencia_inactividad);	
				$horas_inactividad_suma=$separar_total_inactividad[0];
				$minutos_inactividad_suma=$separar_total_inactividad[1];
				$segundos_inactividad_suma=$separar_total_inactividad[2];				
				$acumulador_horas_inactividad=$acumulador_horas_inactividad+$horas_inactividad_suma;
				$acumulador_minutos_inactividad=$acumulador_minutos_inactividad+$minutos_inactividad_suma;
				$acumulador_segundos_inactividad=$acumulador_segundos_inactividad+$segundos_inactividad_suma;				
				if($acumulador_horas_inactividad==0 or $acumulador_horas_inactividad<10)
		 		{
		 			$acumulador_horas_inactividad='0'.$acumulador_horas_inactividad;
		 		}
		 		if($acumulador_minutos_inactividad==0 or $acumulador_minutos_inactividad<10)
		 		{
		 			$acumulador_minutos_inactividad='0'.$acumulador_minutos_inactividad;
		 		}
		 		if($acumulador_segundos_inactividad==0 or $acumulador_segundos_inactividad<10)
		 		{
		 			$acumulador_segundos_inactividad='0'.$acumulador_segundos_inactividad;
		 		}
		 		if($acumulador_segundos_inactividad>=60)
		 		{
		 			$acumulador_minutos_inactividad=$acumulador_minutos_inactividad+1;
		 			$acumulador_segundos_inactividad=$acumulador_segundos_inactividad-60;
		 			if($acumulador_minutos_inactividad==0 or $acumulador_minutos_inactividad<10)
			 		{
			 			$acumulador_minutos_inactividad='0'.$acumulador_minutos_inactividad;
			 		}
			 		if($acumulador_segundos_inactividad==0 or $acumulador_segundos_inactividad<10)
			 		{
			 			$acumulador_segundos_inactividad='0'.$acumulador_segundos_inactividad;
			 		}
		 		}
		 		if($acumulador_minutos_inactividad>=60)
		 		{
		 			$acumulador_horas_inactividad=$acumulador_horas_inactividad+1;
		 			$acumulador_minutos_inactividad=$acumulador_minutos_inactividad-60;
		 			if($acumulador_minutos_inactividad==0 or $acumulador_minutos_inactividad<10)
			 		{
			 			$acumulador_minutos_inactividad='0'.$acumulador_minutos_inactividad;
			 		}			 				
		 		}
				$total_inactividad_acumulada=$acumulador_horas_inactividad.':'.$acumulador_minutos_inactividad.':'.$acumulador_segundos_inactividad;

				$separar_total_horas_laborada=explode(":",$asistencia[$i]->total_horas);	
				$horas_laborados_suma=$separar_total_horas_laborada[0];
				$minutos_laborados_suma=$separar_total_horas_laborada[1];
				$segundos_laborados_suma=$separar_total_horas_laborada[2];

				$acumulador_horas_laboradas=$acumulador_horas_laboradas+$horas_laborados_suma;
				$acumulador_minutos_laboradas=$acumulador_minutos_laboradas+$minutos_laborados_suma;
				$acumulador_segundos_laboradas=$acumulador_segundos_laboradas+$segundos_laborados_suma;	
				if($acumulador_segundos_laboradas>=60)
		 		{
		 			$acumulador_minutos_laboradas=$acumulador_minutos_laboradas+1;
		 			$acumulador_segundos_laboradas=$acumulador_segundos_laboradas-60;
		 			if($acumulador_minutos_laboradas==0 or $acumulador_minutos_laboradas<10)
			 		{
			 			$acumulador_minutos_laboradas='0'.$acumulador_minutos_laboradas;
			 		}
			 		if($acumulador_segundos_inactividad==0 or $acumulador_segundos_inactividad<10)
			 		{
			 			$acumulador_segundos_inactividad='0'.$acumulador_segundos_inactividad;
			 		}
		 		}
		 		if($acumulador_minutos_laboradas>=60)
		 		{
		 			$acumulador_horas_laboradas=$acumulador_horas_laboradas+1;
		 			$acumulador_minutos_laboradas=$acumulador_minutos_laboradas-60;
		 			if($acumulador_minutos_laboradas==0 or $acumulador_minutos_laboradas<10)
			 		{
			 			$acumulador_minutos_laboradas='0'.$acumulador_minutos_laboradas;
			 		}			 				
		 		}

		 		if($acumulador_horas_laboradas==0 or $acumulador_horas_laboradas<10)
		 		{
		 			$acumulador_horas_laboradas='0'.$acumulador_horas_laboradas;
		 		}
		 		if($acumulador_minutos_laboradas==0 or $acumulador_minutos_laboradas<10)
		 		{
		 			$acumulador_minutos_laboradas='0'.$acumulador_minutos_laboradas;
		 		}
		 		if($acumulador_segundos_laboradas==0 or $acumulador_segundos_laboradas<10)
		 		{
		 			$acumulador_segundos_laboradas='0'.$acumulador_segundos_laboradas;
		 		}	



				$total_jornada_laborada_acumulada=$acumulador_horas_laboradas.':'.$acumulador_minutos_laboradas.':'.$acumulador_segundos_laboradas;
			}
			else
			{
				$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $asistencia[$i]->fecha);
				$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $asistencia[$i]->horario_entrada);
				if($asistencia[$i]->horario_salida==null)
				{
					$asistencia_horario_salida='S/M';
				}
				else
				{
					$asistencia_horario_salida=$asistencia[$i]->horario_salida;
				}
				$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $asistencia_horario_salida);				
				$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $asistencia_total_jornada);
				$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila");//unir celdas				
				$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $asistencia_breaks);
				$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $asistencia_reunion);
				$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $asistencia_inactividad);
				$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'S/F');



			}
		}		 
		//insertar formula
		$fila+=2;
		$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'TOTAL:');
		$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila");
		$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", $total_jornada_acumulada);		
		$objPHPExcel->getActiveSheet()->mergeCells("D$fila:E$fila");//unir celdas
		$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $total_breaks_acumulada);
		$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $total_reunion_acumulada);
		$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $total_inactividad_acumulada);
		$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $total_jornada_laborada_acumulada);
		//recorrer las columnas
		foreach (range('A', 'I') as $columnID)
		{
		  //autodimensionar las columnas
		  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}		 
		//establecer pie de impresion en cada hoja
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R&F página &P / &N');		 
		//*************Guardar como excel 2003*********************************
		$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); //Escribir archivo		 
		// Establecer formado de Excel 2003
		header("Content-Type: application/vnd.ms-excel");		 
		// nombre del archivo
		header('Content-Disposition: attachment; filename="informe asistencia.xls"');
		//**********************************************************************		 
		//****************Guardar como excel 2007*******************************
		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
		//
		//// Establecer formado de Excel 2007
		//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		//
		//// nombre del archivo
		//header('Content-Disposition: attachment; filename="informe asistencia.xlsx"');
		//**********************************************************************
		//forzar a descarga por el navegador
		$objWriter->save('reportes/'.$nombre_reporte);
		$this->db->trans_complete();		
		$this->response($objSalida);
		exit;	
    }
     

  	
}
?>