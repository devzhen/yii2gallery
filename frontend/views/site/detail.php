<?php
/**@var $this \yii\web\View */
/**@var $album common\models\Album */
$this->title = "Album detail";

$date = new DateTime();
$date->setTimestamp($album->date);

$this->registerJsFile('/js/jquery.fancybox.min.js', [
    'depends' => \frontend\assets\AppAsset::className()
]);
$this->registerCssFile('/css/jquery.fancybox.min.css', [
    'depends' => \frontend\assets\AppAsset::className()
]);
?>

<!--Navs and images-->
<div class="container">

    <!--Header-->
    <div class="row">

        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 logo">
            <h2><a href="<?= \Yii::$app->homeUrl ?>">Yii2 Gallery</a></h2>
        </div>

        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 navigation">
            <ul class="nav nav-pills">
                <li>
                    <a href="<?= \Yii::$app->homeUrl ?>">Back to all albums</a>
                </li>
            </ul>
        </div>

    </div>

    <div class="color-bar-1"></div>
    <div class="color-bar-2"></div>

    <!--Content-->
    <div id="album-container" class="row">

        <div class="col-lg-12">
            <ul class="album-info">
                <li>Name:<h4><?= $album->name ?></h4></li>
                <li>Date: <h4><?= $date->format("d-m-Y H:i:s") ?></h4></li>
                <li>Description:<h4> <?= $album->description ?></h4></li>
            </ul>
        </div>
    </div>

    <div id="image-container" class="row">

        <?php if (\count($album->images) == 0): ?>
            <h5>There are no images in the album</h5>
        <?php endif; ?>

        <?php foreach ($album->images as $image): ?>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 image">

                <a data-fancybox="gallery" href="<?= $image->src ?>">

                    <!--Изображение галереи-->
                    <img class="gallery-image img-responsive" src="<?= $image->src ?>" alt="">

                </a>
            </div>

        <?php endforeach; ?>

    </div>
</div>
