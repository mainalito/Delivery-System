<?php use frontend\models\Orders;
use yii\grid\GridView;
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
                return $model->RiderConfirmation == 1 ? '<span class="badge badge-success" style="font-weight: bold">Confirmed</span>' :
                    '<span class="badge badge-warning" style="font-weight: bold">Pending</span>';
            }
        ],
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
