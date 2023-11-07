<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Documents $model */

$this->title = $model->DocumentName;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="documents-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
       
        'DocumentName',
        [
            'attribute' => 'DocumentMimeType',
            'value' => function ($model) {
                return $model->getReadableDocumentMimeTypes();
            },
        ],
        [
            'attribute' => 'Multiple',
            'format'=>'raw',
            'value' => function ($model) {
                return $model->Multiple == 1 ? Html::tag('span','Yes',['class'=>'badge badge-success']) : Html::tag('span','No',['class'=>'badge badge-warning']);
            },
        ],
        [
            'attribute' => 'Required',
            'format'=>'raw',

            'value' => function ($model) {
                return $model->Required == 1 ? Html::tag('span','Yes',['class'=>'badge badge-success']) : Html::tag('span','No',['class'=>'badge badge-warning']);
            },
        ],
       
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>


</div>
