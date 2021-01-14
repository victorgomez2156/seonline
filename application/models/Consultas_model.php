<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Consultas_model extends CI_Model 
{
   public function get_all_datos($huser)
    {
        $this->db->select('id,nombres,apellidos,usuario');
        $this->db->from('tblusuarios');
        $this->db->where('id',$huser); 
        //$this->db->or_where('usuario',$correo_usuario);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        return false;   
    }
    public function list_folders()
    {
        $this->db->order_by('nombre_carpeta asc');
        $this->db->select('id,nombre_carpeta');
        $this->db->from('tblcarpetas');
        //$this->db->where('id',$hdepartamento);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
    }
     public function list_users()
    {
        $this->db->order_by('nombres,apellidos asc');
        $this->db->select('id,nombres,apellidos,usuario');
        $this->db->from('tblusuarios');
        //$this->db->where('id',$hdepartamento);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
    }
      public function list_departamentos()
    {
        $this->db->order_by('nombre_departamento asc');
        $this->db->select('id,nombre_departamento');
        $this->db->from('tbldepartamentos');
        //$this->db->where('id',$hdepartamento);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
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
    public function get_users_departamentos($hdepartamento)
    {
        $this->db->distinct();
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
     public function get_users_room($hcarpeta)
    {
        $this->db->distinct();
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
     public function get_users_folders_pertenecen($hdepartamento)
    {
        $this->db->distinct();
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
   
    public function get_departamentos($hdepartamento)
    {
        $this->db->order_by('id asc');
        $this->db->select('id,nombre_departamento');
        $this->db->from('tbldepartamentos');
        $this->db->where('id',$hdepartamento);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();              
        }
        return false;
    }
    
    public function get_carpetas($hdepartamento,$hcarpeta)
    {
        $this->db->order_by('a.id asc');
        $this->db->select('a.nombre_carpeta,b.nombre_departamento');
        $this->db->from('tblcarpetas a');
        $this->db->join('tbldepartamentos b','b.id='.$hdepartamento.'');
        $this->db->where('a.id',$hcarpeta);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();              
        }
        return false;
    }
    public function get_detalle_tabla_acceso_sistemas($huser)
    {
        $this->db->order_by('nombre_sistema asc');
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
    public function get_sistemas($hsistema)
    {
        $this->db->order_by('id asc');
        $this->db->select('*');
        $this->db->from('tblsistemas');
        //$this->db->join('tbldepartamentos b','b.id='.$hdepartamento.'');
        $this->db->where('id',$hsistema);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();              
        }
        return false;
    }
     public function get_usuarios($huser)
    {
        
        foreach ($huser as $record):
        {           
            $this->db->order_by('id asc');
            $this->db->select('*');
            $this->db->from('tblusuarios');          
            $this->db->where('id',$record->huser);
            $query = $this->db->get(); 
            if($query->num_rows()>0)
            {
                return $query->result();              
            }
            return false;
        }
        endforeach;

    }
    public function get_datos_users($huser)
    {
        $this->db->select('id,nombres,apellidos');
        $this->db->from('tblusuarios');       
        $this->db->where('id',$huser); 
        $query = $this->db->get(); 
        if($query->num_rows()==1)
        {
           return $query->row();
        }
        return false;   
        
    }
     public function get_asistencias($huser,$desde,$hasta)
    {
          $sql=$this->db->query("SELECT id, DATE_FORMAT(horario_entrada,'%H:%i:%s') AS hora_entrada, DATE_FORMAT(horario_salida,'%H:%i:%s') AS hora_salida,TIMEDIFF(DATE_FORMAT(horario_salida,'%Y-%m-%d %H:%i:%s'), DATE_FORMAT(horario_entrada,'%Y-%m-%d %H:%i:%s')) AS total_trabajadas, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, TYPE FROM tblcontrolasistencia WHERE huser='$huser' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY horario_entrada DESC");        
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
          $sql=$this->db->query("SELECT SEC_TO_TIME(SUM((TIME_TO_SEC(total_jornada)))) AS total_empleado FROM view_control_asistencia WHERE fecha BETWEEN '$desde' AND '$hasta' AND huser='$huser'");        
        if($sql->num_rows()>0)
        {
            return $sql->row();
        }
        else
        {
            return false;
        }
    }
    public function get_asistencias_breaks($huser,$desde,$hasta)
    {
          $sql=$this->db->query("SELECT hasistencia as id,DATE_FORMAT(break_salida, '%Y/%m/%d' ' %H:%i:%s') as break_salida,DATE_FORMAT(break_entrada, '%Y/%m/%d' ' %H:%i:%s') as break_entrada,DATE_FORMAT(fecha, '%d/%m/%Y') as fecha,type from tblbreaks where huser='$huser' AND fecha BETWEEN '$desde' AND '$hasta' order by break_salida desc");        
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }
     public function get_all_breaks($hasistencia)
    {
          $sql=$this->db->query("SELECT hasistencia as id,DATE_FORMAT(break_salida, '%Y/%m/%d' ' %H:%i:%s') as break_salida,DATE_FORMAT(break_entrada, '%Y/%m/%d' ' %H:%i:%s') as break_entrada,DATE_FORMAT(fecha, '%d/%m/%Y') as fecha,type from tblbreaks where hasistencia='$hasistencia'");        
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }
     public function get_breaks_detalles($hasistencia,$huser)
    {
        $this->db->order_by('break_salida DESC');
        $this->db->select('*');
        $this->db->from('tblbreaks');
        $this->db->where('hasistencia',$hasistencia);
        $this->db->where('huser',$huser);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
    }
     public function get_reuniones_detalles($hasistencia,$huser)
    {
        $this->db->order_by('reuniones_salida DESC');
        $this->db->select('*');
        $this->db->from('tblreuniones');
        $this->db->where('hasistencia',$hasistencia);
        $this->db->where('huser',$huser);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
    }
    public function get_inactiviades_detalles($hasistencia,$huser)
    {
        $this->db->order_by('hora_inactividad DESC');
        $this->db->select('DATE_FORMAT(hora_inactividad, "%H:%i:%s") as hora_inactividad,tiempo_inactivo');
        $this->db->from('tblinactividad');
        $this->db->where('hasistencia',$hasistencia);
        $this->db->where('huser',$huser);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();              
        }
        return false;
    }
    public function get_asistencia_rango_fecha($huser,$desde,$hasta)
    {
          $sql=$this->db->query("SELECT  repo.id,date_format(repo.fecha,'%d-%m-%Y') as fecha,date_format(repo.horario_entrada,'%H:%i:%s') as horario_entrada,date_format(repo.horario_salida,'%H:%i:%s') as horario_salida,repo.huser,repo.total_jornada,repo.type,repo.breaks,repo.reunion,repo.inactividad,
SEC_TO_TIME((ifnull(time_to_sec(repo.total_jornada),0)-ifnull(time_to_sec(repo.breaks),0)-ifnull(time_to_sec(repo.inactividad),0))) total_horas
from
(SELECT a.id,a.fecha,a.horario_entrada,a.horario_salida,a.huser,a.TYPE,

TIMEDIFF(DATE_FORMAT(horario_salida,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(horario_entrada,'%Y-%m-%d %H:%i:%s')) as total_jornada,


(SELECT sec_to_time(sum(time_to_sec(c.break_entrada)-time_to_sec(c.break_salida))) FROM tblbreaks c
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
     public function get_reporte_general($desde,$hasta)
    {
        $sql=$this->db->query("SELECT a.id,a.nombres,a.apellidos,
 (
SELECT SEC_TO_TIME(SUM((TIME_TO_SEC(total_jornada)))) AS total_empleado
FROM view_control_asistencia b
WHERE a.id=b.huser AND b.fecha BETWEEN '$desde' AND '$hasta') AS total_jornada, (
SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(b.total_breaks)))
FROM view_breaks b
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