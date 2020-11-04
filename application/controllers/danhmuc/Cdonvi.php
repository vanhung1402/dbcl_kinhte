<?php  
class Cdonvi extends MY_Controller
{
	
	 public function __construct()
		{
			parent::__construct();
			$this->load->model('danhmuc/Mdonvi');
			
		}
	public function index(){

		if($this->input->post('them')){
			return $this->insert();
		} 
		if($this->input->post('delete')){
			return $this->delete();
		}
		$id = $this->input->get('madv');
		if($id){
			$temp['data']['sua'] = $this->Mdonvi->getdata($id);
		}
		if ($this->input->post('capnhat')) {
			return $this->update();
		}
		$Madonvi_sudung = $this->Mdonvi->getMaDonViSuDung();
		
		$temp['data']['ds'] 	= $this->Mdonvi->getListdonvi();
		$temp['data']['Madonvi_sudung'] 	= $Madonvi_sudung;
		$temp['template'] 		= 'danhmuc/Vdonvi';

		// $temp['data']['message'] = getMessages();
		$this->load->view("layout/Vcontent",$temp);
	}
	public function insert(){
		if($this->input->post('them')){
			$data = array(
				'ma_donvi' 	 		=> $this->input->post('ma_donvi'),
				'ten_donvi' 	 	=> $this->input->post('ten_donvi'),
				
			);

			$kt_madv 			= $this->Mdonvi->kiemTraDonVi($data['ma_donvi']);

			if (!empty($kt_madv)) {
				setMessage('error','Mã đơn vị ' . $data['ma_donvi'] . ' đã tồn tại!');
				return redirect('donvi');	
			}

			$row = $this->Mdonvi->insert($data);
		if($row > 0){
			setMessage('success','Thêm thành công');
			return redirect('donvi');
			} 
		}
	}
	public function delete(){
		$ma = $this->input->post("delete");
		$checkf = $this->Mdonvi->checkfk($ma);
		if($checkf['ma_donvi']==null){
			$row = $this->Mdonvi->delete($ma);
			showMessages('success','Xóa thành công');
			return redirect('donvi');
		}
		else 
		{
			setMessage('error',"Không thể xóa<br>Giá trị này đang được sử dụng");
			return redirect('donvi');
		}
	}
	
	public function update(){
		$data = array(
			'ma_donvi' 	 		=> $this->input->post('ma_donvi'),
			'ten_donvi' 	 		=> $this->input->post('ten_donvi'),
			
		);
		$id = $this->input->post('capnhat');

		$kt_madv 			= $this->Mdonvi->kiemTraDonVi($data['ma_donvi'], $id);

		if (!empty($kt_madv)) {
			setMessage('error','Mã đơn vị ' . $data['ma_donvi'] . ' đã tồn tại!');
			return redirect('donvi');	
		}
		$row = $this->Mdonvi->updateData($id,$data);
		if($row >0){
			setMessage('success','Cập nhật thành công');
			return redirect('donvi');
		}
		else{
			setMessage('error','Cập nhật không thành công');
			
			return redirect('donvi');
		}
	}

}
