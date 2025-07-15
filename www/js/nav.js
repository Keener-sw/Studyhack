document.addEventListener('DOMContentLoaded', function () {
    const homeBtn = document.getElementById('homeBtn');
    const mypageBtn = document.getElementById('mypageBtn');
    const logoutBtn = document.getElementById('logoutBtn');
    //const interfaceButton = document.getElementById('interface_button');

    if (homeBtn) {
        homeBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = "main.php";
        });
    }

    if (mypageBtn) {
        mypageBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = "verify_mypage.php";
        });
    }

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            fetch('logout.php')
                .then(response => {
                    if (response.ok) {
                        window.location.href = "index.php";
                    } else {
                        alert("Logout failed.");
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    }

        /*if (window.location.pathname === '/login.php' && interfaceButton) {
            interfaceButton.style.display = 'none';
        }*/
    });