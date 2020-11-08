<?php
class Mlop_hocphan extends MY_Model{
    public function get_donvi($ma_cb){
        $this->db->where('ma_cb',$ma_cb);
        $this->db->join('tbl_canbo','tbl_canbo.ma_donvi = tbl_donvi.ma_donvi');
        return $this->db->get('tbl_donvi')->row_array();
    }
    public function get_tt_lopmon($ma_lopmon){
        $this->db->join('tbl_canbo_lopmon','tbl_canbo_lopmon.ma_lopmon = tbl_lopmon.ma_lopmon');
        $this->db->join('tbl_canbo','tbl_canbo.ma_cb = tbl_canbo_lopmon.ma_cb');
        $this->db->join('tbl_lopmon_monctdt','tbl_lopmon_monctdt.ma_lopmon = tbl_lopmon.ma_lopmon');
        $this->db->join('tbl_mon_ctdt','tbl_mon_ctdt.ma_mon_ctdt = tbl_lopmon_monctdt.ma_mon_ctdt');
        $this->db->join('tbl_ctdt','tbl_ctdt.ma_ctdt = tbl_mon_ctdt.ma_ctdt');
        $this->db->join('dm_trinhdo','dm_trinhdo.madm_trinhdo = tbl_ctdt.madm_trinhdo');
        $this->db->join('dm_hedaotao','dm_hedaotao.madm_hedaotao = tbl_ctdt.madm_hedaotao');
        $this->db->join('dm_nganh','dm_nganh.madm_nganh = tbl_ctdt.madm_nganh');
        $this->db->where('tbl_lopmon.ma_lopmon',$ma_lopmon);
        return $this->db->get('tbl_lopmon')->row_array();
    }
}