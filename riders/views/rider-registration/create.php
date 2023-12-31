<?php

use Codeception\Template\Bootstrap;
use riders\assets\RiderAsset;
use yii\bootstrap4\BootstrapAsset;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */

$this->title = 'Rider Registration';
// $this->params['breadcrumbs'][] = ['label' => 'Rider Registrations', 'url' => ['site/index']];
// $this->params['breadcrumbs'][] = $this->title;
RiderAsset::register($this);

?>
<div class="container">
<div class="card">
    <div class="card-header" style="background: #FF416C; color: white; font-family: 'Montserrat', sans-serif;">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,'documentTypes'=>$documentTypes
        ]) ?>
    </div>
</div>
</div>

