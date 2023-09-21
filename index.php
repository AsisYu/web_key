<?php
//引入数据库配置文件
    include 'public/dbconfig.php';

// 获取用户输入的key
$userKey = isset($_POST['key']) ? $_POST['key'] : "";

// 验证用户输入的key是否与数据库中的key匹配
function verifyKey($userKey, $dbKeys) {
    return in_array($userKey, $dbKeys);
}

// 连接数据库并获取全部key
$dbKeys = array();
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "SELECT key_value FROM keys_table";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dbKeys[] = $row["key_value"];
        }
    }
}
// 如果用户已经提交了key，执行验证逻辑
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
		//key对比
		if (verifyKey($userKey, $dbKeys)) {
			//key_uer对比
			// 准备SQL查询语句
			$sql_1 = "SELECT key_use FROM keys_table WHERE key_value = '$userKey' AND key_use = 0";
			
			// 执行SQL查询
			$result_2 = $conn->query($sql_1);
			// 检查查询结果
			if ($result_2 && $result_2->num_rows > 0) {
			
				//修改数据库中的key_use值为1
				$sql_2 = "UPDATE keys_table SET key_use = 1 WHERE key_value = '$userKey'";
				$conn->query($sql_2);
				// key验证成功，跳转到index.html
				header("Location: index.html");
				// 生成唯一的cookie
				function generateUniqueCookie() {
					$cookieName = "myCookie";
					$cookieValue = uniqid(); // 使用uniqid()生成唯一ID作为cookie的值
					$cookieExpiration = time() + (86400 * 30); // 设置过期时间为30天
				
					setcookie($cookieName, $cookieValue, $cookieExpiration, "/");
				}
				
				generateUniqueCookie();
				exit();
			} else {
						//key已使用
						echo "<script type='text/javascript'>alert('key不存在或已经被使用！')</script>";
					}
		} else {
					// key验证失败
					echo "<script type='text/javascript'>alert('key不存在或已经被使用！')</script>";
				}
}
    $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Key Validation</title>
<script src="public/user/js/index_checkCookieExists.js"></script>
<link id="icon" rel="shortcut icon" href="https://ys.mihoyo.com/main/favicon.ico">
<link rel="stylesheet" href="public/user/css/style.css">
<style>
	.box{
		width:100%;
		height:100%;
	}
	.box form{
		height: 70%;
		width: 60%;
		display: flex;
		justify-content: center;
		align-content: flex-end;
		flex-wrap: nowrap;
		flex-direction: column;
		align-items: center;
	}
	.box form label{
		color: rgba(255,255,255,0.9);
		font-size:50px;
		margin:7%;
	}
	
	.box form input{
		letter-spacing: 1px;
		font-size: 20px;
		box-sizing: border-box;
		width: 490px;
		height: 35px;
		border-radius: 5px;
		border: 1px solid rgba(255,255,255,0.5);
		background: rgba(255,255,255,0.2);
		outline: none;
		padding: 0 12px;
		color: rgba(255,255,255,0.9);
		transition: 0.2s;
	}
	.box form button{
		margin-top:10%;
		font-size:25px;
		width: 120px;
		height: 50px;
		color: rgba(255,255,255,0.9);
		border: 1px solid rgba(192, 119, 91, 0.7);
		background: rgba(192, 119, 91, 0.5);
		border-radius: 7px;
	}
	.box form button:hover{
		border: 1px solid rgba(251, 128, 71, 0.7);
		background: rgba(251, 128, 71, 0.5);
	}
</style>
</head>
<body>
	<div class="box">
		<!-- 显示输入框 -->
		<form method="POST">
			<label for="key">请输入 key </label>
			<input type="text" id="key" name="key">
			<button type="submit">Submit</button>
		</form>
	</div>
</body>
</html>
