<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */

$this->title = 'Create Rider Registration';
$this->params['breadcrumbs'][] = ['label' => 'Rider Registrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rider-registration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
