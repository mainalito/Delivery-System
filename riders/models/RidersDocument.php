<?php

namespace riders\models;

use backend\models\Documents;
use Yii;

/**
 * This is the model class for table "RidersDocument".
 *
 * @property int $ID
 * @property int|null $RiderID
 * @property int|null $DocumentTypeID
 * @property string|null $DocumentLink
 */
class RidersDocument extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'RidersDocument';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RiderID', 'DocumentTypeID'], 'integer'],
            [['DocumentLink'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'RiderID' => 'Rider ID',
            'DocumentTypeID' => 'Document Type ID',
            'DocumentLink' => 'Document Link',
        ];
    }
    public function getDocument()
    {
        return $this->hasOne(Documents::class, ['ID' => 'DocumentTypeID']);
    }
}
