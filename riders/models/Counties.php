<?php

namespace riders\models;

use Yii;

/**
 * This is the model class for table "Counties".
 *
 * @property int $ID
 * @property string|null $name
 *
 * @property SubCounties[] $subCounties
 */
class Counties extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Counties';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[SubCounties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubCounties()
    {
        return $this->hasMany(SubCounties::class, ['CountyID' => 'ID']);
    }
}
