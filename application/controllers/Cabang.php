<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model','admin');
	}

	public function index()
	{
		$data['title'] = 'Cabang';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		$data['dt_all'] = $this->admin->getAllByTable('cabang', 'id_cabang', 'asc');

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('setting/cabang', $data);
		$this->load->view('templates/footer');
	}

	public function add()
	{
		$data = [
	        "nama" => $this->input->post('nama', true),
		];

		$this->admin->addDatabyTable('cabang', $data);
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Data berhasil ditambahkan! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('cabang');
	}

	public function update()
	{
		$id_cabang = $this->input->post('id_cabang', true);

		$data = [
	        "nama" => $this->input->post('nama', true),
		];

		$this->admin->updateDatabyTable('cabang', 'id_cabang', $id_cabang, $data);
		$this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">Data berhasil diubah! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('cabang');
	}

	public function delete($id)
	{
		$this->admin->deleteDataById('cabang', 'id_cabang', $id);
		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data berhasil dihapus! 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		  	</button></div>');
			redirect('cabang');
	}

}