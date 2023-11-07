<?php namespace riders\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // Define your rules here
                    [
                        'allow' => true,
                        'roles' => ['@'], // Only logged-in users
                    ],
                    // You can also define rules that apply to guests using '?' role.
                ],
            ],
            // Other behaviors...
        ];
    }
}
