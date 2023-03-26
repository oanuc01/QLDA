
<header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Miễn phí ship toàn quốc  <br>Đổi trả hàng trong vòng 30 ngày.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__links">
                                <a href="admin/dang_nhap.php">Đăng nhập quản trị</a>
                               
                            </div>
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
            <div class="row" style="background-color: #FECB02">
                <div class="col-lg-3 col-md-4">
                    <div class="header__logo">
                        <a href="./index.php"><img  src="img/logo2.jpg" alt="" style="width: auto; height: 60px; margin-left: 100px"> </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-5">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="./index.php">Trang chủ</a></li>
                            <li><a href="./san_pham.php">Sản phẩm</a></li>
                            <li><a >Danh mục</a>
                                <ul class="dropdown">
                                <?php 
                                $ket_noi=mysqli_connect("localhost","root","","btl");
                                $sql="SELECT * FROM tbl_danh_muc

                                ";
                                $sanpham=mysqli_query($ket_noi,$sql);
                                while($row=mysqli_fetch_array($sanpham))
                                {
                                ;?>


                                <li><a href="san_pham_theo_danh_muc.php?id_dm=<?php echo $row["danh_muc_id"];?>"><?php echo $row["ten_danh_muc"] ?></a></li>

                                <?php }; ?>
                                </ul>
                            </li>
                            <li><a href="./tin_tuc.php">Tin tức</a></li>
                            <li><a href="./lien_he.php">Liên hệ</a></li>
                            
                            <li><div class="giohang" >
                          <a href="./cart.php"><img style="height: 40px; width: auto; margin-top: 0px" src="https://img.icons8.com/external-kiranshastry-solid-kiranshastry/64/000000/external-shopping-cart-interface-kiranshastry-solid-kiranshastry-1.png"/>
                            </a>
                            </div>

                            </li>
                        </ul>
                    </nav>
                </div>
              
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>