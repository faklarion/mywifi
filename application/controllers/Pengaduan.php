<?php defined('BASEPATH') or exit('No direct script access allowed');

class pengaduan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['pengaduan_m', 'package_m', 'services_m', 'bill_m', 'income_m', 'customer_m']);
    }
    public function index()
    {
        $data['title'] = 'Pengaduan Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pengaduan'] = $this->pengaduan_m->get_all();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/pengaduan/data', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required|trim');
    
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Pengaduan';
            $data['company'] = $this->db->get('company')->row_array();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->template->load('backend', 'backend/pengaduan/add_pengaduan', $data);
        } else {
            date_default_timezone_set('Asia/Makassar');
            // Data untuk tabel user
            $data = array(
                'keluhan'           => $this->input->post('keluhan'),
                'user_id'           => $this->session->userdata('id'),
                'tanggal_pengaduan' => date('Y-m-d H:i:s'),
                'status'            => 1,                
            );
    
            // Simpan data ke tabel user
            $this->db->insert('pengaduan', $data);
    
            // Cek apakah data berhasil disimpan
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pengaduan berhasil disimpan');
            }
    
            // Redirect ke halaman pengaduan
            echo "<script>window.location='" . site_url('pengaduan') . "'; </script>";
        }
    }

    public function cek_bill()
    {
        $data['title'] = 'Cek Tagihan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pengaduan'] = $this->pengaduan_m->getpengaduan()->result();
        $data['bill'] = $this->bill_m->getInvoice()->result();
        $data['detail'] = $this->bill_m->getInvoiceDetail()->result();
        $data['invoice'] = $this->bill_m->invoice_no();
        $data['company'] = $this->db->get('company')->row_array();
        // Jika ada data yang ingin dikirim ke view, kirimkan di sini.
        $this->template->load('backend','frontend/cek_bill_pengaduan', $data);
    }

    

    public function edit($pengaduan_id)
    {
        is_logged_in();
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim|callback_no_ktp_check');
        $this->form_validation->set_rules('no_wa', 'No Whatsapp', 'required|trim|callback_no_wa_check');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_email_check');
        $this->form_validation->set_message('required', '%s Tidak boleh kosong, Silahkan isi');
        $this->form_validation->set_message('is_unique', '%s Sudah dipakai, Silahkan ganti');
        if ($this->form_validation->run() == false) {
            $query  = $this->pengaduan_m->getpengaduan($pengaduan_id);
            if ($query->num_rows() > 0) {
                $data['pengaduan'] = $query->row();
                $data['title'] = 'Edit pengaduan';
                $data['company'] = $this->db->get('company')->row_array();
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $this->template->load('backend', 'backend/pengaduan/edit_pengaduan', $data);
            } else {
                echo "<script> alert ('Data tidak ditemukan');";
                echo "window.location='" . site_url('pengaduan') . "'; </script>";
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->pengaduan_m->edit($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pelanggan berhasil diperbaharui');
            }
            echo "<script>window.location='" . site_url('pengaduan') . "'; </script>";
        }
    }

    function email_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM pengaduan WHERE email = '$post[email]' AND pengaduan_id != '$post[pengaduan_id]'");
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
        $query = $this->db->query("SELECT * FROM pengaduan WHERE no_wa = '$post[no_wa]' AND pengaduan_id != '$post[pengaduan_id]'");
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
        $query = $this->db->query("SELECT * FROM pengaduan WHERE no_ktp = '$post[no_ktp]' AND pengaduan_id != '$post[pengaduan_id]'");
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
			$this->data['pengaduan'] =  $this->pengaduan_m->get_all();//
			$this->data['title_web'] = 'Laporan Akta Lahir';	
        }
		
        $this->load->view('backend/pengaduan/pengaduan_doc',$this->data);
	}
    public function word()
    {
        $data = array(
            'pengaduan_data' => $this->pengaduan_m->get_all(),
            'start' => 0
        );
        
        $this->load->view('pengaduan/pengaduan_doc',$data);
    }




    public function delete()
    {
        $pengaduan_id = $this->input->post('pengaduan_id');
        
                $this->pengaduan_m->delete($pengaduan_id);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success', 'Data berhasil dihapus');
                }
                redirect('pengaduan');   
    }

    public function ubah_status()
    {
                $pengaduan_id = $this->input->post('pengaduan_id');

                $data = array(
                    'status' => 2,
                );
                
                $this->db->where('pengaduan_id', $pengaduan_id);
                $this->db->update('pengaduan', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('success', 'Pengaduan berhasil diubah');
                }
                redirect('pengaduan');   
    }
}
