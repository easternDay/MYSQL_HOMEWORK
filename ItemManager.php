<?php
$mysql_server_name = 'localhost'; //改成自己的mysql数据库服务器
$mysql_username = 'root'; //改成自己的mysql数据库用户名
$mysql_password = '0311Yz1135646268'; //改成自己的mysql数据库密码
$mysql_database = '运动会管理系统'; //改成自己的mysql数据库名

$conn = mysqli_connect($mysql_server_name, $mysql_username, $mysql_password, $mysql_database); //连接数据库

//连接数据库错误提示
if (mysqli_connect_errno($conn)) {
    die("连接 MySQL 失败: " . mysqli_connect_error());
}

mysqli_query($conn, "set names utf8"); //数据库编码格式

if (isset($_POST['Add'])) {
    if ($_POST["status"] == "借出") {
        //如果买了
        $sql = "select * from Items where it_name='{$_POST["name"]}' and it_status='购入'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        if ($row) {
            //如果借出
            $sql = "select * from Items where it_name='{$_POST["name"]}' and it_status='借出'";
            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($query);
            if ($row)
                echo "<script language=\"JavaScript\">alert(\"该物品已被借出，无法再次借出！\");</script>";
            else {
                $sql = "INSERT INTO Items VALUES ('{$_POST['name']}','{$_POST['man']}','{$_POST['status']}','{$_POST['time']}')";
                $query = mysqli_query($conn, $sql);
                file_put_contents('log.txt', $sql, FILE_APPEND);
                if ($query) echo "<script language=\"JavaScript\">alert(\"增加成功\");</script>";
                else echo "<script language=\"JavaScript\">alert(\"增加失败\");</script>";
            }
        } else {
            echo "<script language=\"JavaScript\">alert(\"仓库里没有这件物品\");</script>";
        }
    } elseif ($_POST["status"] == "还回") {
        $sql = "select * from Items where it_name='{$_POST["name"]}' and it_status='借出'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        if ($row) {
            $sql = "delete from Items where it_name='{$_POST["name"]}' and it_status='借出'";
            $query = mysqli_query($conn, $sql);
            file_put_contents('log.txt', $sql, FILE_APPEND);
            if ($query) echo "<script language=\"JavaScript\">alert(\"还回成功\");</script>";
            else echo "<script language=\"JavaScript\">alert(\"还回失败\");</script>";
        } else {
            echo "<script language=\"JavaScript\">alert(\"没人借这个东西哦~\");</script>";
        }
    }elseif ($_POST["status"] == "购入") {
        $sql = "select * from Items where it_name='{$_POST["name"]}' and it_status='购入'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        if ($row) {
            echo "<script language=\"JavaScript\">alert(\"这个东西仓库有了！！！\");</script>";
        } else {
            $sql = "INSERT INTO Items VALUES ('{$_POST['name']}','{$_POST['man']}','{$_POST['status']}','{$_POST['time']}')";
            $query = mysqli_query($conn, $sql);
            file_put_contents('log.txt', $sql, FILE_APPEND);
            if ($query) echo "<script language=\"JavaScript\">alert(\"增加成功\");</script>";
            else echo "<script language=\"JavaScript\">alert(\"增加失败\");</script>";
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>运动会管理系统</title>
</head>
<body>
<!--个人信息-->
<center>
    <h1>运动会管理系统【物品管理】</h1>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825101045 姓名：杨祉</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825102042 姓名：臧雪</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
</center>
<form action='ItemManager.php' method="post" align="center">
    物品: <input size="30" type="text" name="name"><br>
    经办: <input size="30" type="text" name="man"><br>
    状态:
    <label><input name="status" type="checkbox" value="借出"/>借出</label>
    <label><input name="status" type="checkbox" value="购入"/>购入</label>
    <label><input name="status" type="checkbox" value="还回"/>还回</label><br>
    时间: <input size="30" type="datetime-local" name="time"><br>
    <input type="submit" value="增加记录" name='Add'/>
</form>
<table align="center" border="2px" cellpadding="10px">
    <tr>
        <th width="100px">物品</th>
        <th width="50px">经办</th>
        <th width="50px">状态</th>
        <th width="150px">时间</th>
    </tr>
    <?php
    //查询代码
    $sql = "select * from Items order by 4 desc";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr>
                    <td align=\"center\">{$row["it_name"]}</td>
                    <td align=\"center\">{$row["it_man"]}</td>
                    <td align=\"center\">{$row["it_status"]}</td>
                    <td align=\"center\">{$row["it_time"]}</td>
                    </tr>";
    }
    ?>
</table>
</body>
</html>