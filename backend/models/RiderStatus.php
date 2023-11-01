<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "RiderStatus".
 *
 * @property int $ID
 * @property string|null $RiderStatus
 */
class RiderStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'RiderStatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RiderStatus'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'RiderStatus' => 'Rider Status',
        ];
    }
}
