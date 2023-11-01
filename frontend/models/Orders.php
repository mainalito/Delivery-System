<?php

namespace frontend\models;

use backend\models\ConfirmationStatus;
use riders\models\RiderRegistration;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "Orders".
 *
 * @property int $ID
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null confrimed_at
 * @property Track[] $tracks
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_CONFIRMED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['confirmed_at', 'DateConfirmed', 'DateAssigned', 'DateDelivered'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['Rider'], 'exist', 'skipOnError' => true, 'targetClass' => RiderRegistration::class, 'targetAttribute' => ['Rider' => 'ID']],
            [['RiderConfirmation'], 'exist', 'skipOnError' => true, 'targetClass' => ConfirmationStatus::class, 'targetAttribute' => ['Status' => 'ID']],
            [['RiderDelivery'], 'exist', 'skipOnError' => true, 'targetClass' => ConfirmationStatus::class, 'targetAttribute' => ['Status' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Tracks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTracks()
    {
        return $this->hasMany(Track::class, ['order_id' => 'ID']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /**
     * Gets query for [[Rider]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRider()
    {
        return $this->hasOne(RiderRegistration::class, ['ID' => 'Rider']);
    }
    /**
     * Gets query for [[Rider]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRiderAvailabilityConfirmation()
    {
        return $this->hasOne(ConfirmationStatus::class, ['ID' => 'Status']);
    }
    /**
     * Gets query for [[Rider]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRiderDeliveryConfirmation()
    {
        return $this->hasOne(ConfirmationStatus::class, ['ID' => 'Status']);
    }
}
