<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik extends CI_Model
{

  public function get_tahun()
  {
    // SELECT YEAR(bea.beasiswaDibuka) tahun FROM `bea` GROUP BY tahun
    $sql = 'SELECT YEAR(bea.beasiswaDibuka) tahun FROM `bea` GROUP BY tahun ORDER BY tahun DESC';
    $res = $this->db->query($sql);
    return $res->result();
  }

  // SELECT bea.id, bea.namaBeasiswa,
  // (SELECT COUNT(pendaftar.nim) FROM `pendaftar` WHERE pendaftar.idBea=bea.id && pendaftar.status="1") penerima,
  // (SELECT COUNT(pendaftar.nim) FROM `pendaftar` WHERE pendaftar.idBea=bea.id) mhsDaftar
  // FROM `bea`
  // WHERE YEAR(bea.beasiswaDibuka)="2017"
  public function get_data_grafik($thn)
  {
    $sql = '
    SELECT bea.id, bea.namaBeasiswa,
    (SELECT COUNT(pendaftar.nim) FROM `pendaftar` WHERE pendaftar.idBea=bea.id && pendaftar.status="1") penerima,
    (SELECT COUNT(pendaftar.nim) FROM `pendaftar` WHERE pendaftar.idBea=bea.id) mhsDaftar
    FROM `bea`
    WHERE YEAR(bea.beasiswaDibuka)="'.$thn.'"
    ';
    $res = $this->db->query($sql);
    return $res->result();
  }

}
