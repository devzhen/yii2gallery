<?php

namespace backend\models;

class LoginForm extends \yii\base\Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = null;

    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }


    /**
     * @param $attribute. Атрибут иодели, кот в данный момент валидируется
     * @param $params. Дополнит. параметры(ключ=значение) переданные в правило
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }


    /**
     * Поиск пользователя по имени
     *
     * @return null|\backend\models\User
     */
    protected function getUser()
    {

        if ($this->_user === null) {

            $this->_user = \backend\models\User::findByUsername($this->username);
        }

        return $this->_user;
    }


    /**
     * Аутентификация пользователя
     *
     * @return bool
     */
    public function login()
    {
        if ($this->validate()) {
            return \Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
}