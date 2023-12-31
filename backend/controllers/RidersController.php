<?php

namespace backend\controllers;

use common\models\User;
use frontend\models\SignupForm;
use riders\models\RiderRegistration;
use riders\models\RiderRegistrationSearch;
use Yii;
use yii\db\Exception;
use yii\helpers\VarDumper;
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
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID)
    {
        $model = $this->findModel($ID);
        $user = User::findOne(['id' => $model->UserID]);

//        $model->scenario = RiderRegistration::SCENARIO_RIDER;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if ($model->save()) {

                    $this->saveRider($model);
                    self::sendEmail($user);
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

    private function saveRider(RiderRegistration $model)
    {
        // Check if the user exists
        $user = User::findOne(['id' => $model->UserID]);

        // If no user found and the model status is 1 (approved), create a new user
        if (!$user && $model->Status == 1) {
            $user = new User();

            $user->firstname = $model->FirstName;
            $user->lastname = $model->LastName;
            $user->usertypeid = SignupForm::STATUS_RIDER;
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();

            // Assign fields with unique username logic
            $user->username = $model->FirstName . $this->generateRandomString();

            while (!$user->validate(['username'])) {
                $user->username = $model->FirstName . $this->generateRandomString();
            }

            $user->setPassword(strtolower($model->LastName)); // Use the setPassword method you have in your User model
            $user->email = $model->Email;

            // Validate and save the user
            if (!$user->save()) {
                // Handle validation errors
                Yii::$app->session->setFlash('error', 'Failed to save User.');
                return false;
            }

            $model->UserID = $user->id;
            // If user account is created/exists, try to save the model
            if (!$model->save()) {
                // Handle error while saving the model
                Yii::$app->session->setFlash('error', 'Failed to save Rider model.');
                return false;
            }
            $this->sendEmail($user);
        } elseif ($model->Status == 2) {
            // If status is 2, don't create an account and return early
            return false;
        }

        // Send notification to rider logic here
        // E.g., using Yii2's mailer component to send an email
        return true;
    }

    protected function sendEmail(User $user)
    {
        try {
            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'riderVerify-html'],
                    ['user' => $user]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($user->email)
                ->setSubject('Account registration at ' . Yii::$app->name)
                ->send();

        } catch (Exception $e) {
            VarDumper::dump($e->getMessage(), 10, true);
            exit;
        }
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID ID
     * @return RiderRegistration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = RiderRegistration::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function generateRandomString($length = 4)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
