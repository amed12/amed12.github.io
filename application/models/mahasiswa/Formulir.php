<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formulir extends CI_Model {

  function data_pendaftar($id)
  { // query binding ditandai dengan "?" untuk security
  $query = $this->db->query('SELECT pendaftar.idBea as idbea,jurusan.namaJur as jurusan,pendaftar.nim as pendaftarnim,identitas_mhs.namaLengkap as namalengkap,bea.namaBeasiswa as namabea,pendaftar.semester as semester,pendaftar.sks as sks,pendaftar.ipk as ipk,pendaftar.alamatMalang as alamatmalang,identitas_mhs.alamatLengkap as alamatlengkap,identitas_mhs.noTelp as telp,identitas_mhs.tempatLahir as tempatLahir,identitas_mhs.tglLahir as tgl FROM pendaftar,bea,identitas_mhs,jurusan WHERE bea.id = pendaftar.idBea AND pendaftar.id = "'.$id.'" AND pendaftar.nim=identitas_mhs.nimMhs AND jurusan.id = identitas_mhs.idJrs');

    // $this->db->select('pendaftar.idBea as idbea,jurusan.namaJur as jurusan,pendaftar.nim as pendaftarnim,identitas_mhs.namaLengkap as namalengkap,bea.namaBeasiswa as namabea,pendaftar.semester as semester,pendaftar.sks as sks,pendaftar.ipk as ipk,pendaftar.alamatMalang as alamatmalang,identitas_mhs.alamatLengkap as alamatlengkap,identitas_mhs.noTelp as telp,identitas_mhs.tempatLahir as tempatLahir,identitas_mhs.tglLahir as tgl');
    // $this->db->from('pendaftar,bea,identitas_mhs,jurusan');
    // $this->db->where('bea.id = pendaftar.idBea')AND('pendaftar.id = "0"')AND('pendaftar.nim=identitas_mhs.nimMhs AND jurusan.id = identitas_mhs.idJrs');
    // $query = $this->db->get();
    // mengembalikan hasil query
  return $query->row();

  $query = null;

  unset($id);


}
public function data_kategori($id)
{
      $query = $this->db->query('SELECT kategori_skor.nama as skor,set_sub_kategori_skor.nama as nama FROM pendaftar_skor,kategori_skor,set_sub_kategori_skor WHERE pendaftar_skor.idPendaftar = "'.$id.'" AND pendaftar_skor.idKategori=kategori_skor.id AND set_sub_kategori_skor.id = pendaftar_skor.idSubKategori');
      return $query->result();
     $query = null;
      unset($id);
}
public function get_nama_bea($idBea)
{
  $this->db->select('bea.id, bea.namaBeasiswa');
  $this->db->from('bea');
  $this->db->where('bea.id',$idBea);
  $query = $this->db->get();
  return $query->row();
}
public function getdataMhs($nim)
{ 
  $this->db->select('*');
  $this->db->from('identitas_mhs');
  $this->db->where('identitas_mhs.nimMhs',$nim);
  $hasil = $this->db->get();
  return $hasil->row();
}

public function getdataMhs_byId($id)
{
  $this->db->from('identitas_mhs');
  $this->db->where('nimMhs',$id);
  $query = $this->db->get();
  return $query->row();
}

public function getDataPendaftar($key)
{
  $this->db->where('id',$key);
  $hasil = $this->db->get('pendaftar');
  return $hasil;
}
public function getInsert($data)
{
  $this->db->insert('pendaftar',$data);
  return $this->db->insert_id();
}

public function pendaftarSkor($data)
{
  $this->db->insert_batch('pendaftar_skor', $data);
  return $this->db->insert_id();
}


public function get_skor_bea($id)
{
  $this->db->select('set_bea_kategori_skor.idKategoriSkor, set_bea_kategori_skor.id');
  $this->db->from('set_bea_kategori_skor');
  $this->db->where('set_bea_kategori_skor.idBea',$id);
  $result = $this->db->get()->result();
  $combo = "";
  foreach ($result as $res) {
    $namaKategori = $this->get_kategori($res->idKategoriSkor);
    $combo .= '
    <div class="row">
      <input type="hidden" name="idKategoriSkor[]" value="'.$res->idKategoriSkor.'">
      <div class="input-field col s12">
        <select name="score[]">
          <option value="" disabled selected>-Pilihan '.$namaKategori->nama.'</option>
          ';
          $subKategori = $this->get_sub_kategori($res->idKategoriSkor);
          foreach ($subKategori as $kat) {
            $combo .='
            <option value="'.$kat->id.'">'.$kat->nama.'</option>
            ';
          }
          $combo .='
        </select>
        <label>'.$namaKategori->nama.'</label>
      </div>
    </div>
    ';
  }
  return $combo;
}

public function get_kategori($id)
{
  $this->db->select('kategori_skor.nama');
  $this->db->from('kategori_skor');
  $this->db->where('kategori_skor.id',$id);
  $res = $this->db->get();
  return $res->row();
}

public function get_sub_kategori($id)
{
  $this->db->select('set_sub_kategori_skor.nama, set_sub_kategori_skor.id');
  $this->db->from('set_sub_kategori_skor');
  $this->db->where('set_sub_kategori_skor.idKategoriSkor',$id);
  $res = $this->db->get();
  return $res->result();
}

public function get_jurusan()
{
  $this->db->select('jurusan.id, jurusan.namaJur');
  $this->db->from('jurusan');
  $res = $this->db->get()->result();
  return $res;
}

public function FunctionName()
{
 $query=$this->db->query("SELECT pendaftar.nim,bea.beasiswaTutup,CURRENT_DATE,datediff(CURRENT_DATE,bea.beasiswaTutup) FROM bea LEFT JOIN pendaftar ON bea.id=pendaftar.idBea WHERE pendaftar.nim=15650025 and ((YEAR(bea.beasiswaTutup) BETWEEN (YEAR(CURRENT_DATE)-1) AND (YEAR(CURRENT_DATE)+1)))");


 $query1=$this->db->query("SELECT pendaftar.nim nimMhs, identitas_mhs.namaLengkap, pendaftar.idBea, bea.namaBeasiswa, pendaftar.ipk, (
  SELECT SUM(set_sub_kategori_skor.skor)
  FROM pendaftar
  RIGHT JOIN pendaftar_skor ON pendaftar.id=pendaftar_skor.idPendaftar
  LEFT JOIN kategori_skor ON pendaftar_skor.idKategori=kategori_skor.id
  LEFT JOIN set_sub_kategori_skor ON pendaftar_skor.idSubKategori=set_sub_kategori_skor.id
  WHERE pendaftar.nim=nimMhs
) skor, (
SELECT SUM(set_sub_kategori_skor.skor)+pendaftar.ipk
FROM pendaftar
RIGHT JOIN pendaftar_skor ON pendaftar.id=pendaftar_skor.idPendaftar
LEFT JOIN kategori_skor ON pendaftar_skor.idKategori=kategori_skor.id
LEFT JOIN set_sub_kategori_skor ON pendaftar_skor.idSubKategori=set_sub_kategori_skor.id
WHERE pendaftar.nim=nimMhs
) jumlah,
pendaftar.status, bea.beasiswaDibuka,bea.beasiswaTutup, bea.periodeBerakhir,pendaftar.waktuDiubah updated
FROM pendaftar
LEFT JOIN bea ON pendaftar.idBea=bea.id
LEFT JOIN identitas_mhs ON pendaftar.nim=identitas_mhs.nimMhs WHERE pendaftar.status='1'
ORDER BY jumlah DESC");


$query=$this->db->query("SELECT pendaftar.nim,bea.beasiswaTutup,bea.periodeBerakhir,CURRENT_DATE now,datediff(CURRENT_DATE,bea.beasiswaTutup) berakhirPendaftaran,datediff(CURRENT_DATE,bea.periodeBerakhir)berakhirPeriode FROM bea LEFT JOIN pendaftar ON bea.id=pendaftar.idBea WHERE pendaftar.nim=15650025 and ((YEAR(bea.beasiswaTutup) BETWEEN (YEAR(CURRENT_DATE)-1) AND (YEAR(CURRENT_DATE)+1))) AND ((YEAR(bea.periodeBerakhir) BETWEEN (YEAR(CURRENT_DATE)-1) AND (YEAR(CURRENT_DATE)+1)))");


$query=$this->db->query("SELECT pendaftar.nim nimMhs, identitas_mhs.namaLengkap, pendaftar.idBea, bea.namaBeasiswa, pendaftar.ipk, (
  SELECT SUM(set_sub_kategori_skor.skor)
  FROM pendaftar
  RIGHT JOIN pendaftar_skor ON pendaftar.id=pendaftar_skor.idPendaftar
  LEFT JOIN kategori_skor ON pendaftar_skor.idKategori=kategori_skor.id
  LEFT JOIN set_sub_kategori_skor ON pendaftar_skor.idSubKategori=set_sub_kategori_skor.id
  WHERE pendaftar.nim=nimMhs
) skor, (
SELECT SUM(set_sub_kategori_skor.skor)+pendaftar.ipk
FROM pendaftar
RIGHT JOIN pendaftar_skor ON pendaftar.id=pendaftar_skor.idPendaftar
LEFT JOIN kategori_skor ON pendaftar_skor.idKategori=kategori_skor.id
LEFT JOIN set_sub_kategori_skor ON pendaftar_skor.idSubKategori=set_sub_kategori_skor.id
WHERE pendaftar.nim=nimMhs
) jumlah,
pendaftar.status, bea.beasiswaDibuka,bea.beasiswaTutup, bea.periodeBerakhir,CURRENT_DATE now,datediff(CURRENT_DATE,bea.beasiswaTutup) berakhirPendaftaran,datediff(CURRENT_DATE,bea.periodeBerakhir)berakhirPeriode,pendaftar.waktuDiubah updated
FROM pendaftar
LEFT JOIN bea ON pendaftar.idBea=bea.id
LEFT JOIN identitas_mhs ON pendaftar.nim=identitas_mhs.nimMhs WHERE pendaftar.status='1' and ((YEAR(bea.beasiswaTutup) BETWEEN (YEAR(CURRENT_DATE)-1) AND (YEAR(CURRENT_DATE)+1))) AND ((YEAR(bea.periodeBerakhir) BETWEEN (YEAR(CURRENT_DATE)-1) AND (YEAR(CURRENT_DATE)+1)))
ORDER BY jumlah DESC");

}

}
