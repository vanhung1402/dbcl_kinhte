INSERT INTO `tbl_router` (`id_route`, `ten_route`, `icon_route`, `thutu_route`, `id_menu`, `hienthi_route`)
VALUES 
('caplaimatkhau', 'Cấp lại mật khẩu', NULL, NULL, '1', b'0'),
('email_user', 'Cập nhật Email', NULL, NULL, '1', b'0');

CREATE TABLE dm_chucvu(
    ma_chucvu VARCHAR(25) PRIMARY KEY,
    ten_chucvu VARCHAR(100) NOT NULL,
    thutu_chucvu INT
);

ALTER TABLE `tbl_canbo` ADD `ma_chucvu` VARCHAR(25) NULL AFTER `ma_hocvi`;
ALTER TABLE `tbl_canbo` ADD FOREIGN KEY (`ma_chucvu`) REFERENCES `dm_chucvu`(`ma_chucvu`) ON DELETE RESTRICT ON UPDATE CASCADE; 
INSERT INTO `dm_chucvu` (`ma_chucvu`, `ten_chucvu`, `thutu_chucvu`) VALUES ('chunhiemkhoa', 'Chủ nhiệm Khoa', '1'), ('phongkhaothi', 'Cán bộ PKT', '0'), ('giaovukhoa', 'Giáo vụ Khoa', '2'), ('covanhoctap', 'Cố vấn học tập', '3');
ALTER TABLE `tbl_canbo` CHANGE `ma_canbo_hou` `ma_doituong` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL; 
UPDATE `tbl_router` SET `icon_route` = 'mdi mdi-book-open-page-variant' WHERE `tbl_router`.`id_route` = 'donvihocvu';
ALTER TABLE `tbl_sinhvien` ADD `email_sv` VARCHAR(100) NULL AFTER `ngaysinh_sv`, ADD `sdt_sv` VARCHAR(15) NULL AFTER `email_sv`; 