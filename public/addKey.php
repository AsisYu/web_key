<?php
    //引入数据库配置文件或者直接写在这里，注意安全性
    include 'dbconfig.php';

    // 创建与数据库的连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查数据库连接
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 获取要生成的密钥数量
$keyCount = $_POST["keyCount"];

// 生成并插入密钥到数据库
for ($i = 0; $i < $keyCount; $i++) {
    $key = uniqid(); // 使用uniqid()函数生成一个唯一的秘钥

    // 将密钥插入数据库
    $sql = "INSERT INTO keys_table (key_value) VALUES ('$key')";

    if ($conn->query($sql) !== TRUE) {
        echo "生成并添加密钥时出错： " . $conn->error;
        $conn->close();
        return;
    }
}

echo "成功添加 " . $keyCount . " 个密钥";
$conn->close();
?>