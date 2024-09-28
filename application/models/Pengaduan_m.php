<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan_m extends CI_Model
{

    public function getPengaduan($pengaduan_id = null, $no_services = null)
    {
        $this->db->select('*');
        $this->db->from('pengaduan');
        if ($pengaduan_id != null) {
            $this->db->where('pengaduan_id', $pengaduan_id);
        }
        if ($no_services != null) {
            $this->db->where('no_services', $no_services);
        }
        $query = $this->db->get();
        return $query;
    }



    function get_all()
    {
        $this->db->select('*');
        $this->db->join('user', 'user.id = pengaduan.user_id');
        $this->db->join('customer', 'customer.customer_id = user.customer_id');
        if($this->session->userdata('role_id') == 2) {
            $this->db->where('pengaduan.user_id', $this->session->userdata('id'));
        }
        $this->db->order_by('pengaduan_id', 'DESC');
        return $this->db->get('pengaduan')->result();
    }

    public function getNSpengaduan($no_services = null)
    {
        $this->db->select('*');
        $this->db->from('pengaduan');
        if ($no_services != null) {
            $this->db->where('no_services', $no_services);
        }
        $query = $this->db->get();
        return $query;
    }
    public function getInvoicepengaduan($no_services = null)
    {
        $this->db->select('*');
        $this->db->from('pengaduan');
        if ($no_services != null) {
            $this->db->where('no_services', $no_services);
        }
        $query = $this->db->get();
        return $query;
    }
    public function add($post)
    {
        $params = [
            'name' => $post['name'],
            'no_services' => $post['no_services'],
            'no_ktp' => $post['no_ktp'],
            'email' => $post['email'],
            'no_wa' => $post['no_wa'],
            'address' => $post['address'],
            'created' => time(),
        ];
        $this->db->insert('pengaduan', $params);
    }

    public function edit($post)
    {
        $params = [
            'name' => $post['name'],
            'no_ktp' => $post['no_ktp'],
            'email' => $post['email'],
            'no_wa' => $post['no_wa'],
            'address' => $post['address'],
        ];
        $this->db->where('pengaduan_id', $post['pengaduan_id']);
        $this->db->update('pengaduan', $params);
    }

    public function delete($pengaduan_id)
    {
        $this->db->where('pengaduan_id', $pengaduan_id);
        $this->db->delete('pengaduan');
    }
}
