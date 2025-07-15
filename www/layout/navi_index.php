<header>
    <a href="index.php"><img src='/img/home_bt.png' class="home_btn" id="navHome"></a>
    <div class="top-buttons">
        <a href="login.php" class="top-link">Login</a>
        <a href=# class="top-link" id="registerBtn">Register</a>
        <!-- 모달 구조 -->
        <div id="registerModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModalBtn">&times;</span>
                <h2>Register</h2>
                <!-- 입력 필드 -->
                <input type="text" id="reg_id" placeholder="아이디" required><br>
                <div id="id_chk" class="error"></div>
                <input type="text" id="reg_nickname" placeholder="닉네임" required><br>
                <div id="nick_chk" class="error"></div>
                <input type="password" id="reg_pwd" placeholder="비밀번호" required><br>
                <div id="pwd_chk" class="error"></div>
                <input type="text" id="reg_name" placeholder="이름" required><br><br>
                <div id="name_chk" class="error"></div>
                <input type="email" id="reg_email" placeholder="이메일" required><br><br>
                <div id="email_chk" class="error"></div>
                <!-- 가입하기 버튼 -->
                <button id="button_reg" disabled>가입하기</button>
                <!-- 결과 메시지 출력 영역 -->
                <div id="registerResult"></div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="/js/register.js"></script>
    </div>
</header>