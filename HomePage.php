<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>运动会管理系统</title>
</head>
<body>
<!--个人信息-->
<center>
    <h1>运动会管理系统</h1>
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
    <table align="center" border="2px">
        <!--文章管理-->
        <form method="post">
            <!--表单-->
            <tr>
                <!--标题-->
                <td aligin="justify" style="font-size:26px;"><strong>【文章管理】</strong></td>
                <!--按钮-->
                <td aligin="justify">
                    <input
                            onclick="window.location.href='PassageManager.php'"
                            style="font-size:18px;"
                            type="button" name="PassageManager"
                            value="进入"
                    >
                </td>
            </tr>
            <tr>
                <!--标题-->
                <td aligin="justify" style="font-size:26px;"><strong>【物品管理】</strong></td>
                <!--按钮-->
                <td aligin="justify">
                    <input
                            onclick="window.location.href='ItemManager.php'"
                            style="font-size:18px;"
                            type="button" name="PassageManager"
                            value="进入"
                    >
                </td>
            </tr>
            <tr>
                <!--标题-->
                <td aligin="justify" style="font-size:26px;"><strong>【比赛安排】</strong></td>
                <!--按钮-->
                <td aligin="justify">
                    <input
                            onclick="window.location.href='MatchManager.php'"
                            style="font-size:18px;"
                            type="button" name="PassageManager"
                            value="进入"
                    >
                </td>
            </tr>
            <tr>
                <!--标题-->
                <td aligin="justify" style="font-size:26px;"><strong>【教练打分】</strong></td>
                <!--按钮-->
                <td aligin="justify">
                    <input
                            onclick="window.location.href='CoachManager.php'"
                            style="font-size:18px;"
                            type="button" name="PassageManager"
                            value="进入"
                    >
                </td>
            </tr>
            <tr>
                <!--标题-->
                <td aligin="justify" style="font-size:26px;"><strong>【运动员管理】</strong></td>
                <!--按钮-->
                <td aligin="justify">
                    <input
                            onclick="window.location.href='AtheleteManager.php'"
                            style="font-size:18px;"
                            type="button" name="PassageManager"
                            value="进入"
                    >
                </td>
            </tr>
            <tr>
                <!--标题-->
                <td aligin="justify" style="font-size:26px;"><strong>【积分查询】</strong></td>
                <!--按钮-->
                <td aligin="justify">
                    <input
                            onclick="window.location.href='ScoreManager.php'"
                            style="font-size:18px;"
                            type="button" name="PassageManager"
                            value="进入"
                    >
                </td>
            </tr>
        </form>
    </table>
</div>
</body>

</html>