<?php

namespace backend\controllers;

use frontend\models\Products;
use frontend\models\ProductsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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
     * Lists all Products models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
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

        return $this->render('view', [
            'model' => $this->findModel($ID),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Products();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->upload_image = UploadedFile::getInstance($model, 'upload_image');
                if ($model->save() && $model->upload()) {
                    Yii::$app->session->setFlash('success', 'Added product successfully');
                    return $this->redirect(['view', 'ID' => $model->ID]);
                }
                Yii::$app->session->setFlash('error', 'Failed to add a product');
                $model->loadDefaultValues();
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID)
    {
        $model = $this->findModel($ID);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->upload_image = UploadedFile::getInstance($model, 'upload_image');
                if (!$model->save()) {
                    var_dump($model->getErrors()) . exit();
                }
                if ($model->save() && $model->upload()) {
                    Yii::$app->session->setFlash('success', 'Added product successfully');
                    return $this->redirect(['view', 'ID' => $model->ID]);
                }
                Yii::$app->session->setFlash('error', 'Failed to add a product');
                $model->loadDefaultValues();
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ID ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID)
    {
        $model = $this->findModel($ID);

        // Assuming 'image' attribute of your model holds the relative path to the file
        $imagePath = Yii::getAlias('@webroot') . '/' . $model->image;

        // Check if the file exists and delete it
        if (file_exists($imagePath)) {
            if (!unlink($imagePath)) {
                Yii::$app->session->setFlash('error', 'Error deleting image file.');
                return $this->redirect(['index']);
            }
        }

        // Delete the model
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'The product and its image have been deleted.');
        } else {
            Yii::$app->session->setFlash('error', 'Error deleting the product.');
        }

        return $this->redirect(['index']);
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
        if (($model = Products::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
