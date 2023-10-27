<?php

namespace riders\models;

use Yii;

/**
 * This is the model class for table "UserAddress".
 *
 * @property int $ID
 * @property string|null $County
 * @property string|null $Subcounty
 * @property string|null $Address
 * @property string|null $PhoneNumber
 * @property int|null $UserID
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'UserAddress';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserID'], 'integer'],
            [['County', 'Subcounty', 'Address','PhoneNumber'], 'string', 'max' => 500],
            [['County', 'Subcounty', 'Address','PhoneNumber'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'County' => 'County',
            'Subcounty' => 'Subcounty',
            'Address' => 'Address',
            'PhoneNumber' => 'Phone Number',
            'UserID' => 'User ID',
        ];
    }
}
