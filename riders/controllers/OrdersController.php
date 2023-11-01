<?php

namespace riders\controllers;

use frontend\models\CartItem;
use frontend\models\Products;
use frontend\models\UserAddress;
use riders\models\Orders;
use riders\models\OrdersSearch;
use riders\models\RiderRegistration;
use Yii;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddToCart() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Get the raw JSON string from the POST data
        $rawData = Yii::$app->request->getRawBody();

        // Convert JSON string to PHP associative array
        $cartData = json_decode($rawData, true);
        // At this point, $cartData should be an associative array where the keys are product IDs and the values are quantities
        if(is_array($cartData)) {
            foreach($cartData as $productId => $quantity) {
                // Now you can handle each product ID and quantity pair accordingly
                // For instance, add them to the cart, update the cart, etc.

                // Example: Add product with ID $productId and quantity $quantity to cart
                // You might have a Cart class or component to handle this logic
                // Cart::addProduct($productId, $quantity);
            }

            // You can then return a response, like the updated cart count or some other relevant data
            return ['cartCount' => count($cartData)]; // This is just an example
        } else {
            // Handle the case where the cart data is not in the expected format
            return ['error' => 'Invalid cart data'];
        }
    }



    /**
     * Displays a single Orders model.
     * @param int $ID ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
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
        if ($order->load(Yii::$app->request->post())) {
            $order->DateConfirmed = date('Y-m-d H:i:s');
            if ($order->save(false)) {
                Yii::$app->session->setFlash('success', ' Delivery Successfully Confirmed. Tracking of the product has started.', true);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        $totalSum = CartItem::getTotalCount($order->ID);
        $model = UserAddress::find()->where(['UserID' => $order->user_id])->one();
        $riderAssigned = RiderRegistration::find()->where(['ID' => $order->Rider])->one();
        return $this->render('view', [
            'cartItems' => $cartItems, 'totalSum' => $totalSum,
            'model' => $model, 'order' => $order, 'riderAssigned' => $riderAssigned
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'ID' => $model->ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID)
    {
        $model = $this->findModel($ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ID ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID)
    {
        $this->findModel($ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = Orders::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
