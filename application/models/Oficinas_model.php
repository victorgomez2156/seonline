<?php
class Oficinas_model extends CI_Model 
{
	 public function all_office()
    {
        $this->db->order_by('nombre_oficina asc');
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
     public function all_office_active()
    {
        $this->db->order_by('nombre_oficina asc');
        $this->db->select('*');
        $this->db->from('tbloficinas');
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
    public function all_office_disabled()
    {
        $this->db->order_by('nombre_oficina asc');
        $this->db->select('*');
        $this->db->from('tbloficinas');
        $this->db->where('estatus',2);                 
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
    public function agregar($oficina,$estatus)
    {
        $this->db->insert('tbloficinas',array('nombre_oficina'=>$oficina,'estatus'=>$estatus));
        return $this->db->insert_id();
    }
    public function actualizar($id,$oficina,$estatus)
    {
           
        $this->db->where('id', $id);        
        return $this->db->update('tbloficinas',array('nombre_oficina'=>$oficina,'estatus'=>$estatus));
    }
     public function eliminar($id)
    {
       
        $this->db->select('hoficina');
        $this->db->from('tblusuarios');
        $this->db->where('hoficina',$id);                 
        $query = $this->db->get(); 
        if($query->num_rows()>=1)
        {
            return false;
        }
        else
        {
             return $this->db->delete('tbloficinas', array('id' => $id));
        }         
       
    }
}
?>
