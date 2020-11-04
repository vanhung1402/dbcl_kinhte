<?php  
class Cthemsinhvien extends MY_Controller
{
	 public function __construct()
		{
			parent::__construct();
			$this->load->model('danhmuc/Msinhvien');
			$this->load->library('Excel');
			$this->load->helper('download');
		}
	public function index(){

		if($this->input->post('them')){
			return $this->insert();
		} 
		if($this->input->post('delete')){
			return $this->delete();
		}
		if ($this->input->post('capnhat')) {
			return $this->update();
		}
	

		$data = array(
				// 'message'			=> getMessages(),
				'thongtin' 			=> $this->Msinhvien->getListsinhvien(),
				'lop'				=> $this->Msinhvien->getLop(),
				'trangthai'			=> $this->Msinhvien->getTrangthai(),
		);

		if($action = $this->input->post("action")){
			if($action == "themsinhvien"){
				$filename = $this->uploadFile();
				$global_flag = false;
				$local_flag  = false;
				$dssv_err = array();
				$dataExcel = $this->readFileExcel($filename);

				$data['masinhvien']    		= $this->Msinhvien->getmasv();
				$data['lopconfig']    		= $this->Msinhvien->getLopConfig();
				$data['trangthaiconfig']   	= $this->Msinhvien->getTrangthaiConfig();

				$ip_sv = array();
				foreach ($dataExcel as $k => $v) {
					$local_flag  = false;
					if( in_array($v[0], $data['masinhvien']) || !isset($data['lopconfig'][$v[4]]) || !isset($data['trangthaiconfig'][$v[5]])){
						$local_flag = true;
						$global_flag = true;
						$dssv_err[] = $v;
					}else{
						$ab = explode(' ',  trim($v[1])) ;
						$ten = array_pop($ab);
						$hovaten		= implode(' ', $ab) ;
						$ngaydao = array_reverse(explode('/', trim($v[3])));
						$ngay = implode('-', $ngaydao);

						array_push($data['masinhvien'], $v[0]);
						array_push($ip_sv, array(
								'ma_sv' 				=> $v[0],
								'hodem_sv'				=> $hovaten,
								'ten_sv'				=> $ten,
								'gioitinh_sv'			=> $v[2],
								'ngaysinh_sv'			=> $ngay,
								'ma_lop' 				=> $data['lopconfig'][$v[4]],
								'ma_trangthai_sinhvien' => $data['trangthaiconfig'][$v[5]],
								));
					}
					
				}
				if(empty($dssv_err)){
					$this->db->insert_batch("tbl_sinhvien", $ip_sv);
					setMessage("success","Thêm sinh viên thành công");
					return redirect("sinhvien");
				}else{
					$data['dssv_err'] = $dssv_err;
					setMessage("error","Danh sách sinh viên không hợp lệ");
				}
			}
		}
		$temp = array(
			'template'	=> 'danhmuc/Vthemsinhvien',
			'data' 		=> $data,
		);
		$this->load->view("layout/Vcontent",$temp);
	}

	public function readFileExcel($filename){
		$inputFileName = 'uploads/'.$filename;

		//  Tiến hành đọc file excel
		try {
		    $inputFileType 	= PHPExcel_IOFactory::identify($inputFileName);
		    $objReader 		= PHPExcel_IOFactory::createReader($inputFileType);
		    $objPHPExcel 	= $objReader->load($inputFileName);
		} catch(Exception $e) {
		    die('Lỗi không thể đọc file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		//  Lấy thông tin cơ bản của file excel
		// Lấy sheet hiện tại
		$sheet = $objPHPExcel->getSheet(0); 
		// Lấy tổng số dòng của file, trong trường hợp này là 6 dòng
		$highestRow = $sheet->getHighestRow(); 
		// Lấy tổng số cột của file, trong trường hợp này là 4 dòng
		$highestColumn = $sheet->getHighestColumn();
		// Khai báo mảng $rowData chứa dữ liệu
		//  Thực hiện việc lặp qua từng dòng của file, để lấy thông tin
		$rowData = array();
		for ($row = 1; $row <= $highestRow; $row++){
			if($row == 1) continue;
		    // Lấy dữ liệu từng dòng và đưa vào mảng $rowData
		    $temp = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE,FALSE);
		    $rowData[] = $temp[0];
		}
		//In dữ liệu của mảng
		return $rowData;
	}

	public function uploadFile(){
		$this->load->library('upload');
      	$config['upload_path'] = "uploads/";
        $config['allowed_types'] = 'xlsx'; 
        $config['max_size'] = '90000';
        $this->upload->initialize($config);
        if($this->upload->do_upload("insert_excel")){
            $info = $this->upload->data();
          	return $info['file_name'];
        }else{
        	$change = array(
        		"The filetype you are attempting to upload is not allowed." => "Kiểu tệp bạn đang cố tải lên không được phép"
        		);
            $errors = $this->upload->display_errors();
            setMessage("error", $change[$errors]);
            return 0;
        }
	} 

	// public function download() {   
	//    	$fileName = "sinhvien.xlsx";
	// 	$file = "template/".$fileName;
	//     	// check file exists    
	//     if(file_exists ($file)) {
	//      	// get file content
	//      	$data = file_get_contents($file);
	//      	//force download
	//      	force_download($fileName, $data );
	//     }else {
	//      	// Redirect to base url
	//      	redirect (base_url ());
	//     }
	// }

}
?>