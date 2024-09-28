<?php defined('BASEPATH') or exit('No direct script access allowed');

class expenditure extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['expenditure_m']);
    }


    public function index()
    {
        $data['title'] = 'expenditure';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['expenditure'] = $this->expenditure_m->getexpenditure()->result();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/expenditure/expenditure', $data);
    }


    public function add()
    {
        $post = $this->input->post(null, TRUE);
        $this->expenditure_m->add($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pengeluaran berhasil ditambahkan');
        }
        echo "<script>window.location='" . site_url('expenditure') . "'; </script>";
    }
    public function edit()
    {
        $post = $this->input->post(null, TRUE);
        $this->expenditure_m->edit($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pengeluaran berhasil diperbaharui');
        }
        echo "<script>window.location='" . site_url('expenditure') . "'; </script>";
    }
    public function delete()
    {
        $expenditure_id = $this->input->post('expenditure_id');
        $this->expenditure_m->delete($expenditure_id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data pengeluaran berhasil dihapus');
        }
        echo "<script>window.location='" . site_url('expenditure') . "'; </script>";
   
   
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
			$this->data['expenditure'] =  $this->expenditure_m->get_all();//
			$this->data['title_web'] = 'Laporan Akta Lahir';	
		} else {
			$this->data['label'] = "Bulan $bulanBaru Tahun $tahun";
			$this->data['expenditure'] =  $this->expenditure_m->get_all_bulan($bulan,$tahun);//
			$this->data['title_web'] = 'Laporan Akta Lahir';
		}
		
        $this->load->view('backend/expenditure/expenditure_doc',$this->data);
	}
    
    public function word()
    {
        $data = array(
            'expenditure_data' => $this->Expenditure_m->get_all(),
            'start' => 0
        );
        
        $this->load->view('expenditure/expenditure_doc',$data);
    }

}
