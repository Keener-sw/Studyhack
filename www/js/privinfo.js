document.addEventListener('DOMContentLoaded', function () {
    const checkBtn = document.getElementById('check-nickname');
    const nicknameInput = document.getElementById('nickname');
    const msg = document.getElementById('nickname-msg');
    const nicknameChecked = document.getElementById('nickname_checked');

    if (checkBtn && nicknameInput && msg && nicknameChecked) {
        checkBtn.addEventListener('click', function () {
            const nickname = nicknameInput.value.trim();
            if (!nickname) {
                msg.textContent = "닉네임을 입력하세요.";
                msg.style.color = "red";
                nicknameChecked.value = "0";
                return;
            }
            fetch('/api/check_nickname.php?nickname=' + encodeURIComponent(nickname))
                .then(res => res.json())
                .then(data => {
                    if (data.exists) {
                        msg.textContent = "이미 사용중인 닉네임입니다.";
                        msg.style.color = "red";
                        nicknameChecked.value = "0";
                    } else {
                        msg.textContent = "사용 가능한 닉네임입니다.";
                        msg.style.color = "#0ff";
                        nicknameChecked.value = "1";
                    }
                })
                .catch(() => {
                    msg.textContent = "서버 오류";
                    msg.style.color = "red";
                    nicknameChecked.value = "0";
                });
        });

        nicknameInput.addEventListener('input', function () {
            nicknameChecked.value = "0";
            msg.textContent = "";
        });
    }
});