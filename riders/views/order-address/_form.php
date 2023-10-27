<?php

use yii\bootstrap4\Accordion;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var riders\models\UserAddress $model */
$selectedCounty = $model->County;
$subcounties = [];
if ($selectedCounty) {
    $subcounties = ArrayHelper::map(\riders\models\Subcounties::find()->where(['CountyID' => $selectedCounty])->all(), 'ID', 'Name');
}

?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 ">
            <div class="card">
                <h5 class="card-header">
                    Customer Address
                </h5>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'Address')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'County')->dropDownList(
                        ArrayHelper::map(\riders\models\Counties::find()->all(), 'ID', 'name'),
                        [
                            'prompt' => 'Select County',
                            'onchange' => new \yii\web\JsExpression('
                                $.get("subcounties?id=" + $(this).val(), function(data) {
                                    var $dropdown = $("select#subcounties-id");
                                    $dropdown.empty();
                                    $.each(data, function(index, item) {
                                        $dropdown.append($("<option></option>").attr("value", item.id).text(item.name));
                                    });
                                });
        ')
                        ]
                    ) ?>
                    <?= $form->field($model, 'Subcounty')->dropDownList(
                        $subcounties, // Populate with the related subcounties
                        [
                            'id' => 'subcounties-id',
                            'prompt' => 'Select Subcounty',
                            'options' => [$model->Subcounty => ['Selected' => true]] // Set the saved value as selected
                        ]
                    ) ?>

                    <?= $form->field($model, 'PhoneNumber')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

            </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Cart Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mt-3">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr data-id="<?= $item['product_id'] ?>"
                                    data-url="<?= Url::to(['/cart-item/change-quantity']) ?>">
                                    <td><?= Html::img('@web/' . $item['image'], ['class' => 'w-25 h-25']); ?></td>
                                    <td><?= $item['product_name'] ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?= Html::a('Modify Cart', ['/cart-item/'], ['class' => 'btn btn-outline-primary mt-3 w-100']) ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">Item's total (<?= $this->params['cartCount'] ?>): <strong
                                class="float-right">KSh <?= number_format($totalSum, 2) ?></strong></p>

                    <p class="mt-3 mb-1"><strong>Total:</strong> <strong
                                class="float-right">KSh <?= number_format($totalSum, 2) ?></strong></p>
                    <?= Html::a('Confirm Order', ['/order-address/confirm'], ['class' => 'btn btn-warning mt-3 w-100', 'data-method' => 'post']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
