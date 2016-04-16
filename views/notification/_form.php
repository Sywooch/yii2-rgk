<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Event;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\NotificationType;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */
/* @var $form yii\widgets\ActiveForm */

$allEvents = Event::find()->indexBy('id')->all();
$eventDropDown = ArrayHelper::map($allEvents,'id','label');
$usersDropDown = [null => ""] + ArrayHelper::map(User::find()->all(),'id','username');

?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'event_id')->dropDownList($eventDropDown,[
        'onchange' => 'not_form.on_event_change()',
    ]) ?>


    <?= $form->field($model, 'from_user_id')->dropDownList($usersDropDown) ?>

    <?= $form->field($model, 'to_user_id')->dropDownList($usersDropDown) ?>

    <?= $form->field($model, 'to_all_users')->checkbox([
        'onchange' => 'not_form.on_all_users_change()',
    ]) ?>

    <div class="well well-sm">If u don't chose user it will be passed from context model</div>
    
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 5]) ?>

    <div class="form-group" id="paste_options">
<!--        <label class="control-label">Possible substitution</label>-->
        <?php
        /* @var $event app\models\Event */
        foreach ($allEvents as $event) {
            echo '<p class="well well-sm" style="display:none">
                            <strong>Possible substitution:</strong> '.$event->paste_options.'</p>';
        }
        ?>
    </div>
    
    <?= $form->field($model, 'notType')->checkboxList(ArrayHelper::map(NotificationType::find()->all(),'id','name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php

    $this->registerJs('
     var not_form = {
        on_event_change: function(){
            $("#paste_options").children("p").hide().eq($("#notificationform-event_id").val()-1).show();
        },
        on_all_users_change: function(){
           $("#notificationform-to_all_users").is(":checked")?
            $("#notificationform-to_user_id").parent().hide():$("#notificationform-to_user_id").parent().show();
        },
     };
     not_form.on_event_change();
     not_form.on_all_users_change();
    ',\yii\web\View::POS_END);
    ActiveForm::end();
    ?>

</div>
