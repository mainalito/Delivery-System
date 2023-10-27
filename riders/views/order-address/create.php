<?php

use riders\models\CartItem;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var riders\models\OrderAddress $model */
/** @var riders\models\Orders $order */

$this->title = 'Create Order Address';
$this->params['breadcrumbs'][] = ['label' => 'Order Addresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-address-create">

<!--    <h1>--><?php //= Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model, 'totalSum' => $totalSum,'cartItems'=>$cartItems

    ]) ?>

</div>
