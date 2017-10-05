<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model
{	function __construct()



{	parent::__construct();
}


    private $table = 'bea';
    private $table2 = 'berita';
    private $pk = 'id';
    private $pk2 = 'idBerita';

    function daftar_bea()
    {	$query = $this->db->query("SELECT namaBeasiswa,penyelenggaraBea,beasiswadibuka,beasiswatutup,statusbeasiswa,kuota FROM bea LIMIT 4");

        // mengembalikan hasil query
        return $query->result();

        // menghapus query dari memory
        $query = null;
    }
    function daftar_berita()
    {	$query = $this->db->query("SELECT idBerita, judulBerita,topikBerita,penulisBerita,kontenBerita,tglInBerita FROM berita");

        // mengembalikan hasil query
        return $query->result();

        // menghapus query dari memory
        $query = null;
    }

    public function detailBerita($id) {
        $data = $this->db->query("select * from berita where idBerita=?", array($id));
        if ($data) {
            return $data;
        } else {
            return false;
        }
        unset($data);
    }
    function user_limit($limit, $start = 0) {
        $this->db->order_by($this->pk, 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table);
    }
    function user_limit2($limit, $start = 0) {
        $this->db->order_by($this->pk2, 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table2);
    }
    function total_record() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    function total_record2() {
        $this->db->from($this->table2);
        return $this->db->count_all_results();
    }


}
// End of file M_aplikasi.php
// Location: ./application/models/M_aplikasi.php
