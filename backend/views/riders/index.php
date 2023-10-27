<?php

use frontend\models\Products;
use riders\models\RiderRegistration;
use riders\models\RiderRegistrationSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var RiderRegistrationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Riders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'IdentificationNumber',
            ['label' => 'Customer Name', 'value' => function ($model) {
                return $model->FirstName . ' ' . $model->LastName;
            }],
            'Vehicle',
            'VehicleRegistration',
            'Status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RiderRegistration $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
