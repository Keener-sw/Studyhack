<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Future Burger</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        
        <div class="middle">
            <div class="title">Welcome to the Future Burger</div>
                <img src="/img/mainburger.png" alt="로고" class="main-logo">
        </div>
        
        <div class="top-buttons">
            <a href="login.php" class="top-link">Login</a>
            <a href="reges.php" class="top-link" onclick="openModal(event)" >Register</a>

        <!-- 모달 구조 -->
        <div id="registerModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
            <h2>Register</h2>
    
         <!-- 입력 필드 -->
        <input type="text" id="id" placeholder="아이디" onblur=id_check()><br>
        <div id="id_chk", class="error"></div>
        <input type="text" id="nickname" placeholder="닉네임"><br>
        <div id="nick_chk" class="error"></div>
        <input type="password" id="pwd" placeholder="비밀번호" onblur="pwd_check()"><br>
        <div id="pwd_chk" class="error"></div>
        <input type="text" id="name" placeholder="이름"><br><br>
        <div id="name_chk" class="error"></div>
        <input type="email" id="email" placeholder="이메일"><br><br>
    
        <!-- 가입하기 버튼 -->
        <button onclick="submitRegister()">가입하기</button>

        <!-- 결과 메시지 출력 영역 -->
        <div id="registerResult"></div>
                    </div>
        </div>

        <!-- JS 코드 -->
<script>
function submitRegister() {
  const data = {
    id: document.getElementById('id').value,
    pwd: document.getElementById('pwd').value,
    name: document.getElementById('name').value,
    email: document.getElementById('email').value,
    nickname: document.getElementById('nickname').value,
  };

  fetch('reges.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
  })
  .then(res => res.text())
  .then(result => {
    document.getElementById('registerResult').innerText = result;
  })
  .catch(err => {
    document.getElementById('registerResult').innerText = '에러 발생';
  });
}
</script>
<script>
function openModal(e) {
  e.preventDefault(); // a 태그 기본 동작 방지
  const modal = document.getElementById('registerModal');
  modal.classList.add('show');
}

function closeModal() {
  const modal = document.getElementById('registerModal');
  modal.classList.remove('show');
}
</script>
<script>
    function id_check(){
        const cid = document.getElementById('id').value;
        const errorDiv =document.getElementById('id_chk');
        const onlyEnglish = /^[a-zA-Z]+$/;
        if(!onlyEnglish.test(cid)){
            errorDiv.innerText = "영어로 된 아이디를 입력하세요.";
        }else{
            errorDiv.innerText = "";
        }
    }
    function pwd_check(){
        const cpwd = document.getElementById('pwd').value;
        const errorDiv = document.getElementById('pwd_chk');
        const specialChar = /[!@#$%^&*(),.?":{}|<>]/;

        if(cpwd.length < 8){
            errorDiv.innerText = "비밀번호는 8자 이상 설정 하세요.";
        }else if(!specialChar.test(cpwd)){
            errorDiv.innerText = "비밀번호는 특수문자를 최소 1개 이상 설정 하세요";
        }else{
            errorDiv.innerText = "";
        }
    }
    function nick_check(){
        const cnick =document.getElementById('nickname').value;

    }
</script>
    </body>
</html>
