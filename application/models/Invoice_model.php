<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

    public function insert_invoice($data) {
        $this->db->insert('invoices', $data);
        return $this->db->insert_id();
    }

    public function insert_items($items) {
        return $this->db->insert_batch('invoice_items', $items);
    }

    public function update_invoice($invoice_id, $data) {
        $this->db->where('id', $invoice_id);
        return $this->db->update('invoices', $data);
    }

    public function delete_invoice($invoice_id) {
        $this->db->where('invoice_id', $invoice_id)->delete('invoice_items');
        return $this->db->where('id', $invoice_id)->delete('invoices');
    }

    public function generate_invoice_no() {
        $this->db->select('invoice_no');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('invoices');

        if ($query->num_rows() > 0) {
            $last_invoice_no = $query->row()->invoice_no;
            $number = (int) str_replace('INV', '', $last_invoice_no);
            $new_number = $number + 1;
        } else {
            $new_number = 1;
        }

        return 'INV' . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    }

    public function get_all_invoices($limit = null, $offset = null) {
        $this->db->select('
            invoices.*,
            users.name AS customer_name,
            COALESCE(SUM(ii.quantity * ii.unit_price), 0) AS subtotal_calc
        ', false);
        $this->db->from('invoices');
        $this->db->join('users', 'users.id = invoices.customer_id AND users.type = 3', 'left');
        $this->db->join('invoice_items AS ii', 'ii.invoice_id = invoices.id', 'left');
        $this->db->group_by('invoices.id');
        $this->db->order_by('invoices.id', 'DESC');

        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    public function count_all_invoices() {
        return $this->db->count_all('invoices');
    }

    public function get_invoice_with_items($invoice_id) {
        $this->db->select('invoices.*, users.name as customer_name');
        $this->db->from('invoices');
        $this->db->join('users', 'users.id = invoices.customer_id AND users.type = 3', 'left');
        $this->db->where('invoices.id', $invoice_id);
        $invoice = $this->db->get()->row();

        $this->db->where('invoice_id', $invoice_id);
        $items = $this->db->get('invoice_items')->result();

        return ['invoice' => $invoice, 'items' => $items];
    }

public function getInvoicesByCustomer($customer_id, $limit = null, $offset = null) {
    $this->db->select('i.*, u.name as customer_name, COALESCE(SUM(ii.quantity * ii.unit_price), 0) AS subtotal_calc', false);
    $this->db->from('invoices i');
    $this->db->join('users u', 'u.id = i.customer_id AND u.type = 3', 'left');
    $this->db->join('invoice_items ii', 'ii.invoice_id = i.id', 'left');
    $this->db->where('i.customer_id', $customer_id);
    $this->db->group_by('i.id');
    $this->db->order_by('i.id', 'DESC');

    if ($limit !== null && $offset !== null) {
        $this->db->limit($limit, $offset);
    }

    return $this->db->get()->result();
}



    public function getCustomerOutstanding($customer_id) {
        $this->db->select_sum('grand_total');
        $this->db->from('invoices');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('status', 'unpaid');
        $result = $this->db->get()->row();
        return $result->grand_total ?? 0;
    }

    public function get_existing_invoice($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('invoices')->row();
    }

    public function get_invoice($id) {
        return $this->db->get_where('invoices', ['id' => $id])->row();
    }

    public function get_invoice_items($invoice_id) {
        return $this->db->get_where('invoice_items', ['invoice_id' => $invoice_id])->result();
    }

    public function get_customer_total_pending($customer_id) {
        $this->db->select_sum('subtotal');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('status', 'unpaid');
        $query = $this->db->get('invoices');
        return $query->row()->subtotal;
    }

    public function pdf($id) {
        $this->load->library('pdf');
        $invoice = $this->Invoice_model->get_invoice($id);
        $items   = $this->Invoice_model->get_invoice_items($id);

        $html = $this->load->view('invoices/pdf_template', [
            'invoice' => $invoice,
            'items'   => $items
        ], TRUE);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("invoice_{$invoice->invoice_no}.pdf", array("Attachment" => 0));
    }

    public function add_payment($data) {
        $this->db->insert('payments', $data);
        return $this->db->insert_id();
    }

    public function get_total_received($invoice_id) {
        $this->db->select_sum('amount');
        $this->db->where('invoice_id', $invoice_id);
        $res = $this->db->get('payments')->row();
        return $res->amount ?? 0;
    }

    public function receive_payment_info($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('status', 'unpaid');
        $this->db->order_by('id', 'DESC');
        $invoice = $this->db->get('invoices')->row();

        if (!$invoice) return null;

        $this->db->select_sum('amount');
        $this->db->where('invoice_id', $invoice->id);
        $this->db->where('customer_id', $customer_id);
        $payments = $this->db->get('payments')->row();
        $received = $payments->amount ?? 0;

        return [
            'invoice_id'  => $invoice->id,
            'customer_id' => $customer_id,
            'invoice_no'  => $invoice->invoice_no,
            'grand_total' => $invoice->grand_total,
            'received'    => $received,
            'pending'     => $invoice->grand_total - $received
        ];
    }

    public function get_total_pending_of_customer($customer_id) {
        $this->db->select_sum('grand_total');
        $this->db->where('customer_id', $customer_id);
        $this->db->where('status', 'unpaid');
        $result = $this->db->get('invoices')->row();
        return $result->grand_total ? (float)$result->grand_total : 0;
    }

    public function get_all_unpaid_invoices($customer_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('status', 'unpaid');
        $invoices = $this->db->get('invoices')->result();

        foreach ($invoices as $invoice) {
            $invoice->received = $this->get_total_received($invoice->id);
            $invoice->pending = $invoice->grand_total - $invoice->received;
        }
        return $invoices;
    }

    public function get_payment_history($customer_id = null, $invoice_id = null) {
        $this->db->select('p.*, i.invoice_no, u.name as customer_name');
        $this->db->from('payments p');
        $this->db->join('invoices i', 'i.id = p.invoice_id');
        $this->db->join('users u', 'u.id = p.customer_id AND u.type = 3');

        if ($customer_id) {
            $this->db->where('p.customer_id', $customer_id);
        }

        if ($invoice_id) {
            $this->db->where('p.invoice_id', $invoice_id);
        }

        $this->db->order_by('p.payment_date', 'DESC');
        return $this->db->get()->result();
    }

    public function get_invoices_by_vendor($vendor_id, $limit = null, $offset = null) {
        $this->db->select('i.*, c.name as customer_name, COALESCE(SUM(ii.quantity * ii.unit_price), 0) AS subtotal_calc', false);
        $this->db->from('invoices i');
        $this->db->join('users c', 'c.id = i.customer_id AND c.type = 3', 'left');
        $this->db->join('invoice_items ii', 'ii.invoice_id = i.id', 'left');
        $this->db->where('c.vendor_id', $vendor_id);
        $this->db->group_by('i.id');
        $this->db->order_by('i.id', 'DESC');

        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

public function get_all_payment_history() {
    $this->db->select('p.*, u.name as customer_name, i.invoice_no'); // select needed fields
    $this->db->from('payments p');
    $this->db->join('users u', 'u.id = p.customer_id', 'left'); // join users table
    $this->db->join('invoices i', 'i.id = p.invoice_id', 'left'); // join invoices for invoice_no
    $this->db->where('u.type', 3); // only users with type = 3
    $this->db->order_by('p.payment_date', 'DESC');
    return $this->db->get()->result();
}




    public function count_invoices_by_vendor($vendor_id) {
        $this->db->from('invoices i');
        $this->db->join('users c', 'c.id = i.customer_id AND c.type = 3', 'left');
        $this->db->where('c.vendor_id', $vendor_id);
        return $this->db->count_all_results();
    }



}
