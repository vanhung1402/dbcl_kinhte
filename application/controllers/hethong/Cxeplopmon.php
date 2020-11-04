<?php
class Cxeplopmon extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->Model('hethong/Mxeplopmon');
        $this->load->Model('hethong/Mtaolopmon');
    }
    public function index(){
        $action = $this->input->post('action');
        switch ($action) {
            case 'get_sv_lophc':
                $this->get_sv_lophc();
                break;
            case 'change_sv_lopmon':
                $this->change_sv_lopmon();
                break;
            case 'get_lopmon':
                $this->get_lopmon();
                break;
            default:
                # code...
                break;
        }
        if($action =='get_sv_lophc'){
        }
        if($action =='change_sv_lopmon'){
        }
        $temp['data']= array(
            'ds_dvhv'       => $this->Mtaolopmon->get_dvhv() ,
            'ds_lophc'      => $this->Mxeplopmon->get_lophc(),
        );

        $temp['template'] = 'hethong/Vxeplopmon';
        $this->load->view('layout/Vcontent', $temp);
    }
    public function get_lopmon(){
        $ma_dvhv = $this->input->post('dvhv');
        $ma_trangthai = $this->input->post('trangthai_lopmon');
        $ds_lopmon = $this->Mxeplopmon->get_lopmon($ma_dvhv, 'dukien');
        echo json_encode($ds_lopmon);
        exit();
    }
    public function get_sv_lophc(){
        $ma_lopmon = $this->input->post('lopmon');
        $ma_lophc = $this->input->post('lophc');
        $ds_sv_lopmon = array();
        $arr_sv_lm = array();
        if($ma_lophc){
            $ds_sv_lopmon = $this->Mxeplopmon->get_sv_lopmon($ma_lopmon);
            foreach($ds_sv_lopmon as $sv){
                $arr_sv_lm[] = $sv['ma_sv']; 
            }
        }
        $ds_sv_lophc = $this->Mxeplopmon->get_sv_lophanhchinh($ma_lophc,$arr_sv_lm);
        $data = array(
            'ds_sv_lophc'   => $ds_sv_lophc,
            'ds_sv_lopmon'  => $ds_sv_lopmon,
            'so_sv_chuaxep' => count($ds_sv_lophc),
            'so_sv_lopmon'  => count($ds_sv_lopmon),
        );
        echo json_encode($data);
        exit();
    }
    public function change_sv_lopmon(){
        $sv_lopmon_add = $this->input->post('add_sv_lm');
        $sv_lopmon_del = $this->input->post('del_sv_lm');
        $ma_lopmon = $this->input->post('lopmon');
        $row1 ='';$row2='';$data=0;
        if($sv_lopmon_add != array()){
            foreach($sv_lopmon_add as $sv){
                $add_dkm[] = array(
                    'ma_dkm'        => 'dkm'.time().rand(100,999),
                    'ma_sv'         => $sv,
                    'ma_lopmon'     => $ma_lopmon,
                    'ngaydangky'    => date("dd/mm/YY"),
                    'nguoidangky'   => $this->_session['ma_canbo'],
                );
            }
            $row1 = $this->Mxeplopmon->insert_sv_lopmon($add_dkm);
        }
        if($sv_lopmon_del != array()){
            $row2 = $this->Mxeplopmon->delete_sv_lopmon($sv_lopmon_del);
        }
        if($row1 >0 || $row2 >0){
            $data = 1;
        }
        echo $data;
        exit();
    }
}