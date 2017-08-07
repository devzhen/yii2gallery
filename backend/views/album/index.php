<?php
/**@var $this \yii\web\View */
/**@var $model \yii\base\Model */
/**@var $pagination \yii\data\Pagination */
/**@var $albums array */
$this->title = "Albums";
?>

<!--Navs and albums-->
<div class="container">

    <!--Header-->
    <div class="row">

        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 logo">
            <h2><a href="<?= \Yii::$app->homeUrl ?>">Yii2 Gallery</a></h2>
        </div>

        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 navigation">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="<?= \Yii::$app->homeUrl ?>">All albums</a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        Actions <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a id="add-album" href="#" data-toggle="modal" data-target="#add-album-modal">Add album</a>
                        </li>
                        <?php if (\count($albums) > 0): ?>
                            <li><a href="<?= \yii\helpers\Url::to(['album/sort']) ?>">Sort albums</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li>
                    <form method="post" action="<?= \yii\helpers\Url::to(['site/logout']) ?>">
                        <button type="submit" class="btn btn-link">Logout(<?= Yii::$app->user->identity->username ?>)
                        </button>
                        <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                    </form>
                </li>
            </ul>
        </div>

    </div>

    <div class="color-bar-1"></div>
    <div class="color-bar-2"></div>

    <!--Content-->
    <div id="album-container" class="row">

        <?php if (\count($albums) == 0): ?>
            <h3>There are no albums in the gallery</h3>
        <?php endif; ?>


        <?php foreach ($albums as $album): ?>

            <!--Album of the gallery-->
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 album">

                <div class="album-content">

                    <?php if (\count($album['firstImage']) == 0): ?>
                        <img class="img-responsive" src="<?= \Yii::getAlias('@web/img/no-photo.jpg') ?>"
                             draggable="false"/>
                    <?php else: ?>
                        <img class="img-responsive" src="<?= $album['firstImage']['src'] ?>" draggable="false"/>
                    <?php endif; ?>


                    <?php
                    $cryptKey = \Yii::$app->params['cryptKey'];
                    $albumId = \Yii::$app->getSecurity()->encryptByKey($album['id'], $cryptKey);
                    ?>

                    <a href="<?= yii\helpers\Url::to(['album/one', 'album_id' => $albumId]) ?>" class="album-view">
                        <img class="album-view-icon" src="<?= \Yii::getAlias('@web/img/view-album.png') ?>"
                             data-toggle="tooltip" title="View details"/>
                    </a>

                    <a href="#" class="album-delete" data-toggle="modal" data-target="#delete-album-modal"
                       data-album-id="<?= $album['id'] ?>" data-album-name="<?= $album['name'] ?>">
                        <img class="album-delete-icon" src="<?= \Yii::getAlias('@web/img/delete-album.png') ?>"
                             data-toggle="tooltip" title="Delete"/>
                    </a>
                </div>
                <div class="album-footer">

                    <div class="album-footer-name">
                        <p><?= $album['name'] ?></p>
                    </div>

                    <div class="album-footer-date">
                        <?php
                        $date = new DateTime();
                        $date->setTimestamp($album['date']);
                        ?>
                        <p><?= $date->format("d-m-Y H:i:s") ?></p>
                    </div>

                    <div class="album-footer-description">
                        <p><?= $album['description'] ?></p>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

    <!--Pagination buttons-->
    <div class="row pagination-container">
        <div class="col-lg-12">
            <?php
            echo \yii\widgets\LinkPager::widget([
                'pagination' => $pagination,
            ]);
            ?>
        </div>
    </div>


</div>