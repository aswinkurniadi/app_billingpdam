<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Xendit extends CI_Controller 
{ 
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->model('Admin_model','admin');
	}

	public function index()
	{
		// semua transaksi
	}

	public function cek_all_transaction()
	{
		// tulis code disini		
	}

	public function choose_method_payment()
	{
		// tulis code disini
	}

	public function preview()
	{
		// tulis code disini
	}

	public function process()
	{
		// tulis code disini
	}
}