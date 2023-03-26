<?php 
	session_start();
	if (!isset($_SESSION['tai_khoan'])) {
	  header("Location: dang_nhap.php");
	}

	// Lấy các dữ liệu bên trang Thêm mới bài viết
	$id = $_POST['txtID'];
	$tieude = $_POST['txtTieuDe'];
	$mota = $_POST['txtMoTa'];
	$noidung = $_POST['txtNoiDung'];

	//Upload hình ảnh
	$anhminhhoa = "images/" . basename($_FILES["txtAnhMinhHoa"]["name"]);
	$fileanhtam = $_FILES["txtAnhMinhHoa"]["tmp_name"];
	$result = move_uploaded_file($fileanhtam, $anhminhhoa);
	if(!$result) {
		$anhminhhoa=NULL;
	}

	// Chàn dữ liệu vào bảng tbl_tin_tuc
	// Bước 1: Kết nối đến CSDL 
	include("../config/dbconfig.php");
	$ketnoi = mysqli_connect($host, $dbusername, $dbpassword, $dbname);
	mysqli_set_charset($ketnoi, 'UTF8');

	// Bước 2: Chàn dữ liệu vào bảng Liên hệ
	if($anhminhhoa==NULL) {		
		$sql = "
		UPDATE `tbl_tin_tuc` SET 
			`mo_ta` = '".$mota."',
			`tieu_de` = '".$tieude."', 
			`noi_dung` = '".$noidung."'
		WHERE `tin_tuc_id` = '".$id."'
		";
	} else {
		$sql = "
		UPDATE `tbl_tin_tuc` SET 
			`mo_ta` = '".$mota."',
			`tieu_de` = '".$tieude."', 
			`noi_dung` = '".$noidung."', 
			`anh_minh_hoa` = '".$anhminhhoa."'				
		WHERE `tin_tuc_id` = '".$id."'
		";
	}
	
	// Xem câu lệnh SQL viết có đúng hay không?
	// echo $sql;

	// Cho thực thi câu lệnh SQL trên
	mysqli_query($ketnoi, $sql);
	echo '
		<script type="text/javascript">
			alert("Sửa tin tức thành công!!!");
			window.location.href="tin_tuc_quan_tri.php";
		</script>';
;?>