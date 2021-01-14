<?php
class Horarios_model extends CI_Model 
{
	 
	 public function get_all_dias_laborables()
    {
        $this->db->order_by('orden asc');
        $this->db->select('id,dia_laborable,orden');
        $this->db->from('tbldiaslaborables');
        $this->db->where('estatus',1);                        
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;   
    } 
    public function search_empleado_data($huser)
    {
        //$this->db->order_by('orden asc');
        $this->db->select('id as hcontrato,DATE_FORMAT(fecha_inicio_contrato, "%d/%m/%Y" ) as fecha_inicio_contrato,DATE_FORMAT(fecha_perioro_prueba, "%d/%m/%Y" ) as fecha_perioro_prueba,DATE_FORMAT(fecha_fin_contrato, "%d/%m/%Y" ) as fecha_fin_contrato,estatus as estatus_contrato');
        $this->db->from('tblcontratos');
        $this->db->where('huser',$huser);
        $this->db->where('estatus',1);                        
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        return false;   
    } 
     public function search_vacaciones_data($huser)
    {
        //$this->db->order_by('orden asc');
        $this->db->select('id as hvacaciones,DATE_FORMAT(fecha_desde, "%d/%m/%Y" ) as fecha_desde,DATE_FORMAT(fecha_hasta, "%d/%m/%Y" ) as fecha_hasta,dias_vacaciones,estatus as estatus_vacaciones');
        $this->db->from('tbldetallevacacionesusuarios');
        $this->db->where('huser',$huser);
        $this->db->where('estatus',1);                        
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        return false;   
    } 
     public function search_days_laborables_data($huser)
    {
        $this->db->order_by('hdia asc');
        $this->db->select('hdia as id,dia_laborable,hora_entrada,hora_salida,orden');
        $this->db->from('tbldetallehorariosusuarios');
        $this->db->where('huser',$huser);
       // $this->db->where('estatus',1);                        
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;   
    }
    public function buscar_historico_vacaciones($huser)
    {
       // $this->db->order_by('orden asc'); 
        $this->db->select('id as hvacaciones,DATE_FORMAT(fecha_desde, "%d/%m/%Y" ) as fecha_desde,DATE_FORMAT(fecha_hasta, "%d/%m/%Y" ) as fecha_hasta,dias_vacaciones,estatus');
        $this->db->from('tbldetallevacacionesusuarios');
        $this->db->where('huser',$huser);                        
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;   
    }
     public function actualizar_vacaciones_extras($hvacaciones,$estatus)
    {
        $this->db->where('id', $hvacaciones);
        return $this->db->update('tbldetallevacacionesusuarios',array('estatus'=>$estatus));
    }
     public function adicionar_vacaciones_extras($dias_vacaciones,$fecha_desde,$fecha_hasta,$huser,$estatus_vacaciones1)
    {       
        $this->db->insert('tbldetallevacacionesusuarios',array('fecha_desde'=>$fecha_desde,'fecha_hasta'=>$fecha_hasta,'dias_vacaciones'=>$dias_vacaciones,'huser'=>$huser,'estatus'=>$estatus_vacaciones1));
        $id = $this->db->insert_id();
        return $id; 
    }
     public function eliminar_dias_laborables($hhorario,$huser)
    {
        return $this->db->delete('tbldetallehorariosusuarios', array('hhorario' => $hhorario,'huser'=>$huser));
    }
     public function agregar_detalle_horarios($id,$dia_laborable,$orden,$hhorario,$huser,$hora_entrada,$hora_salida)
    {       
        $this->db->insert('tbldetallehorariosusuarios',array('hdia'=>$id,'dia_laborable'=>$dia_laborable,'orden'=>$orden,'hhorario'=>$hhorario,'huser'=>$huser,'hora_entrada'=>$hora_entrada,'hora_salida'=>$hora_salida));        
    }

     public function actualizar_contrato($hcontrato,$fecha_inicio_contrato,$fecha_perioro_prueba,$fecha_fin_contrato,$usuario,$estatus_contrato)
    {
        $this->db->where('id', $hcontrato);
        $this->db->where('huser', $usuario);
        return $this->db->update('tblcontratos',array('fecha_inicio_contrato'=>$fecha_inicio_contrato,'fecha_perioro_prueba'=>$fecha_perioro_prueba,'fecha_fin_contrato'=>$fecha_fin_contrato,'estatus'=>$estatus_contrato));
    }
      public function agregar_contratos($fecha_inicio_contrato,$fecha_perioro_prueba,$fecha_fin_contrato,$usuario,$estatus)
    {       
        $this->db->insert('tblcontratos',array('fecha_inicio_contrato'=>$fecha_inicio_contrato,'fecha_perioro_prueba'=>$fecha_perioro_prueba,'fecha_fin_contrato'=>$fecha_fin_contrato,'huser'=>$usuario,'estatus'=>$estatus));
        $id = $this->db->insert_id();
        return $id; 
    }
      public function agregar_vacaciones($fecha_vacaciones_desde,$fecha_vacaciones_hasta,$dias_vacaciones,$huser,$estatus,$hcontrato)
    {       
        $this->db->insert('tbldetallevacacionesusuarios',array('fecha_desde'=>$fecha_vacaciones_desde,'fecha_hasta'=>$fecha_vacaciones_hasta,'dias_vacaciones'=>$dias_vacaciones,'huser'=>$huser,'estatus'=>$estatus,'hcontrato'=>$hcontrato));
        $id = $this->db->insert_id();
        return $id; 
    }
      public function actualizar_vacaciones($hvacaciones,$fecha_vacaciones_desde,$fecha_vacaciones_hasta,$dias_vacaciones,$huser,$estatus_vacaciones,$hcontrato)
    {
        $this->db->where('id', $hvacaciones);
        $this->db->where('huser', $huser);
        $this->db->where('hcontrato', $hcontrato);
        return $this->db->update('tbldetallevacacionesusuarios',array('fecha_desde'=>$fecha_vacaciones_desde,'fecha_hasta'=>$fecha_vacaciones_hasta,'dias_vacaciones'=>$dias_vacaciones,'estatus'=>$estatus_vacaciones));
    }
   
   
   /* public function get_all_datos($huser)
    {
        $this->db->select('*');
        $this->db->from('tblusuarios');
        $this->db->where('id',$huser);               
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        return false;   
    }
    
        public function agregar_horarios($hora_entrada,$duracion_almuerzo,$hora_salida,$huser,$break_1,$break_2)
    {       
        $this->db->insert('tblhorariosusuarios',array('hora_entrada'=>$hora_entrada,'duracion_almuerzo'=>$duracion_almuerzo,'hora_salida'=>$hora_salida,'huser'=>$huser,'break_1'=>$break_1,'break_2'=>$break_2));
        $id = $this->db->insert_id();
        return $id; 
    }
    
   
    
     public function get_horarios($huser)
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
     public function get_detalle_dias_laborables($hhorario)
    {
        $this->db->order_by('orden asc'); 
        $this->db->select('hdia as id,dia_laborable,orden');
        $this->db->from('tbldetallehorariosusuarios');
        $this->db->where('hhorario',$hhorario);
        //$this->db->or_where('usuario',$correo_usuario);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;   
    }
    public function actualizar_horas_laborales($id,$hora_entrada,$duracion_almuerzo,$hora_salida,$break_1,$break_2)
    {
        $this->db->where('id', $id);
        return $this->db->update('tblhorariosusuarios',array('hora_entrada'=>$hora_entrada,'duracion_almuerzo'=>$duracion_almuerzo,'hora_salida'=>$hora_salida,'break_1'=>$break_1,'break_2'=>$break_2));
    }
   
  
     public function buscar_fechas_contratos($huser)
    {
       // $this->db->order_by('orden asc'); 
        $this->db->select('id as hcontrato,DATE_FORMAT(fecha_inicio_contrato, "%d/%m/%Y" ) as fecha_inicio_contrato,DATE_FORMAT(fecha_perioro_prueba, "%d/%m/%Y" ) as fecha_perioro_prueba,DATE_FORMAT(fecha_fin_contrato, "%d/%m/%Y" ) as fecha_fin_contrato,estatus');
        $this->db->from('tblcontratos');
        $this->db->where('huser',$huser);
        //$this->db->where('estatus',1);
        //$this->db->or_where('usuario',$correo_usuario);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        return false;   
    }
    public function buscar_fechas_vacaciones($huser)
    {
       // $this->db->order_by('orden asc'); 
        $this->db->select('id as hvacaciones,DATE_FORMAT(fecha_desde, "%d/%m/%Y" ) as fecha_desde,DATE_FORMAT(fecha_hasta, "%d/%m/%Y" ) as fecha_hasta,dias_vacaciones,estatus');
        $this->db->from('tbldetallevacacionesusuarios');
        $this->db->where('huser',$huser);
        $this->db->where('estatus',1);
        $this->db->order_by('id desc');
        //$this->db->or_where('usuario',$correo_usuario);                 
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return $query->row();
        }
        return false;   
    }
     */
}
?>
