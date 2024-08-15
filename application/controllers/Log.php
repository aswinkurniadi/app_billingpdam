<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        is_logged_in();
        
        $this->load->model('Pelanggan_model','pelanggan');
    }
    
	// Masterdata Pelanggan Internet
    public function index()
    {
        $data['title'] = 'Log';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('setting/log', $data);
        $this->load->view('templates/footer');
    }
}