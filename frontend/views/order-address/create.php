<?php

use frontend\models\CartItem;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\OrderAddress $model */
/** @var frontend\models\Orders $order */

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
