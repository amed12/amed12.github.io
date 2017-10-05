<?php defined('BASEPATH')OR exit('tidak ada akses diizinkan');
class C_seleksi extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->library('Loginauth');
    $this->loginauth->view_page();

    $this->load->model("kasubag/Seleksi",'mdl');
  }

  public function index()
  {
    $this->load->view('attribute/header_kasubag');
    $data['comboBea'] = $this->mdl->getComboBea();
    $this->load->view('kasubag/seleksi',$data);
    $this->load->view('attribute/footer');
  }

  public function datatable($idBea){
    $fetch_data = $this->mdl->make_datatables($idBea);
    $data = array();
    $nmr = 0;
    foreach($fetch_data as $row)
    {
      $nmr+=1;
      $sub_array = array();
      $sub_array[] = $nmr;
      $sub_array[] = $row->nimMhs;
      $sub_array[] = $row->namaLengkap;
      $sub_array[] = $row->ipk;
      $sub_array[] = '<a href="#" onclick="view_detail_score('.$row->idPendaftar.','.$row->idBeasiswa.')">'.$row->skor.'</a>';
      $sub_array[] = number_format($row->jumlah,2);
      $sub_array[] = $row->updated;
      if ($row->status==1) {
        $sub_array[] = '
          <button class="btn-floating waves-effect waves-light primary-color" title="Confirmed" type="submit" name="idPengaturan" onclick="seleksi('."'".$row->idPendaftar."'".','."'".$row->status."','".$row->nimMhs."'".');"><i class="mdi-action-done"></i></button>
        ';
      }elseif ($row->status==0) {
        $sub_array[] = '
          <button class="btn-floating waves-effect waves-light red" title="Not Confirmed" type="submit" name="idPengaturan" onclick="seleksi('."'".$row->idPendaftar."'".','."'".$row->status."','".$row->nimMhs."'".');"><i class="mdi-content-clear"></i></button>
        ';
      }


      $data[] = $sub_array;
    }
    $output = array(
      "draw"            =>  intval($_POST["draw"]),
      "recordsTotal"    =>  $this->mdl->get_all_data(),
      "recordsFiltered" =>  $this->mdl->get_filtered_data($idBea),
      "data"            =>  $data
    );
    echo json_encode($output);
  }

  public function view_detail_score($idPendaftar, $idBea)
  {
    $data = $this->mdl->view_detail_score($idPendaftar, $idBea);
    echo json_encode($data);
  }

  public function getDiterima($idBea)
  {
    $data = $this->mdl->infoDiterima($idBea);
    echo json_encode($data);
  }

  public function seleksi($idPendaftar, $status, $nim)
  {
    $change_status;
    if ($status=="1") {
      $change_status = "0";
      $data = array(
        'status' => $change_status
      );
      $this->mdl->seleksi_penerima(array('id' => $idPendaftar), $data);
      echo json_encode(array("status" => TRUE));
    }elseif ($status=="0") {
      $check = $this->mdl->check_status_penerima($nim);
      if ($check==null) {
        $change_status = "1";
        $data = array(
          'status' => $change_status
        );
        $this->mdl->seleksi_penerima(array('id' => $idPendaftar), $data);
        echo json_encode(array("status" => TRUE));
        // echo "belum diterima di beasiswa";
      }else{
        $detail_diterima = array(
          'status' => FALSE,
          'nim' => $check->nim,
          'bea' => $check->namaBeasiswa,
          'periode_berakhir' => $check->periodeBerakhir
        );
        echo json_encode($detail_diterima);
        // echo "telah di terima di beasiswa";
      }
    }
  }

}
 ?>
