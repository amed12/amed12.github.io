<?php defined('BASEPATH')OR exit('akses tidak dapat diterima');

class C_formulir extends CI_Controller
{

  function __construct(){
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    $this->load->model("mahasiswa/Formulir",'mdl');
  }

  public function index()
  {
    $nim = $this->session->userdata('username');
    $idBea = $this->input->post('idPengaturan');

    $dataMhs = $this->mdl->getdataMhs($nim);
    $data = array(
      'idBea' => $idBea,
      'namaBea' => $this->mdl->get_nama_bea($idBea),
      'combo' => $this->mdl->get_skor_bea($idBea),
      'jurusan' => $this->mdl->get_jurusan(),
      'nim' => $dataMhs->nimMhs,
      'nama' => $dataMhs->namaLengkap,
      'tempatLahir' => $dataMhs->tempatLahir,
      'tglLahir' => $dataMhs->tglLahir,
      'asalKota' => $dataMhs->asalKota,
      'noTelp' => $dataMhs->noTelp
      );
    $this->load->view('mahasiswa/formulir', $data);
  }
  
  public function simpan()
  {
    $nim  = $this->input->post('nim');
    $data =array(
      'idBea'     => $this->input->post('idBea'),
      'nim'       => $this->input->post('nim'),
      'semester'  => $this->input->post('semester'),
      'sks'       => $this->input->post('sks'),
      'ipk'       => $this->input->post('ipk'),
      'alamatMalang' => $this->input->post('alamatMalang'),
      'tanggal'   => $this->input->post('tanggal')
      );
    
    $pendaftar = $this->mdl->getInsert($data);

    // echo(json_encode($this->input->post('idKategoriSkor')));
    // echo(json_encode($this->input->post('score')));

    $count_score = count($this->input->post('idKategoriSkor'));
    $data1 = array();
    for ($i=0;$i<$count_score;$i++) {
      $kategori_skor = $this->input->post('idKategoriSkor['.$i.']');
      $skor          = $this->input->post('score['.$i.']');
        $data1[]= array(
          'idKategori'    => $kategori_skor,
          'idSubKategori' => $skor,
          'idBea'         => $this->input->post('idBea'),
          'idPendaftar'   => $pendaftar
        );
    }
    $this->mdl->pendaftarSkor($data1);
    // echo json_encode(array("score" => TRUE));
    redirect('mahasiswa/C_daftar_bea');

  }
  public function simpan2()
    {
        $nim  = $this->input->post('nim');
        $data =array(
            'idBea'     => $this->input->post('idBea'),
            'nim'       => $this->input->post('nim'),
            'semester'  => $this->input->post('semester'),
            'sks'       => $this->input->post('sks'),
            'ipk'       => $this->input->post('ipk'),
            'alamatMalang' => $this->input->post('alamatMalang'),
            'tanggal'   => $this->input->post('tanggal')
        );

        $this->mdl->getInsert($data);

        // echo(json_encode($this->input->post('idKategoriSkor')));
        // echo(json_encode($this->input->post('score')));

        // echo json_encode(array("score" => TRUE));
        redirect('mahasiswa/C_daftar_bea');

    }
}
