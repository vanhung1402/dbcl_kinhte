<?php

class Mthemmon_ctdt extends MY_Model
{
    public function get_ds_ctdt($ma_cb){
        $this->db->join('dm_nganh','dm_nganh.madm_nganh = tbl_ctdt.madm_nganh');
        $this->db->join('tbl_canbo','tbl_canbo.ma_donvi = dm_nganh.ma_donvi');
        $this->db->order_by('nam','asc');
        $this->db->where('ma_cb',$ma_cb);
        return $this->db->get('tbl_ctdt')->result_array();
    }
    public function get_mon_in_ctdt($ma_ctdt){
        if($ma_ctdt !=''){
            $this->db->join('tbl_mon_ctdt','tbl_mon_ctdt.ma_monhoc = tbl_monhoc.ma_monhoc');
            $this->db->order_by('ten_monhoc','asc');
            $this->db->where('ma_ctdt',$ma_ctdt);
            return $this->db->get('tbl_monhoc')->result_array();
        }
    }
    public function get_monhoc($ma_ctdt){
        if ($ma_ctdt != '') {
            $query = $this->db->query("SELECT ma_monhoc,ten_monhoc,donvitinh,tongkhoiluong
                FROM tbl_monhoc
                WHERE ma_monhoc NOT IN(SELECT ma_monhoc FROM tbl_mon_ctdt WHERE ma_ctdt='$ma_ctdt') ORDER BY ten_monhoc");
            return $query->result_array();
        }
        return;
    }
    public function change_mon_ctdt($insert_mon_ctdt, $arr_dellist){
        $row1 = 0;
        $row2 = 0;
        if(!empty($insert_mon_ctdt)){
            $this->db->insert_batch('tbl_mon_ctdt',$insert_mon_ctdt);
            $row1 = $this->db->affected_rows();
        }
        if(!empty($arr_dellist)){
            $this->db->where_in('ma_mon_ctdt',$arr_dellist);
            $this->db->delete('tbl_mon_ctdt');
            $row2 = $this->db->affected_rows();
        }
        return $row1 + $row2;
    }
    public function genid(){
        $this->db->select('MAX(ma_mon_ctdt * 1 + 1) AS maxid');
        $rs = $this->db->get('tbl_mon_ctdt')->row_array();
        return $rs['maxid'];
    }
    public function check_ctdt($ma_ctdt){
        $this->db->select('ma_lop');
        $this->db->from('tbl_lop l');
        $this->db->join('tbl_khoahoc kh', 'l.ma_khoahoc = kh.ma_khoahoc', 'inner');
        $this->db->where('ma_ctdt',$ma_ctdt);

        $this->db->get()->result_array();
        return null;
    }
    public function get_tt_ctdt($ma_ctdt){
        $this->db->join('dm_nganh','dm_nganh.madm_nganh = tbl_ctdt.madm_nganh');
        $this->db->join('dm_trinhdo','dm_trinhdo.madm_trinhdo = tbl_ctdt.madm_trinhdo');
        $this->db->join('dm_hedaotao','dm_hedaotao.madm_hedaotao = tbl_ctdt.madm_hedaotao');
        $this->db->where('ma_ctdt',$ma_ctdt);
        return $this->db->get('tbl_ctdt')->result_array();
    }
}