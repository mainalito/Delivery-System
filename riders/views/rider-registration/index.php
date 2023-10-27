<?php

use riders\models\RiderRegistration;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistrationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Rider Registrations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rider-registration-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Rider Registration', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'FirstName',
            'LastName',
            'Vehicle',
            'VehicleRegistration',
            //'Email:email',
            //'PhoneNumber',
            //'IdentificationNumber',
            //'Status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RiderRegistration $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
    ]); ?>


</div>
