<?php

namespace riders\models;

use Yii;

/**
 * This is the model class for table "SubCounties".
 *
 * @property int $ID
 * @property string|null $Name
 * @property int|null $CountyID
 *
 * @property Counties $county
 */
class SubCounties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'SubCounties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CountyID'], 'integer'],
            [['Name'], 'string', 'max' => 250],
            [['CountyID'], 'exist', 'skipOnError' => true, 'targetClass' => Counties::class, 'targetAttribute' => ['CountyID' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'Name',
            'CountyID' => 'County ID',
        ];
    }

    /**
     * Gets query for [[County]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCounty()
    {
        return $this->hasOne(Counties::class, ['ID' => 'CountyID']);
    }
}
