<?php  
class Csinhvien extends MY_Controller
{
	 public function __construct()
		{
			parent::__construct();
			$this->load->model('danhmuc/Msinhvien');
		}
	public function index(){
		$action 			= $this->input->post('action');
		switch ($action) {
			case 'loc':
				$key 		= $this->input->post('key');
				$dsinhvien 	= $this->Msinhvien->locSinhVien($key);
				break;
			
			default:
				# code...
				break;
		}

		if($this->input->post('them')){
			return $this->insert();
		} 
		if($this->input->post('delete')){
			return $this->delete();
		}
		if ($this->input->post('capnhat')) {
			return $this->update();
		}

		$id = $this->input->get('masv');
		if ($id) {
			$sua 		= $this->Msinhvien->getdata($id);
			if (empty($sua)) {
				setMessage('error','Sinh viên có mã ' . $id . ' không tồn tại!');
				return redirect('sinhvien');
			}
		}
		
		$Masinhvien_sudung = $this->Msinhvien->getMasinhvienSuDung();
		$data = array(
				// 'message'			=> getMessages(),
				'ds' 				=> $dsinhvien,
				'sua' 				=> (isset($sua) ? $sua : null),
				'Masinhvien_sudung' => $Masinhvien_sudung,
				'lop'				=> $this->Msinhvien->getLop(),
				'trangthai'			=> $this->Msinhvien->getTrangthai(),
		);
		$temp = array(
			'template'	=> 'danhmuc/Vsinhvien', 
			'data' 		=> $data,
		);

		$this->load->view("layout/Vcontent",$temp);
	}
	public function insert(){
		$lop = $this->input->post('lop');
		if(empty($lop)){
				setMessage('error','Thông tin sinh viên chưa đầy đủ');
				return redirect('sinhvien');
			}
			$trangthai = $this->input->post('trangthai');
			if(empty($trangthai)){
				setMessage('error','Thông tin sinh viên chưa đầy đủ');
				return redirect('sinhvien');
			}
		$ab = explode(' ', trim($this->input->post('hodem_sv'))) ;
		$ten = array_pop($ab);
		$hovaten		= implode(' ', $ab) ;
		$ngaydao = array_reverse(explode('/', trim($this->input->post('ngaysinh_sv'))));
		$ngay = implode('-', $ngaydao);
		$data = array(
			'ma_sv' 	 			=> $this->input->post('ma_sv'),
			'hodem_sv' 	 			=> $hovaten,
			'ten_sv' 				=> $ten,
			'gioitinh_sv'  			=> trim($this->input->post('gioitinh_sv')),
			'ngaysinh_sv'  			=> $ngay,
			'email_sv'  			=> trim($this->input->post('email_sv')),
			'sdt_sv'  				=> trim($this->input->post('sdt_sv')),
			'ma_lop'				=> trim($this->input->post('lop')),
			'ma_trangthai_sinhvien'	=> trim($this->input->post('trangthai')),
		);

		$kt_masv 			= $this->Msinhvien->kiemTrasinhvien($data['ma_sv']);

		if (!empty($kt_masv)) {
			setMessage('error','Mã sinh viên ' . $data['ma_sv'] . ' đã tồn tại!');
			return redirect('sinhvien');	
		}

		$row = $this->Msinhvien->insert($data);
		if($row > 0){
			setMessage('success','Thêm thành công');
			return redirect('sinhvien');
			} 
			
		}
	public function delete(){
		$ma = $this->input->post("delete");
		$checkf = $this->Msinhvien->checkfk($ma);
		if($checkf['ma_sv']==null){
			$row = $this->Msinhvien->delete($ma);
			setMessage('success','Xóa thành công');
			return redirect('sinhvien');
		}
		else 
		{
			setMessage('error',"Không thể xóa<br>Giá trị này đang được sử dụng");
			return redirect('sinhvien');
		}
	}
	
	public function update(){
		$ab = explode(' ', trim($this->input->post('hodem_sv'))) ;
		$ten = array_pop($ab);
		$hovaten		= implode(' ', $ab) ;

		$ngaydao = array_reverse(explode('/', trim($this->input->post('ngaysinh_sv'))));
		$ngay = implode('-', $ngaydao);
		$data = array(
			'ma_sv' 	 			=> $this->input->post('ma_sv'),
			'hodem_sv' 	 			=> $hovaten,
			'ten_sv' 				=> $ten,
			'gioitinh_sv'  			=> trim($this->input->post('gioitinh_sv')),
			'ngaysinh_sv'  			=> $ngay,
			'email_sv'  			=> trim($this->input->post('email_sv')),
			'sdt_sv'  				=> trim($this->input->post('sdt_sv')),
			'ma_lop'				=> trim($this->input->post('lop')),
			'ma_trangthai_sinhvien'	=> trim($this->input->post('trangthai')),
		);
		$id = $this->input->post('capnhat');

		$kt_masv 			= $this->Msinhvien->kiemTrasinhvien($data['ma_sv'], $id);

		if (!empty($kt_masv)) {
			setMessage('error','Mã sinh viên ' . $data['ma_sv'] . ' đã tồn tại!');
			return redirect('sinhvien');	
		}
		$row = $this->Msinhvien->updateData($id,$data);
		if($row >0){
			setMessage('success','Cập nhật thành công');
			return redirect('sinhvien');
		}
		else{
			setMessage('error','Cập nhật không thành công');
			return redirect('sinhvien');
		}
	}
}