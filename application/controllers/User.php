<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->library('template');
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        
        
        $this->template->load('user/index', $data);
    }

    public function pengajuan()
    {
        $data['title'] = 'Input Pengajuan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['inputPengajuan'] = $this->db->get('pengajuan')->result_array();

        $this->form_validation->set_rules('cost_element', 'Cost_element', 'required');
        $this->form_validation->set_rules('cost_element_name', 'Cost_element_name', 'required');
        $this->form_validation->set_rules('cost_center', 'Cost_center', 'required');
        $this->form_validation->set_rules('value', 'Value', 'required');

        if($this->form_validation->run() == false) {
            $this->template->load('user/pengajuan', $data);
        } 
        
    }

}
