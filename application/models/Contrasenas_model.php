<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contrasenas_model extends CI_Model 
{
   public function get_all_sistemas($usuario)
    {
        $this->db->order_by('nombre_sistema asc');
        $this->db->select('a.id,b.nombre_sistema,b.url_sistema,b.estatus,a.huser');
        $this->db->from('tbldetalleaccesosistemas a');
        $this->db->join('tblsistemas b','a.hsistema=b.id');       
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
     public function get_all_users()
    {
        $this->db->order_by('nombres,apellidos asc');
        $this->db->select('id,nombres,apellidos');
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
     public function buscar_credenciales_repeat($users)
    {
       // $this->db->order_by('nombres,apellidos asc');
        $this->db->select('usuario_sistema');
        $this->db->from('tblcredencialessistemas');
        $this->db->where('usuario_sistema',$users);
        $query = $this->db->get(); 
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }       
    }
     public function get_all_systems()
    {
        $this->db->order_by('nombre_sistema asc');
        $this->db->select('id,nombre_sistema,url_sistema');
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
     public function consultando_acceso_sistemas($huser)
    {
        //$this->db->order_by('nombres,apellidos asc');
        $this->db->select('*');
        $this->db->from('tbldetalleaccesosistemas');
        $this->db->where('huser',$huser);
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
    public function get_datos_filtrados($id,$coordinador,$usuario)
    {
        
        if($usuario==1)
        {
            $this->db->select('id,usuario_sistema,contrasena_sistema,contrasena_sin_codificar,notas,coordinador,usuario');
            $this->db->from('tbldetalleaccesosistemas');
            //$this->db->join('tblsistemas b','a.hsistema=b.id');       
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
        else
        {
            $this->db->select('id,usuario_sistema,contrasena_sistema,notas,coordinador,usuario');
            $this->db->from('tbldetalleaccesosistemas');
            //$this->db->join('tblsistemas b','a.hsistema=b.id');       
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
    }
    public function buscar_credenciales($id_principal)
    {
        $this->db->select('*');
        $this->db->from('tblcredencialessistemas');
        $this->db->where('hdetalleaccesosistema',$id_principal);
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
     public function agregar_credencial($contrasena_sistema,$coordinador,$huser,$id_principal,$notas,$usuario,$usuario_sistema)
    {
        $this->db->insert('tblcredencialessistemas',array('hdetalleaccesosistema'=>$id_principal,'usuario_sistema'=>$usuario_sistema,'contrasena_sistema'=>md5($contrasena_sistema),'contrasena_sin_codificar'=>$contrasena_sistema,'notas'=>$notas,'coordinador'=>$coordinador,'usuario'=>$usuario));
        return $this->db->insert_id();
    }
    public function add_systems_users($id,$huser)
    {
        $this->db->insert('tbldetalleaccesosistemas',array('hsistema'=>$id,'huser'=>$huser));
        return $this->db->insert_id();
    }
    public function add_credenciales_users($id,$usuario_sistema,$contrasena,$notas,$coordinador,$usuario)
    {
        $this->db->insert('tblcredencialessistemas',array('hdetalleaccesosistema'=>$id,'usuario_sistema'=>$usuario_sistema,'contrasena_sistema'=>md5($contrasena),'contrasena_sin_codificar'=>$contrasena,'notas'=>$notas,'coordinador'=>$coordinador,'usuario'=>$usuario));
        return $this->db->insert_id();
    }
     public function add_systems($nombre_sistema,$url_sistema)
    {
        $this->db->insert('tblsistemas',array('nombre_sistema'=>$nombre_sistema,'url_sistema'=>$url_sistema,'estatus'=>1));
        return $this->db->insert_id();
    }
    public function update_credencial($id,$hdetalleaccesosistema,$usuario_sistema,$contrasena_sistema,$notas)
    {
        $this->db->where('id', $id);
        $this->db->where('hdetalleaccesosistema', $hdetalleaccesosistema);
        return $this->db->update('tblcredencialessistemas',array('usuario_sistema'=>$usuario_sistema,'contrasena_sistema'=>md5($contrasena_sistema),'contrasena_sin_codificar'=>$contrasena_sistema,'notas'=>$notas));
    }
    public function update_accion_credencial($usuario_sistema,$contrasena_sin_codificar,$notas,$id,$id_principal,$hdetalleaccesosistema)
    {
        $this->db->where('id', $id);
        $this->db->where('hdetalleaccesosistema', $hdetalleaccesosistema);
        return $this->db->update('tblcredencialessistemas',array('usuario_sistema'=>$usuario_sistema,'contrasena_sistema'=>md5($contrasena_sin_codificar),'contrasena_sin_codificar'=>$contrasena_sin_codificar,'notas'=>$notas));
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
     public function update_status_coordinador($id_credencial,$id_principal,$estatus)
    {
        $this->db->where('id', $id_credencial);
        $this->db->where('hdetalleaccesosistema', $id_principal);
        return $this->db->update('tblcredencialessistemas',array('coordinador'=>$estatus));
    }
     public function update_status_usuario($id_credencial,$id_principal,$estatus)
    {
        $this->db->where('id', $id_credencial);
        $this->db->where('hdetalleaccesosistema', $id_principal);
        return $this->db->update('tblcredencialessistemas',array('usuario'=>$estatus));
    }
}