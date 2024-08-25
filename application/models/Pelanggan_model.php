<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model
{
    // Datatables serverside
    var $column_order = array('plng.id_plng','plng.no_plng','plng.nm','plng.almt','plng.no_telp','plng.nomor_air','paket.nama','paket.nilai'); //set column field database for datatable orderable
    var $column_search = array('plng.id_plng','plng.no_plng','plng.nm','plng.almt','plng.no_telp','plng.nomor_air','paket.nama','paket.nilai'); //set column field database for datatable searchable 
    var $order = array('plng.tgl' => 'asc'); // default order 
 
    private function _get_datatables_query()
    {    
        $this->db->select('plng.*, paket.*');
        $this->db->from('plng');
        $this->db->join('paket', 'plng.id_paket = paket.id_paket', 'left');
        $this->db->where_in('plng.stts', 1);

        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from('plng');
        $this->db->join('paket', 'plng.id_paket = paket.id_paket', 'left');
        $this->db->where_in('plng.stts', 1);
        return $this->db->count_all_results();
    }
    // Datatables serverside pelanggan
    




	// menampilkan semua data pelanggan
    public function getCustomer()
    {
        $this->db->select('*');
        $this->db->from('plng');
        $query = $this->db->get()->result();
        return $query;
    }

    // menampilkan data pelanggan by id
    public function getCustomerById($id)
    {
        return $this->db->get_where('plng', ['id_plng' => $id])->row();
    }

    // mencari nilai terakhir
    public function check_max_code()
    {
        $query = $this->db->query("SELECT max(no_plng) as no_plng from plng");
        return $query->row()->no_plng;
    }

    // simpan tambah data pelanggan
    public function insert()
    {
		$data = [
            "no_plng"       => $this->input->post('no_plng', true),
            "tgl"           => $this->input->post('tgl', true),
            "nm"            => $this->input->post('nm', true),
            "almt"          => $this->input->post('almt', true),
            "no_telp"       => $this->input->post('no_telp', true),
            "nomor_air"     => $this->input->post('nomor_air', true),
            "id_paket"      => $this->input->post('id_paket', true),
            "stts"      	=> 1,
        ];

        $this->db->insert('plng', $data);
    }

    // simpan ubah data pelanggan
	public function update($id_plng)
    {
		$data = [
            "tgl"           => $this->input->post('tgl', true),
            "nm"            => $this->input->post('nm', true),
            "almt"          => $this->input->post('almt', true),
            "no_telp"       => $this->input->post('no_telp', true),
            "nomor_air"     => $this->input->post('nomor_air', true),
            "id_paket"      => $this->input->post('id_paket', true),
        ];

        $this->db->where('id_plng', $id_plng);
        return $this->db->update('plng', $data);
    }
    // hapus data pelanggan
    public function delete($id)
    {
        return $this->db->delete('plng', ['id_plng' => $id]);
    }


    public function getAllDtPemutusan()
    {
        $this->db->select('plng_berhenti.ket, plng_berhenti.tgl as tgl_putus, plng.*, paket.nama as nm_paket');
        $this->db->from('plng_berhenti');
        $this->db->join('plng', 'plng_berhenti.id_plng = plng.id_plng', 'left');
        $this->db->join('paket', 'plng.id_paket = paket.id_paket', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
}
    