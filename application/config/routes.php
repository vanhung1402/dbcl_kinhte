<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	$route['default_controller'] 				= 'Chome';
	$route['home'] 								= 'Chome';
	$route['404_override'] 						= 'hethong/Cnotfound';
	$route['notfound'] 							= 'hethong/Cnotfound';
	$route['login'] 							= 'hethong/Cloginadmin';
	$route['logout'] 							= 'hethong/Cloginadmin/logout';
	$route['doimatkhau'] 						= 'hethong/Cdoimatkhau';

	$route['cauhoi'] 							= 'khaosat/Ccauhoi';
	$route['chude'] 							= 'khaosat/Cchude';
	$route['khaosathoctap/dot'] 				= 'khaosat/Cdotkhaosathoctap';
	$route['khaosathoctap/chitiet'] 			= 'khaosat/Cchitietkhaosathoctap';
	$route['khaosathoctap/inchitiet'] 			= 'khaosat/Cchitietkhaosathoctap/inChiTiet';
	$route['khaosathoctap/sinhvien'] 			= 'khaosat/Cthuhienkhaosathoctap';
	$route['khaosathoctap/chitietphieu']		= 'khaosat/Cchitietphieuhoctap';
	$route['khaosathoctap/tinhtrang']			= 'khaosat/Ctinhtrangkhaosathoctap';
	$route['khaosathoctap/thongke']				= 'khaosat/Cthongkekhaosathoctap';
	$route['khaosathoctap/baocao']				= 'khaosat/Cbaocaokhaosathoctap';
	$route['khaosathoctap/danhgia']				= 'khaosat/Cdanhgiakhaosathoctap';
	$route['khaosathoctap/thongke']				= 'khaosat/Cthongkekhaosathoctap';
	$route['khaosathoctap/lopmon']				= 'khaosat/Ctinhtrangkhaosathoctap/lopMon';

	$route['luutru/khaosathoctap']				= 'luutru/Cbaocaokhaosathoctap';
	$route['luutru/khaosathoctap/danhgia']		= 'luutru/Cdanhgiakhaosathoctap';
	$route['luutru/khaosathoctap/chitietphieu']	= 'luutru/Cchitietphieuhoctap';


	$route['canbo'] 							= 'danhmuc/Ccanbo'; 
	$route['donvi'] 							= 'danhmuc/Cdonvi'; 
	// $route['khoahoc'] 							= 'danhmuc/Ckhoahoc';
	$route['lop'] 								= 'danhmuc/Clop';
	$route['sinhvien'] 							= 'danhmuc/Csinhvien';
	$route['themcanbo'] 						= 'danhmuc/Cthemcanbo';
	$route['themsinhvien'] 						= 'danhmuc/Cthemsinhvien';
	$route['taikhoan'] 							= 'danhmuc/Ctaikhoan';
	$route['danhsachsinhvien'] 					= 'danhmuc/Cdanhsachsinhvien';
	
	$route['importdangkymon']					= 'import/Cimportdangkymon';

	$route['khoahoc'] 							= 'hethong/Ckhoahoc';
	$route['ctdt'] 								= 'hethong/Cchuongtrinhdaotao';
	$route['monhoc'] 							= 'hethong/Ctaomonhoc';
	$route['monhoc_ctdt'] 						= 'hethong/Cthemmon_ctdt';
	$route['canbo_mon'] 						= 'hethong/canbo_mon';
	$route['dukienlopmon'] 						= 'hethong/Ctaolopmon';
	$route['duyetlopmon'] 						= 'hethong/Cduyetlopmon';
	$route['chitietlopmon'] 					= 'hethong/Chitietlopmon';
	$route['xeplopmon'] 						= 'hethong/Cxeplopmon';
	$route['lop_hocphan'] 						= 'hethong/Clop_hocphan';
	$route['donvihocvu']						= 'hethong/Cdonvihocvu';
	$route['chuyenkhoa']						= 'hethong/Cchuyendonvi';


	$route['cuockhaosat']	 					= 'quanly/Ckhaosat';
	$route['dotkhaosat'] 						= 'quanly/Cdotkhaosat';
	$route['khaosat'] 							= 'quanly/Ckhaosat';
	$route['phieukhaosat/hoctap'] 				= 'quanly/Ckhaosat/printForm';

	$route['chuanhoa'] 							= 'chuanhoa/Cchuanhoa';