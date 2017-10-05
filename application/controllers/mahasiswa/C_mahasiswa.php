<?php defined('BASEPATH')OR exit('akses tidak dapat diterima');

class C_mahasiswa extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    $this->load->model("mahasiswa/PengumumanPenerimaBeasiswa",'model');
    $this->load->model("mahasiswa/StatusBea",'mod');
    $this->load->model("mahasiswa/Profile",'mdl');
    $this->load->model("mahasiswa/Formulir", 'm_aplikasi');
    $this->load->model('kasubag/Beasiswa');
    $this->load->model('kasubag/ReportBeasiswa');
    $this->load->model("grafik/Grafik",'grf');
  }

  public function index(){
   $this->load->view('attribute/header_mhs');
   $this->load->view('mahasiswa/dashboard');
   $this->load->view('attribute/footer'); 
 }
 public function data_pendaftar($id)
 {   
  $data['pendaftar'] = $this->m_aplikasi->data_pendaftar($id);
  $data['kategori'] = $this->m_aplikasi->data_kategori($id);


  $this->load->view('mahasiswa/buktipendaftaran',$data);
  unset($data);
}
public function dataDaerah($id)
{
  $data['pendaftar'] = $this->m_aplikasi->data_pendaftar($id);



  $this->load->view('mahasiswa/buktiDaerah',$data);
  unset($data);
}
function pdf($id)
{
  $data['pendaftar'] = $this->m_aplikasi->data_pendaftar($id);
  $data['kategori'] = $this->m_aplikasi->data_kategori($id);
  $date['tanggal'] = date("Y-m-d");

  $this->load->view('mahasiswa/pdfreport',$data);
  unset($data);
}

public function profile()
{ 
  $key = $this->session->userdata('username');
  $cek = $this->mdl->getdata($key);
  if($this->mdl->getIdentitasMhs($key) != 0){
    $data =array(
      'angkatan'    => $cek->angkatan,
      'nimMhs'      => $cek->nimMhs,
      'fotoMhs'     => $cek->fotoMhs,
      'namaLengkap' => $cek->namaLengkap,
      'tempatLahir' => $cek->tempatLahir,
      'tglLahir'    => $cek->tglLahir,
      'asalKota'    => $cek->asalKota,
      'namaOrtu'    => $cek->namaOrtu,
      'alamatOrtu'  => $cek->alamatOrtu,
      'kotaOrtu'    => $cek->kotaOrtu,
      'propinsiOrtu'    => $cek->propinsiOrtu,
      'alamatLengkap'   => $cek->alamatLengkap,
      'noTelp'          => $cek->noTelp,
      'emailAktif'      => $cek->emailAktif
      ); 
  }else{
    $data =array(
      'angkatan'    => "",
      'nimMhs'      => "",
      'fotoMhs'     => "",
      'namaLengkap' => "",
      'tempatLahir' => "",
      'tglLahir'    => "",
      'asalKota'    => "",
      'namaOrtu'    => "",
      'alamatOrtu'  => "",
      'kotaOrtu'    => "",
      'propinsiOrtu'    => "",
      'alamatLengkap'   => "",
      'noTelp'          => "",
      'emailAktif'      => ""
      ); 
  }
  $this->load->view('attribute/header_mhs');
  $this->load->view('mahasiswa/v_profile_mhs',$data);
  $this->load->view('attribute/footer');
}

public function pengumuman_penerima_beasiswa()
{
  $isi['fakultas']  =$this->db->get('fakultas')->result();
  $isi['tahun']     = $this->grf->get_tahun();
  $isi['beasiswa']  =$this->db->get('bea')->result();
  
  $this->load->view('attribute/header_mhs');
  $this->load->view('mahasiswa/v_pengumuman_penerima_beasiswa',$isi);
  $this->load->view('attribute/footer');
}
public function status_beasiswa()
{
  $isi['fakultas']  = $this->db->get('fakultas')->result();
  $isi['tahun']     = $this->grf->get_tahun();
  $isi['beasiswa']  = $this->db->get('bea')->result();
  
  $this->load->view('attribute/header_mhs');
  $this->load->view('mahasiswa/status_beasiswa',$isi);
  $this->load->view('attribute/footer');
}

public function datatable(){
  $tahun =$this->input->post('tahun')?$this->input->post('tahun'):0;
  $fakultas =$this->input->post('fakultas')?$this->input->post('fakultas'):0;
  $jurusan =$this->input->post('jurusan')?$this->input->post('jurusan'):0;
  $bea =$this->input->post('beasiswa')?$this->input->post('beasiswa'):0;

  $fetch_data = $this->model->make_datatables($tahun, $fakultas, $jurusan, $bea);
  $data = array();
  $nmr = 0;

  foreach($fetch_data as $row)
  {
    $nmr +=1;
    $sub_array = array();
    $sub_array[] = $nmr;
    $sub_array[] = $row->nim;
    $sub_array[] = $row->namaLengkap;
    $sub_array[] = $row->namaFk;
    $sub_array[] = $row->namaJur;
    $sub_array[] = $row->namaBeasiswa;
    $sub_array[] = $row->tahun;
    $data[] = $sub_array;
  }

  $output = array(
    "draw"            =>  intval($_POST["draw"]),
    "recordsTotal"    =>  $this->model->get_all_data(),
    "recordsFiltered" =>  $this->model->get_filtered_data($tahun, $fakultas, $jurusan, $bea),
    "data"            =>  $data
    );
  echo json_encode($output);
    // echo "<br/>".$tahun."<br/>".$fakultas."<br/>".$jurusan."<br/>".$bea;
}

public function datatableStatus(){
  $tahun =$this->input->post('tahun')?$this->input->post('tahun'):0;
  $fakultas =$this->input->post('fakultas')?$this->input->post('fakultas'):0;
  $jurusan =$this->input->post('jurusan')?$this->input->post('jurusan'):0;
  $bea =$this->input->post('beasiswa')?$this->input->post('beasiswa'):0;

  $fetch_data = $this->mod->make_datatables($tahun, $fakultas, $jurusan, $bea);
  $data = array();
  $nmr = 0;

  foreach($fetch_data as $row)
  {
    $nmr +=1;
    $sub_array = array();
    $sub_array[] = $nmr;
    $sub_array[] = $row->nim;
    $sub_array[] = $row->namaLengkap;
    $sub_array[] = $row->namaFk;
    $sub_array[] = $row->namaJur;
    $sub_array[] = $row->namaBeasiswa;
    $date        = $row->periodeBerakhir;
    $date       = date('d F Y', strtotime($date));
    $date1        = $row->beasiswaDibuka;
    $date1       = date('d F Y', strtotime($date1));
    $sub_array[] = $date1;
    $sub_array[] = $date;
    
    $data[] = $sub_array;
  }

  $output = array(
    "draw"            =>  intval($_POST["draw"]),
    "recordsTotal"    =>  $this->mod->get_all_data(),
    "recordsFiltered" =>  $this->mod->get_filtered_data($tahun, $fakultas, $jurusan, $bea),
    "data"            =>  $data
    );
  echo json_encode($output);
    // echo "<br/>".$tahun."<br/>".$fakultas."<br/>".$jurusan."<br/>".$bea;
}

public function getjurusan()
{
  $fakultas = $_GET['fakultas'];
  $getjur = $this->model->get_jurusan($fakultas);
  echo json_encode($getjur); 
}

public function Pemohon() {
  $data['fakultas'] = $this->ReportBeasiswa->dataFakultas();
  $data['beasiswa'] = $this->Beasiswa->daftarBeasiswa();
  $this->load->view('attribute/header_mhs');
  $this->load->view('mahasiswa/ReportBeasiswaFilter', $data);
  $this->load->view('attribute/footer');
}

public function Penerima() {
  $data['fakultas'] = $this->ReportBeasiswa->dataFakultas();
  $data['beasiswa'] = $this->Beasiswa->daftarBeasiswa();
  $this->load->view('attribute/header_mhs');
  $this->load->view('mahasiswa/ReportBeasiswaPenerima', $data);
  $this->load->view('attribute/footer');
}
public function viewGrafik($th=null)
{
  if ($th==null) {
    date_default_timezone_set('Asia/Jakarta');
    $tahun = date('Y');
  }else {
    $tahun = $th;
  }
  $data['tahun'] = $this->grf->get_tahun();
  $data['selected_tahun'] = $tahun;
  $data['view_grafik'] = $this->grf->get_data_grafik($tahun);

  $this->load->view('attribute/header_mhs');
  $this->load->view('grafik/grafikMhs', $data);
  $this->load->view('attribute/footerKasubag');
}

public function datatablePenerima() {
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
    $sub_array[] = $row->angkatan;
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
    $sub_array[] = $row->angkatan;
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
}