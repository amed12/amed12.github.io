<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Model {
	public function __construct()
	{	
		parent::__construct();
	}

	public function getdata($key)
	{
		$this->db->from('profil_admin');
		$this->db->where('profil_admin.idAkses',$key);
		$query = $this->db->get();
		return $query->row();
	}
	public function getIdentitasAdmin($id)
	{
		$this->db->select('idAkses');    
		$this->db->from('profil_admin');
		$this->db->where('profil_admin.idAkses',$id);
		return $this->db->count_all_results();
	}

	var $table='akses';
	public function getProfile($user,$pass){
		$this->db->select('*');
		$this->db->from('akses as a');
		$this->db->where('a.userId', $user);
		$this->db->where('a.password', $pass);
		$this->db->join('profil_admin as p', 'a.id = p.idAkses', 'LEFT');
		$this->db->join('levellog as l', 'a.idLevel=l.id', 'LEFT');
		$query=$this->db->get($this->table);
		return $query;
	}

	public function getupdate($key,$data)
	{
		$this->db->where('id',$key);
		$this->db->update('profil_admin',$data);
	}

	function get_update($data,$where){
		$this->db->where($where);
		$this->db->update('profil_admin', $data);
		return TRUE;
	}
	public function getupdatePass($key,$data)
	{
		$this->db->where('id',$key);
		$this->db->update('akses',$data);
	}
	public function getInsert($data)
	{
		$this->db->insert('profil_admin',$data);
	}
	public function getdelete($key)
	{
		$this->db->where('id',$key);
		$this->db->delete('profil_admin');
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
}
