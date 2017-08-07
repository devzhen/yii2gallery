<?php

namespace backend\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /*Название таблицы в БД*/
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new \yii\base\NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Поиск пользователя по имени
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {

        $user = static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);

        return $user;
    }

    /**
     * Поиск пользователя по token для сброса пароля
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Валидно ли token для сброса пароля
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Валидация пароля
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Генерирование hash пароля
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Генерирование "remember me" ключа аутентификации
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * Генерирование нового token для сброса пароля
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = \Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Удаление token для сброса пароля
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}