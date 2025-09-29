<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subsidi extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model','admin');
	}

	public function index()
	{
		$data['title'] = 'Subsidi';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dt_all'] = $this->admin->getAllByTable('subsidi', 'id_subsidi', 'asc');

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('setting/subsidi', $data);
		$this->load->view('templates/footer');
	}

	public function update()
	{
		$id_paket = $this->input->post('id_paket', true);

		$data = [
	        "nama" => $this->input->post('nama', true),
	        "nilai" => $this->input->post('nilai', true),
		];

		$this->admin->updateDatabyTable('paket', 'id_paket', $id_paket, $data);
		$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">Data berhasil diubah! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('paket');
	}

	public function delete($id)
	{
		$this->admin->deleteDataById('paket', 'id_paket', $id);
		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data berhasil dihapus! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('paket');
	}

}