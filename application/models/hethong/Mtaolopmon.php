<?php
class Mtaolopmon extends MY_Model
{
    public function get_dvhv(){
        $this->db->order_by('namhoc','DESC');
        $this->db->order_by('kyhoc','DESC');
        return $this->db->get('tbl_donvihocvu')->result_array();
    }
    public function get_canbo_mon($ma_monhoc){
        $this->db->join('tbl_canbo','tbl_canbo.ma_cb = tbl_canbo_monhoc.ma_canbo');
        $this->db->where('ma_monhoc',$ma_monhoc);
        return $this->db->get('tbl_canbo_monhoc')->result_array();
    }
    public function insert_lopmon($lopmon_new){
        $this->db->insert('tbl_lopmon',$lopmon_new);
        // return $this->db->last_query();
        return $this->db->affected_rows();
    }
    public function insert_canbo_lopmon($canbo_lopmon){
        $this->db->insert('tbl_canbo_lopmon',$canbo_lopmon);
        return $this->db->affected_rows();
    }
    public function get_max_id(){
        return $this->db->query("SELECT MAX(`ma_cb_lm` *1)+1 AS maxid FROM tbl_canbo_lopmon")->row_array();
    }
    public function insert_lopmon_monctdt($lopmon_monctdt){
        $this->db->insert('tbl_lopmon_monctdt',$lopmon_monctdt);
        return $this->db->affected_rows();

    }
    public function loadDanhSachLopMon($dvhv){
        $this->db->where('ma_donvihocvu', $dvhv);
        $this->db->order_by('ten_lopmon');
        return $this->db->get('tbl_lopmon')->result_array();
    }
}