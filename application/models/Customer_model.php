<?php
class Customer_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($limit = null, $offset = null) {
        $this->db->where('type', 3);
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('users')->result();
    }

    public function count_all_customers() {
        $this->db->where('type', 3);
        return $this->db->count_all_results('users');
    }
    
    public function get($id){
        return $this->db->where('id', $id)
                        ->where('type', 3)
                        ->get('users')
                        ->row();
    }

    public function insert($data) {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id) {
        return $this->db->delete('users', array('id' => $id));
    }

    public function get_customer_name($customer_id) {
        $customer = $this->db->where('id', $customer_id)
                             ->where('type', 3)
                             ->get('users')
                             ->row();
        return $customer ? $customer->name : 'Unknown Customer';
    }

    public function get_customers_by_vendor($vendor_id, $limit = 0, $offset = 0) {
        $this->db->select('u.*, v.name as vendor_name');
        $this->db->from('users u');
        $this->db->join('users v', 'v.id = u.vendor_id', 'left');
        $this->db->where('u.vendor_id', $vendor_id);
        $this->db->where('u.type', 3);
        if($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function count_customers_by_vendor($vendor_id) {
        $this->db->where('vendor_id', $vendor_id);
        $this->db->where('type', 3);
        return $this->db->count_all_results('users');
    }

    public function get_customer_by_id($id) {
        $this->db->where('id', $id);
        $this->db->where('type', 3);
        return $this->db->get('users')->row();
    }

    public function get_all_customers_with_vendor() {
        $this->db->select('c.*, v.name as vendor_name');
        $this->db->from('users c');
        $this->db->join('users v', 'v.id = c.vendor_id AND v.type = 2', 'left');
        $this->db->where('c.type', 3); // customers only
        $this->db->order_by('c.id', 'DESC');
        return $this->db->get()->result();
    }


}
