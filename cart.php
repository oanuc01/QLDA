<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<?php
    require("layout/header.php");
  ; ?>  
<!-- Header Section Begin -->
<?php
require("layout/menu.php")
;?>
<!-- Header Section End -->

    <body>
        <?php
        include("./config/dbconfig.php");
         $con = mysqli_connect($host, $dbusername, $dbpassword, $dbname);
         mysqli_set_charset($con, 'UTF8');
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
        $error = false;
        $success = false;

        if (isset($_GET['action'])) {

            function update_cart($add = false) {

                foreach ($_POST['quantity'] as $id => $quantity) {

                    if ($quantity == 0) {
                        unset($_SESSION["cart"][$id]);
                    } else {
                            if ($add) {
                                       if(isset($_SESSION["cart"][$id])==0){
                                        $_SESSION["cart"][$id] = $quantity;
                                       }
                                       else{
                                        $_SESSION["cart"][$id] += $quantity;
                                       }
                        } else {
                            $_SESSION["cart"][$id] = $quantity;
                        }
                        
                    }
                }
            }


                //2. viet cau lenh truy van lay ra du lieu mong muon
                
           $soluong = count($_SESSION["cart"]);

            switch ($_GET['action']) {
                case "add":
                    update_cart(true);
                    
                    break;
                case "delete":
                    if (isset($_GET['id'])) {
                        unset($_SESSION["cart"][$_GET['id']]);
                    }
                    
                    break;
                case "submit":

                    if (isset($_POST['update_click']))
                     { if ($soluong==0) {
                         break;
                     }
                        update_cart();
                        
                    } elseif ($_POST['order_click']) { //Đặt hàng sản phẩm
                        if (empty($_POST['name'])) {
                            $error = "Bạn chưa nhập tên của người nhận";
                        } elseif (empty($_POST['phone'])) {
                            $error = "Bạn chưa nhập số điện thoại người nhận";
                        } elseif (empty($_POST['address'])) {
                            $error = "Bạn chưa nhập địa chỉ người nhận";
                        } elseif (empty($_POST['quantity'])) {
                            $error = "Giỏ hàng rỗng";
                        }
                        if ($error == false && !empty($_POST['quantity'])) { //Xử lý lưu giỏ hàng vào db
                            $products = mysqli_query($con, "SELECT * FROM `tbl_sp` WHERE `san_pham_id` IN (" . implode(",", array_keys($_POST['quantity'])) . ")");
                            $total = 0;
                            $orderProducts = array();
                            while ($row = mysqli_fetch_array($products)) {
                                $orderProducts[] = $row;
                                $total += $row['gia_ban'] * $_POST['quantity'][$row['san_pham_id']];
                            }
                            $insertOrder = mysqli_query($con, "INSERT INTO `order` (`id`, `name`, `phone`, `address`, `note`, `total`, `created_time`, `last_updated`) VALUES (NULL, '" . $_POST['name'] . "', '" . $_POST['phone'] . "', '" . $_POST['address'] . "', '" . $_POST['note'] . "', '" . $total . "', '" . time() . "', '" . time() . "');");
                            $orderID = $con->insert_id;
                            $insertString = "";
                            foreach ($orderProducts as $key => $product) {
                                $insertString .= "(NULL, '" . $orderID . "', '" . $product['san_pham_id'] . "', '" . $_POST['quantity'][$product['san_pham_id']] . "', '" . $product['gia_ban'] . "', '" . time() . "', '" . time() . "')";
                                if ($key != count($orderProducts) - 1) {
                                    $insertString .= ",";
                                }
                            }
                            $insertOrder = mysqli_query($con, "INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_time`, `last_updated`) VALUES " . $insertString . ";");
                            $success = "Đặt hàng thành công";
                            unset($_SESSION['cart']);
                        }
                    }
                    break;
            }
        }
        if (!empty($_SESSION["cart"])) {
            $products = mysqli_query($con, "SELECT * FROM `tbl_sp` WHERE `san_pham_id` IN (" . implode(",", array_keys($_SESSION["cart"])) . ")");
        }
//        $result = mysqli_query($con, "SELECT * FROM `product` WHERE `id` = ".$_GET['id']);
//        $product = mysqli_fetch_assoc($result);
//        $imgLibrary = mysqli_query($con, "SELECT * FROM `image_library` WHERE `product_id` = ".$_GET['id']);
//        $product['images'] = mysqli_fetch_all($imgLibrary, MYSQLI_ASSOC);
        ?>
    
    <div id="gio_hang" class="container body">
       <div class="main_container">
          <div class="left_col scroll-view">

            <!-- page content -->
            <div class="right_col" role="main">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <h1 style="height: 100px; width: 180px; line-height: 100px; font-weight: 600; color: #fff; background-color: #141249; text-align: center; border-radius: 0 115px 115px 0; ">Giỏ hàng</h1>
                  <div style="width: 86%; margin: auto">
                      <p style="text-align: right;"><a href="san_pham.php">Thêm sản phẩm<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></p>
                        <?php if (!empty($error)) { ?> 
                            <div id="notify-msg">
                                <?= $error ?>. <a href="javascript:history.back()">Quay lại</a>
                            </div>
                        <?php } elseif (!empty($success)) { ?>
                            <div id="notify-msg">
                                <?= $success ?>. <a href="index.php">Tiếp tục mua hàng</a>
                            </div>
                        <?php } else { ?>
                            <!-- <a href="index.php">Trang chủ</a> -->
                
                    <form id="cart-form" action="cart.php?action=submit" method="POST">
                    <table id="giohang" class="table table-bordered">
                        <tr>
                            <th class="product-number">STT</th>
                            <th class="product-name">Tên sản phẩm</th>
                            <th class="product-img">Ảnh sản phẩm</th>
                            <th class="product-price">Đơn giá</th>
                            <th class="product-quantity">Số lượng</th>
                            <th class="total-money">Thành tiền</th>
                            <th class="product-delete">Xóa</th>
                        </tr>
                        <?php
                        if (!empty($products)) {
                            $total = 0;
                            $num = 1;
                            while ($row = mysqli_fetch_array($products)) {
                                ?>
                                <tr>
                                    <td class="product-number"><?= $num++; ?></td>
                                    <td class="product-name"><?= $row['ten_san_pham'] ?></td>
                                    <td class="product-img"><img src="admin/<?= $row['anh_san_pham']?>" /></td>
                                    <td class="product-price"><?= number_format($row['gia_ban'], 0, ",", ".") ?></td>
                                    <td class="product-quantity"><input type="text" value="<?= $_SESSION["cart"][$row['san_pham_id']] ?>" name="quantity[<?= $row['san_pham_id'] ?>]" /></td>
                                    <td class="total-money"><?= number_format($row['gia_ban'] * $_SESSION["cart"][$row['san_pham_id']], 0, ",", ".") ?></td>
                                    <td class="product-delete"><a href="cart.php?action=delete&id=<?= $row['san_pham_id'] ?>">Xóa</a></td>
                                </tr>
                                <?php
                                $total += $row['gia_ban'] * $_SESSION["cart"][$row['san_pham_id']];
                                $num++;
                            }
                            ?>
                            <tr id="row-total">
                                <td class="product-number">&nbsp;</td>
                                <td class="product-name">Tổng tiền</td>
                                <td class="product-img">&nbsp;</td>
                                <td class="product-price">&nbsp;</td>
                                <td class="product-quantity">&nbsp;</td>
                                <td class="total-money"><?= number_format($total, 0, ",", ".") ?></td>
                                <td class="product-delete">Xóa</td>
                            </tr>
                            <?php
                        }
                                ?>
                            </table>
                            <div id="form-button" style="text-align: right;" >
                                <input style="letter-spacing: 3px;
                            padding: 5px 20px; background-color:#141249; color: white;" type="submit" name="update_click" value="Cập nhật" />
                            </div>
                            <!-- <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="filter__controls">
                                           <li class="active" data-filter="*">THÔNG TIN ĐẶT HÀNG</li>          
                                        </ul>
                                    </div>
                                </div> 
                            </div> -->
                            <div class="contact__form" style="margin-left: 0px;">
                              <div class="col" >
                              <br>
                                <h4><b>THÔNG TIN ĐẶT HÀNG</b></h4>
                                <br>
                                  <div class="col-lg-8">
                                      <input type="text"  placeholder="Name" value="" name="name" />
                                  </div>
                                  <div class="col-lg-8">
                                      <input type="text"  placeholder="SDT" value="" name="phone" />
                                  </div>
                                  <div class="col-lg-8">
                                      <input type="text"  placeholder="DiaChi" value="" name="address" />
                                  </div>
                                  <div class="col-lg-8">
                                    <textarea name="note"  placeholder="GhiChu" cols="50" rows="7" ></textarea></div>
                                </div>   
                            </div>
                            <input style="margin-left:50px;letter-spacing: 4px;
                            padding: 14px 35px; background-color:black; color: white; " type="submit" name="order_click" value="Đặt hàng" />
                            <br>
                            <br>
                    <!-- <hr>
                    <div><label>Người nhận: </label><input type="text" value="" name="name" /></div>
                    <div><label>Điện thoại: </label><input type="text" value="" name="phone" /></div>
                    <div><label>Địa chỉ: </label><input type="text" value="" name="address" /></div>
                    <div><label>Ghi chú: </label><textarea name="note" cols="50" rows="7" ></textarea></div>
                    <input type="submit" name="order_click" value="Đặt hàng" /> -->
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>

    <?php
require("layout/footer.php")
;?>
    </body>
</html>