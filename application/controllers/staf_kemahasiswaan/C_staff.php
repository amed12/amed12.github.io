<?php defined('BASEPATH')OR exit('akses ditolak');

class C_staff extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();

    $this->load->model('staff_kemahasiswaan/Berita');
    $this->load->model("staff_kemahasiswaan/Profile",'mdl');
    $this->load->model('kasubag/Beasiswa');
    $this->load->model('kasubag/ReportBeasiswa');
    $this->load->model("grafik/Grafik",'grf');
  }
  public function index()
  {
    $this->load->view('attribute/header_staff');
    $this->load->view('staff_kemahasiswaan/dashboard');
    $this->load->view('attribute/footer');
  }

  public function tambahBerita()
  {
    $this->load->view('attribute/header_staff');
    $this->load->view('staff_kemahasiswaan/tambahBerita');
    $this->load->view('attribute/footer');
  }

  public function profile()
  {
    $user = $this->session->userdata('id');
    $cek = $this->mdl->getdata($user);
    if($this->mdl->getIdentitasAdmin($user) != 0){
      $data =array(
        'foto'    => $cek->foto,
        'id'      => $cek->id,
        'nama'    => $cek->nama,
        'alamat'  => $cek->alamat,
        'noTelp'  => $cek->noTelp,
        'email'   => $cek->email
        );
    }else{
      $data=array(
        'foto'    => "",
        'id'      => "",
        'nama'    => "",
        'alamat'  => "",
        'noTelp'  => "",
        'email'   => ""
        );
    }
    $this->load->view('attribute/header_staff');
    $this->load->view('staff_kemahasiswaan/v_profile_staff',$data);
    $this->load->view('attribute/footer');
  }

  public function daftarBerita()
  {
    $data['berita']=$this->Berita->daftarBerita();
    $this->load->view('attribute/header_staff');
    $this->load->view('staff_kemahasiswaan/Berita', $data);
    $this->load->view('attribute/footerKasubag');
  }
  public function filterLaporan() {
    $tahun = $this->input->post('filTahun');
    $jurusan = $this->input->post('filJurusan');
    $fakultas = $this->input->post('filFakultas');
    $beasiswa = $this->input->post('filBea');
    $data['fakultas'] = $this->ReportBeasiswa->dataFakultas();
    $data['jurusan'] = $this->ReportBeasiswa->dataJurusan();
    $data['beasiswa'] = $this->Beasiswa->daftarBeasiswa();
    $data['datafill'] = $this->ReportBeasiswa->filterPemohon($tahun, $jurusan, $fakultas, $beasiswa);

    $this->load->view('attribute/header_staff');
    $this->load->view('staff_kemahasiswaan/ReportBeasiswaFilter', $data);
    $this->load->view('attribute/footer');
  }
  public function penerimaBeaSiswa() {
    $tahun = $this->input->post('filTahun');
    $jurusan = $this->input->post('filJurusan');
    $fakultas = $this->input->post('filFakultas');
    $beasiswa = $this->input->post('filBeasiswa');
    $data['fakultas'] = $this->ReportBeasiswa->dataFakultas();
    $data['jurusan'] = $this->ReportBeasiswa->dataJurusan();
    $data['beasiswa'] = $this->Beasiswa->daftarBeasiswa();
    $data['detail'] = $this->ReportBeasiswa->dataPenerimaBeasiswa($tahun, $jurusan, $fakultas, $beasiswa);
    $this->load->view('attribute/header_staff');
    $this->load->view('staff_kemahasiswaan/ReportBeasiswaPenerima', $data);
    $this->load->view('attribute/footer');
  }
  public function GrafikBeasiswa() {
    $data['grafis'] = $this->ReportBeasiswa->grafikPenerima();
    $data['pemohon'] = $this->ReportBeasiswa->grafikPemohon();
    $this->load->view('attribute/header_staff');
    $this->load->view('kasubag/Grafik', $data);
    $this->load->view('attribute/footerKasubag');
  }

  public function Penerima() {
    $data['fakultas'] = $this->ReportBeasiswa->dataFakultas();
    $data['beasiswa'] = $this->Beasiswa->daftarBeasiswa();
    $data['tahun']     = $this->grf->get_tahun();

    $this->load->view('attribute/header_staff');
    $this->load->view('staff_kemahasiswaan/ReportBeasiswaPenerima', $data);
    $this->load->view('attribute/footer');
  }

  public function Pemohon() {
    $data['fakultas'] = $this->ReportBeasiswa->dataFakultas();
    $data['beasiswa'] = $this->Beasiswa->daftarBeasiswa();
    $data['tahun']     = $this->grf->get_tahun();

    $this->load->view('attribute/header_staff');
    $this->load->view('staff_kemahasiswaan/ReportBeasiswaFilter', $data);
    $this->load->view('attribute/footer');
  }

  public function getJurusan() {
    $fakultas = $_GET['fakultas'];
    $getjur = $this->ReportBeasiswa->get_jurusan($fakultas);
    echo json_encode($getjur);
  }

  public function datatable() {
    $tahun = $this->input->post('tahun')?$this->input->post('tahun'):0;
    $fakultas = $this->input->post('fakultas')?$this->input->post('fakultas'):0;
    $jurusan = $this->input->post('jurusan')?$this->input->post('jurusan'):0;
    $bea = $this->input->post('beasiswa')?$this->input->post('beasiswa'):0;

    $fetch_data = $this->ReportBeasiswa->make_datatables($tahun, $fakultas, $jurusan, $bea);
    $data = array();
    foreach ($fetch_data as $row) {
      $sub_array = array();
      $sub_array[] = $row->nim;
      $sub_array[] = $row->namaLengkap;
      $sub_array[] = $row->namaFk;
      $sub_array[] = $row->namaJur;
      $sub_array[] = $row->namaBeasiswa;
      $sub_array[] = $row->tahun;
      $data[] = $sub_array;
    }

    $output = array(
      "draw" => intval($_POST["draw"]),
      "recordsTotal" => $this->ReportBeasiswa->get_all_data(),
      "recordsFiltered" => $this->ReportBeasiswa->get_filtered_data($tahun, $fakultas, $jurusan, $bea),
      "data" => $data
      );
    echo json_encode($output);
  }

  public function datatablePemohon() {
    $tahun = $this->input->post('tahun')?$this->input->post('tahun'):0;
    $fakultas = $this->input->post('fakultas')?$this->input->post('fakultas'):0;
    $jurusan = $this->input->post('jurusan')?$this->input->post('jurusan'):0;
    $bea = $this->input->post('beasiswa')?$this->input->post('beasiswa'):0;

    $fetch_data = $this->ReportBeasiswa->make_datatablesPemohon($tahun, $fakultas, $jurusan, $bea);
    $data = array();
    foreach ($fetch_data as $row) {
      $sub_array = array();
      $sub_array[] = $row->nim;
      $sub_array[] = $row->namaLengkap;
      $sub_array[] = $row->namaFk;
      $sub_array[] = $row->namaJur;
      $sub_array[] = $row->namaBeasiswa;
      $sub_array[] = $row->tahun;
      $data[] = $sub_array;
    }

    $output = array(
      "draw" => intval($_POST["draw"]),
      "recordsTotal" => $this->ReportBeasiswa->get_all_data(),
      "recordsFiltered" => $this->ReportBeasiswa->get_filtered_dataPemohon($tahun, $fakultas, $jurusan, $bea),
      "data" => $data
      );
    echo json_encode($output);
  }
  public function viewGrafik($th=null)
  {
    if ($th==null) {
      date_default_timezone_set('Asia/Jakarta');
      $tahun = date('Y');
    }else {
      $tahun = $th;
    }
    $this->load->model('grafik/grafik');
    $data['tahun'] = $this->grafik->get_tahun();
    $data['selected_tahun'] = $tahun;
    $data['view_grafik'] = $this->grafik->get_data_grafik($tahun);

    $this->load->view('attribute/header_staff');
    $this->load->view('grafik/grafikStaf', $data);
    $this->load->view('attribute/footer');
  }
  public function semuaDataPenerima() {
      $data['databea'] = $this->ReportBeasiswa->semuaPenerimaBeasiswa();
      $this->load->view('kasubag/masterDataPenerima', $data);
  }
  public function get_data_print($tahun, $fakultas,$jurusan,$bea)
  {

    // $fetch_data = $this->ReportBeasiswa->make_query1($tahun, $fakultas, $jurusan, $bea);
    //
    //
    //
    // echo json_encode($fetch_data);
    // echo json_encode($fetch_data);
    $data['databea'] = $this->ReportBeasiswa->make_query1($tahun, $fakultas, $jurusan, $bea);
    $this->load->view('kasubag/masterDataPenerima', $data);
}
public function get_data_print1($tahun, $fakultas,$jurusan,$bea)
{

  // $fetch_data = $this->ReportBeasiswa->make_query1($tahun, $fakultas, $jurusan, $bea);
  //
  //
  //
  // echo json_encode($fetch_data);
  // echo json_encode($fetch_data);
  $data['databea'] = $this->ReportBeasiswa->make_queryPemohon1($tahun, $fakultas, $jurusan, $bea);
  $this->load->view('kasubag/masterDataPemohon', $data);
}

  }

?>
