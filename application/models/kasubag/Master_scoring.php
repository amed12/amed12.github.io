<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_scoring extends CI_Model {

  var $table = "kategori_skor";
  var $select_column = array("kategori_skor.id", "kategori_skor.nama");
  var $order_column = array("kategori_skor.id", "kategori_skor.nama", null, null);

  function make_query()
  {
    $this->db->select($this->select_column);
    $this->db->from($this->table);
    if(isset($_POST["search"]["value"]))
    {
      $this->db->like("kategori_skor.nama", $_POST["search"]["value"]);
      // $this->db->or_like("set_sub_kategori_skor.nama", $_POST["search"]["value"]);
    }
    if(isset($_POST["order"]))
    {
      $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else
    {
      $this->db->order_by('kategori_skor.id', 'DESC');
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

  public function get_sub_score($id)
  {
    $sql="SELECT sub.id, sub.nama, sub.skor FROM set_sub_kategori_skor sub WHERE sub.idKategoriSkor='".$id."' ORDER BY sub.skor ASC";
    $query = $this->db->query($sql);
    $data = "";
    $level_dark = 1;
    foreach ($query->result() as $val) {
      $data .= '<div class="chip light-blue darken-'.$level_dark.' white-text">('.$val->skor.') '.$val->nama.'</div>';
      if ($level_dark==4) {
        $level_dark = 1;
      }else {
        $level_dark+=1;
      }
    }
    return $data;
  }

  public function save_kategori($data)
  {
    $this->db->insert($this->table, $data);
		return $this->db->insert_id();
  }

  public function save_sub_kategori($data)
  {
    $this->db->insert_batch('set_sub_kategori_skor', $data);
		return $this->db->insert_id();
  }

  public function get_by_id($id)
	{
		$this->db->from('kategori_skor');
		$this->db->where('kategori_skor.id',$id);
		$query = $this->db->get();
		return $query->row();
	}

  public function get_by_id_sub($id)
	{
		$this->db->from('set_sub_kategori_skor');
		$this->db->where('set_sub_kategori_skor.idKategoriSkor',$id);
		$query = $this->db->get();
		return $query->result();
	}

  public function update_kategori($where, $data)
  {
    $this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
  }

  public function insert_sub_kategori($dataSub)
  {
    $this->db->insert('set_sub_kategori_skor', $dataSub);
		return $this->db->insert_id();
  }

  public function update_sub_kategori($where, $data)
  {
    $this->db->update('set_sub_kategori_skor', $data, $where);
		return $this->db->affected_rows();
  }

  public function delete_sub_kategori($idSub)
  {
    $this->db->where('id', $idSub);
		$this->db->delete('set_sub_kategori_skor');
  }

  public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
    #karena db sudah relasi jadi query dibawah di komen
    // $this->db->where('idKategoriSkor', $id);
		// $this->db->delete('set_sub_kategori_skor');
	}

}
