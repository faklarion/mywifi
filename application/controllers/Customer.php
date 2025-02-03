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
        $data['bill_customer'] = $this->bill_m->getInvoiceById($this->session->userdata('id'))->result();
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
        $tahun      = $this->input->get('tahun');
        $bulan      = $this->input->get('bulan');
        $status     = $this->input->get('status');

        if($status == 0) {
            $label_status = 'Belum Dipasang';
        } elseif($status == 1) {
            $label_status = 'Sudah Dipasang';
        }
		
        $this->data['label'] = "Bulan $bulan Tahun $tahun";
        $this->data['label_status'] = $label_status;
		$this->data['customer'] =  $this->customer_m->get_filter($bulan, $tahun, $status);//
		$this->data['title_web'] = 'Laporan Installasi Customer';	

		
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

    public function update_pemasangan()
    {
        $customer_id = $this->input->post('customer_id');
        $no_services = $this->input->post('no_services');
        $lokasi_pasang = $this->input->post('lokasi_pasang');
    
        // Konfigurasi upload gambar
        $config['upload_path'] = './assets/images/pemasangan/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = uniqid(); // Nama file unik
    
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('foto_pasang')) {
            // Jika gagal upload gambar, kembalikan error
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('customer');
        } else {
            // Jika berhasil upload gambar
            $imageData = $this->upload->data();
            $foto_pasang = $imageData['file_name'];
    
            // Update data pemasangan
            $data = array(
                'status_pasang' => 1,
                'foto_pasang' => $foto_pasang,
                'lokasi_pasang' => $lokasi_pasang,
            );
    
            $this->db->where('customer_id', $customer_id);
            $this->db->update('customer', $data);
    
            $this->session->set_flashdata('success', 'Data berhasil diperbarui');
            redirect('customer');
        }
    }
    

    public function verif_pembayaran()
    {
        $customer_id = $this->input->post('customer_id');

        $dataCustomer = $this->customer_m->get_customer_by_id($customer_id)->row();

        $no_services = $dataCustomer->no_services;

        $dataService = $this->services_m->getServices($no_services)->row();

        $price = $dataService->price;
        
        $data = array(
            'status_bayar' => 1,
        );

        $dataIncome = array(
            'date_payment' => date('Y-m-d'),
            'nominal' => $price,
            'remark' => 'Pembayaran installasi no layanan '.$no_services.' a/n '.$dataCustomer->name.'',
        );


        
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer', $data);
        $this->db->insert('income', $dataIncome);
        
        $this->session->set_flashdata('success', 'Data berhasil diperbarui');
                
        redirect('customer');
    }

    public function upload_bayar()
{
    $customer_id = $this->input->post('customer_id');
    $config['upload_path'] = './assets/images/bukti_bayar/'; // Direktori penyimpanan
    $config['allowed_types'] = 'jpg|jpeg|png'; // Jenis file yang diperbolehkan
    //$config['max_size'] = 2048; // Ukuran maksimum file (2MB)
    $config['file_name'] = uniqid(); // Nama file unik

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('bukti_bayar')) {
        // Jika gagal upload, kembalikan pesan error
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', 'Gagal mengunggah bukti bayar: ' . $error);
        redirect('customer');
    } else {
        // Jika berhasil upload, ambil nama file
        $imageData = $this->upload->data();
        $buktiBayar = $imageData['file_name'];

        // Update data di database
        $data = array(
            'bukti_bayar' => $buktiBayar, // Simpan nama file bukti bayar
        );

        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer', $data);

        $this->session->set_flashdata('success', 'Data berhasil diperbarui dan bukti bayar berhasil diunggah');
        redirect('customer');
    }
}

public function print_kartu($id)
{
    $data['title'] = 'Cetak Kartu';
    $data['customers'] = $this->customer_m->get_customer_by_id($id)->result();
    
    $this->load->view('backend/customer/kartu', $data);
}

public function grafik()
{
    $data['tahun'] = $this->input->get('tahun');
    $data['title'] = 'Grafik Informasi Installasi';
    
    $this->load->view('backend/customer/grafik', $data);
}

}
