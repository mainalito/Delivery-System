<?php

namespace riders\models;

use Yii;

/**
 * This is the model class for table "Vehicle".
 *
 * @property int $ID
 * @property string|null $Type
 *
 * @property RiderRegistration[] $riderRegistrations
 */
class Vehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Vehicle';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Type' => 'Type',
        ];
    }

    /**
     * Gets query for [[RiderRegistrations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRiderRegistrations()
    {
        return $this->hasMany(RiderRegistration::class, ['Vehicle' => 'ID']);
    }
}
