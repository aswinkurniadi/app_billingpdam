<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_model extends CI_Model
{

    // tagihan by id
    public function getTagihanByID($table, $id_plng, $value)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where_in($id_plng, $value);
        $query = $this->db->get()->row_array();
        return $query;
    }
    
    public function getTagihanByTable($table, $id_plng, $value)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where_in($id_plng, $value);
        $query = $this->db->get()->result();
        return $query;
    }

    // riwayat tagihan dan pelunasan    
    public function getDetailTagihan($id)
    {
        // join
        $query = "
            SELECT 
                b.name,
                a.id_piut as id_piutang_in, 
                '-' as id_piutang_out, 
                a.plng_id as plng_id,
                a.tgl,
                '-' as dibayar,
                '-' as diterima,
                a.bln,
                a.nilai,
                '-' as id_kas,
                '-' as kas,
                '-' as ket,
                1 as type
            FROM 
                piutang_in a
            LEFT JOIN user b ON a.user_id = b.id_user  WHERE plng_id = '$id'

            UNION

            SELECT 
                b.name,
                '-' as id_piutang_out, 
                a.id_piut as id_piutang_out, 
                a.plng_id as plng_id,
                a.tgl,
                a.dibayar,
                a.diterima,
                a.bln,
                a.nilai,
                c.id_kas,
                c.nm_kas as kas,
                a.ket,
                0 as type
            FROM 
                piutang_out a 
            LEFT JOIN user b ON a.user_id = b.id_user
            LEFT JOIN kas c ON a.id_kas = c.id_kas WHERE plng_id = '$id'
            ORDER BY tgl ASC";

        return $this->db->query($query)->result_array();
    }

    // hapus 
    public function deleteTagihan($table, $id)
    {
        return $this->db->delete($table, ['id_piut' => $id]);
    }









    // terkait pencarian tagihan
    public function fetch_data($find)
    {
        $this->db->select("*");
        $this->db->from("plng");
        if($find != '')
        {
            $this->db->like('nm', $find, 'after'); 
        }
        $this->db->order_by('nm', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }


}