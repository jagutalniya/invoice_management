<?php
class Vendor_model extends CI_Model {
    private $table = 'users';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert($data) {
        $data['type'] = 2;
        return $this->db->insert($this->table, $data);
    }

    public function get_all($type = 2) {
        return $this->db->where('type', $type)
                        ->get($this->table)
                        ->result();
    }

    public function get_all_vendors() {
        return $this->db->where('type', 2)
                        ->get($this->table)
                        ->result();
    }

    public function get($id) {
        return $this->db->where('id', $id)
                        ->where('type', 2)
                        ->get($this->table)
                        ->row();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)
                        ->where('type', 2)
                        ->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)
                        ->where('type', 2)
                        ->delete($this->table);
    }
}
