<?php
class Mdonvihocvu extends MY_Model
{
    public function get_dvhv_apply(){
        $this->db->join('tbl_lopmon','tbl_lopmon.ma_donvihocvu = tbl_donvihocvu.ma_donvihocvu');
        $this->db->group_by('tbl_donvihocvu.ma_donvihocvu');
        return $this->db->get('tbl_donvihocvu')->result_array();
    }
    public function get_ky_theonam($namhoc){
        $this->db->where('namhoc',$namhoc);
        return $this->db->get('tbl_donvihocvu')->result_array();
    }
    public function insert_donvihocvu($add_dvhv){
        $this->db->insert('tbl_donvihocvu',$add_dvhv);
        return $this->db->affected_rows();
    }
    public function delete_dvhv($ma_dvhv){
        $this->db->where('ma_donvihocvu',$ma_dvhv);
        $this->db->delete('tbl_donvihocvu');
        return $this->db->affected_rows();
    }
    public function get_dvhv_ma($ma_dvhv){
        $this->db->where('ma_donvihocvu',$ma_dvhv);
        return $this->db->get('tbl_donvihocvu')->row_array();
    }
    public function update_donvihocvu($up_dvhv,$ma_dvhv){
        $this->db->where('ma_donvihocvu',$ma_dvhv);
        $this->db->update('tbl_donvihocvu',$up_dvhv);
        return $this->db->affected_rows();
    }
}