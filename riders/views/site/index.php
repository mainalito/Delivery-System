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





