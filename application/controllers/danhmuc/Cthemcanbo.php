<?php  
class Cthemcanbo extends MY_Controller
{
	 public function __construct()
		{
			parent::__construct();
			$this->load->model('danhmuc/Mcanbo');
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
				'thongtin' 			=> $this->Mcanbo->getListcanbo(),
				'donvi'				=> $this->Mcanbo->getDonvi(),
				'hocham'			=> $this->Mcanbo->getHocham(),
				//'hocvi'				=> $this->Mcanbo->getHocvi(),
		);

		if($action = $this->input->post("action")){
			if($action == "themcanbo"){
				$filename = $this->uploadFile();
				$global_flag = false;
				$local_flag  = false;
				$dscb_err = array();
				$dataExcel = $this->readFileExcel($filename);

				$data['macanbo']    	= $this->Mcanbo->getmacb();
				$data['donviconfig']    = $this->Mcanbo->getDonviConfig();
				$data['hochamconfig']   = $this->Mcanbo->getHochamConfig();
				//$data['hocviconfig']  	= $this->Mcanbo->getHocviConfig();

				$ip_canbo = array();
				foreach ($dataExcel as $k => $v) {
					$local_flag  = false;
					if( in_array($v[0], $data['macanbo']) || !isset($data['donviconfig'][$v[4]]) || !isset($data['hochamconfig'][$v[5]]) ){
						$local_flag = true;
						$global_flag = true;
						$dscb_err[] = $v;
					}else{
						$ab = explode(' ',  trim($v[1])) ;
						$ten = array_pop($ab);
						$hovaten		= implode(' ', $ab) ;
						$ngaydao = array_reverse(explode('/', trim($v[3])));
						$ngay = implode('-', $ngaydao);
						array_push($data['macanbo'], $v[0]);
						array_push($ip_canbo, array(
											'ma_cb' 		=> $v[0],
											'hodem_cb'		=> $hovaten,
											'ten_cb'		=> $ten,
											'gioitinh_cb'	=> $v[2],
											'ngaysinh_cb'	=> $ngay,
											'ma_donvi' 		=> $data['donviconfig'][$v[4]],
											'ma_hocham' 	=> $data['hochamconfig'][$v[5]],
											//'ma_hocvi'		=> $data['hocviconfig'][$v[6]],
											));
					
					}
					
				}
				
				if(empty($dscb_err)){
					$this->db->insert_batch("tbl_canbo", $ip_canbo);
					setMessage("success","Thêm cán bộ thành công");
					return redirect("canbo");
				}else{
					$data['dscb_err'] = $dscb_err;
					setMessage("error","Danh sách cán bộ không hợp lệ");
				}
			}
		}
		$temp = array(
			'template'	=> 'danhmuc/Vthemcanbo',
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
	//    	$fileName = "canbo.xlsx";
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