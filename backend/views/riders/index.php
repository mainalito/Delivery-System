<?php

use frontend\models\Products;
use riders\models\RiderRegistration;
use riders\models\RiderRegistrationSearch;
use riders\models\Status;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
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
            ['label'=>'Vehicle','value'=>function ($model){
                return $model->vehicle->Type;
            }],
            'VehicleRegistration',
            [
                'label' => 'Status',
                'format' => 'raw',
                'attribute' => 'Status', // Attribute used for sorting and filtering
                'value' => function ($model) {
                    if ($model->Status == 1) {
                        return Html::tag('span', @$model->status->Status, ['class' => 'badge badge-success']);
                    } elseif ($model->Status == 2) {
                        return Html::tag('span', @$model->status->Status, ['class' => 'badge badge-danger']);
                    }
                    return @$model->status->Status;
                },
                'filter' => ArrayHelper::map(Status::find()->all(),'ID','Status')
            ],
            
            
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
