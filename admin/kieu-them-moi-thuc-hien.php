<?php 
	session_start();
	if (!isset($_SESSION['tai_khoan'])) {
	  header("Location: dang_nhap.php");
	}

	
	$tendm = $_POST['txtTenDm'];

	// Bước 1: Kết nối đến CSDL 
	include("../config/dbconfig.php");
	$ketnoi = mysqli_connect($host, $dbusername, $dbpassword, $dbname);
	mysqli_set_charset($ketnoi, 'UTF8');

	// Bước 2: Chàn dữ liệu vào bảng Liên hệ
	$sql = "
	INSERT INTO `tbl_kieu_san_pham` (
		`kieu_san_pham_id`, 
		`kieu_san_pham`) 
	VALUES (
		NULL, 
	
		'".$tendm."')";
	
	// Xem câu lệnh SQL viết có đúng hay không?
	// echo $sql;

	// Cho thực thi câu lệnh SQL trên
	mysqli_query($ketnoi, $sql);
	echo '
		<script type="text/javascript">
			alert("Thêm mới loại sản phẩm thành công!!!");
			window.location.href="kieu-list.php";
		</script>';
;?>