<?php

/** @var array $cartItems * */
/** @var yii\web\View $this */
/** @var Orders $order */
/** @var UserAddress $model */

use frontend\models\Orders;
use frontend\models\UserAddress;
use riders\models\RiderRegistration;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

$this->title = 'Cart';
$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container fluid">
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">
            <!-- Cart Items -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Cart Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cartItems as $item) : ?>
                                    <tr>
                                        <td><?= $item['product_name'] ?></td>
                                        <td><img src="<?= '@web/' . $item['image'] ?>" class="img-fluid w-25"></td>
                                        <td><?= number_format($item['price'], 2) ?> KSh</td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td><?= number_format($item['total_price'], 2) ?> KSh</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4">Order Status</th>
                                <td>
                                    <?php
                                    $statusLabel = '';
                                    $badgeClass = '';

                                    switch ($order->status) {
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
                                    ?>
                                    <span class="badge <?= $badgeClass; ?>"><?= $statusLabel; ?></span>
                                </td>

                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>

            <!-- User Address -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    User Address
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'Address',
                            [
                                'attribute' => 'County',
                                'value' => function ($model) {
                                    return \frontend\models\Counties::findOne($model->County)->name;
                                },
                            ], [
                                'attribute' => 'Subcounty',
                                'value' => function ($model) {
                                    return \frontend\models\SubCounties::findOne($model->Subcounty)->Name;
                                },
                            ],
                            'PhoneNumber',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <!-- Cart Summary -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">Cart Summary</div>
                <div class="card-body">
                    <h5 class="font-weight-bold">SubTotal</h5>
                    <span>KSh <?= number_format($totalSum, 2) ?></span>
                </div>
            </div>

            <!-- Rider Assigned -->
            <?php if ($order->Rider !== null && $order->status === Orders::STATUS_PAID) : ?>
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Rider Assigned</div>
                    <div class="card-body table-responsive">
                        <?= DetailView::widget([
                            'model' => $riderAssigned,
                            'attributes' => [
                                [
                                    'attribute' => 'Name',
                                    'value' => function ($model) {
                                        return $model->FirstName . $model->LastName;
                                    }
                                ],
                                [
                                    'attribute' => 'IdentificationNumber',
                                    'value' => function ($model) {
                                        return $model->IdentificationNumber;
                                    }
                                ],
                                [
                                    'attribute' => 'Email',
                                    'value' => function ($model) {
                                        return $model->Email;
                                    }
                                ],
                                [
                                    'attribute' => 'PhoneNumber',
                                    'value' => function ($model) {
                                        return $model->PhoneNumber;
                                    }
                                ],
                                [
                                    'attribute' => 'Vehicle',
                                    'value' => function ($model) {
                                        return $model->vehicle->Type;
                                    }
                                ],
                                [
                                    'attribute' => 'VehicleRegistration',
                                    'value' => function ($model) {
                                        return $model->VehicleRegistration;
                                    }
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>

            <!-- Assign Rider -->
            <div class="card">
                <div class="card-header bg-warning text-dark">Assign Rider</div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($order, 'Rider')->dropDownList(ArrayHelper::map(RiderRegistration::find()->where(['not', ['UserID' => null]])->all(), 'ID', function ($model) {
                        return $model->FirstName . ' ' . $model->LastName . ' - ' . $model->VehicleRegistration;
                    }))->label(false) ?>
                    <div class="form-group">
                        <?= Html::submitButton("Assign", ['class' => 'btn btn-primary btn-block']); ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>