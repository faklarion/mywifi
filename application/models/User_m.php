<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email !=', 'ginginabdulgoni@gmail.com');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_all()
    {
        $this->db->where('role_id', '1');
        $this->db->or_where('role_id', '3');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('user')->result();
    }
    public  function edit($post)
    {
        $params['is_active'] = $post['is_active'];
        $params['role_id'] = $post['role_id'];
        $this->db->where('id', $post['id']);
        $this->db->update('user', $params);
    }
    public function del($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }
}
