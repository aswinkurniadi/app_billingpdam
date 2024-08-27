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

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            
            $paket = $this->admin->GetDataById('paket','id_paket',$customers->id_plng);

            // mencari tagihan terakhir
            $tagihan_in = $this->tagihan->getTagihanByTable('piutang_in', 'plng_id', $customers->id_plng);
            $nilai_tagih  = 0;
            foreach($tagihan_in as $pin){
                $nilai_tagih += $pin->nilai;
            }

            $tagihan_out = $this->tagihan->getTagihanByTable('piutang_out', 'plng_id', $customers->id_plng);
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
        $data['now'] = date("Y-m-d H:i:s");
        $data['bulan'] = date("m");

        // data by id 
        $data['dtByID'] = $this->pelanggan->getCustomerById($id);

        // daftar paket 
        $data['dt_paket'] = $this->admin->getAllByTable('paket', 'id_paket', 'asc');

        // riwayat tagihan
        $data['riw_tagihan'] = $this->tagihan->getDetailTagihan($id);

        // data kas
        $data['datakas'] = $this->admin->getAllByTable('kas', 'id_kas', 'asc');

        // tagihan terakhir
        $saldo = 0;
        foreach($data['riw_tagihan'] as $row) { 
            if($row['type'] == 1) {
                $id_piut = $row['id_piutang_in'];
                $saldo += $row['nilai'];
            } else {
                $id_piut = $row['id_piutang_out'];
                $saldo -= $row['nilai'];
            }
        }

        $data['tagihan_saat_ini'] = $saldo;


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
        $id_plng    = $this->input->post('id_plng', true);
        $nilai      = $this->input->post('value', true);
        $hide       = array("Rp", ".", " ");
        $nilai_new  = str_replace($hide, "", $nilai);

        $this->tagihan->insertTagihanBaru($nilai_new);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Tagihan baru berhasil ditambahkan!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('tagihan/detail/'.$id_plng);
    }

    // tambah pelunasan
    public function tambah_pelunasan()
    {
        $id_plng    = $this->input->post('id_plng', true);
        $nilai      = $this->input->post('value', true);
        $hide       = array("Rp", ".", " ");
        $nilai_new  = str_replace($hide, "", $nilai);

        $this->tagihan->insertPelunasan($nilai_new);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Pelunasan berhasil ditambahkan! 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('tagihan/detail/'.$id_plng);
    }


    // update piutang in
    public function ubah_tagihan()
    {
        $id_plng      = $this->input->post('id_plng_edit', true);
        $nilai      = $this->input->post('value_edit', true);
        $type      = $this->input->post('type_edit', true);
        $hide       = array("Rp", ".", " ");
        $nilai_new   = str_replace($hide, "", $nilai);
        
        // echo $nilai_new;
        if($type == 1){
            // piutang in
            $this->tagihan->updateTagihan($type,$nilai_new);
        } else {
            // piutang out
            $this->tagihan->updateTagihan($type,$nilai_new);
        }
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Piutang berhasil di ubah! '.$nilai.' 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('tagihan/detail/'.$id_plng);
    }


    // hapus tagihan in
    public function deleteTagihanIn($id)
    {
        $data = $this->db->get_where('piutang_in', ['id_piut' => $id])->row();

        $this->tagihan->deleteTagihan('piutang_in', $id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been deleted!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
                redirect('tagihan/detail/'.$data->plng_id);
    }

    public function deleteTagihanOut($id)
    {
        $data = $this->db->get_where('piutang_out', ['id_piut' => $id])->row();

        $this->tagihan->deleteTagihan('piutang_out', $id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role has been deleted!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
                redirect('tagihan/detail/'.$data->plng_id);
    }



    // laporan belum lunas
    public function laporan_belum_lunas()
    {
        $data['title'] = 'Laporan Tagihan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->load->model('Admin_model','admin');
        $this->load->model('Pelanggan_model','pelanggan');

        // semua pelanggan
        $result = array();
        $dtAllPlng = $this->pelanggan->getCustomer();
        foreach ($dtAllPlng as $customers) {
            
            $paket = $this->admin->GetDataById('paket','id_paket',$customers->id_plng);

            // mencari tagihan terakhir
            $tagihan_in = $this->tagihan->getTagihanByTable('piutang_in', 'plng_id', $customers->id_plng);
            $nilai_tagih  = 0;
            foreach($tagihan_in as $pin){
                $nilai_tagih += $pin->nilai;
            }

            $tagihan_out = $this->tagihan->getTagihanByTable('piutang_out', 'plng_id', $customers->id_plng);
            $nilai_bayar  = 0;
            foreach($tagihan_out as $pout){
                $nilai_bayar += $pout->nilai;
            }
            // tagihan out
            $tagihan_saat_ini = $nilai_tagih - $nilai_bayar;

            if($tagihan_saat_ini > 0) {
                $result[] = array(
                    'id_plng' => $customers->id_plng,
                    'no_plng' => $customers->no_plng,
                    'nm' => $customers->nm,
                    'almt' => $customers->almt,
                    'no_telp' => $customers->no_telp,
                    'nomor_air' => $customers->nomor_air,
                    'paket' => $paket['nama'],
                    'nilai' => 'Rp. '.number_format($paket['nilai'],0,',','.').' ,-',
                    'tag_saat_ini' => 'Rp. '.number_format($tagihan_saat_ini,0,',','.').' ,-'
                );
            }
        }

        $data['data_blm_tertagih'] = $result;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tagihan/laporan_tagihan', $data);
        $this->load->view('templates/footer');
    }

    // riwayat setoran
    public function laporan_setoran()
    {
        $data['title'] = 'Laporan Setoran';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $data['now'] = date("Y-m-d");

        $this->load->model('Admin_model','admin');
        $data['dt_setoran'] = $this->tagihan->getDataSetoran();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tagihan/laporan_setoran', $data);
        $this->load->view('templates/footer');              
    }


    public function add_setoran()
    {   
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Admin_model','admin');

        $upload_file = $_FILES['file']['name'];

        $new_file = null;
        if($upload_file){
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size']      = '20480';
            $config['upload_path']   = './assets/file/setoran/';

            $this->load->library('upload', $config);

            if($this->upload->do_upload('file')) {
                $new_file = $this->upload->data('file_name');
            } else {
                echo $this->upload->display_errors();
            }
        }

        if($new_file == null) {            
            $data = [
                "id_user" => $data['user']['id_user'],
                "tgl" => $this->input->post('tgl', true),
                "ket" => $this->input->post('ket', true),
                "nilai" => $this->input->post('nilai', true),
                "stts" => 0,
            ];
        } else {            
            $data = [
                "id_user" => $data['user']['id_user'],
                "tgl" => $this->input->post('tgl', true),
                "ket" => $this->input->post('ket', true),
                "nilai" => $this->input->post('nilai', true),
                "file" => $new_file,
                "stts" => 0,
            ];
        }

        $this->admin->addDatabyTable('setoran', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Data berhasil ditambahkan! 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('tagihan/laporan_setoran');
    }

    public function update_setoran()
    {
        $this->load->model('Admin_model','admin');
        $id_setoran = $this->input->post('id_setoran', true);


        $fileSetoran = $this->admin->GetDataById('setoran','id_setoran',$id);

        $upload_file = $_FILES['file']['name'];

        $new_file = null;
        if($upload_file){
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size']      = '20480';
            $config['upload_path']   = './assets/file/setoran/';

            $this->load->library('upload', $config);

            if($this->upload->do_upload('file')) {
                // menghapus file lama
                unlink(FCPATH . 'assets/file/setoran/' . $fileSetoran['file']);                
                $new_file = $this->upload->data('file_name');
            } else {
                echo $this->upload->display_errors();
            }
        }


        if($new_file == null) {            
            $data = [
                "tgl" => $this->input->post('tgl', true),
                "ket" => $this->input->post('ket', true),
                "nilai" => $this->input->post('nilai', true),
            ];
        } else {            
            $data = [
                "tgl" => $this->input->post('tgl', true),
                "ket" => $this->input->post('ket', true),
                "nilai" => $this->input->post('nilai', true),
                "file" => $new_file,
            ];
        }

        $this->admin->updateDatabyTable('setoran', 'id_setoran', $id_setoran, $data);
        $this->session->set_flashdata('message','<div class="alert alert-primary" role="alert">Data berhasil diubah! 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('tagihan/laporan_setoran');
    }

    public function delete_setoran($id)
    {
        $this->load->model('Admin_model','admin');

        $fileSetoran = $this->admin->GetDataById('setoran','id_setoran',$id);
        unlink(FCPATH . 'assets/file/setoran/' . $fileSetoran['file']);

        $this->admin->deleteDataById('setoran', 'id_setoran', $id);
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Data berhasil dihapus! 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('tagihan/laporan_setoran');
    }

    // ubah status setoran
    public function ubah_status_setoran($data_id)
    {          
        $dtditerima = json_decode(base64_decode($data_id));
        $this->load->model('Admin_model','admin');
        $data = [
            "stts" => $dtditerima->stts,
        ];
        $this->admin->updateDatabyTable('setoran', 'id_setoran', $dtditerima->id_setoran, $data);

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Status setoran berhasil diubah! 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button></div>');
            redirect('tagihan/laporan_setoran');

    }


    // tutup setoran







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

        $this->load->model('Admin_model','admin');

        date_default_timezone_set('Asia/Jakarta');
        $data['now'] = date("Y-m-d H:i:s");
        $data['bulan'] = date("m");

        // data by id 
        $data['dtByID'] = $this->pelanggan->getCustomerById($id);

         // tambah tagihan
        $piutang_in = $this->tagihan->getTagihanByTable('piutang_in', 'plng_id', $data['dtByID']->id_plng);

        $nilai_tagih  = 0;
        foreach($piutang_in as $p){
            $nilai_tagih += $p->nilai;
        }

        // pelunasan tagihan
        $piutang_out = $this->tagihan->getTagihanByTable('piutang_out', 'plng_id', $data['dtByID']->id_plng);

        $nilai_bayar  = 0;
        foreach($piutang_out as $p){
            $nilai_bayar += $p->nilai;
        }

        $data['tagihan_saat_ini'] = $nilai_tagih - $nilai_bayar;

        // nm paket
        $data['dtPaketById'] = $this->admin->GetDataById('paket','id_paket', $data['dtByID']->id_paket);

        // data kas
        $data['dtByIDkas'] = $this->admin->getAllByTable('kas', 'id_kas', 'asc');


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tagihan/detail_pencarian', $data);
        $this->load->view('templates/footer');       
    }

    public function pelunasan()
    {
        $this->load->model('Admin_model','admin');
        $this->load->model('Pelanggan_model','pelanggan');

        // Cetak nota
        $id_plng    = $this->input->post('id_plng', true);
        $nilai      = $this->input->post('value', true);
        $hide       = array("Rp", ".", " ");
        $nilai_new  = str_replace($hide, "", $nilai);
        if($nilai_new == 0) {
            $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Nominal tidak boleh Rp. 0 ,-. Silahkan masukkan kode pelanggan kembali!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button></div>');
                redirect('colector/piutang_tv');
        } else {
            // cek pelanggan nominal sudah 0 atau kurang dari 0
            $data_cust = $this->pelanggan->getCustomerById($id_plng);
            $piutang_in = $this->tagihan->getTagihanByTable('piutang_in', 'plng_id', $id_plng);
    
            $nilai_tagih  = 0;
            foreach($piutang_in as $p){
                $nilai_tagih += $p->nilai;
            }
    
            $piutang_out = $this->tagihan->getTagihanByTable('piutang_out', 'plng_id', $id_plng);
    
            $nilai_bayar  = 0;
            foreach($piutang_out as $p){
                $nilai_bayar += $p->nilai;
            }
    
            $piutang = $nilai_tagih - $nilai_bayar;

            if($piutang > 0) {


                $data['title'] = 'Silahkan klik cetak. dan tunggu sebentar.';
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
                $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

                // masukkan ke database
                $this->tagihan->insertPelunasanTagihan($data['user']['id_user'], $nilai_new);

                // mengambil data
                $tgl = $this->input->post('tgl', true);
                $id_kas = $this->input->post('kas', true);
                $dtPlngById = $this->pelanggan->getCustomerById($id_plng);
                $dtPaketById = $this->admin->GetDataById('paket','id_paket', $dtPlngById->id_paket);
                $dKasById = $this->admin->GetDataById('kas', 'id_kas', $id_kas);

                $save_bln = $this->input->post('bln', true);
                $dibayar = $this->input->post('dibayar', true);
                $diterima = $this->input->post('diterima', true);

                $dt_plng = [
                    "account"       => $data['user']['name'],
                    "waktu"         => $tgl,
                    "no_plng"       => $dtPlngById->no_plng,
                    "nm"            => $dtPlngById->nm,
                    "almt"          => $dtPlngById->almt,
                    "no_telp"       => $dtPlngById->no_telp,
                    "nomor_air"     => $dtPlngById->nomor_air,
                    "paket"         => $dtPaketById['nama'],
                    "bln"           => getBulan($save_bln),
                    "metode_byr"    => $dKasById['nm_kas'],
                    "nilai"         => $nilai_new,
                    "dibayar"       => $dibayar,
                    "diterima"      => $diterima,
                ];

                // mengubah nilai menjadi base 64
                $data['myarray'] ='myarray=' . rawurlencode(base64_encode(json_encode($dt_plng)));

                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Pelanggan berhasil terlunasi! 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></div>');

                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('tagihan/konfirm_cetak', $data);
                $this->load->view('templates/footer');
            }
        }           
    }

    function print_struct()
    {
        $this->load->library('escpos');

        $myarray = json_decode(base64_decode(rawurldecode($_GET["myarray"])));

        try {
            $profile = Mike42\Escpos\CapabilityProfile::load("simple");
            $connector = new Mike42\Escpos\PrintConnectors\RawbtPrintConnector();
            $printer = new Mike42\Escpos\Printer($connector, $profile);

            // Setting template header
                function buatBaris4Kolom($kolom1, $kolom2, $kolom3) {
                    // Mengatur lebar setiap kolom (dalam satuan karakter)
                    $lebar_kolom_1 = 6;
                    $lebar_kolom_2 = 1;
                    $lebar_kolom_3 = 23;

                    // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
                    $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
                    $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
                    $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

                    // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
                    $kolom1Array = explode("\n", $kolom1);
                    $kolom2Array = explode("\n", $kolom2);
                    $kolom3Array = explode("\n", $kolom3);

                    // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
                    $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

                    // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
                    $hasilBaris = array();

                    // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
                    for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                        // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                        $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                        $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");

                        // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                        $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_RIGHT);

                        // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                        $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
                    }

                    // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
                    return implode($hasilBaris, "\n") . "\n";
                }  
             // Tutup header 

            // Setting template catatan
                function buatBarisCatatan($kolom1, $kolom2) {
                    // Mengatur lebar setiap kolom (dalam satuan karakter)
                    $lebar_kolom_1 = 1;
                    $lebar_kolom_2 = 29;

                    // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
                    $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
                    $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);

                    // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
                    $kolom1Array = explode("\n", $kolom1);
                    $kolom2Array = explode("\n", $kolom2);

                    // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
                    $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array));

                    // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
                    $hasilBaris = array();

                    // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
                    for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                        // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                        $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                        $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");

                        // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                        $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2;
                    }

                    // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
                    return implode($hasilBaris, "\n") . "\n";
                } 
             // Tutup header 

        // Enter the device file for your USB printer here


            $today = date("F j, Y, g:i a");   

            // Membuat judul
            $printer->initialize();
            $printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
            $printer->text("PDAM TIRTA PANGABUAN\n");
            $printer->text("(WA) -\n");                                   

            // Header
            $printer->initialize();
            $printer->setTextSize(1, 1);
            $printer->text("--------------------------------\n");
            $printer->text(buatBaris4Kolom("Akun", ":", $myarray->account));
            $printer->text(buatBaris4Kolom("Waktu", ":", $myarray->waktu));

            // Membuat tabel 
            $printer->initialize(); // Reset bentuk/jenis teks
            $printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_LEFT);
            $printer->text("--------------------------------\n");
            $printer->text(buatBaris4Kolom("ID PLNG", ":", $myarray->no_plng));
            $printer->text(buatBaris4Kolom("Nama", ":", $myarray->nm));
            $printer->text(buatBaris4Kolom("Alamat", ":", $myarray->almt));
            $printer->text(buatBaris4Kolom("Telp", ":", $myarray->no_telp));
            $printer->text(buatBaris4Kolom("Nomor Air", ":", $myarray->nomor_air));
            $printer->text(buatBaris4Kolom("Paket", ":", $myarray->paket));
            $printer->text(buatBaris4Kolom("Metode", ":", $myarray->metode_byr));
            $printer->text(buatBaris4Kolom("Tagih", ":", $myarray->value));
            $printer->text(buatBaris4Kolom("Bulan", ":", $myarray->bln));
            $printer->text("--------------------------------\n");
            $printer->text("Dibayarkan oleh :\n");
            $printer->initialize();
            $printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text($myarray->dibayar);
            $printer->text("\n");
            $printer->initialize();
            $printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_LEFT);
            $printer->text("Diterima oleh :\n");
            $printer->initialize();
            $printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text($myarray->diterima);
            $printer->text("\n");
            $printer->text("--------------------------------\n");

             // Pesan catatan
            $printer->initialize();
            $printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_LEFT);
            $printer->text("Catatan :\n");
            $printer->text(buatBarisCatatan("-", "Tunjukkan bukti pembayaran ini pada waktu membayar bulan berikutnya."));
            $printer->text("\n");
            $printer->initialize();
            $printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text("https://home.saranganvision.com/info_selengkapnya\n");
            $printer->text("\n");

            // Pesan penutup
            $printer->initialize();
            $printer->setJustification(Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text("Terima kasih telah menggunakan\n");
            $printer->text("layanan kami\n");

            $printer->feed(1);
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $printer->close();
        }
    }


    // cetak nota by id
    

    public function laporan_pelunasan()
    {
        $data['title'] = 'Laporan Pelunasan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        date_default_timezone_set('Asia/Jakarta');
        $data['now'] = date("Y-m-d");
        // bulan
        $tglakhir = date("Y-m-d", strtotime('+2 days', strtotime( $data['now'] )));
        $tglawal = date('Y-m-d', strtotime('-8 days', strtotime( $tglakhir )));
        
        $data['tglawal'] = $tglawal;
        $data['tglakhir'] = $tglakhir;
        $data['repayment'] = $this->tagihan->getDataRepayment($tglawal, $tglakhir, $data['user']['id_user']);

        $this->form_validation->set_rules('tglAwal','', 'required');
        $this->form_validation->set_rules('tglAkhir','', 'required');

        if($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('tagihan/laporan_pelunasan', $data);
            $this->load->view('templates/footer');   
        } else {
            $tglawal    = $this->input->post('tglAwal', true);
            $tglakhir   = $this->input->post('tglAkhir', true);

            // mencari data yang ada
            $data['repayment'] = $this->tagihan->getDataRepayment($tglawal, $tglakhir, $data['user']['id_user']);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('tagihan/laporan_pelunasan', $data);
            $this->load->view('templates/footer');  
        } 
    }

    public function download_laporan_penagihan()
    {
        $tglawal    = $this->input->post('tglAwal', true);
        $tglakhir   = $this->input->post('tglAkhir', true);
        $id_user    = $this->input->post('colektor', true);
        $user       = $this->db->get_where('user', ['id_user' => $id_user])->row_array();

        // mencari data yang ada
        $data['repayment']  = $this->tagihan->getDataRepayment($tglawal, $tglakhir, $id_user);
        $data['tglAwal']    = $tglawal;
        $data['tglAkhir']   = $tglakhir;
        $data['menu']       = "Laporan Pelunasan";
        $data['colektor']   = $user['name'];
        
        $this->load->library('PDF_MC_Table');
        $this->load->view('tagihan/downloadpdf_laporan_penagihan', $data);
    }

    public function preview($id_piut)
    {
        $data['title'] = 'Preview Nota';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->load->model('Admin_model','admin');

        $dtPelunasanById = $this->admin->GetDataById('piutang_out','id_piut',$id_piut);


        $dtPlngById = $this->pelanggan->getCustomerById($dtPelunasanById['plng_id']);
        $dtPaketById = $this->admin->GetDataById('paket','id_paket', $dtPlngById->id_paket);
        $dKasById = $this->admin->GetDataById('kas', 'id_kas', $dtPelunasanById['id_kas']);
        $dtUserById = $this->admin->GetDataById('user', 'id_user', $dtPelunasanById['user_id']);


        $data['dtByIDkas'] = $this->admin->getAllByTable('kas', 'id_kas', 'asc');

        $dt_plng = [
            "account"       => $dtUserById['name'],
            "waktu"         => $dtPelunasanById['tgl'],
            "no_plng"       => $dtPlngById->no_plng,
            "nm"            => $dtPlngById->nm,
            "almt"          => $dtPlngById->almt,
            "no_telp"       => $dtPlngById->no_telp,
            "nomor_air"     => $dtPlngById->nomor_air,
            "paket"         => $dtPaketById['nama'],
            "bln"           => $dtPelunasanById['bln'],
            "metode_byr"    => $dKasById['nm_kas'],
            "nilai"         => $dtPelunasanById['nilai'],
            "dibayar"       => $dtPelunasanById['dibayar'],
            "diterima"      => $dtPelunasanById['diterima'],

            "value"         => $dtPelunasanById['nilai'],
            "id_kas"        => $dtPelunasanById['id_kas'],
        ];

        $data['dtPelunasan'] = $dt_plng;

        // mengubah nilai menjadi base 64
        $data['myarray'] ='myarray=' . rawurlencode(base64_encode(json_encode($dt_plng)));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('tagihan/preview_nota', $data);
        $this->load->view('templates/footer');      
    }

    public function cek_pelunasan()
    {
        $data['title'] = 'Pengecekan Pelunasan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id_profile' => 1])->row_array();

        $this->load->model('Admin_model','admin');


        $data['cabang'] = $this->admin->getAllByTable('cabang', 'id_cabang', 'ASC');
        $data['id_cabang'] = $data['user']['id_cab'];

        $data['now'] = date("Y-m-d");

        $this->db->where('id_cab', $data['user']['id_cab']);
        // $this->db->where('id_role', 2);
        $data['kolektor'] = $this->admin->getUser();
        $data['datakas'] = $this->admin->getAllByTable('kas', 'id_kas', 'asc');

        $this->form_validation->set_rules('tglAwal','', 'required');
        $this->form_validation->set_rules('tglAkhir','', 'required');
        if($this->form_validation->run() == false) {
            $data['status'] = 0;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('tagihan/cek_tagihan', $data);
            $this->load->view('templates/footer');    
        } else {
            $data['status']     = 1;

            $tglawal    = $this->input->post('tglAwal', true);
            $tglakhir   = $this->input->post('tglAkhir', true);
            $col        = $this->input->post('colektor', true);
            $kas        = $this->input->post('kas', true);

            // mencari data yang ada
            $data['tgl_awal'] = $tglawal;
            $data['tgl_akhir'] = $tglakhir;
            $data['id_col'] = $col;
            $data['id_kas'] = $kas;

            $tglawal_p = date("Y-m-d 00:00:00", strtotime($tglawal));
            $tglakhir_p = date("Y-m-d 23:59:59", strtotime($tglakhir));

            $data['repayment'] = $this->tagihan->getDataRepaymentByKas($tglawal_p, $tglakhir_p, $data['user']['id_cab'], $col, $kas);
            
            // memperoleh array
            $array_id = array();
            foreach($data['repayment'] as $row){
                $array_id[] = $row['id_plng'];
            }
            
            function findDuplicates($count) {
                return $count > 1;
            }
            
            $duplicates = array_filter(array_count_values($array_id), "findDuplicates");
            
            $clear_array = array_unique($array_id);
            
            $duplikat_v = array();
            $i = 0;
            foreach($clear_array as $rows) {
                
                $jml_data = 0;
                if(isset($duplicates[$rows])){
                    $jml_data = $duplicates[$rows];
                }
                
                $duplikat_v[] = array(
                    'id' => $rows,
                    'jml' => $jml_data,
                );
                
                $jml_data = 0;
            }
            
            // mencari data duplikat
            $data['data_duplikat'] = $duplikat_v;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('tagihan/cek_tagihan', $data);
            $this->load->view('templates/footer');    
        }
    }

    public function ekspor_pelunasan()
    {
        $tglawal    = $this->input->post('tglAwal', true);
        $tglakhir   = $this->input->post('tglAkhir', true);
        $col        = $this->input->post('colektor', true);
        $kas        = $this->input->post('kas', true);

        // mencari data yang ada
        $data['tgl_awal'] = $tglawal;
        $data['tgl_akhir'] = $tglakhir;
        $data['id_col'] = $col;
        $data['id_kas'] = $kas;

        $user_col = $this->db->get_where('user', ['id_user' => $col])->row_array();

        $tglawal_p = date("Y-m-d 00:00:00", strtotime($tglawal));
        $tglakhir_p = date("Y-m-d 23:59:59", strtotime($tglakhir));

        $data['repayment'] = $this->tagihan->getDataRepaymentByKas($tglawal_p, $tglakhir_p, $data['user']['id_cab'], $col, $kas);

        // mencari data yang ada
        $data['tglAwal']    = $tglawal;
        $data['tglAkhir']   = $tglakhir;
        $data['menu']       = "Laporan Pelunasan";
        $data['colektor']   = $user_col['name'];
        
        $this->load->library('PDF_MC_Table');
        $this->load->view('tagihan/downloadpdf_laporan_penagihan', $data);
    }

    public function ubah_cabang()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
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
        redirect('tagihan/cek_pelunasan');
    }
    // tutup pelunasan
}