<?php defined('BASEPATH')OR exit('no direct script access allowed');
/**
 * 
 */
 class Beasiswa extends CI_Model
 {
 	
 	function __construct()
 	{
 		parent::__construct();
 	}

 	public function daftarBeasiswa()
 	{
 		$data = $this->db->query("SELECT * from bea order by id asc");
 		if ($data) {
 			return $data->result_array();
 		}else{
 			return false;
 		}
 	}

 	public function tambahBeasiswa($data)
 	{
 		$this->db->query("INSERT into bea(`namaBeasiswa`, `penyelenggaraBea`,`beasiswadibuka`,`beasiswatutup`,`statusbeasiswa`,`statustabel`,`kuota`)values(?,?,?,?,?,?,?)", array($data['nama'], $data['penyelenggara'], $data['buka'], $data['tutup'], $data['status'], $data['tabel'], $data['kuota']));
 		unset($data);
 	}

 	public function EditBeasiswa()
 	{
 		$id = $this->input->get('id');
 		$this->db->where('id', $id);
 		$data = $this->db->get('bea');
 		if ($data->num_rows>0) {
 			return $data->row();
 		}else{
 			return false;
 		}
 	}

 	public function hapusBeasiswa($idBea)
 	{
 		$this->db->where('id', $idBea);
 		$this->db->delete('bea');
 		if ($this->db->affected_rows()>0) {
 			return true;
 		}else{
 			return false;
 		}
 	}
 } ?>