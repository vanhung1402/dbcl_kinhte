<?php
class Mxeplopmon extends MY_Model{
    public function get_lopmon($ma_dvhv,$ma_trangthai){
        $this->db->where('ma_donvihocvu',$ma_dvhv);
        $this->db->where('madm_trangthai_lopmon',$ma_trangthai);
        return $this->db->get('tbl_lopmon')->result_array();
    }
    public function get_lophc(){
        return $this->db->get('tbl_lop')->result_array();
    }
    public function get_sv_lophanhchinh($ma_lophc,$arr_sv_lm){
        $this->db->select('ma_sv,hodem_sv,ten_sv,gioitinh_sv,DATE_FORMAT(ngaysinh_sv, "%d/%m/%Y") AS ngaysinh_sv');
        if($arr_sv_lm != array()){
            $this->db->where_not_in('ma_sv',$arr_sv_lm);
        }
        $this->db->join('tbl_sinhvien','tbl_sinhvien.ma_lop = tbl_lop.ma_lop');
        $this->db->where('tbl_lop.ma_lop',$ma_lophc);
        return $this->db->get('tbl_lop')->result_array();
    }
    public function get_sv_lopmon($ma_lopmon){
        $this->db->select('tbl_lop.*,tbl_sinhvien.ma_sv,hodem_sv,ten_sv,gioitinh_sv,DATE_FORMAT(ngaysinh_sv, "%d/%m/%Y") AS ngaysinh_sv,ma_dkm');
        $this->db->join('tbl_sinhvien','tbl_sinhvien.ma_sv = tbl_dangkymon.ma_sv');
        $this->db->join('tbl_lop','tbl_lop.ma_lop = tbl_sinhvien.ma_lop');
        $this->db->where('ma_lopmon',$ma_lopmon);
        $this->db->order_by('ten_sv','ASC');
        $this->db->order_by('hodem_sv','ASC');
        return $this->db->get('tbl_dangkymon')->result_array();
    }
    public function insert_sv_lopmon($add_dkm){
        $this->db->insert_batch('tbl_dangkymon',$add_dkm);
        return $this->db->affected_rows();
    }
    public function delete_sv_lopmon($arr_dkm){
        $this->db->where_in('ma_dkm',$arr_dkm);
        $this->db->delete('tbl_dangkymon');
        return $this->db->affected_rows();
    }

    public function layDanhSachSinhVien(){
        $this->db->select('ma_sv');
        return $this->db->get('tbl_sinhvien')->result_array();
    }

    public function layDanhSachLopMon(){
        $this->db->select('ma_lopmon');
        return $this->db->get('tbl_lopmon')->result_array();
    }
}