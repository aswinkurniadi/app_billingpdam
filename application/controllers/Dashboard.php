<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	public function __construct()
	{
	 	parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model', 'admin');
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		// GetData
		$data['jumlahuser'] = $this->admin->count('user');

        $data['cabang'] = $this->admin->getAllByTable('cabang', 'id_cabang', 'ASC');
        $data['id_cabang'] = $data['user']['id_cab'];

		$this->form_validation->set_rules('cabang','', 'required');
        if( $this->form_validation->run() == false ){
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('dashboard', $data);
			$this->load->view('templates/footer');
        } else {
            $data['id_cabang'] = $this->input->post('cabang');

            // update id_cabang
            $this->db->set('id_cab', $data['id_cabang']);

            $this->db->where('id_user', $data['user']['id_user']);
            $this->db->update('user');

            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Cabang berhasil diubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('dashboard');
        }
	}

	public function dashboard2()
	{
		// dashboard pelanggan
		$data['title'] = 'PDAM SAYA';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

		// GetData
		$data['jumlahuser'] = $this->admin->count('user');

        $data['cabang'] = $this->admin->getAllByTable('cabang', 'id_cabang', 'ASC');
        $data['id_cabang'] = $data['user']['id_cab'];

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('dashboard2', $data);
		$this->load->view('templates/footer');
	}
}