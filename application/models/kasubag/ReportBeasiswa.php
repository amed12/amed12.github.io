<?php

defined('BASEPATH')OR exit('no direct script access allowed');

/**
 *
 */
class ReportBeasiswa extends CI_Model {

    var $table = "pendaftar";
    var $select_column = array("pendaftar.nim", "identitas_mhs.namaLengkap","YEAR(bea.beasiswaDibuka) tahun", "jurusan.namaJur", "fakultas.namaFk", "bea.namaBeasiswa");
    var $order_column = array("pendaftar.nim", "identitas_mhs.namaLengkap", "jurusan.namaJur", "fakultas.namaFk", "bea.namaBeasiswa", "YEAR(bea.beasiswaDibuka) tahun");
    var $column_search = array("pendaftar.nim", "identitas_mhs.namaLengkap", "jurusan.namaJur", "fakultas.namaFk", "bea.namaBeasiswa");

    function __construct() {
        parent::__construct();
    }

    public function dataFakultas() {
        $data = $this->db->query("SELECT * from fakultas");
        if ($data) {
            return $data->result_array();
        } else {
            return false;
        }
    }

    public function dataJurusan() {
        $data = $this->db->query("SELECT * from jurusan");
        if ($data) {
            return $data->result_array();
        } else {
            return false;
        }
    }

    public function dataPenerimaBeasiswa($tahun, $jurusan, $fakultas, $bea) {
        $this->db->select("*");
        $this->db->from("pendaftar");
        $this->db->join("bea", "pendaftar.idBea=bea.id");
        $this->db->join("identitas_mhs", "pendaftar.nim=identitas_mhs.nimMhs");
        $this->db->join("jurusan", "identitas_mhs.idJrs=jurusan.id");
        $this->db->join("fakultas", "jurusan.idFk=fakultas.id");
        $this->db->where("pendaftar.status=1");
        $this->db->where("YEAR(bea.beasiswaDibuka)",$tahun);
        $this->db->where("jurusan.id",$jurusan);
        $this->db->where("fakultas.id",$fakultas);
        $this->db->where("bea.id",$bea);
        $detailDiri = $this->db->get();
        if ($detailDiri) {
            return $detailDiri->result_array();
        } else {
            return false;
        }
        unset($detailDiri);
    }

    public function semuaPenerimaBeasiswa() {
        $this->db->select("*");
        $this->db->from("pendaftar");
        $this->db->join("bea", "pendaftar.idBea=bea.id");
        $this->db->join("identitas_mhs", "pendaftar.nim=identitas_mhs.nimMhs");
        $this->db->join("jurusan", "identitas_mhs.idJrs=jurusan.id");
        $this->db->join("fakultas", "jurusan.idFk=fakultas.id");
        $this->db->where("pendaftar.status=1");
        $detailDiri = $this->db->get();
        if ($detailDiri) {
            return $detailDiri->result_array();
        } else {
            return false;
        }
        unset($detailDiri);
    }

    public function semuaPemohonBeasiswa() {
        $this->db->select("*");
        $this->db->from("pendaftar");
        $this->db->join("bea", "pendaftar.idBea=bea.id");
        $this->db->join("identitas_mhs", "pendaftar.nim=identitas_mhs.nimMhs");
        $this->db->join("jurusan", "identitas_mhs.idJrs=jurusan.id");
        $this->db->join("fakultas", "jurusan.idFk=fakultas.id");
        $this->db->where("pendaftar.status=0");
        $detailDiri = $this->db->get();
        if ($detailDiri) {
            return $detailDiri->result_array();
        } else {
            return false;
        }
        unset($detailDiri);
    }

    public function filterPemohon($tahun, $jurusan, $fakultas, $bea) {
        $this->db->select("*");
        $this->db->from("pendaftar");
        $this->db->join("bea", "pendaftar.idBea=bea.id");
        $this->db->join("identitas_mhs", "pendaftar.nim=identitas_mhs.nimMhs");
        $this->db->join("jurusan", "identitas_mhs.idJrs=jurusan.id");
        $this->db->join("fakultas", "jurusan.idFk=fakultas.id");
        $this->db->where("pendaftar.status=0");
        $this->db->where("YEAR(bea.beasiswaDibuka)",$tahun);
        $this->db->where("jurusan.id",$jurusan);
        $this->db->where("fakultas.id",$fakultas);
        $this->db->where("bea.id",$bea);
        $detailDiri = $this->db->get();
        if ($detailDiri) {
            return $detailDiri->result_array();
        } else {
            return false;
        }
        unset($detailDiri);
    }
    public function grafikPenerima() {
        $query = $this->db->query("select namaBeasiswa,count(status) as penerima  from pendaftar join bea on pendaftar.idBea=bea.id where status=1 group by namaBeasiswa");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $result) {
                $datahasil[] = $result;
            }
            return $datahasil;
        }
    }

    public function grafikPemohon() {
        $query = $this->db->query("select namaBeasiswa,count(status) as pemohon  from pendaftar join bea on pendaftar.idBea=bea.id where status=0 group by namaBeasiswa");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $result) {
                $datahasil[] = $result;
            }
            return $datahasil;
        }
    }
    public function make_query1($tahun, $fakultas, $jurusan, $bea) {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('identitas_mhs', 'identitas_mhs.nimMhs = pendaftar.nim', 'left');
        $this->db->join('jurusan', 'identitas_mhs.idJrs = jurusan.id', 'left');
        $this->db->join('bea', 'bea.id = pendaftar.idBea', 'left');
        $this->db->join('fakultas', 'fakultas.id = jurusan.idFk', 'left');
        $this->db->where("pendaftar.status=1");

        if ($tahun != 0 && $fakultas == 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("fakultas.id", $fakultas);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
            $this->db->where("jurusan.id", $jurusan);
        }
        $query = $this->db->get();
        return $query->result();


      }
    public function make_query($tahun, $fakultas, $jurusan, $bea) {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('identitas_mhs', 'identitas_mhs.nimMhs = pendaftar.nim', 'left');
        $this->db->join('jurusan', 'identitas_mhs.idJrs = jurusan.id', 'left');
        $this->db->join('bea', 'bea.id = pendaftar.idBea', 'left');
        $this->db->join('fakultas', 'fakultas.id = jurusan.idFk', 'left');
        $this->db->where("pendaftar.status=1");

        if ($tahun != 0 && $fakultas == 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("fakultas.id", $fakultas);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
            $this->db->where("jurusan.id", $jurusan);
        }

        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
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

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('pendaftar.nim', 'DESC');
        }
    }
    public function make_queryPemohon1($tahun, $fakultas, $jurusan, $bea) {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('identitas_mhs', 'identitas_mhs.nimMhs = pendaftar.nim', 'left');
        $this->db->join('jurusan', 'identitas_mhs.idJrs = jurusan.id', 'left');
        $this->db->join('bea', 'bea.id = pendaftar.idBea', 'left');
        $this->db->join('fakultas', 'fakultas.id = jurusan.idFk', 'left');
        $this->db->where("pendaftar.status=0");

        if ($tahun != 0 && $fakultas == 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("fakultas.id", $fakultas);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
            $this->db->where("jurusan.id", $jurusan);
        }
        $query = $this->db->get();
        return $query->result();



    }
    public function make_queryPemohon($tahun, $fakultas, $jurusan, $bea) {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        $this->db->join('identitas_mhs', 'identitas_mhs.nimMhs = pendaftar.nim', 'left');
        $this->db->join('jurusan', 'identitas_mhs.idJrs = jurusan.id', 'left');
        $this->db->join('bea', 'bea.id = pendaftar.idBea', 'left');
        $this->db->join('fakultas', 'fakultas.id = jurusan.idFk', 'left');
        $this->db->where("pendaftar.status=0");

        if ($tahun != 0 && $fakultas == 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("fakultas.id", $fakultas);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan == 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas == 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan != 0 && $bea == 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan == 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas == 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun == 0 && $fakultas != 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("jurusan.id", $jurusan);
            $this->db->where("bea.id", $bea);
        } elseif ($tahun != 0 && $fakultas != 0 && $jurusan != 0 && $bea != 0) {
            $this->db->where("YEAR(bea.beasiswaDibuka)", $tahun);
            $this->db->where("fakultas.id", $fakultas);
            $this->db->where("bea.id", $bea);
            $this->db->where("jurusan.id", $jurusan);
        }

        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
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

        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('pendaftar.nim', 'DESC');
        }
    }

    public function make_datatables($tahun, $fakultas, $jurusan, $beasiswa) {
        $this->make_query($tahun, $fakultas, $jurusan, $beasiswa);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function make_datatablesPemohon($tahun, $fakultas, $jurusan, $beasiswa) {
        $this->make_queryPemohon($tahun, $fakultas, $jurusan, $beasiswa);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filtered_data($tahun, $fakultas, $jurusan, $beasiswa) {
        $this->make_query($tahun, $fakultas, $jurusan, $beasiswa);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_filtered_data1($tahun, $fakultas, $jurusan, $beasiswa) {
        $this->make_query1($tahun, $fakultas, $jurusan, $beasiswa);

    }


    public function get_filtered_dataPemohon($tahun, $fakultas, $jurusan, $beasiswa) {
        $this->make_queryPemohon($tahun, $fakultas, $jurusan, $beasiswa);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_all_data() {
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_jurusan($fakultas) {
        $getjur ="select j.id,j.namaJur,f.namaFk from jurusan j,fakultas f where j.idFk=f.id and f.id='$fakultas' order by j.namaJur asc";
    return $this->db->query($getjur)->result();
    }


}

?>
