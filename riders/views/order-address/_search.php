<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var riders\models\OrderAddressSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-address-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'County') ?>

    <?= $form->field($model, 'Subcounty') ?>

    <?php // echo $form->field($model, 'PhoneNumber') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
