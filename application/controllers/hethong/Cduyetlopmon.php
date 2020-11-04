<?php
class Cduyetlopmon extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model('hethong/Mtaolopmon');
        $this->load->Model('hethong/Mduyetlopmon');
        $this->load->Model('hethong/Mxeplopmon');
    }
    public function index(){
        $action = $this->input->post('action');
        switch ($action) {
            case 'get_lopmon':
                echo json_encode($this->get_lopmon());
                exit();
                break;
            case 'capnhat_lopmon':
                $this->capnhat_lopmon();
                break;
            case 'xuatexcel':
                $this->xuatExcel();
                break;
            default:
                # code...
                break;
        }
        $maquyen        = $session['maquyen'];

        $temp['data']   = array(
            'trangthai_lm'  => $this->Mduyetlopmon->get_trangthai_lopmon(),
            'ds_dvhv'       => $this->Mtaolopmon->get_dvhv() ,
            'dshinhthuc'    => $this->Mduyetlopmon->layDanhSachHinhThuc(),
        );
        $temp['template']   = 'hethong/Vduyetlopmon';
        $this->load->view('layout/Vcontent', $temp);
    }
    public function get_lopmon(){
        $ma_dvhv = $this->input->post('ma_dvhv');
        $trangthai = $this->input->post('trangthai');
        $hinhthuc = $this->input->post('hinhthuc');
        $ds_lopmon = $this->Mduyetlopmon->get_lopmon($ma_dvhv,$trangthai, $hinhthuc);

        $so_sv = array();
        $dsma_lopmon = array_column($ds_lopmon, 'ma_lopmon');
        if (empty($dsma_lopmon)){
            echo json_encode(array());
            exit();
        }
        $sv_lm = $this->Mduyetlopmon->so_sinhvien_lopmon($dsma_lopmon);
        $ds_giangvien = $this->Mduyetlopmon->get_canbo_lopmon($dsma_lopmon);
        $ds_giangvien = handingArrayToMap($ds_giangvien, 'ma_lopmon');

        for($i=0;$i<count($sv_lm);$i++){
            $so_sv[$sv_lm[$i]['ma_lopmon']] = $sv_lm[$i]['so_sv'];
        }
        $data= array(
            'dvhv'      => $ma_dvhv,
            'ds_lopmon' => $ds_lopmon,
            'so_sv'     => $so_sv,
            'gv_lopmon' => $ds_giangvien,
        );
        //pr($data);
         return $data;
        echo json_encode($data);

        exit();
    }
    public function capnhat_lopmon(){
        $ma_lopmon = $this->input->post('ma_lopmon');
        $trangthai = $this->input->post('trangthai');
        if($ma_lopmon && $trangthai){
            $ma_trangthai = $this->input->post('trangthai');
            $up_lm = array(
                'ma_canbo_capnhat'      => $this->_session['ma_canbo'],
                'madm_trangthai_lopmon' => $ma_trangthai,
            );
            $rows = $this->Mduyetlopmon->update_lopmon($this->input->post('ma_lopmon'),$up_lm); 
            $up_lm['success'] = $rows;
            $up_lm['trangthai_new'] = $this->Mduyetlopmon->get_ten_trangthai($ma_trangthai);
            echo json_encode($up_lm);
            exit();
        }
    }
     public function xuatExcel(){
        $this->load->library('Excel');
            $session    = $this->session->userdata('user');
            $quyen    = $session['quyen'];

             if (($quyen != 'phongkhaothi') && ($quyen != 'giaovukhoa')) {
                redirect('404_override','refresh');
            }

            $data = $this->get_lopmon();

            $data1 = $data['ds_lopmon'] ;
            foreach($data['ds_lopmon'] as $key=>$val){
                $data1[$key]['slsv'] = $data['so_sv'][$val['ma_lopmon']];
            }

            $column_end             = PHPExcel_Cell::stringFromColumnIndex(PHPExcel_Cell::columnIndexFromString('F') );

            $filename               = ' Danh sách quản lý lớp môn học kỳ ' . $data['dvhv'];
            $objPHPExcel            = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Administrator")
                ->setLastModifiedBy("Administrator")
                ->setTitle("Danh sách quản lý lớp môn")
                ->setSubject("Danh sách quản lý lớp môn")
                ->setDescription("Danh sách quản lý lớp môn")
                ->setKeywords("office 2003 openxml php")
                ->setCategory("Information of student");
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Times new Roman');

            $array_merge                        = array(
                'A1:B1',
                'A2:B2',
                'A3:G3',
                'A4:G4',
                'A5:G5',

            );
            $array_font_size                    = array(
                'A1' => 13,
                'A2' => 13,
                'A4' => 13,
                'A5' => 11,
            );
            $array_row                          = array(
                '1' => 22,
                '2' => 22,
                '3' => 18,
                '4' => 22,
                '5' => 18,
                '6' => 18
            );

            $start = 1;
            $array_content['A' . $start++]      = 'TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI ';
            $array_content['A' . $start++]      = 'KHOA LUẬT ';
            $array_content['A' . $start++]      = ' ';
            $array_content['A' . $start++]      = 'DANH SÁCH QUẢN LÝ LỚP MÔN';
            $array_content['A' . $start++]      = '(Học kì: '. $data['dvhv']. ')';

            
            $array_column = array(
                'A' => 5,
                'B' => 90,
                'C' => 15,
                'D' => 15,
                'E' => 15,
                'F' => 15,
                'G' => 15,

            );

            /*Thêm border vào tất cả*/
            $style_array                    = array(
                'borders'                   => array(
                    'allborders'            => array(
                        'style'             => PHPExcel_Style_Border::BORDER_THIN
                    ) 
                )
            );

            /*In đậm*/
            $array_bold                     = array(
                'A1:B2',
                'A4:G4',
                'A7:G7'

            );
            $array_underline                = array(
                'A2'
            );
            $array_italic                   = array(
                'A5'
            );
            $array_x_align                  = array(
                'A1:' . $column_end . $start,
                'A7:G7',
            );
            $array_y_align                  = array(

            );
            $array_rigt_align               = array(
                
            );
            
            $array_format_text              = array(

            );
            $start_border                   = $start+1;
            
            //$array_row[$start + 1]          = 25;
            $objPHPExcel->getActiveSheet()->freezePane('A' . ($start +2));
            $start++;
            $array_content                  = array_merge(
                $array_content,
                array(
                    'A' . $start  => 'STT',
                    'B' . $start  => 'Tên môn',
                    'C' . $start  => 'Ngày bắt đầu',
                    'D' . $start  => 'Ngày kết thúc',
                    'E' . $start  => 'Số lượng SV',
                    'F' . $start  => 'Hình thức',
                    'G' . $start  => 'Trạng thái',
                )
            );
            array_push(
                $array_merge,
                'A' . $start . ':A' . ($start),
                'B' . $start . ':B' . ($start),
                'C' . $start . ':C' . ($start),
                'D' . $start . ':D' . ($start),
                'E' . $start . ':E' . ($start),
                'F' . $start . ':F' . ($start),
                'G' . $start . ':' . $column_end . $start

            );

            $start++;
            //$start++;
            $index=1;
            foreach ($data1 as $lm) {
                $array_content['A' . $start]    = $index++;
                $array_content['B' . $start]    = $lm['ten_lopmon'];
                $array_content['C' . $start]    = $lm['ngaybd'];
                $array_content['D' . $start]    = $lm['ngaykt'];
                $array_content['E' . $start]    = ($lm['slsv']) ? $lm['slsv'] : 0;
                $array_content['F' . $start]    = $lm['ma_hinhthuc'];
                $array_content['G' . $start]    = $lm['tendm_trangthai_lopmon'];
                
                $start++;
            }
            $array_wrap_text                = array(
                'A1:' . $column_end . $start,

            );
            $array_center_align                  = array(
                'C1:' . $column_end . $start,
                'A1:' . 'A'.$start
            );

            $objPHPExcel->getActiveSheet()->getStyle('A' . $start_border . ':' . $column_end . ($start-1 ))->applyFromArray($style_array);


            array_push($array_bold, 'A' . $start . ':' . $column_end . ($start + 1));
            array_push($array_italic, 'E' . $start);
            array_push($array_x_align, 'A' . $start . ':' . $column_end . ($start + 1));
            array_push($array_center_align, 'A' . $start . ':' . $column_end . ($start + 1));
            array_push($array_y_align, 'A1:' . $column_end . $start);
            array_push($array_wrap_text, 'A1:' . $column_end . $start);

            $objPHPExcel->getActiveSheet()->getRowDimension($start_border - 1)->setRowHeight(30);  

            for ($i = ($start_border + 2); $i < $start; $i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);  
            }

            $objPHPExcel->getActiveSheet()->getStyle('A1:' . $column_end . $start)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

            foreach (range('A', 'Z') as $column) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }

            foreach ($array_content as $key => $value) {
                $objPHPExcel->getActiveSheet()->setCellValue($key, $value);
            }

            foreach ($array_row as $key => $value) {
                $objPHPExcel->getActiveSheet()->getRowDimension($key)->setRowHeight($value);
            }

            foreach ($array_column as $key => $value) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($key)->setAutoSize(false);
                $objPHPExcel->getActiveSheet()->getColumnDimension($key)->setWidth($value);
            }
            foreach ($array_merge as $cells) {
                $objPHPExcel->getActiveSheet()->mergeCells($cells);
            }

            foreach ($array_wrap_text as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setWrapText(true);
            }

            foreach ($array_bold as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getFont()->setBold(true);
            }

            foreach ($array_underline as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getFont()->setUnderline(true);
            }

            foreach($array_italic as $cell){
                $objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setItalic(true);
            }

            foreach($array_font_size as $key => $value){
                $objPHPExcel->getActiveSheet()->getStyle($key)->getFont()->setSize($value);
            }
            foreach ($array_center_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            foreach ($array_x_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            foreach ($array_y_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }
            
            foreach ($array_rigt_align as $cells) {
                $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            }
            $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
            $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
            $objPHPExcel->getActiveSheet()
                    ->getPageMargins()->setTop(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setRight(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setLeft(0.5);
            $objPHPExcel->getActiveSheet()
                ->getPageMargins()->setBottom(0.5);

            ob_end_clean();
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename=$filename.xls");
            header("Cache-Control: max-age=0");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit();
        }
}