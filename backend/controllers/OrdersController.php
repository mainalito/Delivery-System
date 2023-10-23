<?php

namespace backend\controllers;

use frontend\models\CartItem;
use frontend\models\Orders;
use frontend\models\Products;
use frontend\models\UserAddress;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrdersController extends Controller
{

    public function actionIndex()
    {
        $query = Orders::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $order = Orders::findOne($id);
        if (!$order) throw  new NotFoundHttpException();

        $cartItems = CartItem::find()
            ->select([
                'product_id' => 'c.product_id',
                'image' => 'p.image',
                'product_name' => 'p.product_name',
                'price' => 'p.price',
                'quantity' => 'c.quantity',
                'total_price' => new Expression('p.price * c.quantity')
            ])
            ->alias('c')
            ->innerJoin(['p' => Products::tableName()], 'p.ID = c.product_id')
            ->where(['c.order_id' => $order->ID])
            ->asArray()
            ->all();
        $totalSum = CartItem::getTotalCount($order->ID);
        $model = UserAddress::find()->where(['UserID' => $order->user_id])->one();
        return $this->render('view', ['cartItems' => $cartItems, 'totalSum' => $totalSum,
            'model' => $model
        ]);
    }

}