<?php

namespace riders\models;

use backend\models\Documents;
use common\models\User;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\UploadedFile;

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
 * @property string|null $files
 * @property int|null $Status
 * @property int|null $UserID
 *
 * @property Status $status
 * @property Vehicle $vehicle

 */
class RiderRegistration extends \yii\db\ActiveRecord
{
    const SCENARIO_RIDER = 'rider_signup';

    /**
     * {@inheritdoc}
     */

    public $documentType;
    public $Uploadfile;
    public $Uploadfiles;
    public static function tableName()
    {
        return 'RiderRegistration';
    }
    //    public function scenarios()
    //    {
    //        $scenarios = parent::scenarios();
    //        $scenarios[self::SCENARIO_RIDER] = ['username', 'email', 'password', 'firstname', 'lastname'];
    //        return $scenarios;
    //    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['Uploadfiles'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 4],
            // [['Uploadfile'], 'file', 'skipOnEmpty' => false],

            [['IdentificationNumber', 'Vehicle', 'VehicleRegistration', 'PhoneNumber', 'FirstName', 'LastName', 'Email'], 'required'],
            ['IdentificationNumber', 'unique', 'message' => 'This identification number has already been registered.'],
            ['IdentificationNumber', 'number', 'message' => 'Identification Number must be a numeric value.'],
            ['IdentificationNumber', 'string', 'length' => 8, 'tooShort' => 'Identification Number should contain exactly 8 characters.', 'tooLong' => 'Identification Number should contain exactly 8 characters.'],
            [['Vehicle', 'Status', 'UserID'], 'integer'],
            [['FirstName', 'LastName', 'Email'], 'string', 'max' => 100],
            [['files'], 'string'],
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
            'files' => 'Attach any attachments for identity proof'
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

    public static function getUserImage($ID)
    {
        $rider = RiderRegistration::find()->where(['UserID'=> $ID])->one();
        $Documents = RidersDocument::find()->where(['RiderID'=> $rider->ID])->all();

        foreach ($Documents as $doc)
            if ($doc->ID == 1) {
                return Html::img('@web/documents/riders/' . $doc->DocumentLink,['class'=>'img-profile rounded-circle']);
            }
            return '';
    }
   
    //     public function beforeSave($insert)
    // {
    //     if (parent::beforeSave($insert)) {
    //         // Handle the file upload here if $this->Uploadfiles is not empty.
    //         if ($this->Uploadfiles && !empty($this->Uploadfiles)) {
    //             $uploadPath = Yii::getAlias('@webroot/documents/files/');
    //             // Ensure the directory exists
    //             if (!is_dir($uploadPath)) {
    //                 mkdir($uploadPath, 0777, true);
    //             }

    //             $fileNames = []; // Array to store file names
    //             foreach ($this->Uploadfiles as $file) {
    //                 // Generate a unique filename here
    //                 $fileName = Yii::$app->security->generateRandomString(7) . time() . '.' . $file->extension;
    //                 $filePath = $uploadPath . DIRECTORY_SEPARATOR . $fileName;
    //                 if ($file->saveAs($filePath)) {
    //                     // Add only the file name to the array
    //                     $fileNames[] = $fileName;
    //                 } else {
    //                     // Handle the error accordingly
    //                     $this->addError('Uploadfiles', 'The file ' . $file->name . ' could not be saved.');
    //                     return false;
    //                 }
    //             }

    //             // Here we are assigning the JSON encoded file names to the 'files' attribute
    //             $this->files = Json::encode($fileNames);
    //         }
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

}
