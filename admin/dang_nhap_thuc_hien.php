<!DOCTYPE html>
<html>
<head>
	<title> DumBum | Đăng nhập thực hiện</title>
</head>
<body>
	<?php
		// Lấy các dữ liệu bên trang Thêm mới bài viết
		$taikhoan = $_POST['txtTaiKhoan'];
		$matkhau = $_POST['txtMatKhau'];

		// Kết nối đến CSDL 
		include("../config/dbconfig.php");
	    $ketnoi = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

		// Chèn dữ liệu vào bảng Liên hệ
		$sql = "
		SELECT *
		FROM `tbl_admin` 
		WHERE `ten_nguoi_dung` = '".$taikhoan."' AND `password` = '".$matkhau."'
		";
		
		// Xem câu lệnh SQL viết có đúng hay không?
		echo $sql;

		// Thực thi câu lệnh SQL trên
		$result = mysqli_query($ketnoi, $sql);

		if (mysqli_num_rows($result) == 0) {
			echo '<script type="text/javascript">';
			echo 'alert("Tài khoản mật khẩu không chính xác")';
			echo '</script>';

			header("Location: dang_nhap.php");
		} else {
			session_start();
			$_SESSION['tai_khoan'] = $taikhoan;
			$_SESSION['quyen_han'] = '1';
			
			header("Location: index.php");
		}
		;?>
	</body>
	</html>