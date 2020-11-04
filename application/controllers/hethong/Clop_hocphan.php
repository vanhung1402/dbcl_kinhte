<?php
class Clop_hocphan extends MY_Controller{
    public function __Construct(){
        parent::__Construct();
        $this->load->Model('hethong/Mxeplopmon');
        $this->load->Model('hethong/Mlop_hocphan');
    }
    public function index(){
        if($this->input->get('inlp')){
            $ds_sv_lopmon = $this->Mxeplopmon->get_sv_lopmon($this->input->get('inlp'));
            $tt_lopmon = $this->Mlop_hocphan->get_tt_lopmon($this->input->get('inlp'));
            /* pr($ds_sv_lopmon); */
            $donvi = $this->Mlop_hocphan->get_donvi($this->_session['ma_canbo']);
            $data=array(
                'url' => base_url(),
                'ds_sv' => $ds_sv_lopmon,
                'donvi' => $donvi['ten_donvi'],
                'tt_lopmon'    => $tt_lopmon
            );
            $this->parser->parse('hethong/Vinds_lopmon',$data);
        }
    }
}