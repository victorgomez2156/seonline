<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verificador_model extends CI_Model 
{
     public function get_configuraciones()
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
    public function comprobar_asistencia($dia_laborable,$hoficina)
    {
        $this->db->select('b.id,b.nombres,b.apellidos,a.dia_laborable,a.hora_entrada as hora_entrada_fija,a.hora_salida as hora_salida_fija,c.nombre_oficina');
        $this->db->from('tbldetallehorariosusuarios a');
        $this->db->join('tblusuarios b','b.id=a.huser');
        $this->db->join('tbloficinas c','b.hoficina=c.id');
        //$this->db->join('tblhorariosusuarios c','c.huser=a.huser');
        $this->db->where('dia_laborable',$dia_laborable);
         $this->db->where('hoficina',$hoficina);
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
    public function comprobar_asistencia_latino_america($dia_laborable,$oficina)
    {
        $this->db->select('b.id,b.nombres,b.apellidos,a.dia_laborable,a.hora_entrada as hora_entrada_fija,a.hora_salida as hora_salida_fija,c.nombre_oficina');
        $this->db->from('tbldetallehorariosusuarios a');
        $this->db->join('tblusuarios b','b.id=a.huser');
        $this->db->join('tbloficinas c','b.hoficina=c.id');
        $this->db->where('a.dia_laborable',$dia_laborable);
        $this->db->where('b.hoficina<=',$oficina);
       // $this->db->or_where('a.dia_laborable',$dia_laborable);
        //$this->db->where('b.hoficina',$peru);
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
     public function get_asistencia_hoy($huser,$fecha)
    {
        $this->db->select('*');
        $this->db->from('tblcontrolasistencia');        
        $this->db->where('huser',$huser);
        $this->db->where('fecha',$fecha);
        //$this->db->where('type<=',3);
       // $this->db->where('estatus=',0);
        $this->db->order_by('horario_entrada DESC');
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
   
     public function consultar_contratos($desde,$hasta)
    {
        $sql=$this->db->query("SELECT DATE_FORMAT(a.fecha_inicio_contrato, '%d/%m/%Y' ) as fecha_inicio_contrato,DATE_FORMAT(a.fecha_fin_contrato, '%d/%m/%Y' ) as fecha_fin_contrato,DATE_FORMAT(a.fecha_perioro_prueba, '%d/%m/%Y' ) as fecha_perioro_prueba,b.nombres,b.apellidos,b.correo_electronico,a.estatus from tblcontratos a join tblusuarios b on a.huser=b.id where a.estatus=1 and fecha_perioro_prueba BETWEEN '$desde' AND '$hasta' order by fecha_perioro_prueba desc");
        if($sql->num_rows()>0)
        {
            return $sql->result();
        }
        else
        {
            return false;
        }
    }
    public function get_hora_salida_null()
    {
        $this->db->select('*');
        $this->db->from('tblcontrolasistencia');        
        $this->db->where('horario_salida is null');        
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
    public function get_hora_cierre_app($huser,$fecha,$hoficina)
    {
        $this->db->select('a.id,a.hora_cierre,a.huser,a.fecha,a.estatus,b.nombres,b.apellidos,c.nombre_oficina');
        $this->db->from('tblcierreappescritorio a'); 
        $this->db->join('tblusuarios b','a.huser=b.id');
        $this->db->join('tbloficinas c','b.hoficina=c.id');        
        $this->db->where('huser',$huser);
        $this->db->where('fecha',$fecha);
        $this->db->where('b.hoficina',$hoficina);         
        $this->db->order_by('hora_cierre DESC');
        $this->db->limit('1');
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
     public function cerrar_asistencia_madrid($hasistencia,$hora_cierre_app,$huser)
    {
        $this->db->where('id', $hasistencia);
        $this->db->where('huser', $huser);
        return $this->db->update('tblcontrolasistencia',array('horario_salida'=>$hora_cierre_app,'estatus'=>2,'type'=>4));
    }
     public function get_hora_salida_null_latino($oficina)
    {
        $this->db->select('a.id,a.horario_entrada,a.horario_salida,a.huser,a.fecha,a.type,a.estatus');
        $this->db->from('tblcontrolasistencia a');
        $this->db->join('tblusuarios b','a.huser=b.id');          
        $this->db->where('a.horario_salida is null'); 
        $this->db->where('b.hoficina<=',$oficina);       
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
    public function get_hora_cierre_app_latino($huser,$fecha,$hoficina)
    {
        $this->db->select('a.id,a.hora_cierre,a.huser,a.fecha,a.estatus,b.nombres,b.apellidos,c.nombre_oficina');
        $this->db->from('tblcierreappescritorio a'); 
        $this->db->join('tblusuarios b','a.huser=b.id');
        $this->db->join('tbloficinas c','b.hoficina=c.id');        
        $this->db->where('huser',$huser);
        $this->db->where('fecha',$fecha);
        $this->db->where('b.hoficina<=',$hoficina);         
        $this->db->order_by('hora_cierre DESC');
        $this->db->limit('1');
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
}