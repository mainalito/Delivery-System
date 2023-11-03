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

$this->title = 'My Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">
    <div class="container-fluid">
        <?php foreach ($dataProvider->getModels() as $order) {
            $title = $order->ID;
            switch ($order->status) {
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
        ?>
            <div class="card mb-3">
                <div class="row no-gutters">
                    <!-- Image Column -->
                    <div class="col-md-4">
                        <img src="..." alt="Card image cap" class="img-fluid rounded-start"> <!-- Use "..." for the path to your image -->
                    </div>
                    <!-- Content Column -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">$title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <span class="badge <?= $badgeClass ?>"><?= $statusLabel ?></span>
                            <a href="orders/view/<?= $order->ID ?>" class="btn btn-outline-primary">See Details</a>
                        </div>
                    </div>

                </div>
            </div>
        <?php } ?>
    </div>
</div>