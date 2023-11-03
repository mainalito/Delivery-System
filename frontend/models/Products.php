<?php

namespace frontend\models;

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
    /**      * @var UploadedFile */
    public $upload_image;

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
            [['upload_image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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

    public function upload()
    {
        if ($this->validate()) {

            $uploadDir = 'uploads/';

            // Check if the directory exists, and if not, create it
            if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
                // The second parameter sets the permissions and the third parameter allows the creation of nested directories
                if (!mkdir($uploadDir, 0777, true)) {
                    throw new \Exception('Failed to create folders...');
                }
            }
            $NewBaseName = Yii::$app->getSecurity()->generateRandomString(7) . time();
            $fullPath = $uploadDir . $NewBaseName . '.' . $this->upload_image->extension;
            $this->upload_image->saveAs($fullPath);
            $this->image = $fullPath;
            $this->save(false);
            return true;
        } else {
            return false;
        }
    }
}
