<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Vendor_model');
        $this->load->library('form_validation');

    if (!$this->session->userdata('logged_in')) {
        redirect('auth/login');
    }

    }

    public function index() {
        $user_type = $this->session->userdata('user_type');
        $data['vendors'] = $this->Vendor_model->get_all(2);
        $this->load->view('vendors/index', $data);
        if (!in_array($user_type, [1])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

    public function create() {
        $user_type = $this->session->userdata('user_type');
        $this->load->view('vendors/create');
        if (!in_array($user_type, [1])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

    public function store() {
        $user_type = $this->session->userdata('user_type');
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required|numeric');
        $this->form_validation->set_rules('whatsapp_no', 'Whatsapp Number', 'required|numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('vendors/create');
        } else {
            $data = [
                'name'        => $this->input->post('name'),
                'username'    => $this->input->post('username'),
                'email'       => $this->input->post('email'),
                'mobile_no'   => $this->input->post('mobile_no'),
                'whatsapp_no' => $this->input->post('whatsapp_no'),
                'password'    => $this->input->post('password'),
                'address'     => $this->input->post('address'),
                'pincode'     => $this->input->post('pincode'),
                'type'        => 2,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            $this->Vendor_model->insert($data);
            $this->session->set_flashdata('success', 'Vendor created successfully.');
            redirect('vendor');
        }
        if (!in_array($user_type, [1])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

    public function edit($id) {
        $user_type = $this->session->userdata('user_type');
        $data['vendor'] = $this->Vendor_model->get($id);
        $this->load->view('vendors/edit', $data);
        if (!in_array($user_type, [1])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

    public function update($id) {
        $user_type = $this->session->userdata('user_type');
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $data['vendor'] = $this->Vendor_model->get($id);
            $this->load->view('vendors/edit', $data);
        } else {
            $data = [
                'name'        => $this->input->post('name'),
                'email'       => $this->input->post('email'),
                'mobile_no'   => $this->input->post('mobile_no'),
                'whatsapp_no' => $this->input->post('whatsapp_no'),
                'address'     => $this->input->post('address'),
                'pincode'     => $this->input->post('pincode'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            $this->Vendor_model->update($id, $data);
            $this->session->set_flashdata('success', 'Vendor updated successfully.');
            redirect('vendor');
        }
        if (!in_array($user_type, [1])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

    public function delete($id) {
        $user_type = $this->session->userdata('user_type');
        $this->Vendor_model->delete($id);
        $this->session->set_flashdata('success', 'Vendor deleted successfully.');
        redirect('vendor');
        if (!in_array($user_type, [1])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }        
    }

}
