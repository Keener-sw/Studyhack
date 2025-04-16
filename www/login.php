<?php 
session_start();

$pdo = new PDO(dsn: "mysql:host=mysql-container;dbname=users;charset=utf8",username:"root",password:"admin");
$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') #서버에서 요청이 들어왔을 때 동작
{
    $userid = $_POST['id'];
    $userpw = $_POST['pw'];
    $stmt = $pdo->prepare('Select * from priv_info WHERE id = ?');
    $stmt->execute([$userid]);  
    $user = $stmt->fetch();

    // 2. 사용자 + 비밀번호 확인
    if ($user && password_verify(password: $userpw, hash: $user['pwd'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['name'];
        header('Location: main.php'); // 리디렉션도 가능
        exit();
    } else {
        $error = "아이디 또는 비밀번호가 잘못되었습니다.";
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