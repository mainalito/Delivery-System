<?php

use frontend\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">
    <div class="card mb-3"> <!-- Adjust the max-width as needed -->
        <div class="row no-gutters">

            <!-- Image Column -->
            <div class="col-md-4">
                <img src="..." alt="Card image cap" class="img-fluid rounded-start"> <!-- Use "..." for the path to your image -->
            </div>

            <!-- Content Column -->
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>

        </div>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Order Status',
                'value' => function ($model) {
                    switch ($model->status) {
                        case Orders::STATUS_PAID:
                            $badgeClass = 'badge-success';
                            $statusLabel = 'Paid';
                            break;
                        case Orders::STATUS_SHIPPED:
                            $badgeClass = 'badge-info';
                            $statusLabel = 'Shipped';
                            break;
                        case Orders::STATUS_COMPLETED:
                            $badgeClass = 'badge-primary';
                            $statusLabel = 'Confirmed';
                            break;
                        case Orders::STATUS_DRAFT:
                        default:
                            $badgeClass = 'badge-secondary';
                            $statusLabel = 'Draft';
                            break;
                    }
                    return "<span class=\"badge {$badgeClass}\">{$statusLabel}</span>";
                },
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
