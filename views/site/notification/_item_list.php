<?php

/**
 * @var $model \app\models\SentNotification
 */
use yii\helpers\Html;
?>

<div id="<?=$model->id?>" class="not_list_item alert <?=$model->is_read ? 'alert-warning' : 'alert-success' ?>">
    <div class="subject"><strong><?=$model->subject ?></strong></div> 
    <div class="date"><?=$model->sent_at//date('D, m, Y, H:i',$model->sent_at)?></div>
    <div class="from">from: <?=$model->fromUser->username ?></div>
    <div class="read_button">
    <?=$model->is_read ? "" : "<button type=\"button\" class=\"btn btn-success btn-sm not_read\"\">Прочитано</button>"?>
    </div>
    <p class="text"><?=$model->text ?></p>
</div>
