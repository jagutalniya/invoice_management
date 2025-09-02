<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    
    public function __construct(){
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation');

    if (!$this->session->userdata('logged_in')) {
        redirect('auth/login');
    }

    }
    
public function index() {
    $user_type = $this->session->userdata('user_type');
    $user_id   = $this->session->userdata('user_id');

    $data['customers'] = [];
    $data['total']     = 0;

    if ($user_type == 1) { 
        $data['customers'] = $this->Customer_model->get_all_customers_with_vendor();
        $data['total']     = $this->Customer_model->count_all_customers();
    } elseif ($user_type == 2) {
        $vendor_id = $this->session->userdata('user_id');
        $data['customers'] = $this->Customer_model->get_customers_by_vendor($vendor_id);
        $data['total']     = $this->Customer_model->count_customers_by_vendor($vendor_id);
    } elseif ($user_type == 3) {
        $customer = $this->Customer_model->get_customer_by_id($user_id);
        $data['customers'] = $customer ? [$customer] : [];
        $data['total']     = $customer ? 1 : 0;
    } else {
        $this->session->set_flashdata('error', 'Access denied.');
        redirect('invoices');
        exit;
    }
        if (!in_array($user_type, [1, 2])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    $this->load->view('customers/index', $data);
}



    public function create(){
        $user_type = $this->session->userdata('user_type');
        $data['vendors'] = $this->db->where('type', 2)->get('users')->result();
        if (!in_array($user_type, [1, 2])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
            exit;
        }
        $this->load->view('customers/create', $data);
    }

    public function store(){
        $user_type = $this->session->userdata('user_type');
        $this->form_validation->set_rules('vendor_id', 'Vendor', 'required');
        $this->form_validation->set_rules('name', 'Full Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['vendors'] = $this->db->where('type', 2)->get('users')->result();
            $this->load->view('customers/create', $data);
        } else {
            $insertData = [
                'vendor_id'            => $this->input->post('vendor_id'),
                'name'                 => $this->input->post('name'),
                'username'             => $this->input->post('username'),
                'mobile_no'            => $this->input->post('mobile_no'),
                'whatsapp_no'          => $this->input->post('whatsapp_no'),
                'email'                => $this->input->post('email'),
                'password'             => $this->input->post('password'),
                'aadhar_no'            => $this->input->post('aadhar_no'),
                'pan_card_no'          => $this->input->post('pan_card_no'),
                'gst_no'               => $this->input->post('gst_no'),
                'address'              => $this->input->post('address'),
                'pincode'              => $this->input->post('pincode'),
                'bank_name'            => $this->input->post('bank_name'),
                'bank_account_holder'  => $this->input->post('bank_account_holder'),
                'account_no'           => $this->input->post('account_no'),
                'ifsc_code'            => $this->input->post('ifsc_code'),
                'type'                 => 3,
                'created_at'           => date('Y-m-d H:i:s'),
                'updated_at'           => date('Y-m-d H:i:s')
            ];

            $this->Customer_model->insert($insertData);

            $this->session->set_flashdata('success', 'Customer added successfully.');
            redirect('customer');
        }
        if (!in_array($user_type, [1, 2])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

    public function edit($id){
        $user_type = $this->session->userdata('user_type');
        $data['customer'] = $this->Customer_model->get($id);
        $data['vendors'] = $this->db->where('type', 2)->get('users')->result();

        $this->load->view('customers/edit', $data);
    }

    public function update_field() {
        $user_type = $this->session->userdata('user_type');
        $id    = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        $allowed = ['name', 'mobile_no', 'address'];

        if ($id && in_array($field, $allowed)) {
            $this->db->where('id', $id)
                     ->where('type', 3)
                     ->update('users', [$field => $value]);

            echo "success";
        } else {
            echo "error";
        }
        if (!in_array($user_type, [1, 2])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

    public function update($id){
        $user_type = $this->session->userdata('user_type');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['customer'] = $this->Customer_model->get($id);
            $data['vendors']  = $this->db->where('type', 2)->get('users')->result();
            $this->load->view('customers/edit', $data);
        } else {
            $data = [
                'name'                => $this->input->post('name'),
                'mobile_no'           => $this->input->post('mobile_no'),
                'address'             => $this->input->post('address'),
            ];

            if ($this->input->post('password')) {
                $data['password'] = ($this->input->post('password'));
            }

            $this->Customer_model->update($id, $data);

            $this->session->set_flashdata('success', 'Customer updated successfully.');
            redirect('customer'); 
        }
        if (!in_array($user_type, [1, 2])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

    public function delete($id){
        $user_type = $this->session->userdata('user_type');
        $this->Customer_model->delete($id);
        redirect('customer'); 
        if (!in_array($user_type, [1, 2])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        }
    }

}