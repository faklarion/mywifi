<?php
defined('BASEPATH') or exit('No direct script access allowed');

class auth extends CI_Controller
{


    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $data['company'] = $this->db->get('company')->row_array();
            $this->load->view('backend/auth/login', $data);
        } else {
            $this->_login();
        }
    }

    public function register()
    {
        $data['title'] = 'Register';
        $data['company'] = $this->db->get('company')->row_array();
        $this->load->view('backend/auth/register', $data);
    }


    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('user', ['email' => $email])->row_array(); // select * where user email = email
        // user ada
        if ($user) {
            // jika user active
            if ($user['is_active'] == 1) {
                # cek password dan verifikasi dengan input
                if (password_verify($password, $user['password'])) {
                    # jika sama
                    $data = [
                        'login' => true,
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'customer_id' => $user['customer_id'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        $this->session->set_flashdata('success', 'Selamat datang kembali ' . $user['name']);
                        redirect('dashboard');
                    } else {
                        redirect('dashboard');
                    }
                } else {
                    # jika tidak sama atau error
                    $this->session->set_flashdata('error', 'Password Salah ! ');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Alamat email di aktivasi ! ');
                redirect('auth');
            }
        } else {
            // jika tidak ada
            $this->session->set_flashdata('error', ' Alamat email belum terdaftar ! ');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'Alamat Email Google', // isi Alamat email
            'smtp_pass' => 'Password Email Google', // Isi Password email
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        $this->email->initialize($config);


        $this->load->library('email', $config);

        $this->email->from('Alamat Email', '1112-Project'); // isi Alamat email dan nama pengirim
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activated</a>');
        } elseif ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }


        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }
    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('success', '
                    ' . $email . ' has been actived. Please login.
                  ');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('error', 'Account activation failed! Token Expired.
                  ');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Account activation failed! Wrong token.
              ');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Account activation failed! Wrong email.
          ');
            redirect('auth');
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('success', ' Logout Berhasil !');
        redirect('auth');
    }
    public function forgotpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $data['company'] = $this->db->get('company')->row_array();
            $this->load->view('backend/auth/forgot-password', $data);
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('success', 'Silahkan cek email untuk reset password !');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('error', 'Email belum terdaftar !');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->session->set_userdata('reset_email', $email);
                    $this->changePassword();
                } else {
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('error', '
                    Reset password failed! Token Expired.
                 ');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', '
                Reset password failed! Wrong token.
             ');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', '
            Reset password failed! Wrong email.
         ');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password not match !',
            'min_length' => 'Password too short !'
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Reset Password';
            $data['company'] = $this->db->get('company')->row_array();
            $this->load->view('backend/auth/change-password', $data);
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('success', '
            Password has been changed! Please login.
         ');
            redirect('auth');
        }
    }

    public function register_action()
    {     
        // Mengambil data dari form
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $gender = $this->input->post('gender');
        $no_ktp = $this->input->post('no_ktp');
    
        // Validasi NIK (no_ktp) dan email
        $existsNIK = $this->db->get_where('customer', ['no_ktp' => $no_ktp])->row_array();
        $existsEmail = $this->db->get_where('user', ['email' => $email])->row_array();
    
        if ($existsNIK) {
            $this->session->set_flashdata('error', 'NIK sudah terdaftar. Gunakan NIK lain.');
            redirect(base_url('auth/register'));
        }
    
        if ($existsEmail) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar. Gunakan email lain.');
            redirect(base_url('auth/register'));
        }
    
        // Konfigurasi upload gambar
        $config['upload_path'] = './assets/images/profile/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = uniqid(); // Nama file unik
    
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('image')) {
            // Jika gagal upload gambar, kembalikan error
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('register', $error);
        } else {
            // Jika berhasil upload gambar
            $imageData = $this->upload->data();
            $imageName = $imageData['file_name'];
            date_default_timezone_set('Asia/Makassar');
            // Simpan data ke database
            $data_cust = [
                'name' => $name,
                'no_services' => Date('ymdHis'),
                'email' => $email,
                'address' => $address,
                'no_ktp' => $no_ktp,
                'no_wa' => $phone,
                'created' => date('Y-m-d H:i:s'),
            ];
    
            $this->db->insert('customer', $data_cust);
            $customer_id = $this->db->insert_id();
    
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
                'address' => $address,
                'gender' => $gender,
                'image' => $imageName,
                'role_id' => '2', // Default role sebagai user
                'date_created' => time(), // Timestamp
                'is_active' => '1',
                'customer_id' => $customer_id,
            ];
    
            $this->db->insert('user', $data);
    
            // Redirect ke halaman sukses atau login
            $this->session->set_flashdata('pesan', 'Registrasi selesai! Silakan coba untuk login!');
            redirect(base_url('auth'));
        }
    }
    

// Callback untuk validasi file gambar
public function file_check($str)
{
    $allowed_mime_type_arr = ['image/jpeg', 'image/png', 'image/jpg'];
    $mime = $_FILES['image']['type']; // Mengambil MIME dari $_FILES

    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        if (in_array($mime, $allowed_mime_type_arr)) {
            return true;
        } else {
            $this->form_validation->set_message('file_check', 'Please select only jpeg/png file.');
            return false;
        }
    } else {
        $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
        return false;
    }
}


}
