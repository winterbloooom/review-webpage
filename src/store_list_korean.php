<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  '111111',
  'web11'
);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/topbar.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="https://kit.fontawesome.com/78e43f918f.js" crossorigin="anonymous"></script>
    <title>목록 - 한식</title>  타이틀도 php에서 category로 가져오기
</head>

<body>
    <a href="index.html"><i class="fas fa-arrow-left fa-2x"></i></a>
    <h1>한식</h1>
    <ol>  -나중에는 박스에 넣기
        <?php
    $sql = "SELECT name, star, review_amount, main_menu, main_menu_price FROM stores";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($result)){
      echo "{$row['name']}, {$row['star']}, {$row['review_amount']}, {$row['main_menu']}, {$row['main_menu_price']}";
    }
    </ol>
</body>

</html>
