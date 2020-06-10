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

if (isset($_POST['WATCH'])) {
    $sql = "INSERT INTO Coach VALUES('{$_POST['co_name']}','{$_POST['co_game_id']}')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        echo "<script language=\"JavaScript\">alert(\"成功添加监管\");</script>";
    } else {
        echo "<script language=\"JavaScript\">alert(\"添加监管失败\");</script>";
    }
} elseif (isset($_POST["SCOREADJUST"])) {
    $sql = "SELECT * FROM Score WHERE sc_athlete_name='{$_POST["ath_name"]}' AND sc_game_id='{$_POST["sp_id"]}'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if ($row) {
        $sql = "UPDATE Score SET sc_score='{$_POST["sc_score"]}' WHERE sc_athlete_name='{$_POST["ath_name"]}' AND sc_game_id='{$_POST["sp_id"]}'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo "<script language=\"JavaScript\">alert(\"更新成绩成功\");</script>";
        } else {
            echo "<script language=\"JavaScript\">alert(\"更新成绩失败\");</script>";
        }
    } else {
        $sql = "INSERT INTO Score VALUES('{$_POST["ath_name"]}','{$_POST["sp_id"]}','{$_POST["sc_score"]}','{$_POST["sc_rank"]}')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo "<script language=\"JavaScript\">alert(\"确认成绩成功\");</script>";
        } else {
            echo "<script language=\"JavaScript\">alert(\"确认成绩失败\");</script>";
        }
    }
    //刷新排名
    $sql = "SELECT * FROM Score WHERE sc_game_id='{$_POST["sp_id"]}' ORDER BY 3 DESC";
    $query = mysqli_query($conn, $sql);
    $array = array();
    while ($row = mysqli_fetch_array($query)) {
        array_push($array, $row);
    }
    $rank = 0;
    foreach ($array as $row) {
        $rank++;
        //print_r($row);
        $sql = "UPDATE Score SET sc_rank='$rank' WHERE sc_game_id='{$row["sc_game_id"]}' AND sc_athlete_name='{$row["sc_athlete_name"]}'";
        $query = mysqli_query($conn, $sql);
    }
}elseif (isset($_GET["co_name"])){
    //isset($_POST["ADJUST"]) and $_POST["co_name"] == $row["co_name"]
    echo "<form hidden style='display:none;' id='form1' name='form1' method='post' action='CoachManager.php'>
                      <input name='co_name' type='text' value='{$_GET["co_name"]}'/>
                      <input name='sp_id' type='text' value='{$_GET["sp_id"]}'/>
                      <input type=\"text\" value=\"查看\" name=\"ADJUST\"/>
                    </form>
            <script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";

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
    <h1>运动会管理系统【教练员管理】</h1>
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
        <form action="CoachManager.php" method="post">
            <td align='center'>教练姓名：<input size='5' type='text' name='co_name''/></td>
            <td align='center' colspan="2">监管场次：
                <?php
                $sql = "select sp_id,sp_name,sp_type from Sports";
                $query = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    echo "<label><input name=\"co_game_id\" type=\"radio\" value=\"{$row['sp_id']}\"/>{$row['sp_id']}-{$row['sp_name']}-{$row['sp_type']}</label>";
                }
                ?>
            </td>
            <td align="center">
                <input size="15" type="submit" value="监管" name="WATCH"/>
            </td>
        </form>
    </tr>
    <tr>
        <th width="5%">比赛项目</th>
        <th width="5%">比赛组别</th>
        <th width="5%">比赛场次</th>
        <th width="5%">教练</th>
        <th width="5%">操作</th>
    </tr>
    <?php
    //查询代码
    $sql = "SELECT c.co_name,s.* FROM coach c LEFT JOIN sports s ON c.co_game_id=s.sp_id;";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr>
                <form action=\"CoachManager.php\" method=\"post\">
                    <td align='center'><input size='5' readonly='readonly' type='text' name='sp_name' value='{$row['sp_name']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='sp_type' value='{$row['sp_type']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='sp_id' value='{$row['sp_id']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='co_name' value='{$row["co_name"]}'/></td>
                    <td align=\"center\">
                        <input type=\"submit\" value=\"打分\" name=\"ADJUST\"/>
                    </td>
                </form>
                </tr>";
        if (isset($_POST["ADJUST"]) and $_POST["co_name"] == $row["co_name"]) {
            //SELECT a.*,s.sp_name FROM athlete a LEFT JOIN sports s ON a.ath_game_id=s.sp_id where a.ath_game_id=1;
            $sql_new0 = "SELECT * FROM athlete where ath_game_id='{$_POST['sp_id']}';";
            $query_new0 = mysqli_query($conn, $sql_new0);
            if ($query_new0) {
                ?>
                <tr>
                    <th></th>
                    <th>选手信息</th>
                    <th>成绩</th>
                    <th>排名</th>
                    <th>操作</th>
                </tr>
                <?php
                while ($row_new0 = mysqli_fetch_array($query_new0)) {
                    echo "<tr>";
                    echo "<td></td>";
                    echo "<form action=\"CoachManager.php\" method=\"post\">";
                    echo "<td align='center'>
                            <input hidden size='5' readonly='number' type='text' name='sp_id' value='{$_POST['sp_id']}'/>
                            <input size='15' readonly='number' type='text' name='ath_name' value='{$row_new0['ath_name']}'/>
                            <br>
                            <input size='15' readonly='number' type='text' value='{$row_new0['ath_college']}'/>
                            <br>
                            <input size='15' readonly='number' type='text' value='{$row_new0['ath_class']}-{$row_new0['ath_grade']}'/>
                            </td>";

                    $sql_NEW = "SELECT * FROM Score where sc_athlete_name='{$row_new0['ath_name']}' AND sc_game_id='{$_POST['sp_id']}';";
                    $query_NEW = mysqli_query($conn, $sql_NEW);
                    $row_NEW = mysqli_fetch_array($query_NEW);
                    if (!$row_NEW) {
                        $row_NEW = array("sc_score" => 0, "sc_rank" => -1);
                    }
                    echo "<td align='center'><input size='5' type='number' name='sc_score' value='{$row_NEW['sc_score']}'/></td>";
                    echo "<td align='center'><input size='5' readonly='number' type='text' name='sc_rank' value='{$row_NEW['sc_rank']}'/></td>";
                    echo "<td align=\"center\"><input type=\"submit\" value=\"确认分数\" name=\"SCOREADJUST\"/></td>";
                    echo "</form>";
                    echo "</tr>";
                }
            }
        }
    }
    ?>
</table>
</body>
</html>