<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ConfirmationStatus".
 *
 * @property int $ID
 * @property string|null $Status
 *
 * @property Orders[] $orders
 * @property Orders[] $orders0
 */
class ConfirmationStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ConfirmationStatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['RiderDelivery' => 'ID']);
    }

    /**
     * Gets query for [[Orders0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders0()
    {
        return $this->hasMany(Orders::class, ['RiderDelivery' => 'ID']);
    }
}
