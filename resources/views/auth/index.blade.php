<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/hack-font@3/build/web/hack.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"
    ></script>
<style>
    :root {
        --primary-color: #114cff;
        --secondary-color: #98a4fc;
        --black: #000000;
        --white: #ffffff;
        --gray: #efefef;
        --gray-2: #757575;

        --facebook-color: #4267B2;
        --google-color: #DB4437;
        --twitter-color: #1DA1F2;
        --insta-color: #E1306C;
    }

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

    * {
        font-family: 'Hack', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        height: 100vh;
        overflow: hidden;
    }

    .container {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        height: 100vh;
    }

    .col {
        width: 50%;
    }

    .align-items-center {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .form-wrapper {
        width: 100%;
        max-width: 28rem;
    }

    .form {
        padding: 1rem;
        background-color: var(--white);
        border-radius: 1.5rem;
        width: 100%;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        transform: scale(0);
        transition: .5s ease-in-out;
        transition-delay: 0.5s;
    }

    .input-group {
        position: relative;
        width: 100%;
        margin: 1rem 0;
    }

    .input-group i {
        position: absolute;
        top: 50%;
        left: 1rem;
        transform: translateY(-50%);
        font-size: 1rem;
        color: var(--gray-2);
        opacity: 0.7;
    }
    .input-group input {
        width: 100%;
        padding: 1rem 3rem;
        font-size: 1rem;
        background-color: var(--gray);
        border-radius: .5rem;
        border: 0.125rem solid var(--white);
        outline: none;
    }

    .input-group input:focus {
        border: 0.125rem solid var(--primary-color);
    }

    .form button {
        cursor: pointer;
        width: 100%;
        padding: .6rem 0;
        border-radius: .5rem;
        border: none;
        background-color: var(--primary-color);
        color: var(--white);
        font-size: 1.2rem;
        outline: none;
    }

    .form p {
        margin: 1rem 0;
        font-size: .7rem;
    }

    .flex-col {
        flex-direction: column;
    }

    .social-list {
        margin: 2rem 0;
        padding: 1rem;
        border-radius: 1.5rem;
        width: 100%;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        transform: scale(0);
        transition: .5s ease-in-out;
        transition-delay: 1.2s;
    }

    .social-list>div {
        color: var(--white);
        margin: 0 .5rem;
        padding: .7rem;
        cursor: pointer;
        border-radius: .5rem;
        cursor: pointer;
        transform: scale(0);
        transition: .5s ease-in-out;
    }

    .social-list>div:nth-child(1) {
        transition-delay: 1.4s;
    }

    .social-list>div:nth-child(2) {
        transition-delay: 1.6s;
    }

    .social-list>div:nth-child(3) {
        transition-delay: 1.8s;
    }

    .social-list>div:nth-child(4) {
        transition-delay: 2s;
    }

    .social-list>div>i {
        font-size: 1.5rem;
        transition: .4s ease-in-out;
    }

    .social-list>div:hover i {
        transform: scale(1.5);
    }

    .facebook-bg {
        background-color: var(--facebook-color);
    }

    .google-bg {
        background-color: var(--google-color);
    }

    .twitter-bg {
        background-color: var(--twitter-color);
    }

    .insta-bg {
        background-color: var(--insta-color);
    }

    .pointer {
        cursor: pointer;
    }

    .container.sign-in .form.sign-in,
    .container.sign-in .social-list.sign-in,
    .container.sign-in .social-list.sign-in>div,
    .container.sign-up .form.sign-up,
    .container.sign-up .social-list.sign-up,
    .container.sign-up .social-list.sign-up>div {
        transform: scale(1);
    }

    .content-row {
        position: absolute;
        top: 0;
        left: 0;
        pointer-events: none;
        z-index: 6;
        width: 100%;
    }

    .text {
        margin: 2rem;
        color: var(--white);
    }

    .text h2 {
        font-size: 3.5rem;
        font-weight: 800;
        margin: 1rem 0;
        transition: 1s ease-in-out;
    }

    .text p {
        font-weight: 600;
        transition: 1s ease-in-out;
        transition-delay: .2s;
    }

    .img img {
        width: 30vw;
        transition: 1s ease-in-out;
        transition-delay: .4s;
    }

    .text.sign-in h2,
    .text.sign-in p,
    .img.sign-in img {
        transform: translateX(-250%);
    }

    .text.sign-up h2,
    .text.sign-up p,
    .img.sign-up img {
        transform: translateX(250%);
    }

    .container.sign-in .text.sign-in h2,
    .container.sign-in .text.sign-in p,
    .container.sign-in .img.sign-in img,
    .container.sign-up .text.sign-up h2,
    .container.sign-up .text.sign-up p,
    .container.sign-up .img.sign-up img {
        transform: translateX(0);
    }

    /* BACKGROUND */

    .container::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        height: 100vh;
        width: 300vw;
        transform: translate(35%, 0);
        background-image: linear-gradient(-45deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        transition: 1s ease-in-out;
        z-index: 6;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        border-bottom-right-radius: max(50vw, 50vh);
        border-top-left-radius: max(50vw, 50vh);
    }

    .container.sign-in::before {
        transform: translate(0, 0);
        right: 50%;
    }

    .container.sign-up::before {
        transform: translate(100%, 0);
        right: 50%;
    }

    /* RESPONSIVE */

    @media only screen and (max-width: 425px) {

        .container::before,
        .container.sign-in::before,
        .container.sign-up::before {
            height: 100vh;
            border-bottom-right-radius: 0;
            border-top-left-radius: 0;
            z-index: 0;
            transform: none;
            right: 0;
        }

        /* .container.sign-in .col.sign-up {
        transform: translateY(100%);
    } */

        .container.sign-in .col.sign-in,
        .container.sign-up .col.sign-up {
            transform: translateY(0);
        }

        .content-row {
            align-items: flex-start !important;
        }

        .content-row .col {
            transform: translateY(0);
            background-color: unset;
        }

        .col {
            width: 100%;
            position: absolute;
            padding: 2rem;
            background-color: var(--white);
            border-top-left-radius: 2rem;
            border-top-right-radius: 2rem;
            transform: translateY(100%);
            transition: 1s ease-in-out;
        }

        .row {
            align-items: flex-end;
            justify-content: flex-end;
        }

        .form,
        .social-list {
            box-shadow: none;
            margin: 0;
            padding: 0;
        }

        .text {
            margin: 0;
        }

        .text p {
            display: none;
        }

        .text h2 {
            margin: .5rem;
            font-size: 2rem;
        }
    }
</style>

<body>
    <div id="container"
        class="container @if (session('login')) sign-in @elseif (session('register')) sign-up @endif">

        <!-- FORM SECTION -->
        <div class="row">
            <!-- SIGN UP -->
            <div class="col align-items-center flex-col sign-up">
                <div class="form-wrapper align-items-center">
                    <form action="/register" method="post" class="form sign-up">
                        @csrf
                        <h2>Registrasi</h2>
                        <div class="input-group">
                            <i class="fas fa-user"></i> 
                            <input type="text" placeholder="Name" name="name" value="{{ old('name') }}"
                                autocomplete="off">
                        </div>
                        <div class="input-group">
                            <i class="fas fa-user-alt"></i>
                            <input type="text" placeholder="Username" name="username"
                                @if (session('register')) value="{{ old('username') }}" @endif
                                autocomplete="off">
                        </div>
                        <div class="input-group">
                            <i class="fas fa-envelope"></i>
                            <input type="text" placeholder="Email" name="email" value="{{ old('email') }}"
                                autocomplete="off">
                        </div>
                        <div class="input-group">

                            <i class='bx bx-mail-send'></i>
                            <input type="text" placeholder="Phone Number" name="phone" value="{{ old('phone') }}"
                                autocomplete="off">
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>

                            <input type="password" placeholder="Password" name="password" autocomplete="off">
                        </div>
                        <div class="input-group">
                            <i class="fas fa-lock-open"></i>
                            <input type="password" placeholder="Confirm password" name="password_confirmation"
                                autocomplete="off">
                        </div>
                        <button type="submit">
                            Sign up
                        </button>
                        <p>
                            <span>
                                Already have an account?
                            </span>
                            <b onclick="toggle()" class="pointer">
                                Sign in here
                            </b>
                        </p>
                    </form>
                </div>
            </div>
            <!-- END SIGN UP -->
            <!-- SIGN IN -->
            <div class="col align-items-center flex-col sign-in">
                <div class="form-wrapper align-items-center">
                    <form action="/login" method="post" class="form sign-in">
                        @csrf
                        <h2>Login</h2>
                        <div class="input-group">
                            <i class="fas fa-user-alt"></i>
                            <input type="text" placeholder="Username" name="username"
                                @if (session('login')) value="{{ old('username') }}" @endif
                                autocomplete="off">
                        </div>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Password" name="password" autocomplete="off">
                        </div>
                        <button type="submit">
                            Sign in
                        </button>
                        {{-- <p>
                            <b>
                                Forgot password?
                            </b>
                        </p> --}}
                        <p>
                            <span>
                                Don't have an account?
                            </span>
                            <b onclick="toggle()" class="pointer">
                                Sign up here
                            </b>
                        </p>
                    </form>
                </div>
                <div class="form-wrapper">

                </div>
            </div>
            <!-- END SIGN IN -->
        </div>
        <!-- END FORM SECTION -->
        <!-- CONTENT SECTION -->
        <div class="row content-row">
            <!-- SIGN IN CONTENT -->
            <div class="col align-items-center flex-col">
                <div class="text sign-in">
                    <h2>
                        Welcome Back,
                    </h2>
                    <p>Sign in to continue</p>
                    <p>Access all the exclusive features by signing in.</p>
                </div>
                <div class="img sign-in">
                    <img src="{{ asset('img/2.svg') }}" alt="Nama Gambar">
                </div>
            </div>
            <!-- END SIGN IN CONTENT -->
            <!-- SIGN UP CONTENT -->
            <div class="col align-items-center flex-col">
                <div class="img sign-up">
                    <img src="{{ asset('img/1.svg') }}" alt="Nama Gambar">
                </div>
                <div class="text sign-up">
                    <h2>
                        Join with us
                    </h2>
                    <p>Signup to enjoy with us</p>
                    <p>Become a part of our community by signing up.</p>
                </div>
            </div>
            <!-- END SIGN UP CONTENT -->
        </div>
        <!-- END CONTENT SECTION -->
    </div>
    @if (session('login'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Login gagal!"
            });
        </script>
    @endif
    @if (session('register'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "Registrasi gagal!"
            });
        </script>
    @endif
    @if (session('daftar'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "Registrasi berhasil!"
            });
        </script>
    @endif

</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
</script>
<script>
    let container = document.getElementById('container')

    toggle = () => {
        container.classList.toggle('sign-in')
        container.classList.toggle('sign-up')
    }
</script>
@if (!session('login') && !session('register'))
    <script>
        setTimeout(() => {
            container.classList.add('sign-in')
        }, 200)
        $('input[name="username"]').focus();
    </script>
@endif

</html>
