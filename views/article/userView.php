<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $model->name;

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="article-view">


    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::encode($model->text) ?></p>

</div>
