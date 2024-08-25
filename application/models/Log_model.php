<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model
{
	public function getAllData()
	{
		$this->db->select('*');
		$this->db->from('log a');
		$this->db->join('user b', 'a.id_user = b.id_user','left');
		$this->db->order_by('a.waktu', 'DESC');
		return $this->db->get()->result_array();
	}

	// tambah log
	public function insert($id_user, $url, $ket)
	{	
		date_default_timezone_set('Asia/Jakarta');
        $time = time();
		$data = [
			'id_user' => $id_user,
			'url' => $url,
			'ket' => $ket,
			'waktu' => $time,
		];

		$this->db->insert('log', $data);
	}
}