<?php

namespace riders\models;

use Yii;

/**
 * This is the model class for table "Products".
 *
 * @property int $ID
 * @property string|null $product_name
 * @property string|null $description
 * @property string|null $image
 * @property float|null $price
 *
 * @property CartItem[] $cartItems
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'string'],
            [['price'], 'number'],
            [['product_name', 'description'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'product_name' => 'Product Name',
            'description' => 'Description',
            'image' => 'Image',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[CartItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::class, ['product_id' => 'ID']);
    }
}
