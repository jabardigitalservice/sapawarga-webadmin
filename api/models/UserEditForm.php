<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * User Edit form
 */
class UserEditForm extends Model
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $name;
    public $phone;
    public $address;
    public $rw;
    public $kel_id;
    public $kec_id;
    public $kabkota_id;
    public $photo_url;
    public $facebook;
    public $twitter;
    public $instagram;
    /** @var User */
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'id',
                'exist',
                'targetClass' => '\app\models\User',
                'filter' => [
                    'and',
                    ['status' => User::STATUS_ACTIVE],
                    'confirmed_at IS NOT NULL',
                    'blocked_at IS NULL'
                ],
                'message' => 'The ID is not valid.'
            ],

            ['username', 'trim'],
            ['username', 'string', 'length' => [5, 14]],
            [
                'username',
                'unique',
                'targetClass' => '\app\models\User',
                'message' => Yii::t('app/error', 'app.error.update.username.taken'),
                'filter' => function ($query) {
                    $query->andWhere(['!=', 'id', $this->id]);
                }
            ],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => '\app\models\User',
                'message' => Yii::t('app/error', 'app.error.update.email.taken'),
                'filter' => function ($query) {
                    $query->andWhere(['!=', 'id', $this->id]);
                }
            ],

            ['password', 'string', 'min' => 6],
            [['username', 'name', 'phone', 'address', 'rw', 'kel_id', 'kec_id', 'kabkota_id', 'photo_url', 'facebook', 'twitter', 'instagram'], 'default'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return boolean the saved model or null if saving fails
     */
    public function save()
    {
        if ($this->validate()) {
            $this->getUserByID();

            if ($this->_user->email != $this->email) {
                $this->_user->unconfirmed_email = $this->email;
                $this->_user->email = $this->email;
                $this->_user->confirmed_at = Yii::$app->formatter->asTimestamp(date('Y-m-d H:i:s'));
                $this->_user->generateAuthKey();
            }

            // If password is not null, then update password
            if ($this->password != '') {
                $this->_user->setPassword($this->password);
            }

            if ($this->username != '') {
                $this->_user->username = $this->username;
            }

            // Set all the other fields

            if ($this->name != '') {
                $this->_user->name = $this->name;
            }

            if ($this->phone != '') {
                $this->_user->phone = $this->phone;
            }

            if ($this->address != '') {
                $this->_user->address = $this->address;
            }

            if ($this->rw != '') {
                $this->_user->rw = $this->rw;
            }

            if ($this->kel_id != '') {
                $this->_user->kel_id = $this->kel_id;
            }

            if ($this->kec_id != '') {
                $this->_user->kec_id = $this->kec_id;
            }

            if ($this->kabkota_id != '') {
                $this->_user->kabkota_id = $this->kabkota_id;
            }

            if ($this->photo_url != '') {
                $this->_user->photo_url = $this->photo_url;
            }

            if ($this->facebook != '') {
                $this->_user->facebook = $this->facebook;
            }

            if ($this->twitter != '') {
                $this->_user->twitter = $this->twitter;
            }

            if ($this->instagram != '') {
                $this->_user->instagram = $this->instagram;
            }

            if ($this->_user->save(false)) {
                return true;
            } else {
                $this->addError('generic', Yii::t('app', 'The system could not update the information.'));
            }
        }
        return false;
    }

    /**
     * Finds user by [[id]]
     *
     * @return User|null
     */
    public function getUserByID()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne($this->id);
        }

        return $this->_user;
    }

    public function sendConfirmationEmail()
    {
        $confirmURL = \Yii::$app->params['frontendURL'] . '#/confirm?id=' . $this->_user->id . '&auth_key=' . $this->_user->auth_key;

        $email = \Yii::$app->mailer
            ->compose(
                ['html' => 'email-confirmation-html'],
                [
                    'appName' => \Yii::$app->name,
                    'confirmURL' => $confirmURL,
                ]
            )
            ->setTo($this->email)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
            ->setSubject('Email confirmation')
            ->send();

        return $email;
    }
}
