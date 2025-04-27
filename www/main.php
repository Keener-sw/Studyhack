<?php 
require_once(__DIR__ ."/init.php");
echo $_SESSION['user_id'];
                if(isset($_SESSION['user_id']))
                {
                    $userid = $_SESSION['user_id'];
                }
                else
                {
                    header('Location = login.php');
                    exit();
                }
                ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>나의 페이지</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
        <body>
            <form>
            <p><img src="../img/pro_burger.png" alt="profile_img" width="150" height="150"></p>
            <h1>Welcome back, <?php echo htmlspecialchars($userid);?></h1>
            <p>Check your score to click the button down below~</p>
            <button type=button onclick=find_score()>Click</button><br>
            <div id="myScore"></div>
            <script>
                function find_score(){
                    fetch('find_score.php')
                        .then(response => response.json())
                        .then(data => {document.getElementById('myScore').innerText = "Your score is  " + data.score;});
                }
            </script>
            </form>
        </body>
</html>