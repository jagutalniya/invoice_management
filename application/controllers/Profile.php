<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(array('url','form'));
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function edit() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->db->where('id', $user_id)->get('users')->row();
        $this->load->view('auth/profile_edit', $data);
    }

    public function update() {
        if ($this->input->post()) {
            $user_id = $this->session->userdata('user_id');
            $user = $this->db->where('id', $user_id)->get('users')->row();

            $update_data = array(
                'name'      => $this->input->post('name'),
                'username'  => $this->input->post('username'),
                'email'     => $this->input->post('email'),
                'mobile_no' => $this->input->post('mobile_no')
            );

            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            if(!empty($old_password) && !empty($new_password))
                 {if ($old_password === $user->password) {
                    if($new_password === $confirm_password){
                        $update_data['password'] = $new_password;
                    } else {
                        $this->session->set_flashdata('error', 'New password and confirm password do not match.');
                        redirect('profile/edit');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Old password is incorrect.');
                    redirect('profile/edit');
                }
            }

            $this->db->where('id', $user_id)->update('users', $update_data);

            $this->session->set_userdata([
                'name'     => $update_data['name'],
                'username' => $update_data['username']
            ]);

            $this->session->set_flashdata('success', 'Profile updated successfully.');
            redirect('profile/edit');
        }
    }
}
