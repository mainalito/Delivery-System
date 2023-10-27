<?php

namespace backend\controllers;

use frontend\models\Orders;
use riders\models\RiderRegistration;
use riders\models\RiderRegistrationSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class RidersController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new RiderRegistrationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


}