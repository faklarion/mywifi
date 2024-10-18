<?php defined('BASEPATH') or exit('No direct script access allowed');

class Data_user extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['user_m']);
    }
    public function index()
    {
        $data['title'] = 'Data User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['data_user'] = $this->user_m->get_all();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/data_user/data', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('phone', 'Nomer HP', 'required|trim');
        $this->form_validation->set_rules('address', 'Alamat', 'required|trim');
        
        // Validasi form
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Data User';
            $data['company'] = $this->db->get('company')->row_array();
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->template->load('backend', 'backend/data_user/add_user', $data);
        } else {
            date_default_timezone_set('Asia/Makassar');
            // Data untuk tabel user
            $password = $this->input->post('password');
            $options = array("cost" => 4);
            $hashPassword = password_hash($password, PASSWORD_BCRYPT, $options);
            
            // Konfigurasi upload image
            $config['upload_path'] = './assets/images/profile/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            //$config['max_size'] = 2048; // ukuran maksimal 2MB
            $config['encrypt_name'] = TRUE; // nama file akan diacak
            
            $this->load->library('upload', $config);
    
            // Cek apakah file image diupload
            if (!$this->upload->do_upload('image')) {
                // Jika gagal upload, set gambar default atau error
                $image = 'default.jpg'; // atau bisa set ke gambar default
                $this->session->set_flashdata('error', $this->upload->display_errors());
            } else {
                // Jika berhasil upload
                $upload_data = $this->upload->data();
                $image = $upload_data['file_name']; // dapatkan nama file yang diupload
            }
    
            $data = array(
                'name'          => $this->input->post('name'),
                'email'         => $this->input->post('email'),
                'password'      => $hashPassword,
                'phone'         => $this->input->post('phone'),
                'address'       => $this->input->post('address'),
                'gender'        => $this->input->post('gender'),
                'role_id'       => $this->input->post('role'),
                'is_active'     => 1,
                'date_created'  => time(),
                'customer_id'   => NULL,
                'image'         => $image // simpan nama gambar yang diupload
            );
    
            // Simpan data ke tabel user
            $this->db->insert('user', $data);
    
            // Cek apakah data berhasil disimpan
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data User berhasil disimpan');
            }
    
            // Redirect ke halaman data user
            echo "<script>window.location='" . site_url('data_user') . "'; </script>";
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

    

    public function edit($id)
    {
        is_logged_in();
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('phone', 'Nomer HP', 'required|trim');
        $this->form_validation->set_rules('address', 'Alamat', 'required|trim');
        
        if ($this->form_validation->run() == false) {
            $query  = $this->user_m->get_id($id);
            if ($query->num_rows() > 0) {
                $data['data_user'] = $query->row();
                $data['title'] = 'Edit Data User';
                $data['company'] = $this->db->get('company')->row_array();
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $this->template->load('backend', 'backend/data_user/edit_user', $data);
            } else {
                echo "<script> alert ('Data tidak ditemukan');";
                echo "window.location='" . site_url('data_user') . "'; </script>";
            }
        } else {
            $post = $this->input->post(null, TRUE);
            $this->pengaduan_m->edit($post);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Data Pelanggan berhasil diperbaharui');
            }
            echo "<script>window.location='" . site_url('data_user') . "'; </script>";
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
        $id = $this->input->post('id');
        
        $this->user_m->del($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
        }
        redirect('data_user');   
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
