<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
class C_daftar_bea extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    
    $this->load->model("mahasiswa/DaftarBeasiswa",'mdl');
    $this->load->model("mahasiswa/Formulir",'mod');
  }
/*  public function index()
  {
    $nim  = $this->session->userdata('username');

    //mengecek apakah mhs dg nim ada di database(count)
    $pendaftar    = $this->mdl->ceknimPendaftar($nim);
    $penerima_bea = $this->mdl->ceknimPenerimaBea($nim);

    //ambil value dari database
    $pendaftarr   = $this->mdl->get_pendaftar($nim);
    $penerima     = $this->mdl->get_penerimaBea($nim);

    if ($pendaftar != 0){
      $status     = $pendaftarr->status;
      $nimPendaf  = $pendaftarr->nim;
      if ($pendaftarr->status == "1" && $nim==$nimPendaf) {
        if ($penerima_bea != 0) {
          if ($penerima->berakhirPeriode<=0) {
            echo $penerima->berakhirPeriode;
           $this->statusDiterimaBea(); 
         }else{
          
          $this->pendafBea();
        }
      }else{
        
        $this->pendafBea();
      }  
    }else{
        // $status="";
      echo $penerima->berakhirPeriode;
      $this->pendafBea();
    }      
  }else{
    $this->pendafBea();
  }
}*/

public function index()
{
  $pendaftar = $this->mdl->ceknimPendaftarBea();

  if (!$pendaftar) {
    $this->pendafBea();
  }elseif($pendaftar){
    $nimDiterima=0;
    
    foreach ($pendaftar as $row) {
      if ($row->status == 1) {
        $nimDiterima=1;
      }
    }

    if ($nimDiterima=1) {
      $this->statusDiterimaBea();
    }else{
      $this->pendafBea();
    }
  }else{
    $this->pendafBea();
  }
}

public function pendafBea()
{
  $this->load->view('attribute/header_mhs');
  $this->load->view('mahasiswa/daftar_bea');
  $this->load->view('attribute/footer');
}

public function statusDiterimaBea(){
  $pendaftar = $this->mdl->ceknimPendaftarBea2();
  $date = date("Y-m-d");

  if($pendaftar) {
    if ($pendaftar->status == 1) {
      if ($pendaftar->periodeBerakhir >=$date) {
        $data = array(
          'nim'   => $this->session->userdata('username'),
          'nama'  => $pendaftar->namaLengkap,
          'bea'   => $pendaftar->namaBeasiswa,
          'tglBuka' => $pendaftar->beasiswaDibuka,
          'periodeBerakhir' => $pendaftar->periodeBerakhir
          );
      }else{
        $data = array(
          'nim'     => "",
          'bea'     => "",
          'nama'    => "",
          'tglBuka' => "",
          'periodeBerakhir' => ""
          );
      }  
    }else{
      $data = array(
        'nim'     => "",
        'bea'     => "",
        'nama'    => "",
        'tglBuka' => "",
        'periodeBerakhir' => ""
        );
    }
  }else{
    $data = array(
      'nim'     => "",
      'bea'     => "",
      'nama'    => "",
      'tglBuka' => "",
      'periodeBerakhir' => ""
      );
  }
  
  $this->load->view('attribute/header_mhs');
  $this->load->view('mahasiswa/statusDiterimaBea',$data);
  $this->load->view('attribute/footer');
}

public function pengaturan()
{
  $nim = $this->session->userdata('username');
  $id = $this->input->post('idPengaturan');
  if ($id != null) {
    $dataMhs = $this->mod->getdataMhs_byId($nim);
    $data = array(
      'idBea' => $id,
      'namaBea' => $this->mod->get_nama_bea($id),
      'combo' => $this->mod->get_skor_bea($id),
      'jurusan' => $this->mod->get_jurusan(),
      'nim' => $dataMhs->nimMhs,
      'nama' => $dataMhs->namaLengkap,
      'tempatLahir' => $dataMhs->tempatLahir,
      'tglLahir' => $dataMhs->tglLahir,
      'asalKota' => $dataMhs->asalKota,
      'noTelp' => $dataMhs->noTelp
      );
  }else {
    $data = array(
      'idSetBea' => "",
      'nama' => "",
      'penyelenggara' => "",
      'selektor' => "",
      'keterangan' => "",
      'dibuka' => "",
      'ditutup' => "",
      'kuota' => "",
      'skor' => null,
      'nim' => "",
      'nama' => "",
      'tempatLahir' => "",
      'tglLahir' => "",
      'asalKota' => "",
      'noTelp' => ""
      );
  }
  $this->load->view('mahasiswa/formulir', $data);
  
}
public function pengaturanDaerah()
    {
        $nim = $this->session->userdata('username');
        $id = $this->input->post('idPengaturan');
        if ($id != null) {
            $dataMhs = $this->mod->getdataMhs_byId($nim);
            $data = array(
                'idBea' => $id,
                'namaBea' => $this->mod->get_nama_bea($id),
                'combo' => $this->mod->get_skor_bea($id),
                'jurusan' => $this->mod->get_jurusan(),
                'nim' => $dataMhs->nimMhs,
                'nama' => $dataMhs->namaLengkap,
                'tempatLahir' => $dataMhs->tempatLahir,
                'tglLahir' => $dataMhs->tglLahir,
                'asalKota' => $dataMhs->asalKota,
                'noTelp' => $dataMhs->noTelp
            );
        }else {
            $data = array(
                'idSetBea' => "",
                'nama' => "",
                'penyelenggara' => "",
                'selektor' => "",
                'keterangan' => "",
                'dibuka' => "",
                'ditutup' => "",
                'kuota' => "",
                'skor' => null,
                'nim' => "",
                'nama' => "",
                'tempatLahir' => "",
                'tglLahir' => "",
                'asalKota' => "",
                'noTelp' => ""
            );
        }

        $this->load->view('mahasiswa/formulirDaerah', $data);
//        $this->load->view('attribute/footer');
    }
public function datatable(){
  $fetch_data = $this->mdl->make_datatables();
  $data = array();
  $nmr = 0;
  foreach($fetch_data as $row)
  {
    $nmr+=1;
    $sub_array = array();
    $sub_array[] = $nmr;
    $sub_array[] = $row->namaBeasiswa;
    $sub_array[] = $row->penyelenggaraBea;
    $sub_array[] = $row->beasiswaDibuka;
    $sub_array[] = $row->beasiswaTutup;

    $nim = $this->session->userdata('username');
    $getId = $this->mdl->get_id($nim,$row->id);
    $ceknim = $row->nim;
    $alamat = null;
    $alamat2 = null;
    if ($ceknim == null) {

        if ($row->namaBeasiswa == "Beasiswa Putra Daerah"){
            $alamat = base_url('mahasiswa/C_daftar_bea/pengaturanDaerah');

        }else{
            $alamat = base_url('mahasiswa/C_daftar_bea/pengaturan');

        }

      $sub_array[] = '
      <form action="'.$alamat.'" method="post">
        <button class="btn-floating waves-effect waves-light red" title="Daftar" type="submit" name="idPengaturan" value="'.$row->id.'"><i class="mdi-action-account-balance-wallet"></i></button>
      </form>
      ';
    }else{
        if ($row->namaBeasiswa == "Beasiswa Putra Daerah"){

            $alamat2 = base_url('mahasiswa/C_mahasiswa/dataDaerah/'.$getId->id);
        }else{

            $alamat2 = base_url('mahasiswa/C_mahasiswa/data_pendaftar/'.$getId->id);
        }
      $sub_array[] = '
      <a href="'.$alamat2.'" class="btn-floating waves-effect waves-light primary-color z-depth-0" title="Daftar"><i class="mdi-action-print"></i></a>
      
      ';
    }

    $data[] = $sub_array;
  }
  $output = array(
    "draw"            =>  intval($_POST["draw"]),
    "recordsTotal"    =>  $this->mdl->get_all_data(),
    "recordsFiltered" =>  $this->mdl->get_filtered_data(),
    "data"            =>  $data
    );
  echo json_encode($output);
}

public function get_scoring_data()
{
  $data = $this->mdl->get_scoring();
  echo json_encode($data);
}

public function add_data()
{
  $data_bea = array(
    'namaBeasiswa' => $this->input->post('nama'),
    'penyelenggaraBea' => $this->input->post('penyelenggara'),
    'beasiswaDibuka' => $this->input->post('dibuka'),
    'beasiswaTutup' => $this->input->post('ditutup'),
    'kuota' => $this->input->post('kuota'),
    'selektor' => $this->input->post('selektor')
    );
  $insert_bea = $this->mdl->save_bea($data_bea);

  $count_score = count($this->input->post('score'));
  $data = array();
  for ($i=0;$i<$count_score;$i++) {
    $skor = $this->input->post('score['.$i.']');
    if ($skor != "HAPUS") {
      $data[]= array(
        'idBea' => $insert_bea,
        'idKategoriSkor' => $skor,
        );
    }
  }
  $insert_sub_bea = $this->mdl->save_sub_bea($data);
  echo json_encode(array("status" => TRUE));
}
}
?>
