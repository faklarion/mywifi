<?php defined('BASEPATH') or exit('No direct script access allowed');

class customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['customer_m', 'package_m', 'services_m', 'bill_m', 'income_m']);
    }
    public function index()
    {
        $data['title'] = 'Customer';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/customer/data', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim|is_unique[customer.no_ktp]');
        $this->form_validation->set_rules('no_wa', 'No Whatsapp', 'required|trim|is_unique[customer.no_wa]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[customer.email]');
        $this->form_validation->set_message('required', '%s Tidak boleh kosong, Silahkan isi');
        $this->form_validation->set_message('is_unique', '%s Sudah dipakai, Silahkan ganti');
    
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Add Customer';
            $data['company'] = $this->db->get('company')->row_array();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->template->load('backend', 'backend/customer/add_customer', $data);
        } else {
            // Ambil data dari form
            $post = $this->input->post(null, TRUE);
            
            // Simpan data customer
            $this->customer_m->add($post);
            
            // Dapatkan ID customer yang baru saja diinput
            $customer_id = $this->db->insert_id();
    
            // Data untuk tabel user
            $data = array(
                'email'         => $this->input->post('email'),
                'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'phone'         => $this->input->post('no_wa'),
                'address'       => $this->input->post('address'),
                'role_id'       => 2, // Misalnya role_id 2 untuk customer
                'is_active'     => 1,
                'gender'        => 'Male', // Sesuaikan dengan inputan atau default
                'name'          => $this->input->post('name'),
                'customer_id'   => $customer_id // Gunakan ID customer yang baru diinput
            );
    
            // Simpan data ke tabel user
            $this->db->insert('user', $data);
    
            // Cek apakah data berhasil disimpan
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pelanggan berhasil disimpan');
            }
    
            // Redirect ke halaman customer
            echo "<script>window.location='" . site_url('customer') . "'; </script>";
        }
    }

    public function cek_bill()
    {
        $data['title'] = 'Cek Tagihan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['bill'] = $this->bill_m->getInvoice()->result();
        $data['detail'] = $this->bill_m->getInvoiceDetail()->result();
        $data['invoice'] = $this->bill_m->invoice_no();
        $data['company'] = $this->db->get('company')->row_array();
        // Jika ada data yang ingin dikirim ke view, kirimkan di sini.
        $this->template->load('backend','frontend/cek_bill_customer', $data);
    }

    

    public function edit($customer_id)
    {
        is_logged_in();
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim|callback_no_ktp_check');
        $this->form_validation->set_rules('no_wa', 'No Whatsapp', 'required|trim|callback_no_wa_check');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_email_check');
        $this->form_validation->set_message('required', '%s Tidak boleh kosong, Silahkan isi');
        $this->form_validation->set_message('is_unique', '%s Sudah dipakai, Silahkan ganti');
        if ($this->form_validation->run() == false) {
            $query  = $this->customer_m->getCustomer($customer_id);
            if ($query->num_rows() > 0) {
                $data['customer'] = $query->row();
                $data['title'] = 'Edit Customer';
                $data['company'] = $this->db->get('company')->row_array();
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $this->template->load('backend', 'backend/customer/edit_customer', $data);
            } else {
                echo "<script> alert ('Data tidak ditemukan');";
                echo "window.location='" . site_url('customer') . "'; </script>";
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->customer_m->edit($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pelanggan berhasil diperbaharui');
            }
            echo "<script>window.location='" . site_url('customer') . "'; </script>";
        }
    }

    function email_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM customer WHERE email = '$post[email]' AND customer_id != '$post[customer_id]'");
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_check', '%s Ini sudah dipakai, Silahkan ganti !');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function no_wa_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM customer WHERE no_wa = '$post[no_wa]' AND customer_id != '$post[customer_id]'");
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('no_wa_check', '%s Ini sudah dipakai, Silahkan ganti !');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function no_ktp_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM customer WHERE no_ktp = '$post[no_ktp]' AND customer_id != '$post[customer_id]'");
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('no_ktp_check', '%s Ini sudah dipakai, Silahkan ganti !');
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function konversiAngkaKeBulan($angka)
    {
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    
        if (array_key_exists($angka, $namaBulan)) {
            return $namaBulan[$angka];
        } else {
            return 'Bulan tidak valid';
        }
    }



    public function laporanperbulan()//sesuaikan di list
	{
        
		if (isset($_POST['cetaksemua'])) {
			$this->data['label'] = "Semua Periode";
			$this->data['customer'] =  $this->customer_m->get_all();//
			$this->data['title_web'] = 'Laporan Akta Lahir';	
        }
		
        $this->load->view('backend/customer/customer_doc',$this->data);
	}
    public function word()
    {
        $data = array(
            'customer_data' => $this->customer_m->get_all(),
            'start' => 0
        );
        
        $this->load->view('customer/customer_doc',$data);
    }




    public function delete()
    {
        $customer_id = $this->input->post('customer_id');
        $no_services = $this->input->post('no_services');
        $query = $this->services_m->getServices($no_services);
        if ($query->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Pelanggan tidak bisa dihapus dikarenakan masih ada daftar layanan yang aktif');
            redirect('customer');
        } else {
            $cekInvoice = $this->bill_m->getCekInvoice($no_services);
            if ($cekInvoice->num_rows() > 0) {
                $this->session->set_flashdata('error', 'Pelanggan tidak bisa dihapus dikarenakan data-nya masih digunakan di detail tagihan !');
                redirect('customer');
            } else {
                $this->customer_m->delete($customer_id);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success', 'Data berhasil dihapus');
                }
                redirect('customer');
            }
        }
    }
}
