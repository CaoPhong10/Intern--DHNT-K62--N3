<?php
require("../../../db_connect.php");


$sql = "SELECT MASP from sanpham ORDER BY MASP DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$maSP = (int) substr($row['MASP'], 2);
$maSP = $maSP + 1;
$maSP = "SP" . str_pad($maSP, 6, "0", STR_PAD_LEFT);

$sql = "SELECT MATSKT from thongsokythuat ORDER BY MATSKT DESC LIMIT 1";
$result1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_assoc($result);
$maTSKT = (int) substr($row['MASP'], 4);
$maTSKT = $maTSKT + 1;
$maTSKT = "TSKT" . str_pad($maTSKT, 3, "0", STR_PAD_LEFT);
if (isset($_POST["taomoi"])) {
        $target_dir = "../../../Images/";
        $target_file = $target_dir . basename($_FILES["Avatar"]["name"]);
        $check = getimagesize($_FILES["Avatar"]["tmp_name"]);
        $ngayTao = date("Y-m-d H:i:s");
        if ($check !== false) {
                
                $sql = "INSERT INTO thongsokythuat VALUES ('$maTSKT', '" . $_POST['HEDIEUHANH'] . "', '" . $_POST['RAM'] . "', 
        '" . $_POST['ROM'] . "', '" . $_POST['KICHCOMANHINH'] . "', '" . $_POST['VIXULY'] . "',
        '" . $_POST['PIN'] . "', '" . $_POST['CAMERA']. "')";
        $result = mysqli_query($conn, $sql);
                move_uploaded_file($_FILES["Avatar"]["tmp_name"], $target_file);
                $sql = "INSERT INTO sanpham (NGAYTAO, MASP, TENSP, DONGIA, SOLUONG, MOTA, ANH, MALOAISP, MATH, MATSKT)
            VALUES ('$ngayTao', '$maSP', '" . $_POST['TENSP'] . "', '" . $_POST['DONGIA'] . "', 
            '" . $_POST['SOLUONG'] . "', '" . $_POST['MOTA'] . "', '" . $_FILES["Avatar"]["name"] . "',
            '" . $_POST['loaisp'] . "', '" . $_POST['thuonghieu'] . "', '" . $maTSKT . "')";   
        $result = mysqli_query($conn, $sql);
                header('Location:index.php');
        }
        ?>
        <script>
                window.alert("Tệp ảnh không hợp lệ");
        </script>
        <?php

}
include("../../../header_admin.php");
?>
<div class="container">

        <form action="" class="d-flex justify-content-center" method="post" enctype="multipart/form-data">
                <div>
                        <div class="form-group">
                                <label class="control-label ">Mã sản phẩm </label>
                                <input type="text" class="form-control textfile" readonly value="<?php echo $maSP ?>"
                                        name="MASP">
                        </div>

                        <div class="form-group">
                                <label class="control-label ">Tên sản phẩm </label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" name="TENSP" required>
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label ">Đơn giá </label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" name="DONGIA" required>
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label ">Số lượng </label>
                                <div class="col-md-10">
                                        <input type="number" class="form-control textfile" name="SOLUONG" required>
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label ">Mô tả</label>
                                <div class="col-md-10">
                                        <textarea class="form-control textfile" name="MOTA" id="" cols="60" rows="10">
                                        </textarea>
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label ">Ảnh</label>
                                <div class="col-md-10">
                                        <input type="file" value="Chọn File" name="Avatar" accept="image/*" required />
                                </div>
                        </div>

                        <?php
                        $sql_loaisp = "SELECT TENLOAISP, MALOAISP from loaisanpham ";
                        $result_loaisp = mysqli_query($conn, $sql_loaisp);
                        ?>
                        <div class="form-group">
                                <label class="control-label ">Loại sản phẩm</label>
                                <div class="col-md-10">
                                        <select name="loaisp" id="" class="form-control textfile">
                                                <?php while ($row = mysqli_fetch_row($result_loaisp)) {
                                                        echo "<option selected value='$row[1]'>$row[0]</option>";
                                                } ?>
                                        </select>
                                </div>
                        </div>
                        

                </div>
                <div>
                        <?php
                        $sql_thuonghieu = "SELECT TENTHUONGHIEU, MATH from thuonghieu ";
                        $result_thuonghieu = mysqli_query($conn, $sql_thuonghieu);
                        ?>
                        <div class="form-group">
                                <label class="control-label">Thương hiệu</label>
                                <div class="col-md-10">
                                        <select name="thuonghieu" id="" class="form-control textfile">
                                                <?php while ($rows = mysqli_fetch_row($result_thuonghieu)) {
                                                        if ($row["TENTHUONGHIEU"] == $rows[0]) {
                                                                echo "<option selected value='$rows[1]'>$rows[0]</option>";
                                                        } else
                                                                echo "<option value='$rows[1]'>$rows[0]</option>";
                                                } ?>
                                        </select>
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label">Hệ điều hành </label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" name="HEDIEUHANH">
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label">Ram</label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" name="RAM">
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label">Rom</label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" name="ROM">
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label">Kích cỡ màn hình</label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" name="KICHCOMANHINH">
                                </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label">Vi xử lý</label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" name="VIXULY">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label">Pin</label>
                                <div class="col-md-10">
                                        <input type="number" class="form-control textfile" name="PIN">
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label">Camera</label>
                                <div class="col-md-10">
                                        <input type="text" class="form-control textfile" name="CAMERA">
                                </div>
                        </div>
                        <div class="form-group">
                                <div >
                                        <input type="submit" value="Thêm sản phẩm" class="btn btn-primary"
                                                name="taomoi" />
                                        <a href="./index.php" class="btn btn-primary">Trở về trang danh sách</a>
                                </div>
                        </div>

                </div>
        </form>

</div>
<?php
include("../../../footer_admin.php");
?>