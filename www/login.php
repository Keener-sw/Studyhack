<?php 
session_start();

$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') #서버에서 요청이 들어왔을 때 동작
{
    $userid = $_POST['id'];
    $userpw = $_POST['pw'];
    $rid = 'Keener';
    $rpw = '1q2w3e4r!';
    if($userid === 'Keener' && $userpw ==='1q2w3e4r!'){
        $_SESSION['userid'] = $userid;
        header('Location: main.php');
        exit();
    }
    else
    {
        $error = "아이디 또는 패스워드가 틀렸습니다.";
    }
} ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/style.css">
    <style>
        .error { color: red; }
        input, button { padding: 8px; margin: 5px 0; }
    </style>
    </head>
    <body>

  <form method="POST">
    <?php if (isset($error) && $error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <div class="form-group">
        <label for="id">ID</label>
        <input type="text" id="id" name="id" placeholder="type id" required>
    </div>
    <div class="form-group">
        <label for="pw">Password</label>
        <input type="password" id="pw" name="pw" placeholder="Type password"required>
    </div>
    <button type="submit">로그인</button>
  </form>

</body>
</html>