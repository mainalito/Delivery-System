<?php

namespace riders\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "RiderRegistration".
 *
 * @property int $ID
 * @property string|null $FirstName
 * @property string|null $LastName
 * @property int|null $Vehicle
 * @property string|null $VehicleRegistration
 * @property string|null $Email
 * @property string|null $PhoneNumber
 * @property string|null $IdentificationNumber
 * @property int|null $Status
 * @property int|null $UserID
 *
 * @property Status $status
 * @property Vehicle $vehicle
 */
class RiderRegistration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'RiderRegistration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdentificationNumber', 'Vehicle', 'VehicleRegistration', 'PhoneNumber', 'FirstName', 'LastName', 'Email'], 'required'],
            ['IdentificationNumber', 'unique', 'message' => 'This identification number has already been registered.'],
            ['IdentificationNumber', 'number', 'message' => 'Identification Number must be a numeric value.'],
            ['IdentificationNumber', 'string', 'length' => 8, 'tooShort' => 'Identification Number should contain exactly 8 characters.', 'tooLong' => 'Identification Number should contain exactly 8 characters.'],
            [['Vehicle', 'Status', 'UserID'], 'integer'],
            [['FirstName', 'LastName', 'Email'], 'string', 'max' => 100],
            [['VehicleRegistration', 'PhoneNumber'], 'string', 'max' => 50],
            [['Vehicle'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicle::class, 'targetAttribute' => ['Vehicle' => 'ID']],
            [['Status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['Status' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'Vehicle' => 'Vehicle',
            'VehicleRegistration' => 'Vehicle Registration',
            'Email' => 'Email',
            'PhoneNumber' => 'Phone Number',
            'IdentificationNumber' => 'Identification Number',
            'Status' => 'Status',
        ];
    }


    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['ID' => 'Status']);
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['ID' => 'UserID']);
    }

    /**
     * Gets query for [[Vehicle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::class, ['ID' => 'Vehicle']);
    }
}
