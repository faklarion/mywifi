<?php defined('BASEPATH') or exit('No direct script access allowed');

class Bill extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model(['customer_m', 'package_m', 'services_m', 'bill_m', 'income_m']);
    }

    public function index()
    {
        $data['title'] = 'Bill';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['customer'] = $this->customer_m->getCustomer()->result();
        $data['bill'] = $this->bill_m->getInvoice()->result();
        $data['detail'] = $this->bill_m->getInvoiceDetail()->result();
        $data['invoice'] = $this->bill_m->invoice_no();
        $data['company'] = $this->db->get('company')->row_array();
        $this->template->load('backend', 'backend/bill/bill', $data);
    }


    public function view_data()
    {
        if (isset($_POST['cek_data'])) {
            $data['services'] =  $this->services_m->getServicesDetail($this->input->post('no_services'));
            $this->load->view('backend/bill/detail_bill', $data);
        } else {
            echo "cek";
        }
    }



    public function addBill()
    {
        $data = $this->input->post(null, TRUE);
        $no_services = $this->input->post('no_services');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $cekperiode = $this->bill_m->cekPeriode($no_services, $month, $year);
        if ($cekperiode->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Gagal, Tagihan untuk periode tersebut sudah tersedia, mohon dicek kembali !');
            echo "<script>window.location='" . site_url('bill') . "'; </script>";
        } else {
            $this->bill_m->addBill($data);
            $invoice = $this->input->post('invoice');
            $Detail = $this->services_m->getServicesDetail($this->input->post('no_services'))->result();
            $data2 = [];
            foreach ($Detail as $c => $row) {
                array_push(
                    $data2,
                    array(
                        'invoice_id' => $invoice,
                        'item_id' => $row->item_id,
                        'category_id' => $row->category_id,
                        'price' => $row->price,
                        'qty' => $row->qty,
                        'disc' => $row->disc,
                        'remark' => $row->remark,
                        'total' => $row->total,
                    )
                );
            }
            $this->bill_m->add_bill_detail($data2);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Tagihan berhasil dibuat');
            }
            redirect('bill');
        }
    }

    public function detail($invoice)
    {
        $data['title'] = 'Detail Bill';
        $data['invoice'] = $this->bill_m->getEditInvoice($invoice);
        $data['p_item'] = $this->package_m->getPItem()->result();
        $data['bill'] = $this->bill_m->getBill($invoice)->row_array();
        $data['company'] = $this->db->get('company')->row_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->template->load('backend', 'backend/bill/invoice_detail', $data);
    }

    public function delete()
    {
        $invoice = $this->input->post('invoice');
        $this->bill_m->delete($invoice);
        $this->bill_m->deleteDetailBill($invoice);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Data Tagihan berhasil dihapus');
        }
        redirect('bill');
    }

    public function payment()
    {
        $post = $this->input->post(null, TRUE);
        $invoice = $this->input->post('invoice');
        $this->bill_m->payment($post);
        $this->income_m->addPayment($post);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Iuran berhasil terbayarkan');
        }
        echo "<script>window.location='" . site_url('bill/detail/' . $invoice) . "'; </script>";
    }

    function konversiAngkaKeBulan($angka)
    {
        $angka = ltrim($angka, '0'); // Menghapus leading zero (nol di depan) jika ada
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
			$this->data['invoice'] =  $this->bill_m->get_all();//
			$this->data['title_web'] = 'Laporan Tagihan';	
		} else {
			$this->data['label'] = "Bulan $bulanBaru Tahun $tahun";
			$this->data['invoice'] =  $this->bill_m->get_all_bulan($bulan,$tahun);//
			$this->data['title_web'] = 'Laporan Tagihan';
		}
		
        $this->load->view('backend/bill/bill_doc',$this->data);
	}

    public function laporanperstatus()//sesuaikan di list
	{

		$status = $_POST['status'];

			$this->data['label'] = "Status $status";
			$this->data['invoice'] =  $this->bill_m->get_all_status($status);//
			$this->data['title_web'] = 'Laporan Tagihan';

        $this->load->view('backend/bill/bill_doc',$this->data);
	}
    public function word()
    {
        $data = array(
            'bill_data' => $this->bill_m->get_all(),
            'start' => 0
        );
        
        $this->load->view('bill/bill_doc',$data);
    }
}

