<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna_model extends CI_Model
{
    private $_table = "tbl_diskusi";


    function countAlumnii()
    {
        return $this->db->count_all("tbl_pengguna");
    }
    function countBeritaAlumnii()
    {
        $data = $this->session->userdata('id_pengguna');
        $this->db->where('tbl_diskusi.id_pengguna', $data);
        $this->db->where('status', '0');
        return $this->db->count_all_results('tbl_diskusi', $data);

        // $a = $this->db->query('SELECT * FROM tbl_diskusi WHERE status= "0",');
        // $this->db->where('tbl_diskusi.id_pengguna', $data);
        // $count = $query->num_rows();
        // return $count;
    }


    function detailAlumni($id = null)
    {
        $query = $this->db->get_where('tbl_pengguna', array('id_pengguna' => $id))->row();
        return $query;
    }

    function get_pajak()
    {
        $hsl = $this->db->get("upload");
        return $hsl;
    }
    // Tam

    function updateAlumni($data, $where)
    {
        $this->db->where($where);
        $this->db->update('tbl_pengguna', $data);
        return true;
    }


    function updatejointable($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
    }
    function update($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }
}