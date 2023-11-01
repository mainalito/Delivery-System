<?php use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['label' => 'Owner', 'value' => function ($model) {
            return $model->user->username;
        }],
        [
            'attribute' => 'DateAssigned',
            'format' => 'raw',
            'value' => function ($model){
                return date('Y-m-d H:i:s', strtotime($model->DateAssigned));
            }
        ],
        [
            'attribute' => 'RiderConfirmation',
            'format' => 'raw',
            'value' => function ($model){
                return $model->RiderConfirmation ? $model->RiderConfirmation : '<span class="badge badge-warning" style="font-weight: bold">Pending</span>';
            }
        ],
        [
            'label' => 'Action',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a("View Delivery", ['/orders/view', 'id' => $model->ID], ['class' => 'btn btn-primary']);
            }
        ]
        


    ],
]); ?>

<?php Pjax::end(); ?>
