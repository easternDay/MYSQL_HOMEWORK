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

if (isset($_POST['ADD'])) {
    $sql = "select * from Sports where sp_id='{$_POST["id"]}'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if ($row) {
        echo "<script language=\"JavaScript\">alert(\"该比赛场次已存在\");</script>";
    } else {
        $sql = "INSERT INTO Sports VALUES ('{$_POST['id']}','{$_POST['name']}','{$_POST['type']}','{$_POST['time']}')";
        $query = mysqli_query($conn, $sql);
        if ($query)
            echo "<script language=\"JavaScript\">alert(\"增加成功\");</script>";
        else {
            echo "<script language=\"JavaScript\">alert(\"增加失败\");</script>";
        }
    }
} elseif (isset($_POST['UPDATE'])) {
    $sql = "select * from Sports where sp_id='{$_POST["id"]}'";
    //file_put_contents('log.txt', $sql, FILE_APPEND);
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if ($row) {
        $sql = "Update Sports set sp_name='{$_POST['name']}',sp_type='{$_POST['type']}',sp_time='{$_POST['time']}' where sp_id='{$_POST["id"]}'";
        //file_put_contents('log.txt', $sql, FILE_APPEND);
        $query = mysqli_query($conn, $sql);
        if ($query)
            echo "<script language=\"JavaScript\">alert(\"更新成功\");</script>";
        else {
            echo "<script language=\"JavaScript\">alert(\"更新失败\");</script>";
        }
    } else {
        echo "<script language=\"JavaScript\">alert(\"该比赛场次不存在！\");</script>";
    }

} elseif (isset($_POST['DELETE'])) {
    $sql = "select * from Sports where sp_id='{$_POST["id"]}'";
    //file_put_contents('log.txt', $sql, FILE_APPEND);
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    if ($row) {
        $sql = "delete from Sports where sp_id='{$_POST["id"]}'";
        //file_put_contents('log.txt', $sql, FILE_APPEND);
        $query = mysqli_query($conn, $sql);
        if ($query)
            echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
        else {
            echo "<script language=\"JavaScript\">alert(\"删除失败\");</script>";
        }
    } else {
        echo "<script language=\"JavaScript\">alert(\"该比赛场次不存在！\");</script>";
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
    <h1>运动会管理系统【比赛安排】</h1>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825101045 姓名：杨祉</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825102042 姓名：臧雪</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
</center>
<table align="center" border="2px" cellpadding="10px">
    <tr>
        <th width="50px">比赛场次</th>
        <th width="50px">比赛内容</th>
        <th width="50px">比赛赛道</th>
        <th width="150px">比赛时间</th>
        <th width="100px">操作</th>
        <th width="150px" rowspan="2">运动员</th>
        <th width="150px" rowspan="2">裁判</th>
    </tr>
    <tr>
        <form action="MatchManager.php" method="post">
            <td align="center"><input type="text" name="id"/></td>
            <td align="center">
                <label><input name="name" type="radio" value="篮球"/>篮球</label>
                <label><input name="name" type="radio" value="足球"/>足球</label>
                <label><input name="name" type="radio" value="田径"/>田径</label>
                <label><input name="name" type="radio" value="乒乓"/>乒乓</label>
                <label><input name="name" type="radio" value="游泳"/>游泳</label>
            </td>
            <td align="center">
                <label><input name="type" type="radio" value="A"/>A</label>
                <label><input name="type" type="radio" value="B"/>B</label>
                <label><input name="type" type="radio" value="C"/>C</label>
                <label><input name="type" type="radio" value="D"/>D</label>
                <label><input name="type" type="radio" value="E"/>E</label>
            </td>
            <td align="center"><input type="datetime-local" name="time"/></td>
            <td align="center">
                <input type="submit" value="增加记录" name="ADD"/>
            </td>
        </form>
    </tr>
    <?php
    //查询代码
    $sql = "select * from Sports order by 1 desc";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($query)) {
        $row["sp_time"] = str_replace(" ", "T", $row["sp_time"]);
        $checked_name_arr = array("", "", "", "", "");
        $checked_type_arr = array("", "", "", "", "");
        switch ($row["sp_name"]) {
            case "篮球":
                $checked_name_arr[0] = "checked";
                break;
            case "足球":
                $checked_name_arr[1] = "checked";
                break;
            case "田径":
                $checked_name_arr[2] = "checked";
                break;
            case "乒乓":
                $checked_name_arr[3] = "checked";
                break;
            case "游泳":
                $checked_name_arr[4] = "checked";
                break;
        }
        switch ($row["sp_type"]) {
            case "A":
                $checked_type_arr[0] = "checked";
                break;
            case "B":
                $checked_type_arr[1] = "checked";
                break;
            case "C":
                $checked_type_arr[2] = "checked";
                break;
            case "D":
                $checked_type_arr[3] = "checked";
                break;
            case "E":
                $checked_type_arr[4] = "checked";
                break;
        }
        echo "<tr>
                <form action=\"MatchManager.php\" method=\"post\">
                    <td align=\"center\"><input readonly=\"readonly\" type=\"number\" name=\"id\" value='{$row["sp_id"]}'/></td>
                    <td align=\"center\">
                        <label><input name=\"name\" type=\"radio\" value=\"篮球\" {$checked_name_arr[0]}/>篮球</label>
                        <label><input name=\"name\" type=\"radio\" value=\"足球\" {$checked_name_arr[1]}/>足球</label>
                        <label><input name=\"name\" type=\"radio\" value=\"田径\" {$checked_name_arr[2]}/>田径</label>
                        <label><input name=\"name\" type=\"radio\" value=\"乒乓\" {$checked_name_arr[3]}/>乒乓</label>
                        <label><input name=\"name\" type=\"radio\" value=\"游泳\" {$checked_name_arr[4]}/>游泳</label>
                    </td>
                    <td align=\"center\">
                        <label><input name=\"type\" type=\"radio\" value=\"A\" {$checked_type_arr[0]}/>A</label>
                        <label><input name=\"type\" type=\"radio\" value=\"B\" {$checked_type_arr[1]}/>B</label>
                        <label><input name=\"type\" type=\"radio\" value=\"C\" {$checked_type_arr[2]}/>C</label>
                        <label><input name=\"type\" type=\"radio\" value=\"D\" {$checked_type_arr[3]}/>D</label>
                        <label><input name=\"type\" type=\"radio\" value=\"E\" {$checked_type_arr[4]}/>E</label>
                    </td>
                    <td align=\"center\"><input type=\"datetime-local\" name=\"time\" value='{$row["sp_time"]}'/></td>
                    <td align=\"center\">
                        <input type=\"submit\" value=\"修改\" name=\"UPDATE\"/>
                        <input type=\"submit\" value=\"删除\" name=\"DELETE\"/>
                    </td>
                    <td>";

        $sql_new = "select * from athlete where ath_game_id={$row["sp_id"]}";
        $query_new = mysqli_query($conn, $sql_new);
        //print_r($query_new);

        while ($row_new = mysqli_fetch_array($query_new)) {
            echo "|";
            echo "<a href='AtheleteManager.php?ath_name={$row_new["ath_name"]}&ath_college={$row_new['ath_college']}&ath_grade={$row_new['ath_grade']}&ath_class={$row_new['ath_class']}'>{$row_new["ath_name"]}</a>";
            echo "|";
        }


        echo "</td><td>";
        $sql_new = "select * from Coach where co_game_id={$row["sp_id"]}";
        $query_new = mysqli_query($conn, $sql_new);
        //print_r($query_new);

        while ($row_new = mysqli_fetch_array($query_new)) {
            echo "|";
            echo "<a href='CoachManager.php?co_name={$row_new["co_name"]}&sp_id={$row_new["co_game_id"]}'>{$row_new["co_name"]}</a>";
            echo "|";
        }
        echo "</td></form>
                </tr>";
    }
    ?>
</table>
</body>
</html>