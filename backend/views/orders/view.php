<?php
/** @var array $cartItems * */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = 'Cart';
\yii\web\YiiAsset::register($this);
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Cart Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mt-3">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td><?= $item['product_name'] ?></td>
                                    <td><?= Html::img('@web/' . $item['image'], ['class' => 'w-25 h-25']); ?></td>
                                    <td><?= $item['price'] ?></td>
                                    <td><input type="number"  disabled readonly min="1" class="form-control item-quantity"
                                               value="<?= $item['quantity'] ?>"></td>
                                    <td><?= number_format($item['total_price']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    User Address
                </div>
                <div class="card-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'Address',
                            [
                                'attribute' => 'County',
                                'value' => function($model){
                                    return \frontend\models\Counties::findOne($model->County)->name;
                                },
                            ], [
                                'attribute' => 'Subcounty',
                                'value' => function($model){
                                    return \frontend\models\SubCounties::findOne($model->Subcounty)->Name;

                                },
                            ],
                            'PhoneNumber',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">Cart Summary</div>
                <div class="card-body">
                    <div style="display: flex;  justify-content: space-between" class="mb-4">
                        <h5 class="font-weight-bold">SubTotal</h5>
                        <span>KSh <?= number_format($totalSum, 2) ?></span>
                    </div>

                </div>
            </div>

        </div>
    </div>


</div>
