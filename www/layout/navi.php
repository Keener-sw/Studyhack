<header>
    <a href="index1.php"><img src='/img/home_bt.png' class="home_btn" onclick=nav_home()></a>
    <div class="top-buttons">
        <a href="login.php" class="top-link">Login</a>
        <a href="reges.php" class="top-link" onclick="openModal(event)" >Register</a>

    <!-- 모달 구조 -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
        <h2>Register</h2>

     <!-- 입력 필드 -->
    <input type="text" id="id" placeholder="아이디" onblur=id_check() required><br>
    <div id="id_chk", class="error"></div>
    <input type="text" id="nickname" placeholder="닉네임" onblur=nick_check() required><br>
    <div id="nick_chk" class="error"></div>
    <input type="password" id="pwd" placeholder="비밀번호" onblur=pwd_check() required ><br>
    <div id="pwd_chk" class="error"></div>
    <input type="text" id="name" placeholder="이름" onblur=name_check() required><br><br>
    <div id="name_chk" class="error"></div>
    <input type="email" id="email" placeholder="이메일" onblur=email_check() required><br><br>
    <div id="email_chk" class="error"></div>

    <!-- 가입하기 버튼 -->
    <button id="button_reg" onclick=submitRegister() disabled>가입하기</button>

    <!-- 결과 메시지 출력 영역 -->
    <div id="registerResult"></div>
                </div>
    </div>

    <!-- JS 코드 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const regeinputIds = ['id', 'nickname', 'pwd', 'email', 'name']; // 각 인풋 객체생성
        const regebutton = document.getElementById('button_reg'); // 버튼 활성화/비활성화
        const debg = document.getElementById('registerResult'); // 메시지 디버깅
        regeinputIds.forEach(id => {document.getElementById(id).addEventListener('input', checkFilled);});
        //객체 내부값들을 모두 이벤트 리스너에 등록

        function checkFilled() {
            for (const id of regeinputIds) {
            const value = document.getElementById(id).value.trim();
            if (value === "") {
                regebutton.disabled = true;
                debg.innerText = `${id} 칸에 공백이 있습니다.`;
                return; // 함수 종료
            }
        }   
        regebutton.disabled = false;
        debg.innerText = ""; // 혹은 "모든 칸이 정상적으로 입력되었습니다."
}
</script>
    </script>
<script> /* 가입하기 버튼 입력시 결과값을 저장하는 함수 */
function submitRegister() {
const data = {
id: document.getElementById('id').value,
pwd: document.getElementById('pwd').value,
name: document.getElementById('name').value,
email: document.getElementById('email').value,
nickname: document.getElementById('nickname').value,
};
/* fetch로 rege.php를 실행시켜 결과값을 registerResult로 텍스트로 결과보여줌*/
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
Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '회원가입 완료!',
                showConfirmButton: false,
                timer: 2000
                }).then(() => {
                window.location.href = 'index.php';
            });
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
    }else if(cid.length < 4){
        errorDiv.innerText = "아이디는 최소 4자 이상 입력하세요.";
    }else{
        errorDiv.innerText="";
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
    const errorDiv = document.getElementById('nick_chk')
    if(!cnick){
        errorDiv.innerText="닉네임을 입력하세요.";
    }else{
        errorDiv.innerText="";
    }
}
function email_check(){
    const cmail = document.getElementById('email').value;
    const errorDiv =document.getElementById('email_chk');
    function validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }
    if(!cmail){
        errorDiv.innerText="이메일을 입력하세요.";
    }else if(!validateEmail(cmail)){
        errorDiv.innerText="올바른 이메일 형식이 아닙니다.";
    }else{
        errorDiv.innerText="";
    }
function valid_rege_button(){
}
}
</script>
</header>