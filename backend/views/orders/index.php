<?php use frontend\models\Orders;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'ID',
        ['label' => 'Customer Name', 'value' => function ($model) {
            return $model->user->username;
        }],
        [
            'label' => 'Status',
            'format' => 'raw',
            'value' => function ($model) {

                $statusLabel = '';
                $badgeClass = '';

                switch ($model->status) {
                    case Orders::STATUS_DRAFT:
                        $statusLabel = 'Draft';
                        $badgeClass = 'badge-secondary'; // Gray badge for draft
                        break;
                    case Orders::STATUS_PAID:
                        $statusLabel = 'Paid';
                        $badgeClass = 'badge-success'; // Green badge for paid
                        break;
                    case Orders::STATUS_SHIPPED:
                        $statusLabel = 'Shipped';
                        $badgeClass = 'badge-info'; // Blue badge for shipped
                        break;
                    case Orders::STATUS_COMPLETED:
                        $statusLabel = 'Confirmed';
                        $badgeClass = 'badge-warning'; // Yellow badge for confirmed
                        break;
                    default:
                        $statusLabel = 'Failed';
                        $badgeClass = 'badge-danger';
                        break;
                }

                return '<span class="badge ' . $badgeClass . '">' . $statusLabel . '</span>';

            }
        ],

        [
            'label' => 'Action',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a("View Order", ['/orders/view', 'id' => $model->ID], ['class' => 'btn btn-primary']);
            }
        ]


    ],
]); ?>

<?php Pjax::end(); ?>
