<?php

use frontend\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var frontend\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'My Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">
    <div class="container-fluid">
        <?php foreach ($dataProvider->getModels() as $order): ?>
            <?php
            switch ($order->status) {
                case Orders::STATUS_PAID:
                    $badgeClass = 'badge-success';
                    $statusLabel = 'Paid';
                    $dateLabel =$order->confirmed_at ? date('F j, Y', $order->confirmed_at) : 'N/A';

                    break;
                case Orders::STATUS_SHIPPED:
                    $badgeClass = 'badge-info';
                    $statusLabel = 'Shipped';
                    $dateLabel = $order->DateConfirmed ? date('F j, Y', strtotime($order->DateConfirmed) ): 'N/A';

                    break;
                case Orders::STATUS_COMPLETED:
                    $badgeClass = 'badge-primary';
                    $statusLabel = 'Confirmed';
                    $dateLabel =$order->DateDelivered ? date('F j, Y', strtotime($order->DateDelivered) ): 'N/A';

                    break;
                case Orders::STATUS_DRAFT:
                default:
                    $badgeClass = 'badge-secondary';
                    $statusLabel = 'Draft';
                    $dateLabel = $order->created_at ? date('F j, Y', $order->created_at) : 'N/A';

                    break;
            }
            ?>

            <div class="card mb-4 shadow-sm">
                <div class="row no-gutters">
                    <div class="col-md-8 col-lg-8">
                        <div class="card-body">
                            <h5 class="card-title">
                                <small class="text-muted">Order No: <?= Html::encode($order->ID) ?></small>
                            </h5>
                            <p class="card-text">
                    <span class="badge badge-pill <?= Html::encode($badgeClass) ?>">
                        <?= Html::encode($statusLabel) ?>
                    </span>
                            </p>

                            <div class="card-date">
                                <span class="text-muted" style="font-size: 14px"><?= Html::encode($dateLabel) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 d-flex align-items-center justify-content-end pr-3">
                        <a href="<?= Html::encode(Url::to(['orders/view', 'id' => $order->ID])) ?>"
                           class="btn btn-outline-primary btn-sm">
                            See Details
                        </a>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>


</div>