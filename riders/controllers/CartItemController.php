<?php

namespace riders\controllers;

use riders\models\CartItem;
use riders\models\Orders;
use riders\models\Products;
use Yii;
use yii\db\Expression;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartItemController extends Controller
{
    public function behaviors()
    {
        return
            [
                [
                    'class' => ContentNegotiator::class,
                    'only' => ['add', 'change-quantity'],
                    'formats' => ['application/json' => Response::FORMAT_JSON],
                ],
                [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST', 'DELETE']
                    ]
                ]
            ];
    }

    public function actionIndex()
    {
        $userId = isCurrentUser();
        $cartItems = [];
        $totalSum = 0;

        // Check if the user has a confirmed order
        $order = Orders::find()->where(['user_id' => $userId, 'status' => Orders::STATUS_DRAFT])->one();

        // If there's no confirmed order, fetch the cart items
        if ($order) {
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
        }
        return $this->render('index', ['cartItems' => $cartItems, 'totalSum' => $totalSum]);
    }


    public function actionAdd()
    {
        $productId = \Yii::$app->request->post('id');
        $product = Products::findOne($productId);

        if (!$product) throw new NotFoundHttpException("Product doesn't exist " . $productId);

        // Check if there's a draft order for the current user
        $order = Orders::find()->where(['user_id' => isCurrentUser(), 'status' => Orders::STATUS_DRAFT])->one();

        // If there's no draft order, create one
        if (!$order) {
            $order = new Orders();
            $order->user_id = isCurrentUser();
            $order->status = Orders::STATUS_DRAFT;

            if (!$order->save()) {
                return ['success' => false, 'message' => 'Failed to create a draft order.'];
            }
        }

        // Check if the cart item for the given product already exists in the current draft order
        $cartItem = CartItem::find()->where(['order_id' => $order->ID, 'product_id' => $productId])->one();

        if ($cartItem) {
            // Increase the quantity for the existing cart item
            $cartItem->quantity++;
        } else {
            // Create a new cart item for the desired product and link it to the draft order
            $cartItem = new CartItem();
            $cartItem->order_id = $order->ID;
            $cartItem->created_by = isCurrentUser();
            $cartItem->product_id = $productId;
            $cartItem->quantity = 1;
        }

        // Save the cart item (whether it's new or updated)
        if ($cartItem->save()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Failed to save cart item.'];
        }
    }


    public function actionDelete($id)
    {

        // Find the cart item by its ID
        $cartItem = CartItem::findOne($id);

        // Verify if the cart item belongs to the current user
        if ($cartItem && $cartItem->created_by == isCurrentUser()) {
            $cartItem->delete();

            // Redirect back to the cart page with a success message
            Yii::$app->session->setFlash('success', 'Item removed from cart.');
            return $this->redirect(['cart/index']);
        } else {
            // Item not found or not belonging to the user
            Yii::$app->session->setFlash('error', 'Unable to remove item from cart.');
            return $this->redirect(['cart/index']);
        }
    }

    public function actionChangeQuantity()
    {
        $order = Orders::find()->where(['user_id' => isCurrentUser(), 'status' => Orders::STATUS_DRAFT])->one();

        $productId = \Yii::$app->request->post('id');
        $product = Products::findOne($productId);
        if (!$product) throw new NotFoundHttpException("Product doesn't exist " . $productId);
        if (!$order) throw new NotFoundHttpException("Order doesn't exist ");

        $quantity = \Yii::$app->request->post('quantity');
        $cartItem = CartItem::find()->where(['created_by' => isCurrentUser(), 'product_id' => $productId, 'order_id' => $order->ID])->one();
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }
        $totalQ = (int)CartItem::find()
            ->where(['created_by' => isCurrentUser(), 'order_id' => $order->ID])
            ->sum('quantity');
        $ItemQ = (int)CartItem::find()
            ->where(['created_by' => isCurrentUser(), 'order_id' => $order->ID, 'product_id' => $productId])
            ->sum('quantity');
        $totalSum = CartItem::getTotalCount($order->ID);
        return ['quantity' => number_format($totalQ, 2), 'price' => number_format($ItemQ * $product->price, 2),
            'totalSum' => number_format($totalSum, 2)
        ];
    }


}