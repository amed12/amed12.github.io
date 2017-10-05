<?php defined('BASEPATH')OR exit('no direct script access allowed');

 class BeaAktif extends CI_Model
 {

   function get_bea_aktif()
   {
     $sql = '
     SELECT bea.*, CURRENT_DATE() tanggalSekarang, fakultas.namaFk
     FROM `bea`
     LEFT JOIN fakultas ON fakultas.id=bea.selektorFakultas
     WHERE CURRENT_DATE() <= bea.periodeBerakhir
     ';
     $res = $this->db->query($sql);
     return $res->result();
   }

 }
 ?>
