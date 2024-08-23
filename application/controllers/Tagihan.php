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
        $this->load->model('Admin_model','admin');

        $find = $this->input->post('cari', true);
        $filter = $this->input->post('filter_by', true);

        if($find) {
            if($filter == 1) {

                $dtByID = $this->admin->GetDataById('plng','no_plng',$find);

                if(!is_null($dtByID)){
                    if($dtByID['stts'] == 1) {
                        // status pelanggan aktif 
                        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">ID Pelanggan berhasil ditemukan!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></div>');
    
                        redirect('tagihan/detail_pencarian/'.$dtByID['id_plng']);
                    } else {
                        // status pelanggan non aktif
                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">ID Pelanggan tidak Aktif!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></div>');
                        redirect('tagihan/cari_pelanggan');
                    }
        
                } else {
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">ID Pelanggan tidak ditemukan!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>');
                    redirect('tagihan/cari_pelanggan');
                }

            } else {


                $data['title'] = 'Hasil Pencarian';
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();
                
                $jml_caracter = strlen($find);

                if($jml_caracter >= 3) {

                    $all_cust = $this->tagihan->fetch_data($find);


                    if(isset($all_cust[0])){

                        $result_data = array();
                        foreach($all_cust as $row){

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

                            $tagihan_saat_ini = $nilai_tagih - $nilai_bayar;

                            // nm paket
                            $paketById = $this->admin->GetDataById('paket','id_paket', $row['id_paket']);


                            if($tagihan_saat_ini >= 0){
                                $result_data[] = array(
                                    'id_plng'  => $row['id_plng'],
                                    'no_plng'  => $row['no_plng'],
                                    'nomor_air'=> $row['nomor_air'],
                                    'nm'       => $row['nm'],
                                    'paket'    => $paketById['nama'],
                                    'almt'     => $row['almt'],
                                    'tagihan'  => $tagihan_saat_ini,
                                );
                            }
                            
                        }

                        $data['data'] = $result_data;

                        $this->load->view('templates/header', $data);
                        $this->load->view('templates/sidebar', $data);
                        $this->load->view('templates/topbar', $data);
                        $this->load->view('tagihan/hasil_pencarian', $data);
                        $this->load->view('templates/footer'); 

                    } else {
                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Pelanggan tidak ditemukan!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></div>');
                        redirect('tagihan/cari_pelanggan');
                    }
                } else {
                    $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Pencarian harus lebih dari 3 karakter!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>');
                    redirect('tagihan/cari_pelanggan');
                }

            }
        } else {            
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Pencarian tidak boleh kosong!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>');
                redirect('tagihan/cari_pelanggan');
        }     
    }

    public function detail_pencarian($id)
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