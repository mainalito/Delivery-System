<?php

namespace frontend\controllers;

use frontend\models\SubCounties;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class DropDownController extends Controller
{
    private $dependencyDropdownFirstParam;


    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->dependencyDropdownFirstParam = Yii::$app->request->post('depdrop_parents') ?? NULL;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['sub-county'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSubCounty()
    {
        echo $this->_generate_dropDown(
            SubCounties::find()
                ->where(['CountyID' => $this->dependencyDropdownFirstParam])
                ->all()
        );
    }

    private function _generate_dropDown($data)
    {
        $value = 'Name';

        $response = [];

        foreach ($data as $datum)
            $response[] = [
                'id' => $datum->ID,
                'name' => $datum->$value,
            ];

        return json_encode([
            'output' => $response,
            'selected' => [],
        ]);
    }
}