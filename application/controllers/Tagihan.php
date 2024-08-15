<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tagihan extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        is_logged_in();
        
        $this->load->model('Pelanggan_model','pelanggan');
        $this->load->model('Tagihan_model','tagihan');
    }
    
	// data tagihan keseluruhan
    public function index()
    {
        $data['title'] = 'Tagihan Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $data['data_id'] = rawurlencode(base64_encode(json_encode(array("cabang" => $data['user']['id_cab'], "id_role" =>  $data['user']['id_role']))));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tagihan/index', $data);
        $this->load->view('templates/footer');
    }

    public function ajax_list_tagihan()
    {

        $this->load->model('Admin_model','admin');
        
        // $id_data = json_decode(base64_decode(rawurldecode($data_id)));

        $list = $this->pelanggan->get_datatables(); 

        // echo json_encode($list);
        // die;

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            
            $paket = $this->admin->GetDataById('paket','id_paket',$customers->id_plng);

            // mencari tagihan terakhir
            $tagihan_in = $this->tagihan->getTagihanByTable('piutang_in', 'id_piut', $customers->id_plng);
            $nilai_tagih  = 0;
            foreach($tagihan_in as $pin){
                $nilai_tagih += $pin->nilai;
            }

            $tagihan_out = $this->tagihan->getTagihanByTable('piutang_out', 'id_piut', $customers->id_plng);
            $nilai_bayar  = 0;
            foreach($tagihan_out as $pout){
                $nilai_bayar += $pout->nilai;
            }
            // tagihan out
            $tagihan_saat_ini = $nilai_tagih - $nilai_bayar;
            // tutup mencari tagihan

            $stts_tagihan = '';
            if($tagihan_saat_ini > 0) {
                $stts_tagihan = "Belum Lunas";
                $stts_color = "danger";
            } else if($tagihan_saat_ini < 0) {
                $stts_tagihan = "Ada DEPOSIT";   
                $stts_color = "primary";             
            } else {
                $stts_tagihan = "LUNAS";  
                $stts_color = "success";                     
            }
            
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
            $row[] = 'Rp. '.number_format($tagihan_saat_ini,0,',','.').' ,-';
            $row[] = "<span class='badge badge-".$stts_color."'>".$stts_tagihan."</span>";
            
            $row[] = '<a href="'.base_url('tagihan/detail/').$customers->id_plng.'" class="badge badge-success">
                            <span class="icon text-white-50">
                                <i class="fas fa-fw fa-eye"></i>
                            </span>
                            <span class="text">Detail</span>
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

    // detail tagihan
    public function detail($id)
    {        
        $data['title'] = 'Detail Tagihan Pelanggan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->load->model('Admin_model','admin');

        date_default_timezone_set('Asia/Jakarta');
        $data['now'] = date("Y-m-d");
        $data['bulan'] = date("m");

        // data by id 
        $data['dtByID'] = $this->pelanggan->getCustomerById($id);

        // daftar paket 
        $data['dt_paket'] = $this->admin->getAllByTable('paket', 'id_paket', 'asc');

        // riwayat tagihan
        $data['riw_tagihan'] = $this->tagihan->getDetailTagihan($id);

        // data kas
        $data['datakas'] = $this->admin->getAllByTable('kas', 'id_kas', 'asc');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tagihan/detail', $data);
        $this->load->view('templates/footer');
    }
    // edit tagihan

    // tambah tagihan
    public function tambah_tagihan()
    {
        
    }


    // hapus tagihan in
    public function deleteTagihanIn($id)
    {

    }

    // hapus tagihan out
    public function deleteTagihanOut($id)
    {

    }


    // laporan belum lunas
    public function laporan_belum_lunas()
    {
        $data['title'] = 'Laporan Tagihan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');
    }

    // laporan lunas
    public function laporan_lunas()
    {
        $data['title'] = 'Laporan Tagihan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');        
    }

    // riwayat setoran
    public function laporan_setoran()
    {
        $data['title'] = 'Laporan Tagihan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');              
    }


    // pelunasan
    public function cari_pelanggan()
    {
        $data['title'] = 'Pencarian Tagihan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();
        
        date_default_timezone_set('Asia/Jakarta');
        // Tgl Sekarang
        $data['now'] = date("Y-m-d");
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tagihan/cari_pelanggan', $data);
        $this->load->view('templates/footer');      
    }

    public function hasil_pencarian()
    {
        $data['title'] = 'Hasil Pencarian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');       
    }

    public function detail_pencarian()
    {
        $data['title'] = 'Detail Pencarian';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');       
    }

    public function preview()
    {
        $data['title'] = 'Preview Nota';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');      
    }

    public function konfirmasi()
    {
        $data['title'] = 'Konfirmasi';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');       
    }

    public function laporan_pelunasan()
    {
        $data['title'] = 'Laporan Pelunasan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');    
    }

    public function cek_pelunasan()
    {
        $data['title'] = 'Pengecekan Pelunasan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->session->set_flashdata('msg_putus','<div class="alert alert-danger" role="alert">FITUR BELUM TERSEDIA!</div>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/index', $data);
        $this->load->view('templates/footer');    
    }
    // tutup pelunasan
}