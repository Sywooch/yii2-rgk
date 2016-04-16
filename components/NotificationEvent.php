<?php
/**
 * Event for notification system.
 * If notification hasn't set sender or receiver user their ids could be passed from model
 * throw parameters $from_user_id , $to_user_id
 */
namespace app\components;

use yii\base\Event;

class NotificationEvent extends Event{
    /**
     * @var int $from_user_id User id who send notification
     */
    public $from_user_id = 1;
    /**
     * @var int $to_user_id User id who receive notification
     */
    public $to_user_id = 1;
}