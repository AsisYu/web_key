<?php
   //引入数据库配置文件或者直接写在这里，注意安全性
    include 'dbconfig.php';

    // 创建与数据库的连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 检查数据库连接
    if ($conn->connect_error) {
        die("数据库连接失败: " . $conn->connect_error);
    }

    // 查询数据库中的密钥
    $sql = "SELECT key_value FROM keys_table";
    $result = $conn->query($sql);

    // 导出密钥到文本文件
    if ($result->num_rows > 0) {
        $filename = "keys.txt";
        $file = fopen($filename, "w");

        while ($row = $result->fetch_assoc()) {
            fwrite($file, $row["key_value"] . "\n");
        }

        fclose($file);

        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=".$filename);
        readfile($filename);

        unlink($filename); // 删除临时文件
    }
    else {
        echo "没有密钥可导出";
    }

    $conn->close();
?>
