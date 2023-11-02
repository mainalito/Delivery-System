<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\VarDumper;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $usertypeid;

    const SCENARIO_CUSTOMER = 'customer_signup';
    const STATUS_USER = 1 ;//normal customer
    const STATUS_RIDER = 2 ;//rider
    // Set scenario-specific rules
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CUSTOMER] = ['username', 'email', 'password', 'firstname', 'lastname'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            [['firstname','lastname'], 'string', 'max' => 255],
            [['lastname', 'firstname',], 'required'],
            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['usertypeid', 'required'],
            ['usertypeid', 'in', 'range' => [self::STATUS_USER, self::STATUS_RIDER]],
        ];
    }


    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        // Assign usertype based on scenario
        if ($this->scenario == self::SCENARIO_CUSTOMER) {
            $user->usertypeid = self::STATUS_USER;
        }
        if (!$user->save()) {
            VarDumper::dump($user->getErrors(), 10, true);
        exit;
        }
        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
