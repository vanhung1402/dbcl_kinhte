<?php
class Mduyetlopmon extends MY_Model
{
    public function get_trangthai_lopmon(){
        return $this->db->get('dm_trangthai_lopmon')->result_array();
    }
    public function get_lopmon($ma_dvhv,$trangthai, $hinhthuc = null){
        $this->db->select('ma_lopmon,ten_lopmon,tbl_lopmon.madm_trangthai_lopmon,tendm_trangthai_lopmon, ma_hinhthuc,DATE_FORMAT(ngaybd, "%d/%m/%Y") AS ngaybd,DATE_FORMAT(ngaykt, "%d/%m/%Y") AS ngaykt,DATE_FORMAT(ngaykhaosat, "%d/%m/%Y") AS ngaykhaosat');
        if($trangthai){
            $this->db->where('tbl_lopmon.madm_trangthai_lopmon',$trangthai);
        }
        if ($hinhthuc) {
            $this->db->where('tbl_lopmon.ma_hinhthuc', $hinhthuc);
        }
        $this->db->where('ma_donvihocvu',$ma_dvhv);
        $this->db->order_by('tbl_lopmon.madm_trangthai_lopmon','ASC');
        $this->db->order_by('tbl_lopmon.ten_lopmon');
        $this->db->join('dm_trangthai_lopmon as tt','tt.madm_trangthai_lopmon = tbl_lopmon.madm_trangthai_lopmon');
        return $this->db->get('tbl_lopmon')->result_array();
    }
    public function get_chitiet_lopmon($ma_lopmon){
        $this->db->select('tbl_lopmon.ma_lopmon,ten_lopmon,ten_monhoc,hodem_cb,ten_cb,ma_donvihocvu,tbl_lopmon.madm_trangthai_lopmon,tendm_trangthai_lopmon,DATE_FORMAT(ngaybd, "%d/%m/%Y") AS ngaybd,DATE_FORMAT(ngaykt, "%d/%m/%Y") AS ngaykt,DATE_FORMAT(ngaykhaosat, "%d/%m/%Y") AS ngaykhaosat, ma_hinhthuc, tbl_canbo.ma_cb, tongkhoiluong, donvitinh');
        $this->db->join('tbl_canbo_lopmon','tbl_canbo_lopmon.ma_lopmon=tbl_lopmon.ma_lopmon');
        $this->db->join('tbl_canbo','tbl_canbo.ma_cb=tbl_canbo_lopmon.ma_cb');
        $this->db->join('tbl_monhoc','tbl_monhoc.ma_monhoc=tbl_lopmon.ma_monhoc');
        $this->db->join('dm_trangthai_lopmon','dm_trangthai_lopmon.madm_trangthai_lopmon=tbl_lopmon.madm_trangthai_lopmon');
        $this->db->where('tbl_lopmon.ma_lopmon',$ma_lopmon);
        return $this->db->get('tbl_lopmon')->row_array();
    }
    public function getPhieuLopMon($ma_lopmon){
        $this->db->where('ma_lopmon', $ma_lopmon);
        $this->db->from('tbl_dangkymon dkm');
        $this->db->join('tbl_phieukhaosat_hoctap pht', 'dkm.ma_dkm = pht.ma_dkm', 'inner');
        return $this->db->get()->result_array();
    }
    public function update_lopmon($ma_lopmon,$up_lm){
        $this->removeFormServey($ma_lopmon);
        $this->db->where('ma_lopmon',$ma_lopmon);
        $this->db->update('tbl_lopmon',$up_lm);
        return $this->db->affected_rows();
    }
    public function removeFormServey($ma_lopmon){
        $this->db->where("ma_dkm IN (SELECT ma_dkm FROM tbl_dangkymon WHERE ma_lopmon LIKE '$ma_lopmon')");
        $this->db->delete('tbl_phieukhaosat_hoctap');
        return $this->db->affected_rows();
    }
    public function get_ten_trangthai($ma_trangthai){
        $this->db->where('madm_trangthai_lopmon',$ma_trangthai);
        return $this->db->get('dm_trangthai_lopmon')->row_array();
    }
    public function update_tenlop($ma_lopmon,$tenlopmon_new){
        $this->db->set('ten_lopmon',$tenlopmon_new);
        $this->db->where('ma_lopmon',$ma_lopmon);
        $this->db->update('tbl_lopmon');
        return $this->db->affected_rows();
    }
    public function so_sinhvien_lopmon($dsma_lopmon = null){
        if (!$dsma_lopmon) {
            return null;
        }else{
            $this->db->where_in('tbl_lopmon.ma_lopmon', $dsma_lopmon);
        }
        $this->db->select('tbl_lopmon.ma_lopmon,COUNT(ma_sv) as so_sv');
        $this->db->join('tbl_dangkymon','tbl_dangkymon.ma_lopmon = tbl_lopmon.ma_lopmon');
        $this->db->group_by('tbl_dangkymon.ma_lopmon');
        return $this->db->get('tbl_lopmon')->result_array();
    }
    public function get_so_dkm($ma_lopmon){
        $this->db->select('COUNT(ma_sv) as so_sv');
        $this->db->where('ma_lopmon',$ma_lopmon);
        return $this->db->get('tbl_dangkymon')->row_array();
    }

    public function get_canbo_lopmon($dslopmon){
        if (!$dslopmon) {
            return array();
        }
        $this->db->select('ma_lopmon, cb.ma_cb, hodem_cb, ten_cb');
        $this->db->from('tbl_canbo_lopmon cblm');
        $this->db->join('tbl_canbo cb', 'cblm.ma_cb = cb.ma_cb', 'inner');
        return $this->db->get()->result_array();
    }

    public function layDanhSachHinhThuc(){
        $this->db->order_by('ma_hinhthuc');
        return $this->db->get('dm_hinhthuc_khaosat')->result_array();
    }
    public function get_dulieu_lopmon($ma_lopmon){
        $this->db->join('tbl_mon_ctdt','tbl_mon_ctdt.ma_mon_ctdt = tbl_lopmon_monctdt.ma_mon_ctdt');
        $this->db->join('tbl_lopmon','tbl_lopmon.ma_lopmon = tbl_lopmon_monctdt.ma_lopmon');
        $this->db->join('tbl_canbo_lopmon','tbl_canbo_lopmon.ma_lopmon = tbl_lopmon_monctdt.ma_lopmon');
        $this->db->where('tbl_lopmon.ma_lopmon',$ma_lopmon);
        return $this->db->get('tbl_lopmon_monctdt')->row_array();
    }
    public function update_lopmon_monhoc($ma_lopmon, $ma_monhoc){
        $this->db->where('ma_lopmon', $ma_lopmon);
        $this->db->update('tbl_lopmon', array(
            'ma_monhoc' => $ma_monhoc,
        ));
        return $this->db->affected_rows();
    }
    public function update_canbo_lopmon($ma_lopmon, $ma_canbo){
        $this->db->where('ma_lopmon', $ma_lopmon);
        $this->db->update('tbl_canbo_lopmon', array(
            'ma_cb' => $ma_canbo,
        ));
        return $this->db->affected_rows();
    }
    public function update_lopmon_monctdt($ma_lopmon, $ma_mon_ctdt){
        $this->db->where('ma_lopmon', $ma_lopmon);
        $this->db->set('ma_mon_ctdt', $ma_mon_ctdt);
        $this->db->update('tbl_lopmon_monctdt');
        return $this->db->affected_rows();
    }
    
}