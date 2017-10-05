<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DaftarBeasiswa extends CI_Model {
  var $table = "bea";
  var $select_column;
  var $order_column = array("bea.id", "bea.namaBeasiswa", "bea.penyelenggaraBea", "bea.beasiswaDibuka","bea.beasiswaTutup", null);
  var $column_search = array("bea.namaBeasiswa", "bea.penyelenggaraBea", "bea.beasiswaDibuka","bea.beasiswaTutup");

  function __construct()
  {
    parent::__construct();
    $nim = $this->session->userdata('username');
    $this->select_column = array("bea.id", "bea.namaBeasiswa", "bea.penyelenggaraBea", "bea.beasiswaDibuka","bea.beasiswaTutup","(SELECT pendaftar.nim FROM pendaftar where pendaftar.nim=".$nim." && pendaftar.idBea=bea.id) nim");
  }

  function make_query()
  { 
    $this->db->select($this->select_column);
    $this->db->from($this->table);
    $this->db->where("(select CURRENT_DATE) >= bea.beasiswaDibuka and (select CURRENT_DATE) <= bea.beasiswaTutup");
    $this->db->where('bea.statusBeasiswa','3');

    $i = 0;
    foreach ($this->column_search as $item) // loop column
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {

        if($i===0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if(count($this->column_search) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }    
    if(isset($_POST["order"]))
    {
      $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else
    {
      $this->db->order_by('bea.id', 'DESC');
      $this->db->group_by('bea.id'); 
    }
  }

  function make_datatables(){
    $this->make_query();
    if($_POST["length"] != -1)
    {
      $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }
  public function get_id($nim,$idBea){
    $query = $this->db->query('SELECT id FROM pendaftar WHERE nim="'.$nim.'" AND idBea="'.$idBea.'"');


    return $query->row();

    $query = null;

    unset($idBea,$nim);
  }

  function get_filtered_data(){
    $this->make_query();
    $query = $this->db->get();
    return $query->num_rows();
  }

  function get_all_data()
  {
    $this->db->select("*");
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  public function get_by_id_bea($id)
  {
    $this->db->from($this->table);
    $this->db->where('bea.id',$id);
    $query = $this->db->get();
    return $query->row();
  }

  public function get_scoring()
  {
    $this->db->select('*');
    $this->db->from('kategori_skor');
    $query = $this->db->get();
    return $query->result();
  }

  public function save_bea($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function save_sub_bea($data)
  {
    $this->db->insert_batch('set_bea_kategori_skor', $data);
    return $this->db->insert_id();
  }

  public function get_skor_by_idBea($id)
  {
    $this->db->select('set_bea_kategori_skor.idKategoriSkor, set_bea_kategori_skor.id');
    $this->db->from('set_bea_kategori_skor');
    $this->db->where('set_bea_kategori_skor.idBea',$id);
    $query = $this->db->get();
    return $query->result();
  }

  public function update_setting_bea($where, $data)
  {
    $this->db->update($this->table, $data, $where);
    return $this->db->affected_rows();
  }

  public function update_setting_sub_bea($where, $data)
  {
    $this->db->update('set_bea_kategori_skor', $data, $where);
    return $this->db->affected_rows();
  }

  public function insert_setting_sub_bea($data)
  {
    $this->db->insert('set_bea_kategori_skor', $data);
    return $this->db->insert_id();
  }

  public function delete_setting_sub_bea($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('set_bea_kategori_skor');
  }

  public function delete_by_id($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->table);

    $this->db->where('idBea', $id);
    $this->db->delete('set_bea_kategori_skor');
  }
  public function getPenerimaBea($nim)
  {
    $this->db->from('penerima_bea');
    $this->db->where('penerima_bea.nimMhs',$nim);
    $query = $this->db->get();
    if ($query) {
      return $query->result();  
    }else{
      return false;
    }
  }

  public function get_penerimaBea($nim)
  {
    $this->db->from('penerima_bea');
    $this->db->where('penerima_bea.nimMhs',$nim);
    $query = $this->db->get();
    return $query->row();
  }
  public function get_pendaftar($nim)
  {
    $this->db->from('pendaftar');
    $this->db->where('pendaftar.nim',$nim);
    $query = $this->db->get();
    return $query->row();
  }
  public function ceknimPendaftar($nim)
  {
    $this->db->select('nim');    
    $this->db->from('pendaftar');
    $this->db->where('pendaftar.nim',$nim);
    return $this->db->count_all_results();
  }
  public function ceknimPenerimaBea($nim)
  {
    $this->db->select('nimMhs');    
    $this->db->from('penerima_bea');
    $this->db->where('penerima_bea.nimMhs',$nim);
    return $this->db->count_all_results();
  }
  public function ceknimPendaftarBea()
  { $nim  = $this->session->userdata('username');

  $data = "SELECT pendaftar.*, bea.periodeBerakhir FROM `pendaftar`
  LEFT JOIN bea ON pendaftar.idBea=bea.id
  WHERE pendaftar.nim='".$nim."' && bea.periodeBerakhir>=CURRENT_DATE && pendaftar.status=1";

  $query = $this->db->query($data);
  if ($query) {
    return $query->result();
  }else{
    return false;
  }
}
public function ceknimPendaftarBea2()
{ $nim  = $this->session->userdata('username');

$data = "SELECT pendaftar.*, bea.periodeBerakhir,bea.namaBeasiswa,bea.beasiswaDibuka,bea.periodeBerakhir ,identitas_mhs.namaLengkap FROM `pendaftar`
LEFT JOIN bea ON pendaftar.idBea=bea.id
LEFT JOIN identitas_mhs ON identitas_mhs.nimMhs=pendaftar.nim
WHERE pendaftar.nim='".$nim."' && bea.periodeBerakhir>=CURRENT_DATE && pendaftar.status=1";

$query = $this->db->query($data);
if ($query) {
  return $query->row();
}else{
  return false;
}
}
}
