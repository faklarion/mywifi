<?php defined('BASEPATH') or exit('No direct script access allowed');

class Customer_m extends CI_Model
{

    public function getCustomer($customer_id = null, $no_services = null)
    {
        $this->db->select('*');
        $this->db->from('customer');
        if ($customer_id != null) {
            $this->db->where('customer_id', $customer_id);
        }
        if ($no_services != null) {
            $this->db->where('no_services', $no_services);
        }
        if($this->session->userdata('role_id') == 2) {
            $this->db->where('customer_id', $this->session->userdata('customer_id'));
        }
        if($this->session->userdata('role_id') == 3){
            $this->db->where('status_bayar', '1');
        }
        $this->db->order_by('customer_id', 'DESC');
        $query = $this->db->get();
        return $query;
    }



    function get_all()
    {
        $this->db->select('customer_id,name,no_services,email,address,no_wa,no_ktp,created,status_pasang,status_pasang');
        
        return $this->db->get('customer')->result();
    }

    function get_filter($bulan, $tahun, $status)
    {
        $this->db->select('*');
        $this->db->where('MONTH(created) = '.$bulan.'');
        $this->db->where('YEAR(created) = '.$tahun.'');
        $this->db->where('status_pasang', $status);
        return $this->db->get('customer')->result();
    }

    public function getNSCustomer($no_services = null)
    {
        $this->db->select('*');
        $this->db->from('customer');
        if ($no_services != null) {
            $this->db->where('no_services', $no_services);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_customer_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('customer_id', $id);
        
        $query = $this->db->get();
        return $query;
    }
    public function getInvoiceCustomer($no_services = null)
    {
        $this->db->select('*');
        $this->db->from('customer');
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
        $this->db->insert('customer', $params);
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
        $this->db->where('customer_id', $post['customer_id']);
        $this->db->update('customer', $params);
    }

    public function delete($customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->delete('customer');
    }
}
