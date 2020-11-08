<?php  
class Ccanbo extends MY_Controller
{
	 public function __construct()
		{
			parent::__construct();
			$this->load->model('danhmuc/Mcanbo');
		}
	public function index(){

		
		//pr($macanbo);
		if($this->input->post('them')){
			return $this->insert();
		}
		if($this->input->post('delete')){
			return $this->delete();
		}
		if ($this->input->post('capnhat')) {
			return $this->update();
		}

		$id = $this->input->get('macb');

		if ($id) {
			$sua 		= $this->Mcanbo->getdata($id);
			if (empty($sua)) {
				setMessage('error','Cán bộ có mã ' . $id . ' không tồn tại!');
				return redirect('canbo');
			}
		}
		$thongtin 		= $this->Mcanbo->getListcanbo();
		$dsphanmon 		= $this->Mcanbo->layMonGiangDay();
		$mongiangday 	= array();

		foreach ($dsphanmon as $pm) {
			if (!isset($mongiangday[$pm['ma_canbo']])) {
				$mongiangday[$pm['ma_canbo']] 	= array();
			}

			$mongiangday[$pm['ma_canbo']][] 	= $pm['ten_monhoc'];
		}

		$Macanbo_sudung = $this->Mcanbo->getMacanboSuDung();
		$data = array(
				// 'message'			=> getMessages(),
				'thongtin' 			=> $thongtin,
				'mongiangday' 		=> $mongiangday,
				'sua' 				=> (isset($sua) ? $sua : null),
				'Macanbo_sudung' 	=> $Macanbo_sudung,
				'donvi'				=> $this->Mcanbo->getDonvi(),
				'hocham'			=> $this->Mcanbo->getHocham(),
				'chucvu'			=> $this->Mcanbo->getChucvu(),
		);
		$temp = array(
			'template'	=> 'danhmuc/Vcanbo', 
			'data' 		=> $data,
		);

		$this->load->view("layout/Vcontent",$temp);
	}

	public function insert(){
		$macanbo 		= $this->_session['ma_canbo'];
		$ab = explode(' ', trim($this->input->post('hodem_cb'))) ;
		$ten = array_pop($ab);
		$hovaten		= implode(' ', $ab) ;	
		$data 			= array(
			'ma_cb' 	 		=> time().$macanbo,
			'ma_doituong'		=> trim($this->input->post('ma_doituong')),
			'hodem_cb' 			=> $hovaten ,
			'ten_cb' 			=> $ten,
			'gioitinh_cb'  		=> trim($this->input->post('gioitinh_cb')),
			'ngaysinh_cb'  		=> trim($this->input->post('ngaysinh_cb')),
			'ma_donvi'			=> trim($this->input->post('donvi')),
			'ma_hocham'			=> trim($this->input->post('hocham')),
			'ma_chucvu'  		=> trim($this->input->post('chucvu')),
		);	
		$row = $this->Mcanbo->insert($data);
		if($row > 0){
			setMessage('success','Thêm thành công');
			return redirect('canbo');
		} 		
	}
	
	public function delete(){
		$ma = $this->input->post("delete");
		$checkf = $this->Mcanbo->checkfk($ma);
		if($checkf['ma_cb']==null){
			$row = $this->Mcanbo->delete($ma);
			setMessage('success','Xóa thành công');
			return redirect('canbo');
		}
		
	}

	public function update() {
		$ab = explode(' ',  trim($this->input->post('hodem_cb'))) ;
		$ten = array_pop($ab);
		$hovaten		= implode(' ', $ab);
		
		$ngaydao = array_reverse(explode('/', trim($this->input->post('ngaysinh_cb'))));
		$ngay = implode('-', $ngaydao);

		$data 			= array(
			//'ma_cb' 	 		=> trim($this->input->post('ma_cb')),
			'ma_doituong'		=> trim($this->input->post('ma_doituong')),
			'hodem_cb' 			=> $hovaten ,
			'ten_cb' 			=> $ten,
			'gioitinh_cb'  		=> trim($this->input->post('gioitinh_cb')),
			'ngaysinh_cb'  		=> trim($this->input->post('ngaysinh_cb')),
			'ma_donvi'			=> trim($this->input->post('donvi')),
			'ma_hocham'			=> trim($this->input->post('hocham')),
			'ma_chucvu'  		=> trim($this->input->post('chucvu')),
		);	
		$id = $this->input->post('capnhat');

		$row = $this->Mcanbo->updateData($id,$data);
		if($row >0){
			setMessage('success','Cập nhật thành công');
		}
		else{
			setMessage('error','Cập nhật không thành công');
		}
		return redirect('canbo');
	}
}
?>