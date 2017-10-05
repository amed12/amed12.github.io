<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
class C_request extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();
    $this->load->model("kasubag/Requested",'mdl');
    $this->load->model("kabag/Request",'mdk');
  }

  public function index()
  {
    $this->load->view('attribute/header_kabag');
    $this->load->view('kabag/request');
    $this->load->view('attribute/footer');
  }

  public function revisi()
  {
    $data_bea = array(
      'statusBeasiswa' => '2',
      'keterangan' => $this->input->post('keterangan')
    );
    $idSetBea = $this->input->post('idBea');
    $this->mdk->revisi(array('id' => $idSetBea), $data_bea);
    echo json_encode(array("status" => TRUE));
  }

  public function terima()
  {
    $data_bea = array(
      'statusBeasiswa' => '3',
      'keterangan' => null
    );
    $idSetBea = $this->input->post('idBea');
    $this->mdk->terima(array('id' => $idSetBea), $data_bea);
    echo json_encode(array("status" => TRUE));
  }

  public function mhs_form()
  {
    $id = $this->input->post('idPengaturan');
    if ($id != null) {
      $detailBea = $this->mdl->get_by_id_bea($id);
      $subScoring = '';
      foreach ($this->mdl->get_skor_by_idBea($id) as $fromSetBea) { //dapat idKategoriSkor saja
        $subScoring .= '
        <div class="input-field col s12">
        <select>
        <option value="" disabled selected>-Pilihan</option>';
        foreach ($this->mdk->get_sub_kategori_skor() as $getScore) { //ambil semua kategori dan subnya
          if ($fromSetBea->idKategoriSkor == $getScore->idKategoriSkor) {
            $subScoring .= '
            <option value="">'.$getScore->sub.'</option>
            ';
            $namaInputan = "$getScore->nama";
          }
        }
        $subScoring .= '
        </select>
        <label>'.$namaInputan.'</label>
        </div>';
      }

      $data = array(
        'idSetBea' => $id,
        'nama' => $detailBea->namaBeasiswa,
        'penyelenggara' => $detailBea->penyelenggaraBea,
        'selektor' => $detailBea->selektor,
        'keterangan' => $detailBea->keterangan,
        'dibuka' => $detailBea->beasiswaDibuka,
        'ditutup' => $detailBea->beasiswaTutup,
        'periodeBerakhir' => $detailBea->periodeBerakhir,
        'kuota' => $detailBea->kuota,
        'namaFk' => $detailBea->namaFk,
        'comboBox' => $subScoring
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
        'periodeBerakhir' => "",
        'kuota' => "",
        'namaFk' => "",
        'comboBox' => null
      );
    }
    $this->load->view('attribute/header_kabag');
    $this->load->view('kabag/mhs_form', $data);
    $this->load->view('attribute/footer');
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
      if ($row->selektor == "1") {
        # kasubag kemahasiswaan
        $sub_array[] = '<i class="mdi-toggle-radio-button-on" title="Kasubag. Kemahasiswaan"></i> Kms';
      }elseif ($row->selektor == "2") {
        # kasubag kemahasiswaan fakultas
        $sub_array[] = '<i class="mdi-toggle-radio-button-off" title="Kasubag. Kemahasiswaan Fakultas"></i> Fks';
      }elseif ($row->selektor == "3") {
        # keduanya
        $sub_array[] = '<i class="mdi-action-stars" title="Keduanya"></i> 2K';
      }
      $status = $row->statusBeasiswa;
      if ($status=="0" || $status=="1" ||$status=="3") {
        # aktif/confirmed
        $sub_array[] = '<span class="success-text">Telah Dikonfirmasi</span>';
        $alamat = base_url('kabag/C_request/mhs_form');
        $sub_array[] = '
          <form action="'.$alamat.'" method="post">
            <button class="btn-floating waves-effect waves-light primary-color" title="Confirmed" type="submit" name="idPengaturan" value="'.$row->id.'"><i class="mdi-action-done"></i></button>
          </form>
          ';
      }else{
        # ditolak
        $sub_array[] = '<span class="alert-text">'.$row->keterangan.'</span>';
        $alamat = base_url('kabag/C_request/mhs_form');
        $sub_array[] = '
            <form action="'.$alamat.'" method="post">
              <button class="btn-floating waves-effect waves-light red" title="Not Confirmed" type="submit" name="idPengaturan" value="'.$row->id.'"><i class="mdi-action-settings"></i></button>
            </form>
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

}
 ?>
