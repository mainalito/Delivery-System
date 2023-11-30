<?php

namespace riders\controllers;

use backend\controllers\RidersController;
use backend\models\Documents;
use common\models\User;
use Exception;
use riders\models\RiderRegistration;
use riders\models\RiderRegistrationSearch;
use riders\models\RidersDocument;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * RiderRegistrationController implements the CRUD actions for RiderRegistration model.
 */
class RiderRegistrationController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['create'],

                    'rules' => [
                        [
                            'actions' => ['create'],
                            'allow' => true,
                            'roles' => ['?'], // Allow guests
                        ],

                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        // You can specify other HTTP method restrictions for other actions if necessary
                    ],
                ],
            ]
        );
    }


    /**
     * Lists all RiderRegistration models.
     *
     * @return string
     */
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
     * Displays a single RiderRegistration model.
     * @param int $ID ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID)
    {
        $rider = RiderRegistration::find()->where(['UserID' => $ID])->one();
        if (!$rider) throw new NotFoundHttpException('You are not allowed to access this services');
        $Documents = RidersDocument::find()->where(['RiderID' => $rider->ID])->all();

        return $this->render('view', [
            'model' => $rider,
            'Documents' => $Documents
        ]);
    }

    /**
     * Creates a new RiderRegistration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (isCurrentUser()) {
            // Log the user out
            Yii::$app->user->logout();

            // Optionally, you can redirect the user to the login page
            return $this->goHome(); // or use $this->redirect(['site/login']);
        }
        $this->layout = 'login';

        $model = new RiderRegistration();
        $documentTypes = Documents::find()->all();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // VarDumper::dump(UploadedFile::getInstances($model, 'Uploadfiles'),10,true);exit;

                if ($model->save()) {
                    foreach ($documentTypes as $docType) {
                        if ($docType->Multiple) {
                            // Handle multiple file uploads
                            $uploadedFiles = UploadedFile::getInstances($model, "Uploadfiles[{$docType->ID}]");
                            foreach ($uploadedFiles as $file) {
                                if ($file) {
                                    $document  = RidersDocument::find()->where(["RiderID" => $model->ID, 'DocumentTypeID' => $docType->ID])->one();
                                    if (!$document) {
                                        $document = new RidersDocument();
                                        $document->DocumentTypeID = $docType->ID;
                                        $document->RiderID = $model->ID;
                                    }

                                    $document->DocumentLink = $this->uploadDocument('riders', $file);
                                    if (!$document->save()) {
                                        VarDumper::dump($document->getErrors(), 10, true);
                                        var_dump('first');
                                        exit;
                                    }
                                }
                            }
                        } else {
                            // Handle single file upload
                            $uploadedFile = UploadedFile::getInstance($model, "Uploadfile[{$docType->ID}]");

                            if ($uploadedFile) {
                                $document  = RidersDocument::find()->where(["RiderID" => $model->ID, 'DocumentTypeID' => $docType->ID])->one();
                                if (!$document) {
                                    $document = new RidersDocument();
                                    $document->DocumentTypeID = $docType->ID;
                                    $document->RiderID = $model->ID;
                                }

                                $document->DocumentLink = $this->uploadDocument('riders', $uploadedFile);
                                if (!$document->save()) {
                                    VarDumper::dump($document->getErrors(), 10, true);
                                    exit;
                                }
                            }
                        }
                    }
                    //TODO: send email to the created user with necessary information and also send email in the backend for admin 


                    Yii::$app->session->setFlash('success', 'Your Details were updated successfully');
                    return $this->redirect(['site/login']);
                }
                VarDumper::dump($model->getErrors());
                exit;

                Yii::$app->session->setFlash('error', 'Failed to update your details');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model, 'documentTypes' => $documentTypes
        ]);
    }
    public function uploadDocument($FolderName, $doc)
    {

        $NewBaseName = time() . Yii::$app->getSecurity()->generateRandomString(7);
        $dir = Yii::getAlias('@webroot/documents/' . $FolderName);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true); // This creates the directory with 0777 permissions recursively
        }
        $destination = $dir . '/' . $NewBaseName . '.' . $doc->extension;


        if ($doc->saveAs($destination)) {
            return $NewBaseName . '.' . $doc->extension;
        } else {
            // Add error logging or handling here
            var_dump("Failed to save document: " . $doc->error);
            return false;
        }
    }
    /**
     * Updates an existing RiderRegistration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($UserID)
    {

        $model = $this->findUser($UserID);
        $user = User::find()->where(['id' => $UserID])->one();

        if (isCurrentUser() != $user->id) throw new ForbiddenHttpException('You are not allowed to perform such action');
        $documentTypes = Documents::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $user->load($this->request->post())) {
                // VarDumper::dump(UploadedFile::getInstances($model, 'Uploadfiles'),10,true);exit;
                if ($model->validate() && $user->validate()) {
                    $user->setPassword($user->new_password); // Set the new password

                    if ($model->save() && $user->save()) {
                        foreach ($documentTypes as $docType) {
                            if ($docType->Multiple) {
                                // Handle multiple file uploads
                                $uploadedFiles = UploadedFile::getInstances($model, "Uploadfiles[{$docType->ID}]");
                                foreach ($uploadedFiles as $file) {
                                    if ($file) {
                                        $document  = RidersDocument::find()->where(["RiderID" => $model->ID, 'DocumentTypeID' => $docType->ID])->one();
                                        if (!$document) {
                                            $document = new RidersDocument();
                                            $document->DocumentTypeID = $docType->ID;
                                            $document->RiderID = $model->ID;
                                        }

                                        $document->DocumentLink = $this->uploadDocument('riders', $file);
                                        if (!$document->save()) {
                                            VarDumper::dump($document->getErrors(), 10, true);
                                            var_dump('first');
                                            exit;
                                        }
                                    }
                                }
                            } else {
                                // Handle single file upload
                                $uploadedFile = UploadedFile::getInstance($model, "Uploadfile[{$docType->ID}]");

                                if ($uploadedFile) {
                                    $document  = RidersDocument::find()->where(["RiderID" => $model->ID, 'DocumentTypeID' => $docType->ID])->one();
                                    if (!$document) {
                                        $document = new RidersDocument();
                                        $document->DocumentTypeID = $docType->ID;
                                        $document->RiderID = $model->ID;
                                    }

                                    $document->DocumentLink = $this->uploadDocument('riders', $uploadedFile);
                                    if (!$document->save()) {
                                        VarDumper::dump([$document->getErrors(),1], 10, true);
                                        exit;
                                    }
                                }
                            }
                        }



                        Yii::$app->session->setFlash('success', 'Your Details and password were updated successfully');
                        return $this->redirect(['view', 'ID' => $user->id]);
                    }
                }

                Yii::$app->session->setFlash('error', 'Failed to update your details');
            }
        }
        return $this->render('update', [
            'model' => $model, 'user' => $user, 'documentTypes' => $documentTypes
        ]);
    }
    public function actionViewAttachments($ref)
    {
        // Retrieve the document model using the ID provided in the request
        $documentModel = RidersDocument::findOne($ref);
        if (!$documentModel) {
            throw new NotFoundHttpException('The requested document does not exist.');
        }

        // Assuming the DocumentLink attribute contains the filename of the document
        $documentFile = $documentModel->DocumentLink;
        $filePath = Yii::getAlias('@riders/web/documents/riders/') . $documentFile;

        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new NotFoundHttpException('The file does not exist or cannot be read.');
        }

        // Detect the correct MIME type of the file
        $mimeType = FileHelper::getMimeType($filePath);

        // Send the file to the browser
        return Yii::$app->response->sendFile($filePath, $documentFile, [
            'mimeType' => $mimeType,
            'inline' => true // This will attempt to display the file inline if the browser is capable
        ]);
    }



    /**
     * Deletes an existing RiderRegistration model.
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

    public function actionReviewOrder($id)
    {
        $id = base64_decode($id);
    }

    /**
     * Finds the RiderRegistration model based on its primary key value.
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

    protected function findUser($UserID)
    {
        if (($model = RiderRegistration::findOne(['UserID' => isCurrentUser()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
