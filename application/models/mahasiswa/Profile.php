<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Model {
	public function __construct()
	{	
		parent::__construct();
	}

	public function getdata($key)
	{
		$this->db->from('identitas_mhs');
		$this->db->where('identitas_mhs.nimMhs',$key);
		$query = $this->db->get();
		return $query->row();
	}

	public function getupdate($key,$data)
	{
		$this->db->where('nimMhs',$key);
		$this->db->update('identitas_mhs',$data);
	}

	function get_update($data,$where){
		$this->db->where($where);
		$this->db->update('identitas_mhs', $data);
		return TRUE;
	}

	function get_byimage($where) {
		$this->db->from('identitas_mhs');
		$this->db->where($where);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query;
		}
	}

	public function getupdatePass($key,$data)
	{
		$this->db->where('id',$key);
		$this->db->update('akses',$data);
	}
	public function getInsert($data)
	{
		$this->db->insert('identitas_mhs',$data);
	}
	public function getdelete($key)
	{
		$this->db->where('nimMhs',$key);
		$this->db->delete('identitas_mhs');
	}
	public function getCurrPass($userId){
		$query = $this->db->where(['userId'=>$userId])
		->get('akses');
		if($query->num_rows() > 0){
			return $query->row();
		}
	}
	public function updatePass($newpass,$userid){
		$data = array(
			'password' => $newpass
			);
		return $this->db->where('userId',$userid)->update('akses',$data);
	}
	public function getIdentitasMhs($nim)
	{
		$this->db->select('nimMhs');    
		$this->db->from('identitas_mhs');
		$this->db->where('identitas_mhs.nimMhs',$nim);
		return $this->db->count_all_results();
	}
}
