<?php

use diecoding\toastr\Toastr;
use diecoding\toastr\ToastrBase;

?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?= Toastr::widget([
        'typeDefault' => ToastrBase::TYPE_SUCCESS,
        'message' => Yii::$app->session->getFlash('success'),
        'title' => 'Success',
        'options' => ["positionClass" => "toast-top-right"]
    ]) ?>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <?= Toastr::widget([
        'typeDefault' => ToastrBase::TYPE_ERROR,
        'message' => Yii::$app->session->getFlash('error'),
        'title' => 'Error',
        'options' => ["positionClass" => "toast-top-right"]
    ]) ?>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('warning')): ?>
    <?= Toastr::widget([
        'typeDefault' => ToastrBase::TYPE_WARNING,
        'message' => Yii::$app->session->getFlash('warning'),
        'title' => 'Warning',
        'options' => ["positionClass" => "toast-top-right"]
    ]) ?>
<?php endif; ?>