<?php 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INHA-Pot</title>
</head>

<body>
    <h1>회원가입</h1>
    <form action="./member_ok.php" method="POST">
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" placeholder="이름"></td>
            </tr>
            <tr>
                <td>ID</td>
                <td><input type="text" name="userid" placeholder="아이디"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="userpw" placeholder="비밀번호"></td>
            </tr>
        </table>
        <input type="submit" value="회원가입">
    </form>
</body>

</html>