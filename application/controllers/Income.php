<?php defined('BASEPATH') or exit('No direct script access allowed');

class Income extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['income_m']);
    }


    public function index()
    {
        $data['title'] = 'Income';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['income'] = $this->income_m->getincome()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/income/income', $data);
    }


    public function add()
    {
        $post = $this->input->post(null, TRUE);
        $this->income_m->add($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pemasukan berhasil ditambahkan');
        }
        echo "<script>window.location='" . site_url('income') . "'; </script>";
    }
    public function edit()
    {
        $post = $this->input->post(null, TRUE);
        $this->income_m->edit($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pemasukan berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('income') . "'; </script>";
    }
    public function delete()
    {
        $income_id = $this->input->post('income_id');
        $this->income_m->delete($income_id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pemasukan berhasil dihapus');
        }
        echo "<script>window.location='" . site_url('income') . "'; </script>";
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

		$bulan = $_POST['bulan'];
    	$tahun = $_POST['tahun'];
        $bulanBaru = $this->konversiAngkaKeBulan($bulan);

		if (isset($_POST['cetaksemua'])) {
			$this->data['label'] = "Semua Periode";
			$this->data['income'] =  $this->income_m->get_all();//
			$this->data['title_web'] = 'Laporan Tagihan';	
		} else {
			$this->data['label'] = "Bulan $bulanBaru Tahun $tahun";
			$this->data['income'] =  $this->income_m->get_all_bulan($bulan,$tahun);//
			$this->data['title_web'] = 'Laporan Tagihan';
		}
		
        $this->load->view('backend/income/income_doc',$this->data);
	}

    
    
    public function word()
    {
        $data = array(
            'income_data' => $this->income_m->get_all(),
            'start' => 0
        );
        
        $this->load->view('income/income_doc',$data);
    }
}
