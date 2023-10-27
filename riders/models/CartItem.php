<?php

namespace riders\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "CartItem".
 *
 * @property int $ID
 * @property int|null $product_id
 * @property int $quantity
 * @property int|null $created_by
 * @property int $order_id
 * @property User $createdBy
 * @property Products $product
 */
class CartItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'CartItem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity', 'created_by'], 'integer'],
            [['quantity'], 'required'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'ID']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['ID' => 'product_id']);
    }
    public static function getTotalCount($orderID){
        return CartItem::findBySql("SELECT SUM(p.price * c.quantity) as total_sum
                FROM CartItem c
                INNER JOIN Products p ON p.ID = c.product_id
                WHERE c.created_by = :userId AND c.order_id = $orderID",
            ['userId' => isCurrentUser()]
        )->scalar();
    }

}
