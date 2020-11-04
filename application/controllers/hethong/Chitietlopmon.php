<?php
class Chitietlopmon extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model('hethong/Mduyetlopmon');
        $this->load->Model('hethong/Mthemmon_ctdt');
        $this->load->Model('hethong/Mtaolopmon');
    }
    public function index(){
        $action         = $this->input->post('action');
        switch ($action) {
            case 'capnhap-tenlopmon':
                $this->capnhat_tenlop();
                break;
            case 'capnhap-lopmon':
                $this->capnhat_lopmon();
                break;
            case 'change-hinhthuc':
                $this->capnhat_lopmon();
                break;
            case 'getdl_lopmon':
                $this->lay_dulieu_lopmon();
                break;
            case 'get_canbo_mon':
                $this->get_canbo_mon();
                break;
            case 'capnhat_mon_cb':
                $this->capnhat_mon_cb();
                break;
            default:
                # code...
                break;
        }
        if($this->input->get('mlp')){
            $dl_lopmon = $this->Mduyetlopmon->get_chitiet_lopmon($this->input->get('mlp'));
            $dl_lopmon['sophieu'] = $this->Mduyetlopmon->getPhieuLopMon($this->input->get('mlp'));
        }
        $mlm = $this->Mduyetlopmon->get_so_dkm($this->input->get('mlp'));
        $temp['data']= array(

           'dl_lopmon'  => $dl_lopmon,
           'so_sv'      => $mlm['so_sv'],   
        );
        $temp['template'] = 'hethong/Vchitietlopmon';
        $this->load->view('layout/Vcontent', $temp);
    }
    public function capnhat_lopmon(){
        $ma_lopmon = $this->input->post('ma_lopmon');
        $ma_trangthai = $this->input->post('trangthai');
        $hinhthuc = $this->input->post('hinhthuc');

        if($ma_lopmon && ($hinhthuc || $ma_trangthai)){
            if ($hinhthuc) {
                $tenlop                     = $this->input->post('tenlop');
                $up_lm = array(
                    'ma_canbo_capnhat'      => $this->_session['ma_canbo'],
                    'ma_hinhthuc'           => $hinhthuc,
                    'ten_lopmon'            => $tenlop,
                );
            }else{
                $up_lm = array(
                    'ma_canbo_capnhat'      => $this->_session['ma_canbo'],
                    'madm_trangthai_lopmon' => $ma_trangthai,
                );
            }
            $rows = $this->Mduyetlopmon->update_lopmon($this->input->post('ma_lopmon'),$up_lm);
            $up_lm['success'] = $rows;
            $up_lm['trangthai_new'] = $this->Mduyetlopmon->get_ten_trangthai($ma_trangthai);
            echo json_encode($up_lm);
            exit();
        }
        echo json_encode(array());
        exit();
    }

    public function capnhat_tenlop(){
        $tenlopmon_new = $this->input->post('tenlop');
        $data = array();
        if($tenlopmon_new){
            $rows = $this->Mduyetlopmon->update_tenlop($this->input->post('ma_lopmon'),$tenlopmon_new);
            $data['success'] = $rows;
            $data['tenlop'] = $tenlopmon_new;
            echo json_encode($data);
            exit();
        }

        echo json_encode($data);
        exit();
    }
    public function lay_dulieu_lopmon(){
        $ma_lopmon = $this->input->post('ma_lopmon');
        $dulieu_lopmon = $this->Mduyetlopmon->get_dulieu_lopmon($ma_lopmon);
        $data =array(
            'ds_mon_ctdt'   => $this->Mthemmon_ctdt->get_mon_in_ctdt($dulieu_lopmon['ma_ctdt']),
            'ds_canbo_mon'  => $this->Mtaolopmon->get_canbo_mon($dulieu_lopmon['ma_monhoc']),
            'ma_monhoc'     => $dulieu_lopmon['ma_monhoc'],
            'ma_cb'         => $dulieu_lopmon['ma_cb'],
            'ma_lopmon'     => $ma_lopmon,
        );
        echo json_encode($data);
        exit();
    }
    public function get_canbo_mon(){
        $ma_monhoc = explode('|',$this->input->post('ma_monhoc'));
        $ma_monhoc = $ma_monhoc[0];
        $data = $this->Mtaolopmon->get_canbo_mon($ma_monhoc);
        echo json_encode($data);
        exit();
    }
    public function capnhat_mon_cb(){
        $ma_lopmon = $this->input->post('ma_lopmon');
        $mh = $this->input->post('monhoc');
        $ma_canbo = $this->input->post('ma_canbo');
        $data = array();
        if ($ma_canbo && $mh) {
            $monhoc = explode('|',$mh);
            $row1 = $this->Mduyetlopmon->update_lopmon_monhoc($ma_lopmon,$monhoc[0]);
            $row2 = $this->Mduyetlopmon->update_canbo_lopmon($ma_lopmon,$ma_canbo);
            $row3 = $this->Mduyetlopmon->update_lopmon_monctdt($ma_lopmon,$monhoc[1]);
        }
        echo json_encode($data);
        exit();
    }
}