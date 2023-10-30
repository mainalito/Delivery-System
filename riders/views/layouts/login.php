<?php
/** @var View $this */

use yii\web\View;

/** @var string $content */

use yii\helpers\Html;
\riders\assets\RiderAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    
<div class="container">
    <?= $content ?>
</div>

<?php $this->endBody() ?>
<?php echo $this->blocks['bodyEndScript'] ?? '' ?>

</body>
</html>
<?php $this->endPage() ?>
