document.addEventListener('DOMContentLoaded', function () {
    // 요소 캐싱
    const modal = document.getElementById('registerModal');
    const openBtn = document.getElementById('registerBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const regBtn = document.getElementById('button_reg');
    const resultDiv = document.getElementById('registerResult');

    // 입력 필드
    const idInput = document.getElementById('reg_id');
    const nicknameInput = document.getElementById('reg_nickname');
    const pwdInput = document.getElementById('reg_pwd');
    const nameInput = document.getElementById('reg_name');
    const emailInput = document.getElementById('reg_email');

    // 에러 div
    const idChk = document.getElementById('id_chk');
    const nickChk = document.getElementById('nick_chk');
    const pwdChk = document.getElementById('pwd_chk');
    const nameChk = document.getElementById('name_chk');
    const emailChk = document.getElementById('email_chk');

    // 유효성 검사 함수
    function id_check() {
        const cid = idInput.value.trim();
        const onlyEnglish = /^[a-zA-Z0-9]+$/;
        if (!onlyEnglish.test(cid)) {
            idChk.innerText = "영어와 숫자 조합의 아이디를 입력하세요.";
            return false;
        } else if (cid.length < 4) {
            idChk.innerText = "아이디는 최소 4자 이상 입력하세요.";
            return false;
        } else {
            idChk.innerText = "";
            return true;
        }
    }
    function pwd_check() {
        const cpwd = pwdInput.value;
        const specialChar = /[!@#$%^&*(),.?":{}|<>]/;
        if (cpwd.length < 8) {
            pwdChk.innerText = "비밀번호는 8자 이상 설정 하세요.";
            return false;
        } else if (!specialChar.test(cpwd)) {
            pwdChk.innerText = "비밀번호는 특수문자를 최소 1개 이상 설정 하세요";
            return false;
        } else {
            pwdChk.innerText = "";
            return true;
        }
    }
    function nick_check() {
        const cnick = nicknameInput.value.trim();
        if (!cnick) {
            nickChk.innerText = "닉네임을 입력하세요.";
            return false;
        } else {
            nickChk.innerText = "";
            return true;
        }
    }
    function name_check() {
        const cname = nameInput.value.trim();
        if (!cname) {
            nameChk.innerText = "이름을 입력하세요.";
            return false;
        } else {
            nameChk.innerText = "";
            return true;
        }
    }
    function email_check() {
        const cmail = emailInput.value.trim();
        function validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
        if (!cmail) {
            emailChk.innerText = "이메일을 입력하세요.";
            return false;
        } else if (!validateEmail(cmail)) {
            emailChk.innerText = "올바른 이메일 형식이 아닙니다.";
            return false;
        } else {
            emailChk.innerText = "";
            return true;
        }
    }

    // 모든 입력값이 유효한지 확인
    function checkAllValid() {
        return id_check() && nick_check() && pwd_check() && name_check() && email_check();
    }

    // 입력 이벤트 등록
    [idInput, nicknameInput, pwdInput, nameInput, emailInput].forEach(input => {
        input.addEventListener('input', function () {
            id_check();
            nick_check();
            pwd_check();
            name_check();
            email_check();
            regBtn.disabled = !checkAllValid();
            if (checkAllValid()) {
                resultDiv.innerText = "";
            }
        });
    });

    // 모달 열기/닫기
    openBtn.addEventListener('click', function (e) {
        e.preventDefault();
        modal.classList.add('show');
    });
    closeBtn.addEventListener('click', function () {
        modal.classList.remove('show');
    });

    // 가입하기 버튼 클릭
    regBtn.addEventListener('click', function (e) {
        e.preventDefault();
        if (!checkAllValid()) {
            resultDiv.innerText = "모든 항목을 올바르게 입력하세요.";
            return;
        }
        const data = {
            id: idInput.value.trim(),
            pwd: pwdInput.value,
            name: nameInput.value.trim(),
            email: emailInput.value.trim(),
            nickname: nicknameInput.value.trim()
        };
        fetch('reges.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.text())
        .then(result => {
            resultDiv.innerText = result;
            if (result.includes("성공")) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '회원가입 완료!',
                    showConfirmButton: false,
                    timer: 5000
                }).then(() => {
                    window.location.href = 'index.php';
                });
            }
        })
        .catch(() => {
            resultDiv.innerText = "회원가입 중 오류가 발생했습니다. 나중에 다시 시도해주세요.";
        });
    });
});