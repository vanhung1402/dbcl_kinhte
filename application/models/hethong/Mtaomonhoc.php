<?php

class Mtaomonhoc extends CI_Model
{
    public function get_dsmon()
    {
/*         $this->db->order_by('stt'); */
        $this->db->order_by('ten_monhoc');
        return $this->db->get('tbl_monhoc')->result_array();
       /*  $query = $this->db->join('tbl_mon_ctdt', 'tbl_mon_ctdt.ma_monhoc=tbl_monhoc.ma_monhoc', 'left')
            ->get('tbl_monhoc');
        return $query->result_array(); */
    }

    public function del_mon($id)
    {
        // echo $id; exit();
        if (!empty($id)) {
            $this->db->query("DELETE FROM `tbl_chitiet_monhoc` WHERE `ma_monhoc`= $id ");
            $this->db->query("DELETE FROM `tbl_monhoc` WHERE `ma_monhoc`= $id ");
        }
        return $this->db->affected_rows();

    }

    public function upd_mh($data_mh, $data_ctmh)
    {
        $this->db->where('ma_monhoc', $data_mh['ma_monhoc']);
        $this->db->update('tbl_monhoc', $data_mh);
        $kllt = $data_ctmh['kllt'];
        $klth = $data_ctmh['klth'];
        $mamh = $data_mh['ma_monhoc'];
        $chk = $this->db->get_where('tbl_chitiet_monhoc', array('ma_monhoc' => $mamh));
        $rs_chk = $chk->result_array();
        if (empty($rs_chk)) {
            $sql = "INSERT INTO `tbl_chitiet_monhoc`(`ma_monhoc`, `ma_hinhthucmon`, `khoiluong`) VALUES ('$mamh','LT','$kllt'), ('$mamh','TH','$klth')";
            $this->db->query($sql);
        } else {
            $this->db->query("UPDATE `tbl_chitiet_monhoc` SET `khoiluong`= CASE WHEN `ma_hinhthucmon`='LT' THEN $kllt  WHEN `ma_hinhthucmon`='TH' THEN $klth END WHERE `ma_monhoc`='$mamh'");
        }
    }

    public function get_khoiluong()
    {
        $query = $this->db->select('tbl_monhoc.ma_monhoc,tbl_chitiet_monhoc.khoiluong,ma_hinhthucmon')
            ->from('tbl_monhoc')
            ->join('tbl_chitiet_monhoc', 'tbl_chitiet_monhoc.ma_monhoc=tbl_monhoc.ma_monhoc', 'inner')
            ->get();
        return $query->result_array();
    }

    public function get_loaimh()
    {
        $query = $this->db->get('dm_loaimonhoc');
        return $query->result_array();
    }

    public function insert_monhoc($data_mh){
        $this->db->insert('tbl_monhoc',$data_mh);
    }
    public function insert_chtiet_monhoc($data_chitiet_mh){
        $this->db->insert_batch('tbl_chitiet_monhoc', $data_chitiet_mh);
    }
    public function update_monhoc($data_mh,$mamh){
        $this->db->where('ma_monhoc',$mamh);
        $this->db->update('tbl_monhoc',$data_mh);
    }
    public function update_chitiet_monhoc($data_chitiet_mh,$mamh){
        $this->db->where('ma_monhoc',$mamh);
        $this->db->update_batch('tbl_chitiet_monhoc', $data_chitiet_mh,'ma_hinhthucmon');
    }
    public function delete_monhoc($mamh){
        $this->db->where('ma_monhoc',$mamh);
        $this->db->delete('tbl_chitiet_monhoc');
        $row = $this->db->affected_rows();
        if($row > 0){
            $this->db->where('ma_monhoc',$mamh);
            $this->db->delete('tbl_monhoc');
            $row1 = $this->db->affected_rows();
        }
        return $row1;
    }
    public function genid()
    {
        $query = $this->db->query("SELECT MAX(`ma_monhoc`*1)+1 AS newid FROM tbl_monhoc");
        return $query->result_array();
    }
    public function mon_ctdt(){
        return $this->db->get('tbl_mon_ctdt')->result_array();
    }
    
}