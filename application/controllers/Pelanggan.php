<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Pelanggan extends CI_Controller
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
        $data['title'] = 'Data Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $data['data_id'] = rawurlencode(base64_encode(json_encode(array("cabang" => $data['user']['id_cab'], "id_role" =>  $data['user']['id_role']))));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pelanggan/index', $data);
        $this->load->view('templates/footer');
    }

    public function ajax_list_pelanggan()
    {
        $this->load->model('Admin_model','admin');
        
        // $id_data = json_decode(base64_decode(rawurldecode($data_id)));

        $list = $this->pelanggan->get_datatables(); 

        // echo json_encode($list);
        // die;

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            
            $paket = $this->admin->GetDataById('paket','id_paket', $customers->id_paket);
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customers->no_plng;
            $row[] = $customers->nm;
            $row[] = $customers->almt;
            $row[] = $customers->no_telp;
            $row[] = $customers->nomor_air;
            $row[] = $paket['nama'];
            $row[] = 'Rp. '.number_format($paket['nilai'],0,',','.').' ,-';
            $row[] = $customers->stts == 0 ? "<span class='badge badge-danger'>Non-Aktif</span>" : "<span class='badge badge-success'>Aktif</span>" ;
            
            $row[] = '<a href="'.base_url('pelanggan/detail/').$customers->id_plng.'" class="badge badge-success">
                            <span class="icon text-white-50">
                                <i class="fas fa-fw fa-eye"></i>
                            </span>
                            <span class="text">Detail</span>
                        </a>
                        <a href="'.base_url('pelanggan/update/').$customers->id_plng.'" class="badge badge-primary">
                            <span class="icon text-white-50">
                                <i class="fas fa-fw fa-edit"></i>
                            </span>
                            <span class="text">Edit</span>
                        </a>';
                
            $data[] = $row;
        }
 
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->pelanggan->count_all(),
                    "recordsFiltered" => $this->pelanggan->count_filtered(),
                    "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    // tambah data pelanggan
    public function add()
    {
        $data['title'] = 'Tambah Data Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->load->model('Admin_model','admin');

        date_default_timezone_set('Asia/Jakarta');
        $data['now'] = date("Y-m-d");

        // nilai terbaru
        $no_new = $this->pelanggan->check_max_code();
        $no_new_now = $no_new + 1;
        if($no_new == null){
            $data['no_plng'] = 1;
        } else {
            $data['no_plng'] = $no_new_now;
        }


        // daftar paket        
        $data['dt_paket'] = $this->admin->getAllByTable('paket', 'id_paket', 'asc');

        $this->form_validation->set_rules('no_plng','', 'required');
        $this->form_validation->set_rules('tgl','', 'required');
        $this->form_validation->set_rules('nm','', 'required');
        $this->form_validation->set_rules('almt','', 'required');
        $this->form_validation->set_rules('no_telp','', 'required');
        $this->form_validation->set_rules('nomor_air','', 'required');
        $this->form_validation->set_rules('id_paket','', 'required');
        $this->form_validation->set_rules('stts','', 'required');

        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pelanggan/add', $data);
            $this->load->view('templates/footer');
        } else {
            // memproses data
            $this->pelanggan->insert();

            // log
            $this->load->model('Log_model','riwayat');
            $this->riwayat->insert($data['user']['id_user'], 'tagihan/add', 'menambahkan pelanggan baru');


            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Pelanggan berhasil ditambahkan 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>');
                redirect('pelanggan');
        }        
    }

    // edit data pelanggan
    public function update($id)
    {
        $data['title'] = 'Ubah Data Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->load->model('Admin_model','admin');

        date_default_timezone_set('Asia/Jakarta');
        $data['now'] = date("Y-m-d");

        // data by id 
        $data['dtByID'] = $this->pelanggan->getCustomerById($id);

        // daftar paket 
        $data['dt_paket'] = $this->admin->getAllByTable('paket', 'id_paket', 'asc');

        $this->form_validation->set_rules('tgl','', 'required');
        $this->form_validation->set_rules('nm','', 'required');
        $this->form_validation->set_rules('almt','', 'required');
        $this->form_validation->set_rules('no_telp','', 'required');
        $this->form_validation->set_rules('nomor_air','', 'required');
        $this->form_validation->set_rules('id_paket','', 'required');
        $this->form_validation->set_rules('stts','', 'required');

        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pelanggan/update', $data);
            $this->load->view('templates/footer');
        } else {
            // memproses data
            $this->pelanggan->update($id);

            $this->load->model('Log_model','riwayat');
            $this->riwayat->insert($data['user']['id_user'], 'tagihan/update', 'mengubah pelanggan baru');

            $this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">Pelanggan berhasil diubah! 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>');
                redirect('pelanggan');
        }    
    }

    // delete pelanggan
    public function delete($id)
    {
        // tulis code disini
        $this->pelanggan->delete($id);

        $this->load->model('Log_model','riwayat');
        $this->riwayat->insert($data['user']['id_user'], 'tagihan/delete', 'mengubah pelanggan baru');
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Pelanggan berhasil dihapus! 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pelanggan');
    }


    // detail pelanggan
    public function detail($id)
    {
        $data['title'] = 'Detail Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->load->model('Admin_model','admin');

        $data['now'] = date("Y-m-d");

        // data by id 
        $data['dtByID'] = $this->pelanggan->getCustomerById($id);

        // daftar paket 
        $data['dt_paket'] = $this->admin->getAllByTable('paket', 'id_paket', 'asc');

        if($data['dtByID']->stts == 2) {
            $data['dt_berhenti'] = $this->admin->GetDataById('plng_berhenti', 'id_plng', $id);            
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pelanggan/detail', $data);
        $this->load->view('templates/footer');
    }

    // ubah stts_pelanggan ubah_stts_putus
    public function ubah_stts_putus($id_plng)
    {
        $this->load->model('Admin_model','admin');
        // ubah status pelanggan 2
        $dt_update_plng = [
                'stts' => 2,
            ];
        $this->admin->updateDatabyTable('plng', 'id_plng', $id_plng, $dt_update_plng);

        // tulis code disini
        $dt_insert_berhenti = [
            "id_plng"   => $id_plng,
            "tgl"       => date("Y-m-d H:i:s"),
            "ket"       => $this->input->post('ket', true),
        ];

        $this->admin->addDatabyTable('plng_berhenti', $dt_insert_berhenti);

        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Status pelanggan berhenti berlangganan! 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pelanggan/detail/'.$id_plng);
    }

    // ubah stts_pelanggan aktif
    public function ubah_stts_aktif($id_plng)
    {        
        $this->load->model('Admin_model','admin');
        // ubah status pelanggan 2
        $dt_update_plng = [
                'stts' => 1,
            ];
        $this->admin->updateDatabyTable('plng', 'id_plng', $id_plng, $dt_update_plng);

        // menghapus data plng_berhenti
        $this->admin->deleteDataById('plng_berhenti', 'id_plng', $id_plng);
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Status pelanggan aktif berlangganan! 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('pelanggan/detail/'.$id_plng);
    }

    // pelanggan putus
    public function putus_berlangganan()
    {
        $data['title'] = 'Data Pelanggan Putus Berlangganan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->load->model('Tagihan_model','tagihan');

        $dtPemutusan = $this->pelanggan->getAllDtPemutusan();
        $result = array();
        foreach($dtPemutusan as $row) {
            // tambah tagihan
            $piutang_in = $this->tagihan->getTagihanByTable('piutang_in', 'plng_id', $row['id_plng']);

            $nilai_tagih  = 0;
            foreach($piutang_in as $p){
                $nilai_tagih += $p->nilai;
            }

            // pelunasan tagihan
            $piutang_out = $this->tagihan->getTagihanByTable('piutang_out', 'plng_id', $row['id_plng']);

            $nilai_bayar  = 0;
            foreach($piutang_out as $p){
                $nilai_bayar += $p->nilai;
            }

            $sisa_tagihan = $nilai_tagih - $nilai_bayar;
            
            $result[] = array(
                'id_plng'   => $row['id_plng'],
                'ket'       => $row['ket'],
                'tgl_putus' => $row['tgl_putus'],
                'tgl'       => $row['tgl'],
                'no_plng'   => $row['no_plng'],
                'nomor_air' => $row['nomor_air'],
                'nm'        => $row['nm'],
                'almt'      => $row['almt'],
                'no_telp'   => $row['no_telp'],
                'paket'     => $row['nm_paket'],
                'sisa_tagihan'  => $sisa_tagihan,
            );

        }

         $data['dtPemutusan'] = $result;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pelanggan/putus_berlangganan', $data);
        $this->load->view('templates/footer');
    }


    // impor data pelanggan
    public function impor_pelanggan()
    {
        // tulis code disini
    }

}