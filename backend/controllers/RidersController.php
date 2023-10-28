<?php

namespace backend\controllers;

use frontend\models\Orders;
use riders\models\RiderRegistration;
use riders\models\RiderRegistrationSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
    /**
     * Displays a single Products model.
     * @param int $ID ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID)
    {
        $model = $this->findModel($ID);
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if ($model->save()) {
                    //send notification to rider
                    //create for him login details in user table
                    // set a default password based on firstname or lastname
                    //set firstname as username
                    
                    Yii::$app->session->setFlash('success', 'Your details have been saved');
                    return $this->redirect(['view', 'ID' => $model->ID]);
                }
                Yii::$app->session->setFlash('error', 'Failed to save');
                $model->loadDefaultValues();
            }
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID ID
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = RiderRegistration::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
