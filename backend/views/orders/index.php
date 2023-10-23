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

        'ID',
        ['label' => 'Created By', 'value' => function ($model) {
            return $model->user->username;
        }],
        [
            'label' => 'Status',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->status == \frontend\models\Orders::STATUS_CONFIRMED) {
                    return '<span class="badge badge-success">STATUS_CONFIRMED</span>';
                } else if ($model->status == \frontend\models\Orders::STATUS_DRAFT) {
                    return '<span class="badge badge-warning">STATUS_DRAFT</span>';
                } else {
                    return '<span class="badge badge-secondary">FAILED</span>';
                }
            }
        ],

        [
            'label' => 'Action',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a("View Order", ['/orders/view', 'id' => $model->ID]);

            }
        ]


    ],
]); ?>

<?php Pjax::end(); ?>
