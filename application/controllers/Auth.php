<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('url','form','user'));
        
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            $user_type = $this->session->userdata('user_type');

            if ($user_type == 1) {
                redirect('invoices');
            } elseif ($user_type == 2) {
                redirect('customer');
            } else {
                redirect('invoices');
            }
        }

        if ($this->input->post()) {
            $email    = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->db->where('email', $email)->get('users')->row();

            if ($user && $user->password === $password) {
                $this->session->set_userdata([
                    'logged_in' => true,
                    'user_id'   => $user->id,
                    'user_type' => $user->type,
                    'name'      => $user->name,
                    'username'  => $user->username
                ]);

                if ($user->type == 1) {
                    redirect('invoices');
                } elseif ($user->type == 2) {
                    redirect('customer');
                } else {
                    redirect('invoices');
                }
            } else {
                $data['error'] = 'Invalid email or password';
                $this->load->view('auth/login', $data);
            }
        } else {
            $this->load->view('auth/login');
        }
    }


    public function logout(){
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
