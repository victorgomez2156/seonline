<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH. 'libraries/Mail-1.4.1/Mail.php');
require(APPPATH. 'libraries/Mail-1.4.1/mime.php');
class Verificador_Automatico extends CI_Controller
{
	function __construct()
	{
    	parent::__construct();
		$this->load->database('default');
        $this->load->library('form_validation');
        $this->load->library('user_agent');  
        $this->load->helper('form');
        $this->load->helper('url');  
        $this->load->library('email');
       	$this->load->helper('cookie');  
       	$this->load->model('Verificador_model');  	
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
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
		$dia_numero= date('d');
		$mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');		
		$ano=date('Y');
		$hora_nueva=date('G:i:s');		
		$pais="España, ";		
		$total= $dia[date('l')];
		$numero_final=" ".$dia_numero;		
		$mes_final=" ".$mes[date('m')];		
		$ano_final= " ".$ano;
		$todo_unido=$pais.$total.$numero_final.$mes_final.$ano_final;		
		$configuraciones_sistemas = $this->Verificador_model->get_configuraciones();

		echo "<p align='center'>BIENVENIDOS AL VERIFICADOR AUTOMATICO DE EADIC WEB AQUI SE VERIFICARAN ALGUNOS PROCESOS CON TAREAS PROGRAMADAS.</p>";
		
	}
	public function Verificador_Asistencia_Madrid()
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
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
		$dia_numero= date('d');
		$mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');		
		$ano=date('Y');
		$hora_nueva=date('G:i:s');		
		$pais="España, ";		
		$total= $dia[date('l')];
		$numero_final=" ".$dia_numero;		
		$mes_final=" ".$mes[date('m')];		
		$ano_final= " ".$ano;
		$todo_unido=$pais.$total.$numero_final.$mes_final.$ano_final;		
		$configuraciones_sistemas = $this->Verificador_model->get_configuraciones();
		$cc= $configuraciones_sistemas->correo_cc;
		$sender = $configuraciones_sistemas->smtp_user;// Your name and email address 
	    $recipient = $configuraciones_sistemas->correo_principal.",".$cc;// The Recipients name and email address	    
	    $subject = "Informe Diario de Asistencia de Empleados";// Subject for the email 		
		$html='<div class=""><div class="aHl"></div><div id=":aq" tabindex="1"></div><div id=":af" class="ii gt"><div id=":ae" class="a3s aXjCH msg1052756172818050662"><u></u><div marginwidth="0" marginheight="0"><center><table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="m_1052756172818050662bodyTable"><tbody><tr><td align="center" valign="top" id="m_1052756172818050662bodyCell">
			<table border="0" cellpadding="0" cellspacing="0" id="m_1052756172818050662templateContainer"><tbody><tr><td align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateHeader"><tbody><tr><td valign="top" class="m_1052756172818050662headerContent"><a href="" target="_blank" ></a></td></tr></tbody></table></td></tr><tr><td align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateBody"><tbody><tr><td valign="top" class="m_1052756172818050662bodyContent"><table style="height:919px;width:550px" border="0" align="center"><tbody><tr><td><table border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td colspan="2" align="left"><span style="font-size:small">	<img src='.$configuraciones_sistemas->url.'application/libraries/estilos/img/logo-eadic.png alt="" width="530" height="75" class="CToWUd">&nbsp;</span></td></tr><tr><td colspan="2" align="center"><span style="font-size:small">&nbsp;</span></td></tr></tbody></table></td></tr><tr><td height="310"><span class="im"><p style="text-align:center">
			<span style="font-size:small"><strong>Informe Asistencia Diario <br><br>'.$todo_unido.'</strong></span></p><p style="text-align:center">
			<span style="font-size:small">'.$hora_nueva.'</span></p><p><span style="font-size:small">  </span></p><p align="center"><span style="font-size:small"><strong >Listado de empleados que han llegado con retardo o están inasistentes:</strong></span></p>';
		$madrid=6;
		$detalleG=$this->Verificador_model->comprobar_asistencia($dia[date('l')],$madrid);		
		$detalleFinal = Array();
		if (empty($detalleG))
		{
			echo '<p align="center">No se han encontrados empleados que trabajen el dia de hoy En: '.$todo_unido.'</p>';
			return false;
		}		
		foreach ($detalleG as $record):
		{
			$detalle = $record;
			$asistencia = $this->Verificador_model->get_asistencia_hoy($record->id,date('Y-m-d'));			
			$detalle->asistencia= $asistencia;
			array_push($detalleFinal, $detalle);
		}
		endforeach;	
		$detalleG = $detalleFinal;		
		foreach ($detalleG as $record2):
		{			
			if($record2->asistencia!=false)
			{
				if(date($record2->asistencia->horario_entrada)>date('Y-m-d'." ".$record2->hora_entrada_fija))
				{
					$fecha_entrada=$record2->asistencia->horario_entrada;
					$fecha1 = new DateTime($fecha_entrada);//fecha inicial
					$fecha2 = new DateTime($record2->hora_entrada_fija);//fecha de cierre
					$intervalo = $fecha1->diff($fecha2);
					//$tiempo_total= $intervalo->format('%Y años %m meses %d days %H horas %i minutos %s segundos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
					$tiempo_total= $intervalo->format('%H:%i:%s');
					$nombres=$record2->nombres;
					$apellidos=$record2->apellidos;
					$hora_entrada=$record2->asistencia->horario_entrada;
					$nombre_oficina=$record->nombre_oficina;
					$estatus='<b style="color:blue;">Retardado</b>';
					$html.='<p><span style="font-size:small"><b>Empleado:</b> '.$nombres." ".$apellidos.'</span><br><span style="font-size:small"><b>Fecha del Evento:</b> '.$hora_entrada.'</span><br><span style="font-size:small"><b>Tiempo Retardo:</b> '.$tiempo_total.'</span><br><span style="font-size:small"><b>Observación:</b> '.$estatus.'</span><br><span style="font-size:small"><b>Oficina:</b> '.$nombre_oficina.'</span></p></span><span class="im"></td></tr><tr><td>';
				}										
			}
			else
			{				
				$nombres=$record2->nombres;
				$apellidos=$record2->apellidos;
				$nombre_oficina=$record2->nombre_oficina;
				$estatus='<b>No ha Ingresado</b>';				
				$html.='<p><span style="font-size:small"><b>Empleado:</b> '.$nombres." ".$apellidos.'</span><br><span style="font-size:small"><b>Observación:</b> '.$estatus.'</span><br><span style="font-size:small"><b>Oficina:</b> '.$nombre_oficina.'</span></p></span><span class="im"></td></tr><tr><td>';
			}
			
		}
		endforeach;		
		$html.='<p style="text-align:center"><span style="font-size:small"><br>'.$configuraciones_sistemas->nombre_sistema.' ©</span></p><div style="text-align:center"><span style="font-size:small">&nbsp;</span></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateFooter"><tbody><tr><td valign="top" class="m_1052756172818050662footerContent"><div align="center">Copyright © '.$configuraciones_sistemas->nombre_sistema.', All rights reserved.</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></center><div class="yj6qo"></div><div class="adL"></div></div><div class="adL"></div></div></div><div id=":au" class="ii gt" style="display:none"><div id=":av" class="a3s aXjCH undefined"></div></div><div class="hi"></div></div>';
		//echo $html;	
		 	$crlf = "\n"; 
		    $headers = array('From'=>$sender,'To'=>$configuraciones_sistemas->correo_principal,'Return-Path' => $sender,'Subject'  => $subject,'X-Priority' =>1,'Errors-To'=>$configuraciones_sistemas->correo_principal);
		    $mime = new Mail_mime($crlf); 
		    $mime->setHTMLBody($html); 
		    $mimeparams=array();
		    $mimeparams['text_encoding']="7bit";
		    $mimeparams['text_charset']="UTF-8";
		    $mimeparams['html_charset']="UTF-8";
		    $body = $mime->get($mimeparams); 
		    $headers = $mime->headers($headers); 
		    $params["host"] = $configuraciones_sistemas->smtp_host;
			$params["port"] = $configuraciones_sistemas->smtp_port;
			$params["auth"] = true;
			$params["username"] = $configuraciones_sistemas->smtp_user;
			$params["password"] = $configuraciones_sistemas->smtp_pass;
		    $mail = Mail::factory($configuraciones_sistemas->protocol, $params); 
		    $mail->send($recipient, $headers, $body);	
			if (PEAR::isError($mail)) 
			{
				echo '<p align="center"> Ha ocurrido un error al intentar enviar el correo electrónico, por favor intente nuevamente.</p>'; 
			}
			else
			{
				echo '<p align="center">Hemos Enviado un Correo Electrónico a: <b>'.$configuraciones_sistemas->correo_principal.'</b> Con el Listado de los empleados retardados de '.$pais.'y los que aun no han marcado su entrada.</p>'; 


			}
	}
	public function Verificador_Asistencia_Latino_America()
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
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
		$dia_numero= date('d');
		$mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');		
		$ano=date('Y');
		$hora_nueva=date('G:i:s');		
		$pais="Latino America, ";		
		$total= $dia[date('l')];
		$numero_final=" ".$dia_numero;		
		$mes_final=" ".$mes[date('m')];		
		$ano_final= " ".$ano;
		$todo_unido=$pais.$total.$numero_final.$mes_final.$ano_final;		
		$configuraciones_sistemas = $this->Verificador_model->get_configuraciones();
		$cc= $configuraciones_sistemas->correo_cc;
		$sender = $configuraciones_sistemas->smtp_user;// Your name and email address 
	    $recipient = $configuraciones_sistemas->correo_principal.",".$cc;// The Recipients name and email address	    
	    $subject = "Informe Diario de Asistencia de Empleados";// Subject for the email 		
		$html='<div class=""><div class="aHl"></div><div id=":aq" tabindex="1"></div><div id=":af" class="ii gt"><div id=":ae" class="a3s aXjCH msg1052756172818050662"><u></u><div marginwidth="0" marginheight="0"><center><table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="m_1052756172818050662bodyTable"><tbody><tr><td align="center" valign="top" id="m_1052756172818050662bodyCell">
			<table border="0" cellpadding="0" cellspacing="0" id="m_1052756172818050662templateContainer"><tbody><tr><td align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateHeader"><tbody><tr><td valign="top" class="m_1052756172818050662headerContent"><a href="" target="_blank" ></a></td></tr></tbody></table></td></tr><tr><td align="center" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateBody"><tbody><tr><td valign="top" class="m_1052756172818050662bodyContent"><table style="height:919px;width:550px" border="0" align="center"><tbody><tr><td><table border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td colspan="2" align="left"><span style="font-size:small">	<img src='.$configuraciones_sistemas->url.'application/libraries/estilos/img/logo-eadic.png alt="" width="530" height="75" class="CToWUd">&nbsp;</span></td></tr><tr><td colspan="2" align="center"><span style="font-size:small">&nbsp;</span></td></tr></tbody></table></td></tr><tr><td height="310"><span class="im"><p style="text-align:center">
			<span style="font-size:small"><strong>Informe Asistencia Diario <br><br>'.$todo_unido.'</strong></span></p><p style="text-align:center">
			<span style="font-size:small">'.$hora_nueva.'</span></p><p><span style="font-size:small">  </span></p><p align="center"><span style="font-size:small"><strong >Listado de empleados que han llegado con retardo o están inasistentes:</strong></span></p>';
		$oficina=5;		
		$detalleG=$this->Verificador_model->comprobar_asistencia_latino_america($dia[date('l')],$oficina);		
		$detalleFinal = Array();
		if (empty($detalleG))
		{
			echo '<p align="center">No se han encontrados empleados que trabajen el dia de hoy En: '.$todo_unido.'</p>';
			return false;
		}		
		foreach ($detalleG as $record):
		{
			$detalle = $record;
			$asistencia = $this->Verificador_model->get_asistencia_hoy($record->id,date('Y-m-d'));			
			$detalle->asistencia= $asistencia;
			array_push($detalleFinal, $detalle);
		}
		endforeach;	
		$detalleG = $detalleFinal;
		//var_dump($detalleG)		;
		foreach ($detalleG as $record2):
		{			
			if($record2->asistencia!=false)
			{
				if(date($record2->asistencia->horario_entrada)>date('Y-m-d'." ".$record2->hora_entrada_fija))
				{
					$fecha_entrada=$record2->asistencia->horario_entrada;
					$fecha1 = new DateTime($fecha_entrada);//fecha inicial
					$fecha2 = new DateTime($record2->hora_entrada_fija);//fecha de cierre
					$intervalo = $fecha1->diff($fecha2);
					//$tiempo_total= $intervalo->format('%Y años %m meses %d days %H horas %i minutos %s segundos');//00 años 0 meses 0 días 08 horas 0 minutos 0 segundos
					$tiempo_total= $intervalo->format('%H:%i:%s');
					$nombres=$record2->nombres;
					$apellidos=$record2->apellidos;
					$hora_entrada=$record2->asistencia->horario_entrada;
					$nombre_oficina=$record2->nombre_oficina;
					$estatus='<b style="color:blue;">Retardado</b>';
					$html.='<p><span style="font-size:small"><b>Empleado:</b> '.$nombres." ".$apellidos.'</span><br><span style="font-size:small"><b>Fecha del Evento:</b> '.$hora_entrada.'</span><br><span style="font-size:small"><b>Tiempo Retardo:</b> '.$tiempo_total.'</span><br><span style="font-size:small"><b>Observación:</b> '.$estatus.'</span><br><span style="font-size:small"><b>Oficina:</b> '.$nombre_oficina.'</span></p></span><span class="im"></td></tr><tr><td>';
				}										
			}
			else
			{				
				$nombres=$record2->nombres;
				$apellidos=$record2->apellidos;
				$nombre_oficina=$record2->nombre_oficina;
				$estatus='<b>No ha Ingresado</b>';				
				$html.='<p><span style="font-size:small"><b>Empleado:</b> '.$nombres." ".$apellidos.'</span><br><span style="font-size:small"><b>Observación:</b> '.$estatus.'</span><br><span style="font-size:small"><b>Oficina:</b> '.$nombre_oficina.'</span></p></span><span class="im"></td></tr><tr><td>';
			}
			
		}	

		endforeach;		
		$html.='<p style="text-align:center"><span style="font-size:small"><br>'.$configuraciones_sistemas->nombre_sistema.' ©</span></p><div style="text-align:center"><span style="font-size:small">&nbsp;</span></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateFooter"><tbody><tr><td valign="top" class="m_1052756172818050662footerContent"><div align="center">Copyright © '.$configuraciones_sistemas->nombre_sistema.', All rights reserved.</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></center><div class="yj6qo"></div><div class="adL"></div></div><div class="adL"></div></div></div><div id=":au" class="ii gt" style="display:none"><div id=":av" class="a3s aXjCH undefined"></div></div><div class="hi"></div></div>';
		//echo $html;	
		$crlf = "\n"; 
		$headers = array('From'=>$sender,'To'=>$configuraciones_sistemas->correo_principal,'Return-Path' => $sender,'Subject'  => $subject,'X-Priority' =>1,'Errors-To'=>$configuraciones_sistemas->correo_principal); 
		    $mime = new Mail_mime($crlf); 
		    $mime->setHTMLBody($html); 
		    $mimeparams=array();
		    $mimeparams['text_encoding']="7bit";
		    $mimeparams['text_charset']="UTF-8";
		    $mimeparams['html_charset']="UTF-8";
		    $body = $mime->get($mimeparams); 
		    $headers = $mime->headers($headers); 
		    $params["host"] = $configuraciones_sistemas->smtp_host;
			$params["port"] = $configuraciones_sistemas->smtp_port;
			$params["auth"] = true;
			$params["username"] = $configuraciones_sistemas->smtp_user;
			$params["password"] = $configuraciones_sistemas->smtp_pass;
		    $mail = Mail::factory($configuraciones_sistemas->protocol, $params); 
		    $mail->send($recipient, $headers, $body);	
			if (PEAR::isError($mail)) 
			{
				echo '<p align="center"> Ha ocurrido un error al intentar enviar el correo electrónico, por favor intente nuevamente.</p>'; 
			}
			else
			{
				echo '<p align="center">Hemos Enviado un Correo Electrónico a: <b>'.$configuraciones_sistemas->correo_principal.'</b> Con el Listado de los empleados retardados de '.$pais.'y los que aun no han marcado su entrada.</p>'; 


			}
	}
	public function generate_token($len = 40)
    {
       $chars = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
            'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );
        //desordenamos el array chars
        shuffle($chars);
        $num_chars = count($chars) - 1;
        $token = ''; 
        //creamos una key de 40 carácteres
        for ($i = 0; $i < $len; $i++)
        {
            $token .= $chars[mt_rand(0, $num_chars)];
        }
        return $token;
    }

    public function final_periodo_prueba()
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
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
		$dia_numero= date('d');
		$mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');		
		$ano=date('Y');
		$hora_nueva=date('G:i:s');		
		$pais="España, ";		
		$total= $dia[date('l')];
		$numero_final=" ".$dia_numero;		
		$mes_final=" ".$mes[date('m')];		
		$ano_final= " ".$ano;	
		$todo_unido=$pais.$total.$numero_final.$mes_final.$ano_final;		
		$configuraciones_sistemas = $this->Verificador_model->get_configuraciones();
		$fecha_consulta=date('Y-m-d');
		$fecha_consulta_hasta = date("Y-m-d",strtotime($fecha_consulta.'+ 7 day' ));		
		$traer_contratos=$this->Verificador_model->consultar_contratos($fecha_consulta,$fecha_consulta_hasta);
		if($traer_contratos!=false)
		{

			foreach ($traer_contratos as $record => $contratos):
			{
				if($contratos->fecha_fin_contrato==NULL)
				{
					$contratos->fecha_fin_contrato="<b>Sin Asignar Final Contrato</b>";
				}
					$sender = $configuraciones_sistemas->smtp_user;// Your name and email address 
				    $recipient = $contratos->correo_electronico; //.",".$cc;// The Recipients name and email address	    
				    $subject = "Aviso de Culminación de Contrato";// Subject for the email 
					$html='<div class=""><div class="aHl"></div><div id=":aq" tabindex="-1"></div><div id=":af" class="ii gt"><div id=":ae" class="a3s aXjCH msg1052756172818050662"><u></u><div marginwidth="0" marginheight="0"><center><table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="m_1052756172818050662bodyTable"><tbody><tr><td align="center" valign="top" id="m_1052756172818050662bodyCell"><table border="0" cellpadding="0" cellspacing="0" id="m_1052756172818050662templateContainer"><tbody><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateHeader"><tbody><tr><td valign="top" class="m_1052756172818050662headerContent"><a href=//'.$configuraciones_sistemas->url.' target="_blank">'.$configuraciones_sistemas->nombre_sistema.'</a></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateBody"><tbody><tr><td valign="top" class="m_1052756172818050662bodyContent"><table style="height:919px;width:550px" border="0" align="center"><tbody><tr><td><table border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td colspan="2" align="left"><span style="font-size:small"><img src=../'.$configuraciones_sistemas->logo.' alt="" width="530" height="75" class="CToWUd">&nbsp;</span></td></tr><tr><td colspan="2" align="center"><span style="font-size:small">&nbsp;</span></td></tr></tbody></table></td></tr><tr><td height="310"><span class="im"><p style="text-align:center"><span style="font-size:small"><strong>Aviso de Culminación de Periodo de Prueba</strong></span></p><p><span style="font-size:small">Estimado empleado: <b>'.$contratos->nombres.' '.$contratos->apellidos.'</b> su periodo de prueba esta a punto de culminar.</span></p><p><span style="font-size:small"><strong>Informacíon del Contrato</strong></span></p><p><span style="font-size:small"><b>Fecha Inicio Contrato:</b> '.$contratos->fecha_inicio_contrato.'</span><br><span style="font-size:small"><b>Fecha Final Contrato:</b> '.$contratos->fecha_fin_contrato.'</span><br><span style="font-size:small"><b style="color:red;">Fecha Fin Periodo de Prueba: '.$contratos->fecha_perioro_prueba.'</b></span><br><span style="font-size:small"><b>Estatus Contrato:</b> Activo</span></p></span><span class="im"></td></tr><tr><td><p style="text-align:center"><span style="font-size:small">'.$configuraciones_sistemas->nombre_sistema.' ©</span></p><div style="text-align:center"><span style="font-size:small">&nbsp;</span></div></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%" id="m_1052756172818050662templateFooter"><tbody><tr><td valign="top" class="m_1052756172818050662footerContent">
				<br>
				<div align="center">Copyright © '.$configuraciones_sistemas->nombre_sistema.' All rights reserved.</div></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></center><div class="yj6qo"></div><div class="adL"></div></div><div class="adL"></div></div></div><div id=":au" class="ii gt" style="display:none"><div id=":av" class="a3s aXjCH undefined"></div></div><div class="hi"></div></div>'; 
				$crlf = "\n"; 
			    $headers = array(
			    'From'   => $sender,
			    'To'=>$contratos->correo_electronico,		    
			    'Return-Path' => $sender, 
			    'Subject'  => $subject,
			    'X-Priority' =>1,
			    'Errors-To'=>$configuraciones_sistemas->correo_principal
			    ); 
			    $mime = new Mail_mime($crlf); 
			    $mime->setHTMLBody($html); 
			    $mimeparams=array();
			    $mimeparams['text_encoding']="7bit";
			    $mimeparams['text_charset']="UTF-8";
			    $mimeparams['html_charset']="UTF-8";
			    $body = $mime->get($mimeparams); 
			    $headers = $mime->headers($headers); 
			    $params["host"] = $configuraciones_sistemas->smtp_host;
				$params["port"] = $configuraciones_sistemas->smtp_port;
				$params["auth"] = true;
				$params["username"] = $configuraciones_sistemas->smtp_user;
				$params["password"] = $configuraciones_sistemas->smtp_pass;
			    $mail = Mail::factory($configuraciones_sistemas->protocol, $params); 
			    $mail->send($recipient, $headers, $body);	
				if (PEAR::isError($mail)) 
				{
					echo '<p align="center"> Ha ocurrido un error al intentar enviar el correo electrónico, por favor intente nuevamente.</p>'; 
				}
				else
				{
					echo '<p align="center">Hemos Enviado un Correo Electrónico a: <b>'.$contratos->correo_electronico.'</b> Notificandole su culminación de periodo de prueba.</p>';
				}	
				//echo $html;  
			}
			endforeach;
		}
		else
		{
			echo "No hemos encontrados finalizaciones de periodos de prueba de los empleados.";
		}
		//var_dump($traer_contratos);
    }

    public function Verificar_Cierre_Hora_Salida_Madrid()
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
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
		$dia_numero= date('d');
		$mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');		
		$ano=date('Y');
		$hora_nueva=date('G:i:s');		
		$pais="España, ";		
		$total= $dia[date('l')];
		$numero_final=" ".$dia_numero;		
		$mes_final=" ".$mes[date('m')];		
		$ano_final= " ".$ano;	
		$todo_unido=$pais.$total.$numero_final.$mes_final.$ano_final;
		$madrid=6;		
		$configuraciones_sistemas = $this->Verificador_model->get_configuraciones();
		$buscar_hora_salida_null=$this->Verificador_model->get_hora_salida_null();
		$acumulador=0;
		//echo $hora_nueva=date('G:i:s');
		if($buscar_hora_salida_null!=false)
		{
			foreach ($buscar_hora_salida_null as $salida_null => $salidas_null)
			{
				//var_dump($salidas_null->huser,$salidas_null->fecha);
				$buscar_cierre_app=	$this->Verificador_model->get_hora_cierre_app($salidas_null->huser,$salidas_null->fecha,$madrid);
				if($buscar_cierre_app!=false)
				{
					//var_dump($buscar_cierre_app);
					foreach ($buscar_cierre_app as $cierra_app => $cierre_app_null): 
					{
						$acumulador	=$acumulador+1;
						$arrayName = array('acumulador' =>$acumulador,'hasistencia' =>$salidas_null->id,'nombres'=>$cierre_app_null->nombres,'apellidos'=>$cierre_app_null->apellidos,'hora_entrada'=>$salidas_null->horario_entrada,'hora_cierre'=>$cierre_app_null->hora_cierre,'huser'=>$salidas_null->huser,'hoficina'=>$cierre_app_null->nombre_oficina );
					}
					//var_dump($arrayName);						
					$cerrar_asistencia=$this->Verificador_model->cerrar_asistencia_madrid($arrayName['hasistencia'],$arrayName['hora_cierre'],$arrayName['huser']);

					if($cerrar_asistencia!=false)
					{
						echo "<p align='center'>Se ha registrado la ultima hora del cierre de la app de escritorio a la hora de salida de los empleados</p><br>";
					}
					else
					{
						echo "Algo Salio mal";
					}

					endforeach;					
				}
				else
				{
					//var_dump($buscar_cierre_app);
					echo "<p align='center'>No hay datos que actualizar para esta oficina</p>";
					//break;
				}
			}

		}
		else
		{
			echo 'no hemos encontrados registros pendientes';
		}
		//$fecha_consulta=date('Y-m-d');
		//$fecha_consulta_hasta = date("Y-m-d",strtotime($fecha_consulta.'+ 7 day' ));
    }
    public function Verificar_Cierre_Hora_Salida_Latino_America()
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
		$dia = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
		$dia_numero= date('d');
		$mes = array('01'=>'Enero','2'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre',
		'11'=>'Noviembre','12'=>'Diciembre');		
		$ano=date('Y');
		$hora_nueva=date('G:i:s');		
		$pais="España, ";		
		$total= $dia[date('l')];
		$numero_final=" ".$dia_numero;		
		$mes_final=" ".$mes[date('m')];		
		$ano_final= " ".$ano;	
		$todo_unido=$pais.$total.$numero_final.$mes_final.$ano_final;
		$oficina=5;		
		$configuraciones_sistemas = $this->Verificador_model->get_configuraciones();
		$buscar_hora_salida_null=$this->Verificador_model->get_hora_salida_null_latino($oficina);
		$acumulador=0;
		//echo $hora_nueva=date('G:i:s');
		if($buscar_hora_salida_null!=false)
		{
			foreach ($buscar_hora_salida_null as $salida_null => $salidas_null)
			{
				//var_dump($salidas_null->huser,$salidas_null->fecha);
				$buscar_cierre_app=	$this->Verificador_model->get_hora_cierre_app_latino($salidas_null->huser,$salidas_null->fecha,$oficina);
				if($buscar_cierre_app!=false)
				{
					//var_dump($buscar_cierre_app);
					foreach ($buscar_cierre_app as $cierra_app => $cierre_app_null): 
					{
						$acumulador	=$acumulador+1;
						$arrayName = array('acumulador' =>$acumulador,'hasistencia' =>$salidas_null->id,'nombres'=>$cierre_app_null->nombres,'apellidos'=>$cierre_app_null->apellidos,'hora_entrada'=>$salidas_null->horario_entrada,'hora_cierre'=>$cierre_app_null->hora_cierre,'huser'=>$salidas_null->huser,'hoficina'=>$cierre_app_null->nombre_oficina );
					}
					//var_dump($arrayName);						
					$cerrar_asistencia=$this->Verificador_model->cerrar_asistencia_madrid($arrayName['hasistencia'],$arrayName['hora_cierre'],$arrayName['huser']);

					if($cerrar_asistencia!=false)
					{
						echo "<p align='center'>Se ha registrado la ultima hora del cierre de la app de escritorio a la hora de salida de los empleados</p><br>";
					}
					else
					{
						echo "Algo Salio mal";
					}

					endforeach;					
				}
				else
				{
					//var_dump($buscar_cierre_app);
					echo "<p align='center'>No hay datos que actualizar para esta oficina</p>";
					//break;
				}
			}

		}
		else
		{
			echo 'no hemos encontrados registros pendientes';
		}
		//$fecha_consulta=date('Y-m-d');
		//$fecha_consulta_hasta = date("Y-m-d",strtotime($fecha_consulta.'+ 7 day' ));
    }


}

?>