<?php
session_start();

$conn = mysqli_connect(
  'localhost',
  'inhapot',
  'inha8302#11',
  'inhapot'
);

$sql = "SELECT * FROM stores WHERE id='{$_GET['store_id']}'";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){
  $name = $row['name'];
  $star = $row['star'];
  $review_amount = $row['review_amount'];
  $address = $row['address'];
  $hour = $row['hour'];
  $tel = $row['tel'];
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <script src="https://kit.fontawesome.com/78e43f918f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/restaurant.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <title><?=$name?></title>
</head>

<body>
    <div class="container">
        <div class="top">
            <input type="button" class="btn" onclick="location.href='javascript:history.back()';" value="back">
            <input type="button" class="btn1" onclick="location.href='../index.php';" value="home">
        </div>
        <div class="title">
            <b><?=$name?></b><br>
            <?php
            $star_origin = $star;
            for($i=5; $i>0; $i--){
              if($star > 0){
                echo "<span class=\"fa fa-star checked\"></span>";
                $star = $star - 1;
              } else{
                echo "<span class=\"fa fa-star\"></span>";
              }
            }
            echo "($review_amount)";

           ?>
        </div>
        <table>
            <td id="share"><a id="kakao-link-btn" href="javascript:sendLink()">카카오톡으로 공유하기</a></td>
            <script type="text/javascript">
            Kakao.init('2d9e02bbf3e491073a84b72ed8376f1f');

            function sendLink() {
                Kakao.Link.sendCustom({
                    templateId: 34900,
                    templateArgs: {
                        title: 'INHA-POT',
                        description: 'http://inhapot.dothome.co.kr/src/store_page.php?store_id=<?=$_GET['
                        store_id ']?>',
                    },
                })
            }
            </script>
            <td><a href="../src/write_review.php?store_id=<?=$_GET['store_id']?>">리뷰 작성하기</td>
        </table>
        <div class="information">
            <strong>정보</strong>
            <a href=#none id="show"
                onclick="if(hide1.style.display=='none') {hide1.style.display='';show.innerText='▲'} else {hide1.style.display='none';show.innerText='▶'}">▶</a>
            <div id="hide1" style="display: none">
                <?php
              echo "<div class=\"text1\">주소<div class=\"address\">"."{$row['address']}"."</div></div>";
              echo "<div class=\"text2\">영업시간<div class=\"time\">"."{$row['hour']}"."</div></div>";
              echo "<div class=\"text3\">전화번호<div id=\"plus\">"."{$row['tel']}"."</div></div>";
            }
             ?>
                <div style="text-align: center;"><a href="update_info.php?store_id=<?=$_GET['store_id']?>">정보 수정
                        제안하기</a></div>
            </div>
        </div>
        <div class="menubox">
            <strong>메뉴</strong><br>
            <div class="menu">
                <?php
            $sql = "SELECT main_menu, main_menu_price FROM stores WHERE id={$_GET['store_id']}";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            echo "[대표 메뉴]    "."{$row['main_menu']}"."  ---  "."{$row['main_menu_price']}"."원<br>";
             ?>
            </div>
            <div id="show2">
                <a href=#none id="show2"
                    onclick="if(hide2.style.display=='none') {hide2.style.display='';show2.innerText='접기'} else {hide2.style.display='none';show2.innerText='다른 메뉴 더보기'}">
                    다른 메뉴 더보기
                </a>
            </div>
            <div id="hide2" style="display: none">
                <?php
              $sql = "SELECT * FROM menus WHERE store_id={$_GET['store_id']} ORDER BY price DESC";
              $result = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_array($result)){
                echo "{$row['menu']}"."---"."{$row['price']}"."원<br>";
              }
              ?>
                <a href="update_menu.php?store_id=<?=$_GET['store_id']?>">메뉴 정보 수정 제안하기</a>
            </div>
        </div>
        <div class="reviewbox">
            <?php
      echo "<strong>리뷰 ("."{$review_amount}"."건)</strong>";
      $sql = "SELECT * FROM reviews WHERE store_id={$_GET['store_id']} ORDER BY created DESC";
      $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_array($result)){
        $class_review = "<div class=\"review\">";
        echo $class_review;

        $class_rating = "<div class=\"rating\">";
        echo $class_rating;

          // author 표현
        echo "{$row['author']}"."<br>";
        // 별 표현
        $star = $row['star'];
        for($i=5; $i>0; $i--){
          if($star > 0){
            echo "<span class=\"fa fa-star checked\"></span>";
            $star = $star - 1;
          } else{
            echo "<span class=\"fa fa-star\"></span>";
          }
        }

        echo "</div>";
        // comment 표현
        echo "<div class=\"comment\">"."{$row['review']}"."</div></div>";

          // 아이디 네임이랑 리뷰 네임이랑 같으면 업데이트 표시 $_SESSION['name'] == $row['author']
        if(isset($_SESSION) && $_SESSION['name'] == $row['author'] ){
          $update_link = "update_review.php?store_id='".$_GET['store_id']."'&id='".$row['id']."'";
          $review_id = $row['id'];
          ?>
            <form action="<?php echo $update_link;?>">
                <input type="hidden" name="store_id" value="<?=$_GET['store_id']?>">
                <input type="hidden" name="star_count" value="<?php echo $star_origin;?>">
                <input type="hidden" name="comment" value="<?php echo $row['review'];?>">
                <input type="hidden" name="review_id" value="<?php echo $row['id'] ?>">
                <input type="submit" value="수정">
            </form>
            <form action="process_delete.php" method="post">
                <input type="hidden" name="id" value="<?=$review_id?>">
                <input type="hidden" name="store_id" value="<?=$_GET['store_id']?>">
                <input type="submit" value="삭제">
            </form>
            <?php
            }
            }
            ?>
        </div>
    </div>
</body>

</html>
