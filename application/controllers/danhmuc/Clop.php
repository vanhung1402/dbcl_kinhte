<?php  
class Clop extends MY_Controller
{
	 public function __construct()
		{
			parent::__construct();
			$this->load->model('danhmuc/Mlop');
		}
	public function index(){
		if($this->input->post('them')){
			return $this->insert();
		} 
		if($this->input->post('delete')){
			return $this->delete();
		}
		$id = $this->input->get('malop');
		if($id){
			$temp['data']['sua'] = $this->Mlop->getdata($id);
		}
		if ($this->input->post('capnhat')) {
			return $this->update();
		}
		$Malop_sudung 					= $this->Mlop->getMalopSuDung();
		$temp['data']['ds'] 			= $this->Mlop->getListlop();
		$temp['data']['Malop_sudung'] 	= $Malop_sudung;
		$temp['data']['khoahoc']		= $this->Mlop->getKhoahoc();
		$temp['data']['canbo']			= $this->Mlop->getCanbo();
		$temp['template'] 		= 'danhmuc/Vlop';

		// $temp['data']['message'] = getMessages();
		$this->load->view("layout/Vcontent",$temp);
	}
	public function insert(){
		if($this->input->post('them')){
			
			$data = array(
				'ma_lop' 	 			=> time().rand(10000, 999999),
				'ten_lop' 	 			=> $this->input->post('ten_lop'),
				'ma_khoahoc' 	 		=> $this->input->post('khoahoc'),
				'ma_canbo_quanly' 	 	=> $this->input->post('canbo'),	
			);


			$row = $this->Mlop->insert($data);
		if($row > 0){
			setMessage('success','Thêm thành công');
			return redirect('lop');
			} 
		
		}
	}
	public function delete(){
		$ma = $this->input->post("delete");
		$checkf = $this->Mlop->checkfk($ma);
		if($checkf['ma_lop']==null){
			$row = $this->Mlop->delete($ma);
			setMessage('success','Xóa thành công');
			return redirect('lop');
		}
		else 
		{
			setMessage('error',"Không thể xóa<br>Giá trị này đang được sử dụng");
			return redirect('lop');
		}
	}
	
	public function update(){
		$data = array(
			'ten_lop' 	 			=> $this->input->post('ten_lop'),
			'ma_khoahoc' 	 		=> $this->input->post('khoahoc'),
			'ma_canbo_quanly' 	 	=> $this->input->post('canbo'),	
		);
		$id = $this->input->post('capnhat');

		$row = $this->Mlop->updateData($id,$data);
		if($row >0){
			setMessage('success','Cập nhật thành công');
			return redirect('lop');
		}
		else{
			setMessage('error','Cập nhật không thành công');
			return redirect('lop');
		}
	}
}