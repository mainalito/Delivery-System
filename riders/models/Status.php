<?php

namespace riders\models;

use Yii;

/**
 * This is the model class for table "Status".
 *
 * @property int $ID
 * @property string|null $Status
 *
 * @property RiderRegistration[] $riderRegistrations
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Status';
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
     * Gets query for [[RiderRegistrations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRiderRegistrations()
    {
        return $this->hasMany(RiderRegistration::class, ['Status' => 'ID']);
    }
}
