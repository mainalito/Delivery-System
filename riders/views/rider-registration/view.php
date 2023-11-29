<?php

use riders\models\RiderRegistration;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var riders\models\RiderRegistration $model */

$this->title = $model->FirstName;

\yii\web\YiiAsset::register($this);
?>
<div class="rider-registration-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>-->
    <?= Html::a('Update', ['update', 'UserID' => isCurrentUser()], ['class' => 'btn btn-primary mb-2 float-right']) ?>
    <!--        --><?php //= Html::a('Delete', ['delete', 'ID' => $model->ID], [
                    //            'class' => 'btn btn-danger',
                    //            'data' => [
                    //                'confirm' => 'Are you sure you want to delete this item?',
                    //                'method' => 'post',
                    //            ],
                    //        ]) 
                    ?>
    <!--    </p> -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'IdentificationNumber',
            [
                'label' => 'Rider Full Name', 'value' => fn () =>
                $model->FirstName . ' ' . $model->LastName
            ],
            [
                'label' => 'Vehicle', 'value' => fn () => $model->vehicle->Type,
            ],
            'VehicleRegistration',
            [
                'label' => 'Status',
                'format' => 'raw',
                'attribute' => 'Status', // Attribute used for sorting and filtering
                'value' => function ($model) {
                    if ($model->Status == 1) {
                        return Html::tag('span', @$model->status->Status, ['class' => 'badge badge-success']);
                    } elseif ($model->Status == 2) {
                        return Html::tag('span', @$model->status->Status, ['class' => 'badge badge-danger']);
                    }
                    return @$model->status->Status;
                },
            ],

            'Email:email',
            'PhoneNumber',

        ],
    ]) ?>

    <?php if (!empty($Documents)) : ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Document Name</th>
                        <th>Documents</th>
                    
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $documentsGroupedByName = [];

                    foreach ($Documents as $document) {
                        $documentsGroupedByName[$document->document->DocumentName][] = $document;
                    }

                    foreach ($documentsGroupedByName as $docName => $docs) : ?>
                        <tr>
                            <td><?= Html::encode($docName) ?></td>
                            <td>
                                <?php foreach ($docs as $doc) : ?>
                                    <?php if ($doc->DocumentTypeID == 1) : ?>
                                        <?php echo Html::img('@web/documents/riders/' . $doc->DocumentLink,['class'=>'img-profile rounded-circle']) ?>

                                    <?php else : ?>
                                        <?= Html::a('View Document', ['view-attachments', 'ref' => $doc->ID], ['target' => '_blank', 'class' => 'mr-2']) ?>
                                       <?= $doc->ID?> 

                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        
                        </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
        </div>
    <?php endif; ?>



</div>