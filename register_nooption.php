<!-- 資料庫連線 -->
<?php
require_once('Connections/dbset.php');
//如果session沒有自動啟動，則手動命令session功能
(!isset($_SESSION)) ? session_start() : "";
require_once("php_lib.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once("headfile.php") ?>
    <style>
        span.error-tips,
        span.error-tips::before {
            font-family: "Font Awesome 5 Free";
            color: red;
            font-weight: 900;
            content: "\f057";
        }

        span.valid-tips,
        span.valid-tips::before {
            font-family: "Font Awesome 5 Free";
            color: #a19060;
            font-weight: 900;
            content: "\f058";
        }
    </style>
</head>

<body>
    <?php require_once("newnavbar.php") ?>
    <?php
    if (isset($_POST['formctl']) && $_POST['formctl'] == 'reg') {
        $email = $_POST['r-email'];
        $pw1 = md5($_POST['pw1']);
        $cname = $_POST['r-cname'];
        $tssn = $_POST['tssn'];
        $birthday = $_POST['birthday'];
        $mobile = $_POST['mobile'];
        $address = $_POST['address'] == '' ? NULL : $_POST['address'];
        $insertsql = "INSERT INTO member (email,pw1,cname,tssn,birthday) VALUES ('" . $email . "','" . $pw1 . "','" . $cname . "','" . $tssn . "','" . $birthday . "')";
        $Result = $link->query($insertsql);
        $emailid = $link->lastInsertId();    //讀取剛才新增的會員編號
        if ($Result) {
            //把資料寫進資料表
            $insertsql = "INSERT INTO addbook (emailid, setdefault, cname, mobile, address) VALUES ('" . $emailid . "','1','" . $cname . "','" . $mobile . "','" . $address . "')";
            $Result = $link->query($insertsql);
            $_SESSION['login'] = true;   //註冊完直接登入
            $_SESSION['emailid'] = $emailid;
            $_SESSION['email'] = $email;
            $_SESSION['cname'] = $cname;
            echo "<script>alert('註冊完成');location.href='index.php';</script>";
        }
    }
    ?>
    <form action="register.php" method="post" id="reg" name="reg">
        <div id="outline">
            <div class="register_content">
                <div class="r-content-head">
                    <h4 style="font-weight: bolder;">加入會員</h4>
                </div>
                <div class="r-content-body">
                    <div class="r-item">
                        <span>電子信箱<span style="color: red;">(必填)</span></span><input id="r-email" name="r-email" type="email" placeholder="Email" class="register-enterInput">
                    </div>
                    <div class="r-item">
                        <span>密碼<span style="color: red;">(必填)</span></span><input id="pw1" name="pw1" type="password" placeholder="Password" class="register-enterInput">
                    </div>
                    <div class="r-item">
                        <span>再次輸入密碼<span style="color: red;">(必填)</span></span><input id="pw2" name="pw2" type="password" placeholder="Password Again" class="register-enterInput">
                    </div>
                    <div class="r-item">
                        <span>姓名<span style="color: red;">(必填)</span></span><input type="text" placeholder="Name" class="register-enterInput" id="r-cname" name="r-cname">
                    </div>
                    <div class="r-item">
                        <span>身分證字號<span style="color: red;">(必填)</span></span><input type="text" placeholder="ID" class="register-enterInput" id="tssn" name="tssn">
                    </div>
                    <div class="r-item">
                        <span>出生日期<span style="color: red;">(必填)</span></span><input type="text" placeholder="Birthday" class="register-enterInput" id="birthday" name="birthday" onfocus="(this.type='date')">
                    </div>
                    <div class="r-item">
                        <span>手機號碼<span style="color: red;">(必填)</span></span><input type="text" placeholder="Mobile" class="register-enterInput" id="mobile" name="mobile">
                    </div>
                    <div class="r-item">
                        <span>地址<span style="color: red;">(必填)</span></span><br>
                        <input type="text" placeholder="Address" class="register-entererea" id="address" name="address">
                    </div>
                    <div class="r-item">
                        <span>驗證碼<span style="color: red;">(必填)</span></span><br>
                        <input type="hidden" name="captcha" id="captcha">
                        <a href="javascript:void(0);" title="更新認證碼" onclick="getCaptcha();">
                            <canvas id="can"></canvas>
                        </a>
                        <input type="text" placeholder="Verification Code" class="register-enterInput" id="recaptcha" name="recaptcha">
                    </div>
                    <br><br>
                </div>
                <input type="hidden" name="formctl" id="formctl" value="reg">
                <div class="r-content-foot">
                    <button type="submit" class="btn btn-reon-b">確認</button>
                </div>
            </div>
        </div>
    </form>

    <?php require_once("footer.php") ?>
    <?php require_once("jsfile.php") ?>
    <script src="commlib.js"></script>
    <script src="jquery.validate.js"></script>
    <script>
        jQuery.validator.addMethod("tssn", function(value, element, param) {
            var tssn = /^[a-zA-Z]{1}[1-2]{1}[0-9]{8}$/;
            return this.optional(element) || (tssn.test(value));
        });
        jQuery.validator.addMethod("checkphone", function(value, element, param) {
            var checkphone = /^[0]{1}[9]{1}[0-9]{8}$/;
            return this.optional(element) || (checkphone.test(value));
        });
        jQuery.validator.addMethod("checkMyTown", function(value, element, param) {
            return (value !== "");
        });


        $('#reg').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: 'checkmail.php'
                },
                pw1: {
                    required: true,
                    maxlength: 20,
                    minlength: 4,
                },
                pw2: {
                    required: true,
                    equalTo: '#pw1',
                },
                cname: {
                    required: true,
                },
                tssn: {
                    required: true,
                    tssn: true,
                },
                birthday: {
                    required: true,
                },
                mobile: {
                    required: true,
                    checkphone: true,
                },
                address: {
                    required: true,
                },
                myTown: {
                    checkMyTown: true,
                },
                recaptcha: {
                    required: true,
                    equlaTo: "#captcha",
                },
            },
            messages: {
                email: {
                    required: '此欄位必填',
                    email: '格式有誤',
                    remote: 'email信箱已經註冊'
                },
                pw1: {
                    required: '此欄位必填',
                    maxlength: '須為4-20位英文字母與數字組合',
                    minlength: '須為4-20位英文字母與數字組合',
                },
                pw2: {
                    required: '此欄位必填',
                    equalTo: '兩次輸入密碼不一致',
                },
                cname: {
                    required: '此欄位必填',
                },
                tssn: {
                    required: '此欄位必填',
                    tssn: '格式有誤',
                },
                birthday: {
                    required: '此欄位必填',
                },
                mobile: {
                    required: '此欄位必填',
                    checkphone: '格式有誤',
                },
                address: {
                    required: '此欄位必填',
                },
                myTown: {
                    checkMyTown: '此欄位必填',
                },
                recaptcha: {
                    required: '此欄位必填',
                    equalTo: '驗證失敗，請重新嘗試',
                },
            },
        });


        function getCaptcha() {
            var inputTxt = document.getElementById("captcha");
            inputTxt.value = captchaCode("can", 150, 50, "blue", "white", "28px", 5);
        }
        $(function() {
            getCaptcha();
            // 取得縣市代碼後查詢縣市名稱
            $("#myCity").change(function() {
                var CNo = $('#myCity').val();
                if (CNo == "") {
                    return false;
                }
                $.ajax({
                    // 將縣市名稱從後台取出
                    url: 'Town_ajax.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        CNo: CNo,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            $('#myTown').html(data.m);
                            $('#myZip').val("");
                        } else {
                            alert(data.m);
                        }
                    },
                    error: function(data) {
                        alert("系統目前無法連線至資料庫")
                    }
                });
            });
            $("#myTown").change(function() {
                var AutoNo = $('#myTown').val();
                if (AutoNo == "") {
                    return false;
                }
                $.ajax({
                    url: 'Zip_ajax.php',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        AutoNo: AutoNo,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            $('#myZip').val(data.Post);
                            $('#zipcode').html(data.Post + data.Cityname + data.Name);
                        } else {
                            alert(data.m);
                        }
                    },
                    error: function(data) {
                        alert("系統目前無法連線至資料庫")
                    }
                });
            });
        })
    </script>
</body>

</html>