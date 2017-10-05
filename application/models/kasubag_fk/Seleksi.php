<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleksi extends CI_Model {

  var $table = "skor_mahasiswa";
  var $select_column = array("skor_mahasiswa.nimMhs", "skor_mahasiswa.namaLengkap", "skor_mahasiswa.namaBeasiswa", "skor_mahasiswa.ipk", "skor_mahasiswa.skor", "skor_mahasiswa.jumlah", "skor_mahasiswa.idBeasiswa", "skor_mahasiswa.updated", "skor_mahasiswa.status", "skor_mahasiswa.idPendaftar");
  var $order_column = array(null, "skor_mahasiswa.nimMhs", "skor_mahasiswa.namaLengkap", "skor_mahasiswa.ipk", "skor_mahasiswa.skor", "skor_mahasiswa.jumlah", "skor_mahasiswa.updated", null);
  var $column_search = array("skor_mahasiswa.nimMhs", "skor_mahasiswa.namaLengkap", "skor_mahasiswa.ipk", "skor_mahasiswa.skor", "skor_mahasiswa.jumlah");

  function make_query($idBea)
  {
    $this->db->select($this->select_column);
    $this->db->from($this->table);
    $this->db->where('idBeasiswa', $idBea);

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
      $this->db->order_by('skor_mahasiswa.jumlah', 'DESC');
    }
  }

  function make_datatables($idBea){
    $this->make_query($idBea);
    if($_POST["length"] != -1)
    {
        $this->db->limit($_POST['length'], $_POST['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }

  function get_filtered_data($idBea){
    $this->make_query($idBea);
    $query = $this->db->get();
    return $query->num_rows();
  }

  function get_all_data()
  {
    $this->db->select("*");
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  //combobox
  public function getComboBea()
  {
    $username = $this->session->userdata('username'); //ganti dengan session username
    $password = $this->session->userdata('pass'); //ganti dengan session password

    $sq = "SELECT fakultas.id idFakultas, fakultas.namaFk FROM akses
    LEFT JOIN profil_admin ON profil_admin.idAkses = akses.id
    LEFT JOIN fakultas ON profil_admin.idFakultas = fakultas.id
    WHERE akses.userId='".$username."' && akses.password='".$password."'";
    $que = $this->db->query($sq)->row();

    $sql = 'SELECT * FROM bea WHERE (bea.selektor="2" && bea.selektorFakultas="'.$que->idFakultas.'" || selektor="3") && bea.statusBeasiswa="3" && (CURRENT_DATE>bea.beasiswaTutup && CURRENT_DATE<=bea.seleksiTutup)';
    $query = $this->db->query($sql);
    return $query->result();
  }

  public function seleksi_penerima($where, $data)
  {
    $this->db->update("pendaftar", $data, $where);
		return $this->db->affected_rows();
  }

  public function infoDiterima($idBea)
  {
    $sql = "SELECT COUNT(status) diterima FROM `pendaftar` WHERE idBea=".$idBea." && status=1";
    $query = $this->db->query($sql);
    return $query->row()->diterima;
  }

  public function view_detail_score($idPendaftar,$idBea)
  {
    $sql = 'SELECT pendaftar_skor.idBea, pendaftar.nim, pendaftar.id, kategori_skor.nama kategori, set_sub_kategori_skor.nama pilihan, set_sub_kategori_skor.skor FROM `pendaftar_skor`
    LEFT JOIN pendaftar ON pendaftar.id=pendaftar_skor.idPendaftar
    LEFT JOIN kategori_skor ON pendaftar_skor.idKategori=kategori_skor.id
    LEFT JOIN set_sub_kategori_skor ON pendaftar_skor.idSubKategori=set_sub_kategori_skor.id
    WHERE pendaftar_skor.idPendaftar = '.$idPendaftar.' && pendaftar_skor.idBea = '.$idBea;
    $res = $this->db->query($sql);
    return $res->result();
  }

  public function check_status_penerima($nim)
  {
    $sql = 'SELECT pendaftar.nim, bea.namaBeasiswa, pendaftar.status, bea.periodeBerakhir FROM `pendaftar`
    LEFT JOIN bea ON bea.id=pendaftar.idBea
    WHERE CURRENT_DATE<=bea.periodeBerakhir && pendaftar.status=1 && pendaftar.nim="'.$nim.'"';
    $res = $this->db->query($sql);
    return $res->row();
  }

}
