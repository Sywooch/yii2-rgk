<?php
namespace app\models;

use app\components\Notification;
use app\components\NotificationBehavior;
use app\components\NotificationEvent;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function behaviors()
    {
        return [
            NotificationBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email    = $this->email;
        $user->password = User::crypt($this->password);
        $user->generateAuthKey();

        if($user->save()){
            $auth = Yii::$app->getAuthManager();
            $auth->assign($auth->getRole('user'),$user->getId());

            $event = new NotificationEvent();
            $event->to_user_id = $user->id;

            return $user;
        }else{
            return null;
        }
    }
}
