<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\User;
use frontend\models\CartItem;
use frontend\models\Orders;
use frontend\models\Products;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {


        // Get the IDs of all confirmed orders
        $confirmedOrderIds = Orders::find()
            ->select('ID')
            ->where(['status' => Orders::STATUS_CONFIRMED])
            ->column();

        // Calculate the total earnings
        $totalEarnings = (float)CartItem::find()
            ->alias('c')
            ->innerJoin(['p' => Products::tableName()], 'p.ID = c.product_id')
            ->where(['c.order_id' => $confirmedOrderIds])
            ->sum(new Expression('p.price * c.quantity'));
        $totalProducts = (float)CartItem::find()
            ->alias('c')
            ->innerJoin(['p' => Products::tableName()], 'p.ID = c.product_id')
            ->where(['c.order_id' => $confirmedOrderIds])
            ->sum(new Expression('c.quantity'));
        $totalOrders = count($confirmedOrderIds);
        $totalUsers = User::find()->count();


        return $this->render('index', ['totalEarnings' => $totalEarnings,
            'totalProducts' => $totalProducts, 'totalOrders' => $totalOrders, 'totalUsers' => $totalUsers]);
    }


    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
