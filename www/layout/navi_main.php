<header>
    <link rel="stylesheet" href="../css/style.css">
    <a href ="index1.php">
        <img src='/img/home_bt.png' class="home_btn" onclick=nav_home()>
    </a>
    <div class="top-buttons">
        <a href="priv_page.php" class="top-link" onclick=mypage()>My Page</a>
        <a href="logout.php" class="top-link" onclick=logout()>Logout</a>
    </div>


    <script>
        function nav_home() {
            window.location.href = "main.php";
        }
        function mypage() {
            window.location.href = "priv_page.php";
        }
        function logout() {
            fetch('logout.php')
                .then(response => {
                    if (response.ok) {
                        window.location.href = "index1.php";
                    } else {
                        alert("Logout failed.");
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</header>