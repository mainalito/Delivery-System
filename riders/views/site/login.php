<?php

/** @var yii\web\View $this */

use riders\assets\LoginAsset;
use riders\assets\RiderAsset;

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Ecommerce';
LoginAsset::register($this);

?>

<!--<div style="display: flex; justify-content: center; align-items: center; height: 20vh;">-->
<!--    <div id="lottie-animation-1" style="width: 1000px; height: 200px;"></div>-->
<!--</div>-->

<div class="sub-container" id="sub-container">

    <div class="form-container sign-in-container">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <h1>Login</h1>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <div class="password-wrapper">
            <?= $form->field($model, 'password')->passwordInput(['id' => 'passwordField']) ?>
            <i class="fa fa-eye" id="togglePassword"></i>
        </div>
        <a href="#">Forgot your password?</a>
        <div class="form-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        </div>
        <?php ActiveForm::end(); ?>

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
                        'data-url' => Url::to(['/rider-registration/create']),
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div id="ReviewModal" class="ReviewModal modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-dialog review-modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    $('#signUp').click(function() {
    
        var url = $(this).data('url');
        console.log(url)
        window.location.href = url; // redirecting to the specified URL
    });

    // No need for another listener for #login as you haven't provided its use.

    // Removed the pure JS event listeners for #signUp and #signIn to avoid conflicts

    // Lottie animation init remains as it is
    var animationPath = '/images/DeliveryGuy.json'; // make sure this path is correct
    var animation1 = lottie.loadAnimation({
        container: document.getElementById('lottie-animation-1'), // Required
        renderer: 'svg', // Required
        loop: true, // Optional
        autoplay: true, // Optional
        path: animationPath // Required
    });

    // Password visibility toggle
    $("#togglePassword").click(function() {
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