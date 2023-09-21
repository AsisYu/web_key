<?php
    //引入数据库配置文件或者直接写在这里，注意安全性
        include '../dbconfig.php';
    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        die('Could not Connect MySQL Server: ' . $conn->connect_error);
    }

    if(isset($_POST['login'])) {
        $username = $_POST['usname'];
        $password = $_POST['uspassword'];
    
        $sql = "SELECT * FROM adminuser WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();

        $scripts = '';
        $scripts = '';
        if($stmt->num_rows > 0) {
			// 生成cookie
			$cookie_name = "user";
			$cookie_value = "John";
			$expiry = time() + (3600 * 30); // 设置过期时间（86400秒是一天的时间）
			setcookie($cookie_name, $cookie_value, $expiry, "/"); // 设置cookie并保存在根目录
			
			// 检查cookie是否存在
			if(isset($_COOKIE[$cookie_name])) {
			    $scripts .= '<script type="text/javascript">
			                     $(document).ready(function(){
			                         animateBox();
			                     });
			                 </script>';
							 header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
							 header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
							 header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
							 header("Cache-Control: post-check=0, pre-check=0", false);
							 header("Pragma: no-cache");
			} else {
			    header("Location: ".$_SERVER['PHP_SELF']); // 重定向到当前页面

			}
        }else{
			echo "<script type='text/javascript'>alert('账号密码错误！')</script>";
		}

        $stmt->free_result();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://os.qwp.icu/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/btncg.js"></script>
    <link id="icon" rel="shortcut icon" href="https://ys.mihoyo.com/main/favicon.ico">    
    <link rel="stylesheet" href="css/style.css">
    <title>管理员后台页</title>
    <style>
        .box {
            transition: opacity 0.5s;
            opacity: 1;
        }

        .hidden {
            display: none;
        }
    </style>
    <?php echo $scripts; ?>
</head>
<body>
    <div class="box" id="box">
        <h2>Login</h2>
        <form method="post" action="">
            <div class="input-box">
                <label>账号</label>
                <input type="text" id="usname" name="usname">
            </div>
            <div class="input-box">
                <label>密码</label>
                <input type="password" id="uspassword" name="uspassword">
            </div>
            <div class="btn-box">
                <div>
                    <input type="submit" name="login" value="登录">
                </div>
            </div>
        </form>
    </div>

     <div class="box2" id="box2" style="display: none;">
        <input type="number" id="numOfKeys" min="1" placeholder="&nbsp;&nbsp;&nbsp;请输入要生成的密钥数量">
        <div class="btn2">
            <div class="btn-box">
                <button onclick="addKeys()">生成并添加 Key</button>
            </div>
            <div class="btn-box">
                <button onclick="exportKeys()">导出密钥</button>
            </div>
        </div>
        <script src="js/openkey.js"></script>
    </div>
</body>
</html>
