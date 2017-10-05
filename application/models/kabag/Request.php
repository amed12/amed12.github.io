<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends CI_Model {

  public function revisi($where, $data)
  {
    $this->db->update('bea', $data, $where);
		return $this->db->affected_rows();
  }

  public function terima($where, $data)
  {
    $this->db->update('bea', $data, $where);
		return $this->db->affected_rows();
  }

  public function get_sub_kategori_skor()
  {
    $sql = 'SELECT set_sub_kategori_skor.idKategoriSkor, kategori_skor.nama, set_sub_kategori_skor.nama sub FROM set_sub_kategori_skor LEFT JOIN kategori_skor ON set_sub_kategori_skor.idKategoriSkor=kategori_skor.id';
    $res = $this->db->query($sql);
    return $res->result();
  }

}
