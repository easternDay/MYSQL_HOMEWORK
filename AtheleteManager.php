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

if (isset($_GET["ath_name"])) {
    echo "<form hidden style='display:none;' id='form1' name='form1' method='post' action='AtheleteManager.php'>
                      <input name='ath_name' type='text' value='{$_GET["ath_name"]}'/>
                      <input name='ath_college' type='text' value='{$_GET['ath_college']}'/>
                      <input name='ath_grade' type='text' value='{$_GET["ath_grade"]}'/>
                      <input name='ath_class' type='text' value='{$_GET["ath_class"]}'/>
                      <input type=\"text\" value=\"查看\" name=\"REGISTER\"/>
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
    <h1>运动会管理系统【运动员管理】</h1>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825101045 姓名：杨祉</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825102042 姓名：臧雪</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
</center>
<table align="center" border="2px" cellspacing="10">
    <form method="post">
        <tr>
            <td aligin="justify">
                <input type="submit" name="AllATHLETE" value="全部运动员" style="font-size:18px;">
            </td>
            <td aligin="justify">
                <input type="submit" name="REGISTER" value="运动员注册" style="font-size:18px;">
            </td>
        </tr>
    </form>
</table>
<?php
if (isset($_POST['AllATHLETE'])) {
?>
<table align="center" border="1px" cellpadding="5px">
    <tr>
        <th width="5%">比赛项目</th>
        <th width="5%">比赛组别</th>
        <th width="5%">比赛场次</th>
        <th width="5%">姓名</th>
        <th width="5%">院系</th>
        <th width="5%">班级</th>
        <th width="5%">年级</th>
        <th width="5%">成绩</th>
        <th width="5%">排名</th>
        <th width="5%">操作</th>
    </tr>
    <?php
    //查询代码
    $sql = "select a.*,s.sp_name,sc.sc_score,sc_rank from athlete a left join sports s on a.ath_game_id = s.sp_id LEFT JOIN score sc on sc.sc_athlete_name=a.ath_name and sc.sc_game_id=a.ath_game_id ORDER BY sp_name;";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr>
                <form action=\"AtheleteManager.php\" method=\"post\">
                    <td align='center'><input size='5' readonly='readonly' type='text' name='sp_name' value='{$row['sp_name']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='ath_team' value='{$row['ath_team']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='ath_game_id' value='{$row['ath_game_id']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='ath_name' value='{$row["ath_name"]}'/></td>
                    <td align='center'><input size='15' readonly='readonly' type='text' name='ath_college' value='{$row['ath_college']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='ath_class' value='{$row['ath_class']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='ath_grade' value='{$row['ath_grade']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='sc_score' value='{$row['sc_score']}'/></td>
                    <td align='center'><input size='5' readonly='readonly' type='text' name='sc_rank' value='{$row['sc_rank']}'/></td>
                    <td align=\"center\">
                        <input type=\"submit\" value=\"查看\" name=\"REGISTER\"/>
                        <input type=\"submit\" value=\"删除\" name=\"DELETE\"/>
                    </td>
                </form>
                </tr>";
    }
    ?>

    <?php
    } elseif (isset($_POST['REGISTER'])) {
        ?>
        <table align="center" border="1px" cellpadding="5px">
            <tr>
                <form action="AtheleteManager.php" method="post">
                    <td>
                        姓名:<br>
                        <input type="text" name="ath_name"
                               value="<?php echo isset($_POST['ath_name']) ? $_POST['ath_name'] : ""; ?>">
                        <br>
                        院系:<br>
                        <input type="text" name="ath_college"
                               value="<?php echo isset($_POST['ath_college']) ? $_POST['ath_college'] : ""; ?>">
                    </td>
                    <td>
                        年级:<br>
                        <input type="text" name="ath_grade"
                               value="<?php echo isset($_POST['ath_grade']) ? $_POST['ath_grade'] : ""; ?>">
                        <br>
                        班级:<br>
                        <input type="text" name="ath_class"
                               value="<?php echo isset($_POST['ath_class']) ? $_POST['ath_class'] : ""; ?>">
                    </td>
                    <td colspan="2">
                        比赛：<br>
                        <?php
                        $sql = "select sp_id,sp_name,sp_type from Sports";
                        $query = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($query)) {
                            echo "<label><input name=\"ath_game_id\" type=\"radio\" value=\"{$row['sp_id']}-{$row['sp_name']}-{$row['sp_type']}\"/>{$row['sp_id']}-{$row['sp_name']}-{$row['sp_type']}</label><br>";
                        }
                        ?>
                        <br>
                        <input type="submit" value="报名" name="ADDSPORTS"/>
                    </td>
                </form>
            </tr>
            <tr>
                <th>队名</th>
                <th>项目-场次</th>
                <th>分数</th>
                <th>排名</th>
            </tr>
            <?php
            //查询代码
            if (isset($_POST['ath_name'])) {
                $sql = "select a.*,s.*,sc.* from athlete a left join sports s on a.ath_game_id = s.sp_id LEFT JOIN score sc on sc.sc_athlete_name=a.ath_name and sc.sc_game_id=a.ath_game_id where a.ath_name='{$_POST['ath_name']}' ORDER BY sp_name";
                $query = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($query)) {
                    echo "<tr>
                                    <td align='center'><input size='5' readonly='readonly' type='text' name='ath_team' value='{$row['ath_team']}'/></td>
                                    <td align='center'>项目：<input size='5' readonly='readonly' type='text' name='sp_name' value='{$row['sp_name']}'/>场次：<input size='5' readonly='readonly' type='text' name='ath_game_id' value='{$row['sp_id']}'/></td>
                                    <td align='center'><input size='5' readonly='readonly' type='text' name='sc_score' value='{$row['sc_score']}'/></td>
                                    <td align='center'><input size='5' readonly='readonly' type='text' name='sc_rank' value='{$row['sc_rank']}'/></td>
                                </tr>";

                }
            }
            ?>
        </table>
        <?php
    } elseif (isset($_POST['DELETE'])) {
        //删除成绩
        $sql = "delete from Score where sc_athlete_name='{$_POST["ath_name"]}' and sc_game_id='{$_POST["ath_game_id"]}'";
        $query = mysqli_query($conn, $sql);
        /*
        if ($query)
            echo "<script language=\"JavaScript\">alert(\"删除成绩成功\");</script>";
        else {
            echo "<script language=\"JavaScript\">alert(\"删除成绩失败\");</script>";
        }*/
        //删除运动员
        $sql = "delete from Athlete where ath_name='{$_POST["ath_name"]}' and ath_game_id='{$_POST["ath_game_id"]}'";
        $query = mysqli_query($conn, $sql);
        if ($query)
            echo "<script language=\"JavaScript\">alert(\"删除本场比赛运动员成功\");</script>";
        else {
            echo "<script language=\"JavaScript\">alert(\"删除本场比赛运动员失败\");</script>";
        }
    } elseif (isset($_POST['ADDSPORTS'])) {
        //删除成绩
        $str = explode("-", $_POST['ath_game_id']);
        //print_r($str);
        $sql = "INSERT INTO Athlete VALUES('{$_POST['ath_name']}','{$_POST['ath_college']}','{$_POST['ath_class']}','{$_POST['ath_grade']}','{$str[2]}','{$str[0]}')";
        $query = mysqli_query($conn, $sql);
        file_put_contents('log.txt', $sql, FILE_APPEND);
        if ($query)
            echo "<script language=\"JavaScript\">alert(\"报名成功\");</script>";
        else {
            echo "<script language=\"JavaScript\">alert(\"报名失败\");</script>";
        }
    }
    ?>
</table>
</body>
</html>