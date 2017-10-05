<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requested extends CI_Model {

  var $table = "bea";
  var $select_column = array("bea.id", "bea.namaBeasiswa", "bea.penyelenggaraBea", "bea.selektor", "bea.keterangan", "bea.statusBeasiswa");
  var $order_column = array("bea.id", "bea.namaBeasiswa", "bea.penyelenggaraBea", "bea.selektor", "bea.keterangan", null);

  function make_query()
  {
    $this->db->select($this->select_column);
    $this->db->from($this->table);
    if(isset($_POST["search"]["value"]))
    {
      $this->db->like("bea.namaBeasiswa", $_POST["search"]["value"]);
      $this->db->or_like("bea.penyelenggaraBea", $_POST["search"]["value"]);
      $this->db->or_like("bea.keterangan", $_POST["search"]["value"]);
    }
    if(isset($_POST["order"]))
    {
      $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else
    {
      $this->db->order_by('bea.id', 'DESC');
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
    $this->db->join('fakultas','bea.selektorFakultas=fakultas.id','left');
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

  public function get_fakultas()
  {
    $sql="SELECT * FROM fakultas";
    $data = $this->db->query($sql);
    return $data->result();
  }
}
