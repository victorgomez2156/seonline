<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuarios_model extends CI_Model 
{
    public function agregar($nombres,$apellidos,$usuario,$correo_electronico,$nivel,$contrasena,$re_contrasena,$hoficina,$bloqueado,$apikey)
    {
        $this->db->insert('tblusuarios',array('nombres'=>$nombres,'apellidos'=>$apellidos,'usuario'=>$usuario,'correo_electronico'=>$correo_electronico,'contrasena'=>$contrasena,'key'=>$apikey,'bloqueado'=>$bloqueado,'nivel'=>$nivel,'hoficina'=>$hoficina));
        return $this->db->insert_id();
    }
     public function agregar_acceso_carpetas_masivo($hcarpeta,$hdepartamento,$huser)
    {
        $this->db->insert('tbldetalleaccesousuario',array('hdepartamento'=>$hdepartamento,'hcarpeta'=>$hcarpeta,'huser'=>$huser));
        return $this->db->insert_id();
    }  
     public function agregar_acceso_departamentos_masivo($hdepartamento,$huser)
    {
        $this->db->insert('tbldetalleusuariosdepartamentos',array('hdepartamento'=>$hdepartamento,'huser'=>$huser));
        return $this->db->insert_id();
    } 
    public function agregar_acceso_sistemas_masivo($hsistema,$huser)
    {
        $this->db->insert('tbldetalleaccesosistemas',array('hsistema'=>$hsistema,'huser'=>$huser));
        return $this->db->insert_id();
    } 
    public function agregar_acceso_sistemas_masivo_credenciales($hsistema,$huser,$usuario_sistema,$contrasena_sistema,$contrasena_sin_codificar,$notas,$coordinador,$usuario)
    {      
        if($coordinador==null)
        {
            $coordinador=0;
        }
        if($usuario==null)
        {
            $usuario=0;
        }
        $this->db->insert('tbldetalleaccesosistemas',array('hsistema'=>$hsistema,'huser'=>$huser,'usuario_sistema'=>$usuario_sistema,'contrasena_sistema'=>$contrasena_sistema,'contrasena_sin_codificar'=>$contrasena_sin_codificar,'notas'=>$notas,'coordinador'=>$coordinador,'usuario'=>$usuario));
        return $this->db->insert_id();
    } 
    public function agregar_acceso_controlador_masivo($controller,$huser,$key)
    {
        $this->db->insert('access',array('key'=>$key,'controller'=>$controller,'huser'=>$huser));
        return $this->db->insert_id();
    }  
    public function actualizar($id,$nombres,$apellidos,$usuario,$correo_electronico,$nivel,$hoficina,$bloqueado)
    {
           
        $this->db->where('id', $id);        
        return $this->db->update('tblusuarios',array('nombres'=>$nombres,'apellidos'=>$apellidos,'usuario'=>$usuario,'correo_electronico'=>$correo_electronico,'bloqueado'=>$bloqueado,'nivel'=>$nivel,'hoficina'=>$hoficina));
    }
    public function agregar_credenciales_sistemas($hdetalleaccesosistema,$usuario_sistema,$contrasena,$notas,$coordinador,$usuario)
    {           
        /*$this->db->where('id', $id);        
        return $this->db->update('tblcredencialessistemas',array('usuario_sistema'=>$usuario_sistema,'contrasena_sistema'=>md5($contrasena),'notas'=>$notas,'coordinador'=>$coordinador,'usuario'=>$usuario,'contrasena_sin_codificar'=>$contrasena));*/
         $this->db->insert('tblcredencialessistemas',array('hdetalleaccesosistema'=>$hdetalleaccesosistema,'usuario_sistema'=>$usuario_sistema,'contrasena_sistema'=>md5($contrasena),'notas'=>$notas,'coordinador'=>$coordinador,'usuario'=>$usuario,'contrasena_sin_codificar'=>$contrasena));
        return $this->db->insert_id();
    }
    public function update_contrasena($huser,$contrasena)
    {           
        $this->db->where('id', $huser);        
        return $this->db->update('tblusuarios',array('contrasena'=>$contrasena));
    }
    public function get_usuarios_bloqueado($usuario)
    {
        $this->db->select('*');
        $this->db->from('tblusuarios');       
        $this->db->where('usuario',$usuario);         
        $this->db->where('bloqueado',1);
        $this->db->or_where('correo_electronico',$usuario);
        $this->db->where('bloqueado',1);       
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function comprobar_usuario_sistemas_credencial($usuario)
    {
        $this->db->select('usuario_sistema');
        $this->db->from('tblcredencialessistemas');       
        $this->db->where('usuario_sistema',$usuario);
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return true;
        }
        else
        {
            return false;
        }       
    }
     public function get_usuarios_buscar($usuario)
    {
        $this->db->select('*');
        $this->db->from('tblusuarios');       
        $this->db->where('usuario',$usuario);
        $this->db->or_where('correo_electronico',$usuario);              
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_oficina($hoficina)
    {
        $this->db->select('*');
        $this->db->from('tbloficinas');       
        $this->db->where('id',$hoficina);             
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function get_usuario($usuario,$contrasena)
    {
        $this->db->select('*');
        $this->db->from('tblusuarios');       
        $this->db->where('usuario',$usuario);
        $this->db->where('contrasena',$contrasena);
        $this->db->or_where('correo_electronico',$usuario); 
        $this->db->where('contrasena',$contrasena); 
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_detalle_carpeta_all($usuario)
    {
        $this->db->order_by('nombre_carpeta asc');
        $this->db->select('b.id as id_detalle_acceso,c.nombre_departamento,b.hdepartamento,d.nombre_carpeta,b.hcarpeta as id');
        $this->db->from('tblusuarios a'); 
        $this->db->join('tbldetalleaccesousuario b','a.id=b.huser');
        $this->db->join('tbldepartamentos c','c.id=b.hdepartamento');
        $this->db->join('tblcarpetas d','d.id=b.hcarpeta');       
        $this->db->where('b.huser',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
     public function get_count_departamentos($usuario)
    {
        $this->db->select('count(id) as total_departamentos');
        $this->db->from('tbldetalleusuariosdepartamentos');          
        $this->db->where('huser',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_count_carpetas($usuario)
    {
        $this->db->select('count(id) as total_carpetas');
        $this->db->from('tbldetalleaccesousuario');          
        $this->db->where('huser',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_count_sistemas($usuario)
    {
        $this->db->select('count(id) as total_sistemas');
        $this->db->from('tbldetalleaccesosistemas');          
        $this->db->where('huser',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_count_controladores($usuario)
    {
        $this->db->select('count(id) as total_controladores');
        $this->db->from('access');          
        $this->db->where('huser',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_detalle_departamento_all($usuario)
    {
        $this->db->order_by('nombre_departamento asc');
        $this->db->select('a.hdepartamento as id,b.nombre_departamento');
        $this->db->from('tbldetalleusuariosdepartamentos a'); 
        //$this->db->join('tbldetalleaccesousuario b','a.id=b.huser');
        $this->db->join('tbldepartamentos b','b.id=a.hdepartamento');
        //$this->db->join('tblcarpetas d','d.id=b.hcarpeta');       
        $this->db->where('a.huser',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }      
    }
    public function get_detalle_sistema_all($usuario)
    {
        $this->db->order_by('nombre_sistema asc');
        $this->db->select('b.id as id_principal,b.hsistema as id,a.nombre_sistema,a.url_sistema');
        $this->db->from('tblsistemas a');
        $this->db->join('tbldetalleaccesosistemas b','b.hsistema=a.id');
        $this->db->where('b.huser',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }      
    }
     public function get_detalle_controladores_all($usuario)
    {
        $this->db->order_by('controller asc');
        $this->db->select('b.id,a.controller');
        $this->db->from('access a');
        $this->db->join('controllers b','b.controller=a.controller');
        $this->db->where('a.huser',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }      
    }
    public function consultar_cookie($cookie)
    {
        $this->db->select('*');
        $this->db->from('tblsesion');       
        $this->db->order_by('id');
        $this->db->where('cookie',$cookie);       
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function sesion_cookies($huser,$hempresa,$nivel,$ip,$agent,$version,$os,$cookie)
    {
     
        $final=$this->db->insert('tblsesion',array('huser'=>$huser,'hempresa'=>$hempresa,'hnivel'=>$nivel,'ip'=>$ip,'navegador'=>$agent,'version'=>$version,'os'=>$os,'cookie'=>$cookie));
        return $final;
    }
    public function actualizar_cookie($huser,$nivel,$ip,$agent,$version,$os,$cookie)
    {
        $this->db->where('cookie', $cookie);      
        return $this->db->update('tblsesion',array('huser'=>$huser,'hnivel'=>$nivel,'estatus'=>0));
    }
    public function all_users()
    {
        $this->db->order_by('nombres,apellidos,nivel asc');
        $this->db->select('id,nombres,apellidos,usuario,correo_electronico,key,bloqueado,nivel,hoficina,telefono,bloqueado,DATE_FORMAT(fecha_registro, "%d/%m/%y" " %H:%i:%s") as fecha_registro,dni');
        $this->db->from('tblusuarios');                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function get_filtro_departamentos($hdepartamento)
    {
        $this->db->order_by('c.nombre_departamento asc');
        $this->db->select('b.id, b.nombre_carpeta,c.nombre_departamento,c.id as hdepartamento');
        $this->db->from('tbldetalleperfilescarpetas a');
        $this->db->join('tblcarpetas b','b.id=a.hcarpeta');
        $this->db->join('tbldepartamentos c','c.id=a.hperfil');
        $this->db->where('a.hperfil',$hdepartamento);
        $this->db->where('b.estatus',1);                
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function count_carpetas_perfiles($hpefil)
    {
        $this->db->select('count(a.id) as total_carpetas');
        $this->db->from('tblcarpetas a');
        $this->db->join('tbldetalleperfilescarpetas b','a.id=b.hcarpeta');
        $this->db->where('b.hperfil',$hpefil);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }      
    }
     public function get_contrasena_level($id)
    {
        $this->db->select('contrasena_sin_codificar');
        $this->db->from('tbldetalleaccesosistemas');
        $this->db->where('id',$id);
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function get_departamentos()
    {
        $this->db->order_by('nombre_departamento asc');
        $this->db->select('*');
        $this->db->from('tbldepartamentos');       
        $this->db->where('estatus',1);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
     public function get_sistemas()
    {
        $this->db->order_by('nombre_sistema asc'); 
        $this->db->select('*');
        $this->db->from('tblsistemas');       
        $this->db->where('estatus',1);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function get_controladores()
    {
        $this->db->order_by('controller asc');
        $this->db->select('*');
        $this->db->from('controllers');       
        //$this->db->where('estatus',1);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function all_users_active()
    {
        $this->db->order_by('nombres,apellidos asc');
        $this->db->select('id,nombres,apellidos,usuario,correo_electronico,key,bloqueado,nivel,hoficina,telefono,bloqueado,DATE_FORMAT(fecha_registro, "%d/%m/%y" " %H:%i:%s") as fecha_registro,dni');
        $this->db->from('tblusuarios');
        $this->db->where('bloqueado',1);              
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function all_users_disabled()
    {
        $this->db->order_by('nombres,apellidos asc');
        $this->db->select('id,nombres,apellidos,usuario,correo_electronico,key,bloqueado,nivel,hoficina,telefono,bloqueado,DATE_FORMAT(fecha_registro, "%d/%m/%y" " %H:%i:%s") as fecha_registro,dni');
        $this->db->from('tblusuarios'); 
        $this->db->where('bloqueado>',1);            
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
     public function all_office()
    {
        $this->db->select('*');
        $this->db->from('tbloficinas');             
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function get_dni_users($correo_electronico)
    {
        $this->db->select('id,nombres,apellidos,usuario,correo_electronico,key,bloqueado,nivel,hoficina,telefono,bloqueado,DATE_FORMAT(fecha_registro, "%d/%m/%y" " %H:%i:%s") as fecha_registro,dni');
        $this->db->from('tblusuarios');       
        $this->db->where('correo_electronico',$correo_electronico);       
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_users_comprobar($usuario)
    {
        $this->db->select('usuario');
        $this->db->from('tblusuarios');       
        $this->db->where('usuario',$usuario);       
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function get_email_comprobar($correo_electronico)
    {
        $this->db->select('correo_electronico');
        $this->db->from('tblusuarios');       
        $this->db->where('correo_electronico',$correo_electronico);      
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function eliminar($id)
    {
        $this->db->delete('keys', array('huser' => $id));
        $this->db->delete('tbldetalleaccesousuario', array('huser' => $id));
        $this->db->delete('tbldetalleusuariosdepartamentos', array('huser' => $id));
        //$this->db->delete('tbldetalleaccesosistemas', array('huser' => $id));
        $this->db->delete('access', array('huser' => $id));
        return $this->db->delete('tblusuarios', array('id' => $id));
    }
     public function eliminar_all_detalle($huser)
    {
            //$this->db->delete('tbldetalleaccesosistemas', array('huser' => $huser));
             return $this->db->delete('access', array('huser' => $huser));
            // $this->db->delete('tbldetalleusuariosdepartamentos', array('huser' => $huser));
            // $this->db->delete('tbldetalleaccesousuario', array('huser' => $huser));
    }
     public function buscar_sistemas()
    {
        $this->db->select('*');
        $this->db->from('tbldetalleaccesosistemas');                     
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function buscar_id_detalle_acceso($hsistema,$huser)
    {
        $this->db->select('*');
        $this->db->from('tbldetalleaccesosistemas');       
        $this->db->where('hsistema',$hsistema);
        $this->db->where('huser',$huser);                      
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function count_notificaciones_get()
    {
        $this->db->select('count(id) as total_notificaciones');
        $this->db->from('view_notificaciones');               
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
      public function notificaciones_get()
    {
        $this->db->select('a.id,a.horario_entrada,a.horario_salida,a.fecha,a.type,a.estatus,b.nombres,b.apellidos,a.total_jornada');
        $this->db->from('view_notificaciones a');
        $this->db->join('tblusuarios b','a.huser=b.id');
        $this->db->order_by('horario_entrada DESC');       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
   public function update_asistencia($id,$estatus,$hora_salida)
    {
        //var_dump($id,$estatus);
        $this->db->where('id', $id);
        return $this->db->update('tblcontrolasistencia',array('estatus'=>$estatus,'horario_salida'=>$hora_salida));
    }
    public function update_break($id,$estatus,$break_entrada)
    {
        //var_dump($id,$estatus);
        $this->db->where('id', $id);
        return $this->db->update('tblbreaks',array('estatus_breaks'=>$estatus,'break_entrada'=>$break_entrada));
    }
    public function update_reunion($id,$estatus,$reunion_entrada)
    {
        //var_dump($id,$estatus);
        $this->db->where('id', $id);
        return $this->db->update('tblreuniones',array('estatus_reuniones'=>$estatus,'reuniones_entrada'=>$reunion_entrada));
    }





























## EN EVALUACION PARA SU FUNCIONAMIENTO

    public function get_Menu($usuario)
    {   
        $this->db->order_by('id,hpadre','asc');
        $this->db->where('huser',$usuario);
        $query = $this->db->get('tblmenu');
        return $query->result();
    }
    public function consultar_lista_sesiones($huser)
    {
        $this->db->select('a.id,b.nombres,b.apellidos,c.nombre as empresa,a.ip,a.navegador,a.version,a.os,a.cookie,DATE_FORMAT(a.fecha_sesion, "%d/%m/%y" " %H:%i:%s") as fecha_sesion,DATE_FORMAT(a.fecha, "%d/%m/%y" " %H:%i:%s") as fecha_creada,a.estatus,a.huser');
        $this->db->from('tblsesion a');
        $this->db->join('tblusuarios b','b.id=a.huser');
        $this->db->join('tbldependencias c','a.hempresa=c.id');        
        $this->db->order_by('fecha_sesion desc,estatus asc');
        $this->db->where('a.huser',$huser);      
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
     public function get_dni_comprobrar($dni)
    {
        $this->db->select('dni');
        $this->db->from('tblusuarios');      
        $this->db->where('dni',$dni);        
         $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_correo_comprobrar($usuario)
    {
        $this->db->select('usuario');
        $this->db->from('tblusuarios');      
        $this->db->where('usuario',$usuario);        
         $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
     public function get_comprobrar_contrasena($huser,$contrasena)
    {
        $this->db->select('contrasena');
        $this->db->from('tblusuarios');       
        $this->db->where('id',$huser);        
        $this->db->where('contrasena',$contrasena);
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function get_perfil_cliente($huser)
    {
        $this->db->select('id,nombres,apellidos,dni,usuario,telefono,imagen,hempresa,nivel,bloqueado,foto_por_album,DATE_FORMAT(fecha_miembro, "%d/%m/%y" " %H:%i:%s") as fecha_miembro,direccion,contrasena,key');
        $this->db->from('tblusuarios');       
        $this->db->where('id',$huser);       
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }       
    }
    public function get_empresas()
    {
        $this->db->select('*');
        $this->db->from('tbldependencias');       
        //$this->db->where('id',$huser);       
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }       
    }
    public function cerrar_session_remota($id,$huser,$cookie)
    {
        $this->db->where('id', $id);
        $this->db->where('huser', $huser);
        $this->db->where('cookie', $cookie);
        return $this->db->update('tblsesion',array('estatus'=>1));
    }
    public function actualizar_contrasena($id,$contrasena,$contrasena_sin_cifrar)
    {
        $this->db->where('id', $id);    
        return $this->db->update('tblusuarios',array('contrasena'=>$contrasena,'contrasena_sin_cifrar'=>$contrasena_sin_cifrar));
    }
     public function actualizar_datos($id,$dni,$nombres,$apellidos,$usuario,$direccion,$telefono,$hempresa)
    {
        $this->db->where('id', $id);
        return $this->db->update('tblusuarios',array('nombres'=>$nombres,'apellidos'=>$apellidos,'dni'=>$dni,'usuario'=>$usuario,'telefono'=>$telefono,'hempresa'=>$hempresa,'direccion'=>$direccion));
    }

    public function actualizar_estado_sesion($cookie,$huser)
    {
        $this->db->where('cookie', $cookie);
        $this->db->where('huser',$huser);
       
         return $this->db->update('tblsesion',array('estatus'=>1));
    }

 	public function get_numero_identificacion($numero_identificacion)
    {
		  $consulta = $this->db->query("SELECT usuario,nombres,apellidos FROM tblusuarios WHERE dni like '%$numero_identificacion%'");
        if ($consulta->num_rows() > 0)
        {
            return $consulta->row();
        }
        return false;
    }    
    public function obtener_contrasena($email)
    {
		$consulta = $this->db->query("SELECT contrasena_sin_cifrar,nombres,apellidos FROM tblusuarios WHERE usuario='$email'");
        if ($consulta->num_rows() > 0)
        {
            return $consulta->row();
        }
        return false;
    }
}