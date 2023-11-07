<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "Documents".
 *
 * @property int $ID
 * @property string|null $DocumentName
 * @property string|null $DocumentMimeType
 * @property int|null $Multiple
 * @property int|null $Required
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Documents extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['Multiple', 'Required'], 'integer'],
            [['DocumentName'], 'string', 'max' => 50],
            [['DocumentMimeType'], 'safe'],
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DocumentName' => 'Document Name',
            'DocumentMimeType' => 'Document Mime Type',
            'Multiple' => 'Multiple',
            'Required' => 'Required',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getReadableDocumentMimeTypes()
    {
        $mimeTypesMap = [
            'Image' => ['image/jpeg', 'image/png', 'image/gif'],
            'Word'  => ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'Excel' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        ];
    
        // We'll flip the map to make the MIME types the keys
        $flippedMimeTypesMap = [];
        foreach ($mimeTypesMap as $type => $mimeArray) {
            foreach ($mimeArray as $mime) {
                $flippedMimeTypesMap[$mime] = $type;
            }
        }
    
        $selectedTypes = Json::decode($this->DocumentMimeType);
        
        $readableTypes = [];
        foreach ($selectedTypes as $mime) {
            if (isset($flippedMimeTypesMap[$mime])) {
                $readableTypes[$flippedMimeTypesMap[$mime]] = $flippedMimeTypesMap[$mime];
            }
        }
    
        // Make sure we only return unique category names
        $readableTypes = array_unique($readableTypes);
    
        return implode(', ', $readableTypes); // Join the names with a comma
    }
    

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Assuming 'DocumentMimeType' is the attribute name where you store the MIME types
            $mimeTypesMap = [
                'Image' => ['image/jpeg', 'image/png', 'image/gif'],
                'Word'  => ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                'Excel' => ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
            ];

            $selectedOptions = Json::encode($this->DocumentMimeType);
            $mimeTypesToSave = [];

            foreach (Json::decode($selectedOptions) as $option) {
                if (isset($mimeTypesMap[$option])) {
                    $mimeTypesToSave = array_merge($mimeTypesToSave, $mimeTypesMap[$option]);
                }
            }

            // JSON encode the MIME types for storage
            $this->DocumentMimeType = Json::encode($mimeTypesToSave);

            return true;
        } else {
            return false;
        }
    }
}
