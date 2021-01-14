<?php
class Reportes_model extends CI_Model 
{ 
	  public function get_configuraciones_sistemas()
    {
        $this->db->select('*');
        $this->db->from('tblconfiguracionessistemas');              
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
     public function datos_del_usuario($usuario)
    {
        $this->db->select('a.nombres,a.apellidos,a.usuario,a.dni,a.correo_electronico,a.nivel,DATE_FORMAT(fecha_registro, "%d/%m/%Y") as fecha_registro,b.nombre_oficina');
        $this->db->from('tblusuarios a');
        $this->db->join('tbloficinas b','a.hoficina=b.id');       
        $this->db->where('a.id',$usuario);      
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
    public function get_detalle_tabla_acceso_departamentos($huser)
    {
        $this->db->order_by('nombre_departamento asc');
        $this->db->distinct();
        $this->db->select('nombre_departamento');
        $this->db->from('tbldepartamentos a');
        $this->db->join('tbldetalleusuariosdepartamentos b','a.id=b.hdepartamento');
        $this->db->where('b.huser',$huser);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
    }
     public function get_detalle_tabla_acceso_carpetas($huser)
    {
        $this->db->order_by('nombre_carpeta asc');
        $this->db->distinct();
        $this->db->select('nombre_carpeta');
        $this->db->from('tblcarpetas a');
        $this->db->join('tbldetalleaccesousuario b','a.id=b.hcarpeta');
        $this->db->where('b.huser',$huser);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
    }
    public function get_detalle_tabla_acceso_sistemas($huser)
    {
        $this->db->order_by('nombre_sistema asc');
        $this->db->distinct();
        $this->db->select('nombre_sistema,url_sistema');
        $this->db->from('tblsistemas a');
        $this->db->join('tbldetalleaccesosistemas b','a.id=b.hsistema');
        $this->db->where('b.huser',$huser);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
      
    }
     public function get_detalle_controladores($huser)
    {
        $this->db->order_by('controller asc');
        $this->db->distinct();
        $this->db->select('controller');
        $this->db->from('access');
        //$this->db->join('tbldetalleaccesosistemas b','a.id=b.hsistema');
        $this->db->where('huser',$huser);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
      
    }
     public function nombre_carpeta($hcarpeta)
    {
        $this->db->select('nombre_carpeta');
        $this->db->from('tblcarpetas');
        $this->db->where('id',$hcarpeta);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();              
        }
        return false;     
    }
     public function get_users_folders($hcarpeta)
    {
        $this->db->select('a.nombres,a.apellidos,c.nombre_oficina');
        $this->db->from('tblusuarios a');
        $this->db->join('tbldetalleaccesousuario b','a.id=b.huser');
        $this->db->join('tbloficinas c','a.hoficina=c.id');
        $this->db->where('b.hcarpeta',$hcarpeta); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
           return $query->result();
        }
        return false;   
    }
     public function get_users_room($hcarpeta)
    {
        $this->db->select('a.nombre_departamento');
        $this->db->from('tbldepartamentos a');
        $this->db->join('tbldetalleperfilescarpetas b','a.id=b.hperfil');
        $this->db->where('hcarpeta',$hcarpeta);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
           return $query->result();
        }
        return false;
    }
     public function nombre_perfil($hdepartamento)
    {
        $this->db->select('nombre_departamento');
        $this->db->from('tbldepartamentos');
        $this->db->where('id',$hdepartamento);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();              
        }
        return false;     
    }
    public function get_users_departamentos($hdepartamento)
    {
        $this->db->select('a.nombres,a.apellidos,c.nombre_oficina');
        $this->db->from('tblusuarios a');
        $this->db->join('tbldetalleusuariosdepartamentos b','a.id=b.huser');
        $this->db->join('tbloficinas c','a.hoficina=c.id');
        $this->db->where('b.hdepartamento',$hdepartamento); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
           return $query->result();
        }
        return false;   
    }
    public function get_users_folders_pertenecen($hdepartamento)
    {
        $this->db->select('a.nombre_carpeta');
        $this->db->from('tblcarpetas a');
        $this->db->join('tbldetalleperfilescarpetas b','a.id=b.hcarpeta');
        //$this->db->join('tbloficinas c','a.hoficina=c.id');
        $this->db->where('hperfil',$hdepartamento);
        $this->db->order_by('a.nombre_carpeta asc'); 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
           return $query->result();
        }
        return false;   
    }
     public function get_contratos($huser)
    {
        $this->db->select('id,DATE_FORMAT(fecha_inicio_contrato, "%d/%m/%Y") as fecha_inicio_contrato,DATE_FORMAT(fecha_perioro_prueba, "%d/%m/%Y") as fecha_perioro_prueba,DATE_FORMAT(fecha_fin_contrato, "%d/%m/%Y") as fecha_fin_contrato,estatus');
        $this->db->from('tblcontratos');
        $this->db->where('huser',$huser);
        $this->db->where('estatus',1); 
        //$this->db->or_where('usuario',$correo_usuario);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        return false;   
    }
    public function get_horarios_entradas($huser)
    {
        $this->db->select('*');
        $this->db->from('tblhorariosusuarios');
        $this->db->where('huser',$huser); 
        //$this->db->or_where('usuario',$correo_usuario);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        return false;   
    }
    public function buscar_fechas_vacaciones($huser,$hcontrato)
    {
       $this->db->order_by('estatus asc'); 
        $this->db->select('id as hvacaciones,DATE_FORMAT(fecha_desde, "%d/%m/%Y" ) as fecha_desde,DATE_FORMAT(fecha_hasta, "%d/%m/%Y" ) as fecha_hasta,dias_vacaciones,estatus');
        $this->db->from('tbldetallevacacionesusuarios');
        $this->db->where('huser',$huser);
        $this->db->where('hcontrato',$hcontrato);
        //$this->db->where('estatus',1);
        //$this->db->or_where('usuario',$correo_usuario);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;   
    }
     public function get_detalle_dias_laborables($hhorario,$huser)
    {
        $this->db->order_by('orden asc'); 
        $this->db->select('hdia as id,dia_laborable,orden,hora_entrada,hora_salida');
        $this->db->from('tbldetallehorariosusuarios');
        $this->db->where('hhorario',$hhorario);
        $this->db->where('huser',$huser);
        //$this->db->or_where('usuario',$correo_usuario);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;   
    }
     public function get_asistencia_rango_fecha($huser,$desde,$hasta)
    {
          $sql=$this->db->query("SELECT repo.id,date_format(repo.fecha,'%d-%m-%Y') as fecha,date_format(repo.horario_entrada,'%H:%i:%s') as horario_entrada,date_format(repo.horario_salida,'%H:%i:%s') as horario_salida,repo.huser,repo.total_jornada,repo.type,repo.breaks,repo.reunion,repo.inactividad,
SEC_TO_TIME((ifnull(time_to_sec(repo.total_jornada),0)-ifnull(time_to_sec(repo.breaks),0)-ifnull(time_to_sec(repo.inactividad),0))) total_horas
from
(SELECT a.id,a.fecha,a.horario_entrada,a.horario_salida,a.huser,a.TYPE,

TIMEDIFF(DATE_FORMAT(horario_salida,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(horario_entrada,'%Y-%m-%d %H:%i:%s')) as total_jornada,
(SELECT sec_to_time(sum(time_to_sec(c.total_breaks))) FROM view_breaks c
    WHERE a.id=c.hasistencia) breaks,
(SELECT sec_to_time(sum(time_to_sec(d.reuniones_entrada)-time_to_sec(d.reuniones_salida))) FROM tblreuniones d
    WHERE a.id=d.hasistencia) reunion,
(SELECT sec_to_time(SUM(e.tiempo_inactivo)) FROM tblinactividad e
    WHERE a.id=e.hasistencia) inactividad
FROM tblcontrolasistencia a ) repo WHERE repo.huser='$huser' AND repo.fecha BETWEEN '$desde' AND '$hasta' ORDER BY repo.horario_entrada DESC");        
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }
      public function sum_asistencia($huser,$desde,$hasta)
    {
          $sql=$this->db->query("SELECT SEC_TO_TIME(SUM((TIME_TO_SEC(total_jornada)))) AS total_empleado FROM view_sum_all_jornada WHERE fecha BETWEEN '$desde' AND '$hasta' AND huser='$huser'");        
        if($sql->num_rows()>0)
        {
            return $sql->row();
        }
        else
        {
            return false;
        }
    }
    public function get_breaks_rango_fecha($hasistencia)
    {
          $sql=$this->db->query("SELECT hasistencia,DATE_FORMAT(break_salida, '%H:%i:%s') as break_salida,DATE_FORMAT(break_entrada,'%H:%i:%s') as break_entrada,DATE_FORMAT(fecha, '%d/%m/%Y') as fecha,type from tblbreaks where hasistencia='$hasistencia'");        
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }
    public function get_reuniones_rango_fecha($hasistencia)
    {
          $sql=$this->db->query("SELECT hasistencia,DATE_FORMAT(reuniones_salida, '%H:%i:%s') as reuniones_salida,DATE_FORMAT(reuniones_entrada,'%H:%i:%s') as reuniones_entrada,DATE_FORMAT(fecha, '%d/%m/%Y') as fecha,type,estatus_reuniones from tblreuniones where hasistencia='$hasistencia'");        
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }
    public function get_inactividades_rango_fecha($hasistencia)
    {
          $sql=$this->db->query("SELECT tiempo_inactivo,fecha,hora_inactividad,hasistencia from tblinactividad where hasistencia='$hasistencia'");        
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }
         public function get_reporte_general($desde,$hasta)
    {
        $sql=$this->db->query("SELECT a.id,a.nombres,a.apellidos,
 (
SELECT SEC_TO_TIME(SUM((TIME_TO_SEC(total_jornada)))) AS total_empleado
FROM view_sum_all_jornada b
WHERE a.id=b.huser AND b.fecha BETWEEN '$desde' AND '$hasta') AS total_jornada, (
SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(b.break_entrada)- TIME_TO_SEC(b.break_salida)))
FROM tblbreaks b
WHERE b.fecha BETWEEN '$desde' AND '$hasta' AND b.huser = a.id) AS total_break, (
SELECT SEC_TO_TIME(SUM(e.tiempo_inactivo))
FROM tblinactividad e
WHERE a.id=e.huser AND e.fecha BETWEEN '$desde' AND '$hasta') inactividad, 

 (SELECT SEC_TO_TIME((IFNULL(TIME_TO_SEC(total_break),0) + IFNULL(TIME_TO_SEC(inactividad),0))))    AS descuento,


(SELECT SEC_TO_TIME((IFNULL(TIME_TO_SEC(total_jornada),0) - IFNULL(TIME_TO_SEC(descuento),0)))) AS total_con_descuento

FROM tblusuarios a  ORDER BY a.nombres,a.apellidos ASC");        
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else
        {
             return false;
        }  
        /**/
    }
}
?>