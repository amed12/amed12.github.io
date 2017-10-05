<?php defined('BASEPATH')OR exit('no direct script access allowed');
/**
 * 
 */
 class Berita extends CI_Model
 {
 	
 	function __construct()
 	{
 		parent::__construct();
 	}

 	public function daftarBerita()
 	{
 		$data = $this->db->query("SELECT * from berita order by idBerita asc");
 		if ($data) {
			return $data->result_array();
 		}else{
 			return false;
 		}
 		unset($data);
 	}

 	public function tambahBerita($data)
 	{
 		$this->db->query("INSERT into berita(judulBerita, topikBerita, penulisBerita, kontenBerita, tglInBerita) values(?,?,?,?,?)", array($data['judul'], $data['topik'], $data['penulis'], $data['konten'], $data['tanggal']));
 		unset($data);
 	}

 	public function editBerita()
 	{
 		$idBerita = $this->input->get('id');
 		$this->db->where('idBerita', $idBerita);
 		$berita =$this->db->get('berita');
 		if ($berita->num_rows()>0) {
 			return $berita->row();
 		}else{
 			return false;
 		}
 	}

 	public function updateBerita($idberita, $data)
 	{
 		$this->db->query("UPDATE berita set judulBerita=?, topikBerita=?, penulisBerita=?,kontenBerita=?, tglInBerita=? where idBerita=?", array($data['judul'], $data['topik'], $data['penulis'], $data['konten'], $data['tanggal'], $idberita));
 		unset($idberita, $data);
 	}

 	public function hapusBerita($id)
 	{
 		$this->db->where('idBerita', $id);
 		$this->db->delete('berita');
 		if ($this->db->affected_rows()>0) {
 			return true;
 		}else{
 			return falses;
 		}
 	}
 } ?>