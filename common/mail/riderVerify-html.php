<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->params['riderUrl'].'site/login';
?>
<div class="verify-email" style="font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: #333;">
    <h2 style="color: #0056b3;">Email Verification</h2>
    <p>Dear <strong><?= Html::encode($user->firstname . ' ' .$user->lastname) ?>,</strong></p>

    <p>Welcome to Rider! Your account details are as follows:</p>
    <ul>
        <li>Username: <strong><?= Html::encode($user->username) ?></strong></li>
        <li>Password: Your surname in lowercase (Please change this upon first login for security purposes)</li>
    </ul>

    <p>To complete your registration and verify your email, please click the link below:</p>
    <p style="margin-bottom: 20px;">
        <?= Html::a('Login', $verifyLink, ['class' => 'btn btn-primary', 'style' => 'color: white; text-decoration: none; padding: 10px 20px; background-color: #007bff; border: none; border-radius: 4px;']) ?>
    </p>

    <p>If you did not create an account with us, please ignore this email or contact support.</p>
    <p>Best regards,<br/>Rider</p>
</div>
