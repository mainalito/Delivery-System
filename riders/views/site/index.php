<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Ecommerce';
?>

<!--<div style="display: flex; justify-content: center; align-items: center; height: 20vh;">-->
<!--    <div id="lottie-animation-1" style="width: 1000px; height: 200px;"></div>-->
<!--</div>-->

<div class="container" id="container">
    <!--    <div class="form-container sign-up-container">-->
    <!--        <form action="#">-->
    <!--            <h1>Create Account</h1>-->
    <!--            <span>or use your email for registration</span>-->
    <!--            <input type="text" placeholder="Identification Number"/>-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-6">-->
    <!--                    <input type="text" placeholder="First Name"/>-->
    <!--                </div>-->
    <!--                <div class="col-md-6">-->
    <!--                    <input type="text" placeholder="Last Name"/>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-6">-->
    <!--                    <input type="text" placeholder="Vehicle Type"/>-->
    <!--                </div>-->
    <!--                <div class="col-md-6">-->
    <!---->
    <!--                    <input type="text" placeholder="Vehicle Registration"/>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-6">-->
    <!--                    <input type="email" placeholder="Email"/>-->
    <!--                </div>-->
    <!--                <div class="col-md-6">-->
    <!---->
    <!--                    <input type="number" placeholder="Phone"/>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--                <button>Sign Up</button>-->
    <!--        </form>-->
    <!--    </div>-->
    <div class="form-container sign-in-container">
        <form action="#">
            <h1>Login</h1>
            <input type="email" placeholder="Username"/>
            <div class="password-wrapper">
                <input type="password" placeholder="Password" id="passwordField"/>
                <i class="fa fa-eye" id="togglePassword"></i>
            </div>
            <a href="#">Forgot your password?</a>
            <div class="form-group">
                <?= Html::button('Login', [
                    'class' => 'ghosting',
                    'id' => 'login',
//                        'data-toggle' => 'modal',
//                        'data-target' => '.ReviewModal',
                    'data-url' => \yii\helpers\Url::to(['/rider-registration/view']),
                ]) ?>
            </div>
        </form>

    </div>
    <div class="overlay-container">
        <div class="overlay">
            <!--            <div class="overlay-panel overlay-left">-->
            <!--                <h1>Welcome Back!</h1>-->
            <!--                <p>Keep connected and check on your orders due for delivery.</p>-->
            <!--                <button class="ghost" id="signIn">Login</button>-->
            <!--            </div>-->
            <div class="overlay-panel overlay-right">
                <h1>NEW?</h1>
                <p>Enter your details and start journey with us</p>
                <div class="form-group">
                    <?= Html::button('Sign Up', [
                        'class' => 'ghost',
                        'id' => 'signUp',
//                        'data-toggle' => 'modal',
//                        'data-target' => '.ReviewModal',
                        'data-url' => \yii\helpers\Url::to(['/rider-registration/create']),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ReviewModal" class="ReviewModal modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-dialog review-modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<<JS
                                                        $('button[data-target=".ReviewModal"]').on('click', function () {
                                                            var url = $(this).data('url');
                                                            $.get(url, function (data) {
                                                                $('.ReviewModal .modal-body').html(data);
                                                                 $('#ReviewModal').modal('show'); 
                                                            });
                                                        });
                                                        JS;

$this->registerJs($js, \yii\web\View::POS_READY); ?>
<script>
    $(document).ready(function () {
        $('#signUp').click(function () {
            var url = $(this).data('url');
            window.location.href = url; // redirecting to the specified URL
        });
    });
    $(document).ready(function () {
        $('#login').click(function () {
            var url = $(this).data('url');
            window.location.href = url; // redirecting to the specified URL
        });
    });
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize Lottie animations
        var animationPath = '/images/DeliveryGuy.json';
        // make sure this path is correct

        var animation1 = lottie.loadAnimation({
            container: document.getElementById('lottie-animation-1'), // Required
            renderer: 'svg', // Required
            loop: true, // Optional
            autoplay: true, // Optional
            path: animationPath // Required, the JSON path
        });
    });
    $(document).ready(function () {
        $("#togglePassword").click(function () {
            if ($("#passwordField").attr("type") === "password") {
                $("#passwordField").attr("type", "text");
                $(this).removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                $("#passwordField").attr("type", "password");
                $(this).removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
    });
</script>


<style>
    .review-modal-dialog {
        max-width: 100% !important;
        max-height: 60%;
    }

    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

    * {
        box-sizing: border-box;
    }

    body {
        background: #f6f5f7;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        height: 100vh;
        margin: -20px 0 50px;
    }

    h1 {
        font-weight: bold;
        margin: 0;
    }

    h2 {
        text-align: center;
    }

    h4 {
        text-align: center;
    }

    p {
        font-size: 14px;
        font-weight: 100;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
    }

    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        width: 100%;
        padding-right: 30px; /* space for the eye icon */
    }

    .password-wrapper .fa {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    span {
        font-size: 12px;
    }

    a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
    }

    button {
        border-radius: 20px;
        border: 1px solid #FF4B2B;
        background-color: #FF4B2B;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
    }

    button:active {
        transform: scale(0.95);
    }

    button:focus {
        outline: none;
    }

    button.ghost {
        background-color: transparent;
        border-color: #FFFFFF;
    }

    button.ghosting {
        background-color: #FF4B2B;
        border-color: #FFFFFF;
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
        0 10px 10px rgba(0, 0, 0, 0.22);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {
        0%, 49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%, 100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: #FF416C;
        background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
        background: linear-gradient(to right, #FF4B2B, #FF416C);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    .social-container {
        margin: 20px 0;
    }

    .social-container a {
        border: 1px solid #DDDDDD;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        height: 40px;
        width: 40px;
    }

    footer {
        background-color: #222;
        color: #fff;
        font-size: 14px;
        bottom: 0;
        position: fixed;
        left: 0;
        right: 0;
        text-align: center;
        z-index: 999;
    }

    footer p {
        margin: 10px 0;
    }

    footer i {
        color: red;
    }

    footer a {
        color: #3c97bf;
        text-decoration: none;
    }
</style>


