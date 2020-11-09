<?php

    /**
     * 
     */
    class Cbaocaokhaosathoctap extends MY_Controller{
        function __construct(){
            parent::__construct();
            $this->load->model('khaosat/Mbaocaokhaosathoctap', 'baocao');
        }

        public function index(){
            $action                 = $this->input->post('action');

            $dskhaosat              = $this->baocao->layKhaoSatHocTap();
            if (!$action) {
                $hinhthuc           = $dskhaosat[0]['ma_khaosat'];
                $dsdot              = $this->baocao->layDotKhaoSat($hinhthuc, '1');
                $ma_dks             = ($dsdot) ? $dsdot[0]['ma_dotkhaosat'] : -1;
            }

            switch ($action) {
                case 'loc':
                    $hinhthuc       = $this->input->post('hinhthuc');
                    $dsdot          = $this->baocao->layDotKhaoSat($hinhthuc, '1');
                    $ma_dks         = $this->input->post('hocvu');
                    break;
                case 'xuatexcel':
                    $this->xuatBaoCaoKhaoSat();
                    break;
                case 'load-dotkhaosat':
                    $makhaosat      = $this->input->post('khaosat');
                    echo json_encode($this->baocao->layDotKhaoSat($makhaosat, '1'));
                    exit();
                    break;
                default:
                    # code...
                    break;
            }

            $baocao                 = $this->createModelData($hinhthuc, $ma_dks);

            $data = array(
                'dskhaosat'         => $dskhaosat,
                'dsdot'             => $dsdot,
                'baocao'            => $baocao,
                'map_linhvuc'       => array(),
            );

            $temp['data']           = $data;
            $temp['template']       = 'khaosat/Vbaocaokhaosathoctap';
            $this->load->view('layout/Vcontent', $temp);
        }

        private function createModelData($hinhthuc, $ma_dks){
            $khaosat                = $this->baocao->layKhaoSat($hinhthuc);
            $dotkhaosat             = $this->baocao->getDotKhaoSat($ma_dks);
            $linhvuctinhdiem        = $this->baocao->layNhomCauHoiKhaoSat($hinhthuc);
            $linhvuctinhdiem        = handingKeyArray($linhvuctinhdiem, 'ma_nhomcauhoi');

            foreach ($linhvuctinhdiem as $key => $lv) {
                $lv['alias_name']       = 'Lĩnh vực ' . $lv['thutu_nhomcauhoi'];
                $lv['hailong']          = 0;
                $lv['tongdanhgia']      = 0;
                $linhvuctinhdiem[$key]  = $lv;
            }

            $mon_giangvien          = $this->baocao->layMonGiangVien($dotkhaosat['ma_donvihocvu'], $khaosat['ma_hinhthuc']);
            $dsphieu                = $this->baocao->layKetQuaKhaoSat($ma_dks);
            $ketquaphieu            = $this->baocao->layChiTietKetQua($ma_dks);

            $map_ketquaphieu        = array();
            foreach ($ketquaphieu as $kq) {
                $map_ketquaphieu[$kq['ma_cb']][$kq['ma_monhoc']][$kq['ma_nhomcauhoi']] = $kq['tongnhom'];
            }

            $map_dsphieu            = array();
            foreach ($dsphieu as $ct) {
                if (!isset($map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']])) {
                    $map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']]    = array();
                }
                $map_dsphieu[$ct['ma_cb']][$ct['ma_monhoc']]        = $ct;
            }

            $map_baocao                         = array();
            $stt                                = 0;
            foreach ($mon_giangvien as $m) {
                $baocao                         = array(
                    'stt'                       => ++$stt,
                    'monhoc'                    => $m['ten_monhoc'],
                    'khoiluong'                 => '(' . $m['tongkhoiluong'] . ' TC)',
                    'tencanbo'                  => trim($m['hodem_cb']) . ' ' . $m['ten_cb'],
                    'hocham'                    => ($m['ma_hocham'] != '-') ? $m['ma_hocham'] : '',
                    'sophieu'                   => (isset($map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['sophieu'])) ? $map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['sophieu'] : 0,
                    'dakhaosat'                 => (isset($map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['dakhaosat'])) ? $map_dsphieu[$m['ma_cb']][$m['ma_monhoc']]['dakhaosat'] : 0,
                    'tylekhaosat'               => 0,
                    'tonghailong'               => 0,
                    'hailong'                   => array(),
                );

                if ($baocao['sophieu'] && $baocao['dakhaosat']){
                    $baocao['tylekhaosat']      = round(($baocao['dakhaosat'] * 100) / $baocao['sophieu'], 2);
                }

                foreach ($linhvuctinhdiem as $mn => $lv) {
                    $hailong                    = (isset($map_ketquaphieu[$m['ma_cb']][$m['ma_monhoc']][$mn])) ? $map_ketquaphieu[$m['ma_cb']][$m['ma_monhoc']][$mn] : 0;

                    $lv['hailong']              += $hailong;
                    $lv['tongdanhgia']          += $baocao['dakhaosat'];

                    $baocao['hailong'][$mn]     = 0;

                    if ($baocao['dakhaosat'] > 0) {
                        $baocao['hailong'][$mn] = round(($hailong * 100) / ($lv['socauhoi'] * $baocao['dakhaosat']), 2);
                    }
                    $baocao['tonghailong']      += $baocao['hailong'][$mn];
                    $linhvuctinhdiem[$mn]       = $lv;
                }

                $baocao['tbhailong']            = round($baocao['tonghailong'] / count($linhvuctinhdiem), 2);
                $map_baocao[$m['ma_cb']][$m['ma_monhoc']]   = $baocao;
            }

            $tongchiso                          = array(
                'hailong'                       => 0,
                'danhgia'                       => 0,
            );
            foreach ($linhvuctinhdiem as $mn => $lv) {
                $lv['chiso']                    = round(($lv['hailong'] * 100) / ($lv['tongdanhgia'] * $lv['socauhoi']), 2);
                $linhvuctinhdiem[$mn]           = $lv;

                $tongchiso['hailong']           += $lv['hailong'];
                $tongchiso['danhgia']           += $lv['tongdanhgia'] * $lv['socauhoi'];
            }
            
            return array(
                'hinhthuc'          => $hinhthuc,
                'hocvu'             => $ma_dks,
                'linhvuc'           => $linhvuctinhdiem,
                'mapbaocao'         => $map_baocao,
                'tongchiso'         => $tongchiso,
            );
        }

        private function xuatBaoCaoKhaoSat(){
            $hinhthuc               = $this->input->post('hinhthuc');
            $ma_dks                 = $this->input->post('hocvu');
            $baocao                 = $this->createModelData($hinhthuc, $ma_dks);

            $thongtin               = array(
                'khoa'              => $this->baocao->layDonViCanBo($this->_session['ma_canbo']),
                'hocvu'             => $this->baocao->layThongTinDotKhaoSat($ma_dks),
            );
            $filename               = 'Báo cáo khảo sát - Hình thức đào tạo ' . $thongtin['hocvu']['ma_hinhthuc'] . ' - Học kỳ ' . $thongtin['hocvu']['ma_donvihocvu'];

            $this->load->library('Excel');
            $objPHPExcel            = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Administrator")
                ->setLastModifiedBy("Administrator")
                ->setTitle("Danh sách quản lý lớp môn")
                ->setSubject("Danh sách quản lý lớp môn")
                ->setDescription("Danh sách quản lý lớp môn")
                ->setKeywords("office 2003 openxml php")
                ->setCategory("Information of student");
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Times new Roman');

            $start                          = 1;
            $array_content['A' . $start++]  = 'TRƯỜNG ĐẠI HỌC MỞ HÀ NỘI';
            $array_content['A' . $start++]  = 'KHOA ' . $thongtin['khoa']['ten_donvi_upper'];
            $start++;
            $array_content['A' . $start++]  = 'BÁO CÁO KHẢO SÁT';
            $array_content['A' . $start++]  = '(Học kỳ: '. $thongtin['hocvu']['ma_donvihocvu'] . ' - Hình thức đào tạo: ' . $thongtin['hocvu']['ma_hinhthuc'] . ')';

            $array_column   = array(
                'A' => 5,
                'B' => 60,
                'C' => 22,
                'D' => 8,
                'E' => 8,
                'F' => 8,
                'G' => 8,
            );

            $column_end                     = 'G';
            $startNhom                      = PHPExcel_Cell::columnIndexFromString($column_end);
            $arrayColumnNhom                = array();

            foreach ($baocao['linhvuc'] as $mn => $n) {
                $nhomString                 = PHPExcel_Cell::stringFromColumnIndex($startNhom++);
                $arrayColumnNhom[$mn]       = $nhomString;
                $array_column[$nhomString]  = 8;
            }
            $nhomString                     = PHPExcel_Cell::stringFromColumnIndex($startNhom++);
            $column_end                     = $nhomString;


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
                'A1',
                'A4',
                'A7:' . $column_end . '7'
            );
            $array_underline                = array(
                'A2'
            );
            $array_italic                   = array(
                'A5'
            );

            $array_merge                    = array(
                'A1:B1',
                'A2:B2',
                'A4:' . $column_end . '4',
                'A5:' . $column_end . '5',
            );
            $array_font_size                = array(
                'A1:A2' => 13,
                'A4'    => 15
            );
            $array_row                      = array(
                4       => 25,
                7       => 50,
            );
            $array_x_align                  = array(
                'A1:' . $column_end . '7'
            );
            $array_y_align                  = array(

            );
            $array_rigt_align               = array(
                
            );
            
            $array_format_text              = array(

            );
            $array_wrap_text                = array(
            );
            $start_border                   = ++$start;

            $array_content['A' . $start]    = 'STT';
            $array_content['B' . $start]    = 'Tên môn học';
            $array_content['C' . $start]    = 'Giảng viên';
            $array_content['D' . $start]    = 'Học hàm, học vị';
            $array_content['E' . $start]    = 'Số phiếu hiện có';
            $array_content['F' . $start]    = 'Số phiếu đã khảo sát';
            $array_content['G' . $start]    = 'Tỷ lệ khảo sát';
            foreach ($arrayColumnNhom as $mn => $strNhom) {
                $array_content[$strNhom . $start]   = $baocao['linhvuc'][$mn]['alias_name'];
            }
            $array_content[$column_end . $start++]  = 'Trung bình';
            $objPHPExcel->getActiveSheet()->freezePane('A' . $start);

            $stt                                    = 0;
            $tongsophieu                            = 0; 
            $tongdakhaosat                          = 0; 
            foreach ($baocao['mapbaocao'] as $cbmh) {
                foreach ($cbmh as $mh) {
                    $array_content['A' . $start]    = ++$stt;
                    $array_content['B' . $start]    = $mh['monhoc'] . ' ' . $mh['khoiluong'];
                    $array_content['C' . $start]    = $mh['tencanbo'];
                    $array_content['D' . $start]    = $mh['hocham'];
                    $array_content['E' . $start]    = $mh['sophieu'];
                    $array_content['F' . $start]    = $mh['dakhaosat'];
                    $array_content['G' . $start]    = $mh['tylekhaosat'] . '%';
                    foreach ($arrayColumnNhom as $mn => $strNhom) {
                        $array_content[$strNhom . $start]   = $mh['hailong'][$mn] . '%';
                    }
                    $array_content[$column_end . $start++]  = $mh['tbhailong'] . '%';
                    $tongsophieu                    += $mh['sophieu'];
                    $tongdakhaosat                  += $mh['dakhaosat'];
                }
            }

            array_push(
                $array_merge,
                'A' . $start . ':D' . $start
            );
            array_push(
                $array_bold,
                'A' . $start . ':' . $column_end . $start
            );
            array_push(
                $array_x_align,
                'A' . $start . ':' . $column_end . $start
            );

            $array_content['A' . $start]    = 'Tổng:';
            $array_content['E' . $start]    = $tongsophieu;
            $array_content['F' . $start]    = $tongdakhaosat;
            $array_content['G' . $start]    = round($tongdakhaosat * 100 / $tongsophieu, 2) . '%';
            foreach ($arrayColumnNhom as $mn => $strNhom) {
                $array_content[$strNhom . $start]   = $baocao['linhvuc'][$mn]['chiso'] . '%';
            }
            $array_content[$column_end . $start++]  = round($baocao['tongchiso']['hailong'] * 100 / $baocao['tongchiso']['danhgia'], 2) . '%';

            $objPHPExcel->getActiveSheet()->getStyle('A' . $start_border . ':' . $column_end . ($start-1 ))->applyFromArray($style_array);
            array_push(
                $array_x_align,
                'A8:A' . ($start - 1),
                'E8:' . $column_end . ($start - 1)
            );

            for ($i = 1; $i < $start_border; $i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(-1);  
            }

            for ($i = ($start_border + 1); $i < $start; $i++) {
                $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);  
            }

            $objPHPExcel->getActiveSheet()->getStyle('A1:' . $column_end . $start)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

            /*foreach (range('A', 'Z') as $column) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }*/
            array_push($array_y_align, 'A1:' . $column_end . $start);
            array_push($array_wrap_text, 'A1:' . $column_end . $start);

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

?>