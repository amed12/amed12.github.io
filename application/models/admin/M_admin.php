<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model
{

    var $table = "akses";
    var $select_column = array("akses.id", "akses.userId");
    var $order_column = array("akses.id", "akses.userId");
    var $column_order = array('akses.id', 'akses.userId', null, 'idLevel', 'status', null); //set column field database for datatable orderable
    var $column_search = array('akses.userId', 'akses.idLevel'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('akses.id' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function make_query()
    {
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function make_datatables()
    {
        $this->make_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();

    }

    function get_filtered_data()
    {
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


    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }
    public function getLevel($id)
    {
     $query = $this->db->query('SELECT akses.idLevel as level FROM akses WHERE akses.userId = "'.$id.'"');
     return  $query->row();

     }
     public function getStatus($id)
    {
     $query = $this->db->query('SELECT akses.status FROM akses WHERE akses.userId = "'.$id.'"');
     return  $query->row();

     }
public function update($nim, $data)
{
       // query binding ditandai dengan "?" untuk security
    $hai = null;
    $hai2 = null;
    $pilih_hitung = $data['idLevel'];
      $status= $data['status'];
      if ($pilih_hitung == "Staff kemahasiswaan"){
        $hai = 1;
      }
      else if ($pilih_hitung == "Kasubag"){
        $hai = 2;
      }
      else if ($pilih_hitung == "Kasubag Fakultas"){
        $hai = 3;
      }
      else if ($pilih_hitung == "Kabag"){
        $hai = 4;
      }
      else if ($pilih_hitung == "Mahasiswa"){
        $hai = 5;
      }else if ($pilih_hitung == "Admin"){
        $hai = 6;
      }

      if ($status == "Aktif"){
        $hai2 = "open";
      }
      else {
        $hai2 = "close";
      }

        $this->db->query("UPDATE `akses` SET `userId` = ?, `password` = ?, `idLevel` = ?, `status` = ? WHERE `akses`.`id` = ? ", array($data['userId'],$data['password'],$hai,$hai2,$nim));
        
        // menghapus variabel dari memory
        unset($nim, $data);
    
}
public function delete_by_id($id)
{
    $this->db->where('id', $id);
    $this->db->delete($this->table);
}

public function save($data)
{
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();

}


}
