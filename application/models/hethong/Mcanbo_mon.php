<?php
class Mcanbo_mon extends MY_Model
{
    public function get_thongtin_cb($ma_cb){
        $this->db->select('ma_hocham, ngaysinh_cb, ma_cb, hodem_cb, ten_cb');
        $this->db->where('ma_cb',$ma_cb);
        return $this->db->get('tbl_canbo')->row_array();
    }
    public function get_mon_cb($ma_cb){
        $this->db->where('ma_canbo',$ma_cb);
        $this->db->join('tbl_monhoc','tbl_monhoc.ma_monhoc = tbl_canbo_monhoc.ma_monhoc');
        return $this->db->get('tbl_canbo_monhoc')->result_array();
    }
    public function get_monhoc(){
        $this->db->order_by('ten_monhoc','asc');
        return $this->db->get('tbl_monhoc')->result_array();
    }
    public function delete_mon_canbo($del_mon_cb,$ma_cb){
        $this->db->where('ma_canbo',$ma_cb);
        $this->db->where_in('ma_monhoc',$del_mon_cb);
        $this->db->delete('tbl_canbo_monhoc');
    }
    public function insert_mon_canbo($insert_mon_cb){
        $this->db->insert_batch('tbl_canbo_monhoc',$insert_mon_cb);
    }
    public function get_ds_canbo($ma_cb = null){
        if ($ma_cb) {
            $this->db->where('ma_cb !=',$ma_cb);
        }
        return $this->db->get('tbl_canbo')->result_array();
    }
}