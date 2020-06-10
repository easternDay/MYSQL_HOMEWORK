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
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>运动会管理系统</title>
</head>
<body>
<!--个人信息-->
<center>
    <h1>运动会管理系统【积分查询】</h1>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825101045 姓名：杨祉</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825102042 姓名：臧雪</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
</center>
<table align="center" border="1px" cellpadding="5px">
    <tr>
        <?php
        //select id,distinct name from user
        $sql = "SELECT DISTINCT sp.* FROM Score s LEFT JOIN Sports sp ON s.sc_game_id = sp.sp_id; ";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            echo "<td align='center'>";
            echo $row["sp_id"] . "-" . $row["sp_name"] . $row["sp_type"];
            echo "<br>";
            echo "<a href='ScoreManager.php?sc_game_id={$row["sp_id"]}&type=sc_rank'>个人排名</a><br>";
            echo "<a href='ScoreManager.php?sc_game_id={$row["sp_id"]}&type=ath_college'>学院整合</a>";
            echo "</td>";
        }
        ?>
    </tr>
</table>
<table align="center" border="1px" cellpadding="5px">
    <tr>
        <th>姓名</th>
        <th>学院</th>
        <th>班级</th>
        <th>年级</th>
        <th>分数</th>
        <th>排名</th>
    </tr>
    <?php
    //SELECT s.sc_score,s.sc_rank,a.* FROM Score s LEFT JOIN athlete a ON s.sc_game_id = a.ath_game_id AND s.sc_athlete_name=a.ath_name WHERE s.sc_game_id=3;
    if (isset($_GET["sc_game_id"])) {
        $sql = "SELECT s.sc_score,s.sc_rank,a.* FROM Score s LEFT JOIN athlete a ON s.sc_game_id = a.ath_game_id AND s.sc_athlete_name=a.ath_name WHERE s.sc_game_id={$_GET["sc_game_id"]} ORDER BY " . $_GET["type"];
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td align='center'>{$row['ath_name']}</td>";
            echo "<td align='center'>{$row['ath_college']}</td>";
            echo "<td align='center'>{$row['ath_class']}</td>";
            echo "<td align='center'>{$row['ath_grade']}</td>";
            echo "<td align='center'>{$row['sc_score']}</td>";
            echo "<td align='center'>{$row['sc_rank']}</td>";
            echo "</tr>";
        }
    }

    ?>
</table>
</body>
</html>