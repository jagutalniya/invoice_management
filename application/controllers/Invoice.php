<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use Dompdf\Options;
use Mpdf\Mpdf;

class Invoice extends CI_Controller {

public function __construct() {
    parent::__construct();
    $this->load->model('Invoice_model');
    $this->load->model('Customer_model');
    $this->load->helper(array('url', 'form'));
    $this->load->library('session');

    if (!$this->session->userdata('logged_in')) {
        redirect('auth/login');
    }

}


    public function index(){
        $page = (int) $this->input->get('page');
        if ($page < 1) { $page = 1; }

        $per_page = 5;
        $offset   = ($page - 1) * $per_page;

        $user_type = $this->session->userdata('user_type');
        $user_id   = $this->session->userdata('user_id');

        if($user_type == 1){
            $data['invoices'] = $this->Invoice_model->get_all_invoices($per_page, $offset);
            $data['total']    = $this->Invoice_model->count_all_invoices();
        } elseif($user_type == 2){
            $data['invoices'] = $this->Invoice_model->get_invoices_by_vendor($user_id, $per_page, $offset);
            $data['total']    = $this->Invoice_model->count_invoices_by_vendor($user_id);
        } else {
            $data['invoices'] = $this->Invoice_model->getInvoicesByCustomer($user_id);
            $data['total']    = count($data['invoices']);
        }

        $data['per_page'] = $per_page;
        $data['page']     = $page;

        $this->load->view('invoices/index', $data);
    }


    public function create() {
        $user_type = $this->session->userdata('user_type');
        $user_id   = $this->session->userdata('user_id');

        $per_page = 5;
        $offset   = 0;
        

        if ($user_type == 1) {
            $data['invoices']  = $this->Invoice_model->get_all_invoices($per_page, $offset);
            $data['customers'] = $this->Customer_model->get_all_customers_with_vendor($per_page, $offset);
            $data['total']     = $this->Invoice_model->count_all_invoices();
        } elseif ($user_type == 2) {
            $data['invoices']  = $this->Invoice_model->get_invoices_by_vendor($user_id, $per_page, $offset);
            $data['customers'] = $this->Customer_model->get_customers_by_vendor($user_id) ?: [];
            $data['total']     = $this->Invoice_model->count_invoices_by_vendor($user_id);
        } else {
            $data['invoices']  = $this->Invoice_model->getInvoicesByCustomer($user_id);
            $customer          = $this->Customer_model->get_customer_by_id($user_id);
            $data['customers'] = $customer ? [$customer] : [];
            $data['total']     = count($data['invoices']);
        }
        $this->load->view('invoices/create', $data);
            if (!in_array($user_type, [1, 2])) {
                $this->session->set_flashdata('error', 'Access denied.');
                redirect('invoices');
            exit;
        }
    }


    public function store() {
        $user_type = $this->session->userdata('user_type');
        $customer_id = $this->input->post('customer_id');

        $last_invoice = $this->Invoice_model->get_existing_invoice($customer_id);
        $prev_pending = $this->Invoice_model->get_total_pending_of_customer($customer_id);
        $invoice_no = $this->Invoice_model->generate_invoice_no();

        $invoice_data = [
            'customer_id'  => $customer_id,
            'invoice_no'   => $invoice_no,
            'invoice_date' => $this->input->post('invoice_date'),
            'due_date'     => $this->input->post('due_date'),
            'subtotal'     => (float)$this->input->post('subtotal'),
            'discount'     => (float)$this->input->post('discount'),
            'previous_pending' => $prev_pending,
            'grand_total'  => ((float)$this->input->post('subtotal') - (float)$this->input->post('discount')) + $prev_pending,
            'notes'        => $this->input->post('notes'),
            'status'       => $this->input->post('status'),
        ];

        $invoice_id = $this->Invoice_model->insert_invoice($invoice_data);

        $items = [];
        $descriptions = $this->input->post('description');
        $quantities   = $this->input->post('quantity');
        $prices       = $this->input->post('unit_price');
        $totals       = $this->input->post('total');

        foreach ($descriptions as $i => $desc) {
            if (!empty($desc)) {
                $items[] = [
                    'invoice_id'  => $invoice_id,
                    'description' => $desc,
                    'quantity'    => $quantities[$i],
                    'unit_price'  => $prices[$i],
                    'total'       => $totals[$i],
                ];
            }
        }

        if (!empty($items)) {
            $this->Invoice_model->insert_items($items);
        }
        if (!in_array($user_type, [1, 2])) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('invoices');
        exit;
        } 
        redirect('invoice/view/'.$invoice_id);
    }


    public function view($id) {
        $user_type = $this->session->userdata('user_type');
        $data = $this->Invoice_model->get_invoice_with_items($id);
        $invoice = $data['invoice'];
        $items   = $data['items'];

        $subtotal = 0;
        foreach($items as $item){
            $subtotal += $item->quantity * $item->unit_price;
        }

        $received = $this->Invoice_model->get_total_received($invoice->id);
        $pending  = $invoice->grand_total - $received;

        $data['subtotal'] = $subtotal;
        $data['received'] = $received;
        $data['pending']  = $pending;
        $data['invoice']  = $invoice;
        $data['items']    = $items;

        $this->load->view('invoices/view', $data);
    }

    public function delete($id) {
        $this->Invoice_model->delete_invoice($id);
        redirect('invoice');
    }
        
    public function download($id, $mode = 'D') {
        $this->load->model('Invoice_model');

        $data = $this->Invoice_model->get_invoice_with_items($id);
        $invoice = $data['invoice'];
        $items   = $data['items'];

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item->quantity * $item->unit_price;
        }

        $received = $this->Invoice_model->get_total_received($invoice->id);
        $pending  = $invoice->grand_total - $received;

        $data['subtotal'] = $subtotal;
        $data['received'] = $received;
        $data['pending']  = $pending;
        $data['invoice']  = $invoice;
        $data['items']    = $items;

        $html = $this->load->view('invoices/pdf_template', $data, true);

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("invoice_{$invoice->invoice_no}.pdf", $mode);
    }
    
    public function receive_payment($customer_id = null) {
        $this->load->model('Customer_model');
        $this->load->model('Invoice_model');

        $user_type = $this->session->userdata('user_type');
        $user_id   = $this->session->userdata('user_id');

        if ($user_type == 1) {
            $data['customers'] = $this->Customer_model->get_all();
        } elseif ($user_type == 2) { 
            $data['customers'] = $this->Customer_model->get_customers_by_vendor($user_id);
        } else { 
            $customer = $this->Customer_model->get_customer_by_id($user_id);
            $data['customers'] = $customer ? [$customer] : [];
        }

        if ($this->input->get('customer_id')) {
            $customer_id = $this->input->get('customer_id');
        }

        if ($customer_id) {
            $data['customer_id'] = $customer_id;
            $data['customer_name'] = $this->Customer_model->get_customer_name($customer_id);

            $data['invoices'] = $this->Invoice_model->get_all_unpaid_invoices($customer_id);

            $data['total_outstanding'] = 0;
            foreach ($data['invoices'] as $invoice) {
                $data['total_outstanding'] += $invoice->pending;
            }
        } else {
            $data['invoices'] = [];
            $data['customer_id'] = null;
            $data['customer_name'] = '';
            $data['total_outstanding'] = 0;
        }
      
        $this->load->view('invoices/receive_payment', $data);
    }

    public function submit_payment() {
        $user_type = $this->session->userdata('user_type');
        $customer_id = $this->input->post('customer_id');
        $amount      = (float)$this->input->post('amount');
        $payment_date= $this->input->post('payment_date');

        $this->db->where('customer_id', $customer_id);
        $this->db->where('status', 'unpaid');
        $unpaid_invoices = $this->db->get('invoices')->result();

        $remaining_payment = $amount;

        foreach ($unpaid_invoices as $invoice) {
            if ($remaining_payment <= 0) break;

            $invoice_pending = $invoice->grand_total - $this->Invoice_model->get_total_received($invoice->id);

            $payment_to_apply = min($remaining_payment, $invoice_pending);

            $this->Invoice_model->add_payment([
                'invoice_id'   => $invoice->id,
                'customer_id'  => $customer_id,
                'amount'       => $payment_to_apply,
                'payment_date' => $payment_date
            ]);

            $remaining_payment -= $payment_to_apply;

            $received = $this->Invoice_model->get_total_received($invoice->id);
            if ($received >= $invoice->grand_total) {
                $this->db->where('id', $invoice->id)->update('invoices', ['status' => 'paid']);
            }
        }
            if (!in_array($user_type, [1, 2])) {
                $this->session->set_flashdata('error', 'Access denied.');
                redirect('invoices');
            exit;
        } 
        redirect('invoice');
    }
    public function payment_history($customer_id = null) {
        $this->load->model('Invoice_model');
        $this->load->model('Customer_model');

        $user_type = $this->session->userdata('user_type');
        $user_id   = $this->session->userdata('user_id');

        if ($user_type == 1) {
            $data['customers'] = $this->Customer_model->get_all();
        } elseif ($user_type == 2) {
            $data['customers'] = $this->Customer_model->get_customers_by_vendor($user_id);
        } else {
            $customer = $this->Customer_model->get_customer_by_id($user_id);
            $data['customers'] = $customer ? [$customer] : [];
        }

        if ($this->input->get('customer_id')) {
            $customer_id = $this->input->get('customer_id');
        } elseif ($user_type == 2) {
            $customer_id = !empty($data['customers']) ? $data['customers'][0]->id : null;
        } elseif ($user_type == 3) {
            $customer_id = $user_id;
        }

        $data['customer_id'] = $customer_id;

        if ($customer_id) {
            $data['payments'] = $this->Invoice_model->get_payment_history($customer_id);
            $data['customer_name'] = $this->Customer_model->get_customer_name($customer_id);
        } else {
            if ($user_type == 1) {
                $data['payments'] = $this->Invoice_model->get_all_payment_history();
                $data['customer_name'] = "All Customers";
            } else {
                $data['payments'] = [];
                $data['customer_name'] = '';
            }
        }

        $this->load->view('invoices/payment_history', $data);
    }

}