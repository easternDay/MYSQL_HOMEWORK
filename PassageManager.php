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
    <h1>运动会管理系统【文章管理】</h1>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825101045 姓名：杨祉</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
    <div style="width:fit-content;border:3px dashed gray;padding:10px 100px;display: inline-block;">
        <h4>学号：1825102042 姓名：臧雪</h4>
        <h4>班级：计算机科学与技术一班</h4>
    </div>
</center>
<div style="margin: 50px">
    <table align="center" border="2px" cellspacing="10">
        <form method="post">
            <tr>
                <td aligin="justify">
                    <input type="submit" name="AllPassage" value="全部文章" style="font-size:18px;">
                </td>
                <td aligin="justify">
                    <input type="submit" name="AddPassage" value="新增文章" style="font-size:18px;">
                </td>
            </tr>
        </form>
    </table>
    <?php
    if (isset($_POST['AllPassage'])) {
        echo "
                <table align=\"center\" border=\"2px\">
                <tr>
                    <th width=\"100px\">标题</th>
                    <th width=\"50px\">作者</th>
                    <th width=\"150px\">院系</th>
                    <th colspan=\"2\">内容</th>
                    <th width=\"50px\">操作</th>
                </tr>
                ";
        //查询代码
        $sql = "select * from Passages";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>
                    <td align=\"center\">{$row["pa_title"]}</td>
                    <td align=\"center\">{$row["pa_writer"]}</td>
                    <td align=\"center\">{$row["pa_college"]}</td>
                    <td colspan=\"2\">{$row["pa_content"]}</td>
                    <td align=\"center\">
                        <a href='PassageManager.php?title={$row["pa_title"]}&writer={$row["pa_writer"]}'>操作</a>
                    </td>
                    </tr>";
        }
        echo "</table>";
    } elseif (isset($_POST['AddPassage'])) {
        //Header("Location:PassageManager.php?title=新增文章&writer=作者名");
        echo"<script>url=\"PassageManager.php?title=新增文章&writer=作者名\";window.location.href=url;</script> ";
    } elseif (isset($_GET["title"])) {
        //查询代码
        $sql = "select * from Passages where pa_title='{$_GET["title"]}' and pa_writer='{$_GET["writer"]}'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        $row = $row ? $row : array("pa_college" => null, "pa_content" => null);
        echo "
                <form action='PassageManager.php' method=\"post\" align=\"center\">
                    标题: <br><input size=\"100\" type=\"text\" name=\"title\" value={$_GET["title"]}><br>
                    作者: <br><input size=\"100\" type=\"text\" name=\"writer\" value={$_GET["writer"]}><br>
                    院系: <br><input size=\"100\" type=\"text\" name=\"college\" 
                        value={$row['pa_college']}
                    ><br>
                    内容: <br><textarea name=\"content\" rows=\"20\" cols=\"100\">{$row['pa_content']}</textarea><br>
                    <input type=\"submit\" value=\"更改|增加\" name='AddOrUpdate'/>
                    <input type=\"submit\" value=\"删除\" name='Delete'/>
                </form>
                ";
    } elseif (isset($_POST['AddOrUpdate'])) {
        $sql = "select * from Passages where pa_title='{$_POST["title"]}' and pa_writer='{$_POST["writer"]}'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        if ($row) {
            $sql = "Update Passages set pa_content='{$_POST['content']}',pa_college='{$_POST['college']}'  where pa_title='{$_POST["title"]}' and pa_writer='{$_POST["writer"]}'";
            file_put_contents('log.txt', $sql, FILE_APPEND);
            $query = mysqli_query($conn, $sql);
            if ($query) echo "<script language=\"JavaScript\">alert(\"修改成功\");</script>";
            else echo "<script language=\"JavaScript\">alert(\"修改失败\");</script>";
        } else {
            $sql = "INSERT INTO Passages (pa_title,pa_writer,pa_content,pa_college) VALUES ('{$_POST['title']}','{$_POST['writer']}','{$_POST['content']}','{$_POST['college']}')";
            $query = mysqli_query($conn, $sql);
            file_put_contents('log.txt', $sql, FILE_APPEND);
            if ($query) echo "<script language=\"JavaScript\">alert(\"增加成功\");</script>";
            else echo "<script language=\"JavaScript\">alert(\"增加失败\");</script>";
        }
    } elseif (isset($_POST['Delete'])) {
        $sql = "select * from Passages where pa_title='{$_POST["title"]}' and pa_writer='{$_POST["writer"]}'";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        if ($row) {
            $sql = "delete from Passages where pa_title='{$_POST["title"]}' and pa_writer='{$_POST["writer"]}'";
            file_put_contents('log.txt', $sql, FILE_APPEND);
            $query = mysqli_query($conn, $sql);
            if ($query) echo "<script language=\"JavaScript\">alert(\"删除成功\");</script>";
            else echo "<script language=\"JavaScript\">alert(\"删除失败\");</script>";
        } else {
            echo "<script language=\"JavaScript\">alert(\"不存在这篇文章！\");</script>";
        }
    } ?>
</div>
</body>

</html>