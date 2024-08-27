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
                a.ket,
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

    // Tambah baru
    public function insertTagihanBaru($nilai_new)
    {
        $dt_user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data = [
            "id_piut"   => "",
            "plng_id"   => $this->input->post('id_plng', true),
            "nilai"     => intval($nilai_new),
            "bln"       => $this->input->post('bln', true),
            "tgl"       => $this->input->post('tgl', true),
            "user_id"   => $dt_user['id_user'],
            "ket"       => $this->input->post('ket', true),
        ];

        $this->db->insert('piutang_in', $data);
    }
    
    // Tambah baru
    public function insertPelunasan($nilai_new)
    {
        $dt_user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $data = [
            "id_piut"   => "",
            "plng_id"   => $this->input->post('id_plng', true),
            "nilai"     => intval($nilai_new),
            "bln"       => $this->input->post('bln', true),
            "id_kas"    => $this->input->post('kas', true),
            "tgl"   => $this->input->post('tgl', true),
            "user_id"   => $dt_user['id_user'],
            "dibayar"   => $this->input->post('dibayar', true),
            "diterima"  => $this->input->post('diterima', true),
            "ket"       => $this->input->post('ket', true),
        ];

        $this->db->insert('piutang_out', $data);
    }

    public function updateTagihan($type, $value)
    {   
        if($type == 1){
            $data = [
                "nilai"     => intval($value),
                "bln"       => $this->input->post('bln_edit', true),
                "ket"       => $this->input->post('ket', true)
            ];

            $this->db->where('id_piut', $this->input->post('id_piut_edit'));
            $this->db->update('piutang_in', $data);
        } else {
            $data = [
                "id_kas"    => intval($this->input->post('kas_edit', true)),
                "nilai"     => intval($value),
                "bln"       => $this->input->post('bln_edit', true),
                "tgl"       => $this->input->post('tgl_edit', true),
                "dibayar"   => $this->input->post('dibayar', true),
                "diterima"  => $this->input->post('diterima', true),
                "ket"       => $this->input->post('ket', true)
            ];

            $this->db->where('id_piut', $this->input->post('id_piut_edit'));
            $this->db->update('piutang_out', $data);
        }
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

    // 
    public function insertPelunasanTagihan($user_id, $nilai_new)
    {
        $data = [
            "id_piut"   => "",
            "plng_id"   => $this->input->post('id_plng', true),
            "nilai"     => intval($nilai_new),
            "bln"       => $this->input->post('bln', true),
            "id_kas"    => $this->input->post('kas', true),
            "tgl"       => $this->input->post('tgl', true),
            "user_id"   => $user_id,
            "dibayar"   => $this->input->post('dibayar', true),
            "diterima"  => $this->input->post('diterima', true),
        ];

        $this->db->insert('piutang_out', $data);
    }

    public function getDataRepayment($tglAwal, $tglAkhir, $col)
    {
        $this->db->select('
                piutang_out.id_piut, piutang_out.nilai, piutang_out.bln, piutang_out.tgl,
                user.name,
                plng.id_plng, plng.no_plng, plng.nm, plng.almt,
                kas.nm_kas, kas.id_kas
                ');
            $this->db->from('piutang_out');
            $this->db->join('plng', 'piutang_out.plng_id = plng.id_plng');
            $this->db->join('kas', 'piutang_out.id_kas = kas.id_kas');
            $this->db->join('user', 'piutang_out.user_id = user.id_user','left');
            
            $array = array('piutang_out.tgl >=' => $tglAwal, 'piutang_out.tgl <=' => $tglAkhir, 'piutang_out.user_id' => $col);
        $this->db->where($array);
        $this->db->order_by('piutang_out.tgl', 'asc');
        return $this->db->get()->result_array();        
    }

    public function getDataRepaymentByKas($tglAwal, $tglAkhir, $cabang , $col = null, $kas = null)
    {
        $this->db->select('
                piutang_out.id_piut, piutang_out.nilai, piutang_out.bln, piutang_out.tgl,
                user.name,
                plng.id_plng, plng.no_plng, plng.nm, plng.almt, plng.tgl as tgl_pasang,
                kas.nm_kas, kas.id_kas
                ');
            $this->db->from('piutang_out');
            $this->db->join('plng', 'piutang_out.plng_id = plng.id_plng','left');
            $this->db->join('kas', 'piutang_out.id_kas = kas.id_kas','left');
            $this->db->join('user', 'piutang_out.user_id = user.id_user','left');
        if($col == null && $kas != null) {
            $array = array('piutang_out.tgl >=' => $tglAwal, 'piutang_out.tgl <=' => $tglAkhir, 'kas.id_kas' => $kas);
        } else if($col != null && $kas == null) {
            $array = array('piutang_out.tgl >=' => $tglAwal, 'piutang_out.tgl <=' => $tglAkhir, 'piutang_out.user_id' => $col);
        } else if($col != null && $kas != null) {
            $array = array('piutang_out.tgl >=' => $tglAwal, 'piutang_out.tgl <=' => $tglAkhir, 'kas.id_kas' => $kas, 'piutang_out.user_id' => $col);
        } else {
            $array = array('piutang_out.tgl >=' => $tglAwal, 'piutang_out.tgl <=' => $tglAkhir);
        }
        $this->db->where($array);
        $this->db->where_in('user.id_cab', $cabang);
        $this->db->order_by('piutang_out.tgl', 'asc');
        return $this->db->get()->result_array();
    }



    // laporan setoran tagihan
    public function getDataSetoran()
    {
        $this->db->select('*');
        $this->db->from('setoran');
        $this->db->join('user', 'setoran.id_user = user.id_user','left');
        $this->db->order_by('setoran.tgl', 'desc');
        return $this->db->get()->result_array();
    }

    public function insert_setoran()
    {

    }

    public function update_setoran()
    {
        
    }

    public function delete_setoran()
    {
        
    }



}