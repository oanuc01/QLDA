<?php 
	session_start();
	if (!isset($_SESSION['tai_khoan'])) {
	  header("Location: dang_nhap.php");
	}

	// Lấy các dữ liệu bên trang Thêm mới bài viết
	$id = $_POST['txtID'];
	$tennd = $_POST['txtTen'];
	$password= $_POST['txtPassword'];


	include("../config/dbconfig.php");
	$ketnoi = mysqli_connect($host, $dbusername, $dbpassword, $dbname);
	mysqli_set_charset($ketnoi, 'UTF8');

	// Bước 2: Chàn dữ liệu vào bảng Liên hệ
		
		$sql = "
		UPDATE `tbl_admin` SET 
			`ten_nguoi_dung` = '".$tennd."',
			`password` = '".$password."'
		WHERE `nguoi_dung_id` = '".$id."'
		";
	
	
	// Xem câu lệnh SQL viết có đúng hay không?
	// echo $sql;

	// Cho thực thi câu lệnh SQL trên
	mysqli_query($ketnoi, $sql);
	echo '
		<script type="text/javascript">
			alert("Sửa người dùng thành công!!!");
			window.location.href="admin-list.php";
		</script>';
;?>