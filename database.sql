-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 15, 2022 lúc 01:51 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dbagm`
--
CREATE DATABASE IF NOT EXISTS `dbagm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dbagm`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hash_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `possition` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `department` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `birthday` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `workday` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`username`, `fullname`, `hash_password`, `possition`, `department`, `avatar`, `id`, `phone`, `gender`, `birthday`, `workday`, `address`) VALUES
('admin', 'Nguyễn Đăng Trình', '$2y$10$LhpqNqe4tHE576GyqWkFRu1EUgXlOrTE1xWkYlOFYbUzh8KETjd72', 'admin', '', '../file/avatar/admin/anv.png', 'admin', '0834021123', 0, NULL, NULL, NULL),
('baotran', 'Nguyễn Bảo Trân', '$2y$10$T4vSaOljyqgxIl9cbHXH6ONyNg75QLgOpACwjCfeI5W.fiOsTbGPO', 'employee', '61e290627a5f5', '', 'baotran', '063596324', 0, '2021-08-17', '2001-01-15', 'Hồ Chí Minh'),
('hoaihuong', 'Võ Hoài Hương', '$2y$10$7uTKz2Rqe0a6M2PzQyMuZ.bv958Dp0.wb6J0IiIXE0TaKVIKFkHQS', 'employee', '61e296ea15c67', '', 'hoaihuong', '096432565', 1, '2022-01-15', '2004-02-02', 'Long An'),
('hoaithuong', 'Võ Hoài Thương', '$2y$10$PKDAz70xd49s/zyNPjzU6ezYIGFKHM90SQ3UNFwV9JMDE52658X2.', 'employee', '61e29658de708', '', 'hoaithuong', '0632145978', 1, '2022-01-15', '2000-07-15', 'Gia Lai'),
('minhanh', 'Phạm Minh Anh', '$2y$10$QrmQ/rv9TrnPQEGcfUZxm.fLSx59141w2i6fahvnDeB0J1bqdDZ2a', 'employee', '61e2968a9697f', '', 'minhanh', '032145697', 1, '2022-01-15', '2006-05-16', 'An Giang'),
('ngocanh', 'Võ Ngọc Anh', '$2y$10$DmR9p5dEzBs9R0kVFOuYK.og34LDUr61SFx5xe01hpP3M4zSfiksy', 'leader', '61e29658de708', '', 'ngocanh', '032178954', 0, '2022-01-15', '2001-12-01', 'Long An'),
('ngoctram', 'Võ Ngọc Trâm', '$2y$10$EzBUkhqwiB4mjiMCPYienOLuki0l03UAs.Utbp9FM4qKW3ehV2x.6', 'leader', '61e296bbb81d1', '', 'ngoctram', '093354632', 0, '2022-01-09', '2001-01-30', 'Quảng Nam'),
('nguyenhung', 'Nguyễn Hưng', '$2y$10$u42a/DP3oxllKt/b.vsVje5cnSAIbbWZ5hG4TWbFvU0JX9fYZfgHS', 'employee', '61e2968a9697f', '', 'nguyenhung', '099654265', 1, '2020-06-16', '2007-06-14', 'Long An'),
('nguyenthe', 'Trần Nguyên Thế', '$2y$10$SL0TGHAkyXuIto.lK.fOH.hkHpeYNQbMOamccnk0lPrECK/EFTAsm', 'employee', '61e296bbb81d1', '', 'nguyenthe', '096354321', 1, '2022-01-03', '2007-05-13', 'Gia Lai'),
('nguyenthong', 'Nguyễn Thông', '$2y$10$/XUoL0py8akFyL1uFoBiL.kpyfDLU4HG3ieq0bOtXgjVnYYa.Ku4O', 'employee', '61e296ea15c67', '', 'nguyenthong', '096478523', 1, '2022-01-15', '2002-02-05', 'Hồ Chí Minh'),
('phamhoaibao', 'Phạm Hoài Bảo', '$2y$10$sQ1dTaF3l.caKb7tgK2fz.b/WAxRVRae1U3o9uAcOGCM/PnUWqiZa', 'leader', '61e290627a5f5', '', 'phamhoaibao', '083400922', 1, '2022-01-01', '2001-09-15', 'An Giang'),
('phuochung', 'Nguyễn Phước Hưng', '$2y$10$Wc2dmuDXL8cX2StLT3fIXudOR43HdWOY/26TAC7h.wvB2XnJdA/sy', 'employee', '61e290627a5f5', '', 'phuochung', '0932456123', 1, '2022-01-15', '2011-05-01', 'Hồ Chí Minh'),
('quocdung', 'Nguyễn Quốc Dũng', '$2y$10$.aNa4gkobu0BXJRf/peh6OB4rXlT4mpPKUfSN4pvr.GnZue8LmgMe', 'employee', '61e29658de708', '', 'quocdung', '074563285', 1, '2022-01-15', '2005-01-25', 'Gia Lai'),
('thanhluan', 'Phạm Thanh Luận', '$2y$10$nM47HVJEtmbY5IkOjpooAuQAAllvdUcnotwebvnqYIPqZ5QDFNT9y', 'leader', '61e296ea15c67', '', 'thanhluan', '096502472', 1, '2022-01-07', '2005-05-05', 'An Giang'),
('tuongvy', 'Nguyễn Tường Vy', '$2y$10$G3nS/v6BXTwLILpWDKfMnOJZ1dx5bgGYcY9qMP4ZCpuxrWvuk2GwS', 'employee', '61e296bbb81d1', '', 'tuongvy', '094563521', 0, '2021-06-09', '2005-06-06', 'Long An'),
('vongoctran', 'Võ Ngọc Trân', '$2y$10$65J7MI19BVwM7iPWBH5XMusUWTLZ49OibelywPDR/CS49ioqKB2k.', 'leader', '61e2968a9697f', '', 'vongoctran', '093547896', 0, '2020-06-16', '2001-06-15', 'Hồ Chí Minh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `day_off`
--

CREATE TABLE `day_off` (
  `id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `employeeId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `day_start` date NOT NULL,
  `reason` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `result` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `reason_result` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `num_day_off` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `day_off_request` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tag_file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `day_off_response` date DEFAULT NULL,
  `date_request` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `day_off`
--

INSERT INTO `day_off` (`id`, `employeeId`, `day_start`, `reason`, `result`, `reason_result`, `department_id`, `num_day_off`, `day_off_request`, `tag_file`, `day_off_response`, `date_request`) VALUES
('61e2946dd915b', 'phuochung', '2022-01-16', 'Ốm', 'Accept', NULL, '61e290627a5f5', '2', '2', '', '2022-01-15', '2022-01-15'),
('61e294c71a9b6', 'phamhoaibao', '2022-01-16', 'Đau đầu', 'Reject', NULL, '61e290627a5f5', '', '5', '../file/_readme.txt', '2022-01-15', '2022-01-15'),
('61e2c2f8393a1', 'ngocanh', '2022-01-20', 'Về quê ăn tết', 'Waiting', NULL, '61e29658de708', '', '15', '', NULL, '2022-01-15'),
('61e2c32a00347', 'quocdung', '2022-01-17', 'Về quê nha', 'Waiting', NULL, '61e29658de708', '', '3', '../file/Huong dan.txt', NULL, '2022-01-15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `department`
--

CREATE TABLE `department` (
  `id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `room` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `detail` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `department`
--

INSERT INTO `department` (`id`, `name`, `room`, `detail`) VALUES
('61e290627a5f5', 'Nhân sự', 'A005', 'Quản lý và tuyển dụng nhân sự công ty '),
('61e29658de708', 'Tài chính', 'A006', 'Thanh toán các khoản tiền cho nhân viên'),
('61e2968a9697f', 'Marketing', 'A007', 'Quảng cáo cho công ty'),
('61e296bbb81d1', 'Công nghệ thông tin', 'B004', 'Các vấn đề liên quan đến công nghệ thông tin'),
('61e296ea15c67', 'An ninh', 'B005', 'Các vấn đề an toàn của công ty');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `submit`
--

CREATE TABLE `submit` (
  `submit_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `task_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `submit_date` datetime NOT NULL,
  `tag_file` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `deatail` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `detail_response` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `tag_file_response` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `submit`
--

INSERT INTO `submit` (`submit_id`, `task_id`, `submit_date`, `tag_file`, `deatail`, `status`, `detail_response`, `tag_file_response`) VALUES
('61e2932c4f4c5', '61e292e7c87e7', '2022-01-15 16:26:00', '../file/phieu_tu_danh_gia_hk1_2122.docx', 'Báo cáo lần 1', 'Rejected', 'Chưa đạt', ''),
('61e2938e3e390', '61e292e7c87e7', '2022-01-15 16:27:00', '../file/Huong dan.txt', 'Báo cáo lần 2', 'Completed', '', ''),
('61e2a01cd16f9', '61e29f5e9a700', '2022-01-15 17:21:00', '../file/phieu_tu_danh_gia_hk1_2122.docx', 'Hoàn thành sơ bộ', 'Completed', '', ''),
('61e2a06b72ab6', '61e29ee561423', '2022-01-15 17:22:00', '../file/Huong dan.txt', 'Đã làm xong', 'Completed', '', ''),
('61e2a2303fab5', '61e29f8870cf0', '2022-01-15 17:30:00', '../file/phieu_tu_danh_gia_hk1_2122.docx', 'Đã làm xong!', 'Waiting', '', ''),
('61e2a33314751', '61e29ef9cd7c8', '2022-01-15 17:34:00', '../file/Huong dan.txt', 'Đã làm', 'Rejected', 'Làm lại', ''),
('61e2a3b424e13', '61e29ef9cd7c8', '2022-01-15 17:36:00', '../file/Huong dan.txt', 'Đã làm 2', 'Rejected', 'Làm lại tiếp đi', '../file/phieu_tu_danh_gia_hk1_2122.docx'),
('61e2a3ef5029f', '61e29ef9cd7c8', '2022-01-15 17:37:00', '../file/Huong dan.txt', 'Đã làm 3', 'Waiting', '', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `task`
--

CREATE TABLE `task` (
  `id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `detail` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `start_day` datetime NOT NULL,
  `deadline` datetime NOT NULL,
  `account_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tag_file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `department_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `review` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `process` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `task`
--

INSERT INTO `task` (`id`, `title`, `detail`, `start_day`, `deadline`, `account_id`, `status`, `tag_file`, `department_id`, `review`, `process`) VALUES
('61e29281f02af', 'Báo cáo', 'Báo cáo nhân sự', '2022-01-15 16:23:00', '2022-01-20 16:22:00', 'phuochung', 'Canceled', '../file/_readme.txt', '61e290627a5f5', '', ''),
('61e292e7c87e7', 'Báo cáo', 'Báo cáo nhân sự tháng 2', '2022-01-15 16:24:00', '2022-01-15 16:24:00', 'phuochung', 'Completed', '../file/_readme.txt', '61e290627a5f5', 'OK', 'Hoàn thành trễ hạn'),
('61e29ee561423', 'Báo cáo 1', 'Làm báo cáo 1', '2022-01-15 17:16:00', '2022-01-20 17:15:00', 'hoaithuong', 'Completed', '../file/Huong dan.txt', '61e29658de708', 'OK', 'Hoàn thành đúng hạn'),
('61e29ef9cd7c8', 'Báo cáo 2', 'Làm báo cáo 2', '2022-01-15 17:16:00', '2022-01-23 17:36:00', 'quocdung', 'Waiting', '', '61e29658de708', '', 'Hoàn thành đúng hạn'),
('61e29f2890435', 'Báo cáo 1', 'Làm báo cáo 1', '2022-01-15 17:17:00', '2022-01-20 17:16:00', 'nguyenthe', 'In progress', '', '61e296bbb81d1', '', 'Chưa hoàn thành'),
('61e29f386e46b', 'Báo cáo 2', 'Làm báo cáo 2', '2022-01-15 17:17:00', '2022-01-20 17:17:00', 'tuongvy', 'Canceled', '', '61e296bbb81d1', '', ''),
('61e29f5e9a700', 'Báo cáo mới', 'Làm bảng lương', '2022-01-15 17:18:00', '2022-01-22 17:17:00', 'baotran', 'Completed', '../file/phieu_tu_danh_gia_hk1_2122.docx', '61e290627a5f5', 'GOOD', 'Hoàn thành đúng hạn'),
('61e29f8870cf0', 'Kiểm tra', 'Tính sổ tháng 7', '2022-01-15 17:18:00', '2022-01-27 17:18:00', 'hoaihuong', 'Waiting', '', '61e296ea15c67', '', 'Hoàn thành đúng hạn'),
('61e29f98601b6', 'Kiểm tra', 'Phân công lịch tháng', '2022-01-15 17:19:00', '2022-01-20 17:19:00', 'nguyenthong', 'New', '', '61e296ea15c67', '', ''),
('61e29fda7fb2e', 'Xử lý nhân sự ', 'Báo cáo sơ bộ 1', '2022-01-15 17:20:00', '2022-01-20 17:19:00', 'minhanh', 'In progress', '../file/Huong dan.txt', '61e2968a9697f', '', 'Chưa hoàn thành'),
('61e29fee5b9a8', 'Báo cáo sơ bộ 2', 'Xử lý học vụ chính', '2022-01-15 17:20:00', '2022-01-29 17:20:00', 'minhanh', 'New', '', '61e2968a9697f', '', ''),
('61e2a319e17d1', 'Tính toán sổ sách', 'Tính toán sổ sách ', '2022-01-15 17:34:00', '2022-01-21 17:33:00', 'hoaithuong', 'New', '', '61e29658de708', '', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`username`);

--
-- Chỉ mục cho bảng `day_off`
--
ALTER TABLE `day_off`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `submit`
--
ALTER TABLE `submit`
  ADD PRIMARY KEY (`submit_id`);

--
-- Chỉ mục cho bảng `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
