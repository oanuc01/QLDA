<?php 
	session_start();
	if (!isset($_SESSION['tai_khoan'])) {
	  header("Location: dang_nhap.php");
	}

	// Lấy các dữ liệu bên trang sửa bài viết
	

	$id = $_POST['txtID'];
	$tensp = $_POST['txtTensp'];
	$giagoc = $_POST['txtGiagoc'];
	$giaban = $_POST['txtGiaban'];
	$chitiet = $_POST['txtChitiet'];
	$mota = $_POST['txtMota'];
	$noidung = $_POST['txtNoidung'];
	$dmsp = $_POST['txtDmsp'];
	$kieusp = $_POST['txtKieusp'];



	// Upload hình ảnh
	$anhminhhoa = "images/" . basename($_FILES["txtAnhMinhHoa"]["name"]);
	$fileanhtam = $_FILES["txtAnhMinhHoa"]["tmp_name"];
	$result = move_uploaded_file($fileanhtam, $anhminhhoa);
	if(!$result) {
		$anhminhhoa=NULL;
	}

	
    $ketnoi = mysqli_connect("localhost","root","","btl");
	mysqli_set_charset($ketnoi, 'UTF8');

	// Bước 2: Chàn dữ liệu vào bảng Liên hệ
	if($anhminhhoa==NULL) {		
		$sql = "
		UPDATE `tbl_sp` SET 
			`ten_san_pham` = '".$tensp."',
            `danh_muc_id` = '".$dmsp."',
            `kieu_san_pham_id` = '".$kieusp."', 
            `gia_goc` = '".$giagoc."',    
			`gia_ban` = '".$giaban."',
			`noi_dung` = '".$noidung."',
			`chi_tiet` = '".$chitiet."',
			`mo_ta` = '".$mota."'   
		WHERE `san_pham_id` = '".$id."'
		";
	} else {
		$sql = "
		UPDATE `tbl_sp` SET 
			`ten_san_pham` = '".$tensp."',
            `danh_muc_id` = '".$dmsp."',
            `kieu_san_pham_id` = '".$kieusp."', 
            `gia_goc` = '".$giagoc."',    
			`gia_ban` = '".$giaban."',
			`noi_dung` = '".$noidung."',
			`chi_tiet` = '".$chitiet."',
			`mo_ta` = '".$mota."',
			`anh_san_pham` = '".$anhminhhoa."'				
		WHERE `san_pham_id` = '".$id."'
		";
	}
	
	// Xem câu lệnh SQL viết có đúng hay không?
	// echo $sql;

	// Cho thực thi câu lệnh SQL trên
	mysqli_query($ketnoi, $sql);
	echo '
		<script type="text/javascript">
			alert("Sửa sản phẩm thành công!!!");
			window.location.href="sanpham-list.php";
		</script>';
;?>