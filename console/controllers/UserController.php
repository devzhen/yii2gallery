<?php

namespace console\controllers;

class UserController extends \yii\console\Controller
{
    /**
     * Добавление пользователя в БД
     */
    public function actionAdd()
    {
        echo "Enter user name" . PHP_EOL;
        $name = fgets(STDIN);
        $name = preg_replace('~[\r\n]+~', '', $name);
        if (empty($name)) {
            while (empty($name)) {
                echo "User name can not be empty" . PHP_EOL;
                echo "Enter user name" . PHP_EOL;
                $name = fgets(STDIN);
                $name = preg_replace('~[\r\n]+~', '', $name);
            }
        }
        echo PHP_EOL;

        echo "Enter user email" . PHP_EOL;
        $email = fgets(STDIN);
        $email = preg_replace('~[\r\n]+~', '', $email);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            while (!$email) {
                echo "This is not correct email address" . PHP_EOL;
                echo "Enter user email" . PHP_EOL;
                $email = fgets(STDIN);
                $email = preg_replace('~[\r\n]+~', '', $email);
                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            }
        }
        echo PHP_EOL;

        echo "Enter user password" . PHP_EOL;
        $password = fgets(STDIN);
        $password = preg_replace('~[\r\n]+~', '', $password);
        echo PHP_EOL;

        echo "Save User?" . PHP_EOL .
            "User name - " . $name . PHP_EOL .
            "User email - " . $email . PHP_EOL .
            "User password - " . $password . PHP_EOL;

        echo "Your choice is [Yes|No] - ";

        $choice = fgets(STDIN);
        $choice = preg_replace('~[\r\n]+~', '', $choice);


        if (preg_match('~^Yes$~i', $choice) ||
            preg_match('~^Y$~i', $choice)
        ) {

            $user = new \backend\models\User();
            $user->username = $name;
            $user->email = $email;
            $user->setPassword($password);
            $user->generateAuthKey();

            if ($user->save()) {
                echo "User was saved in DB" . PHP_EOL;
            } else {
                echo "ERROR: User was not saved in DB" . PHP_EOL;
            }
        }

        exit(0);
    }


    /**
     * Сохранение в БД пользователя:
     * username - 'admin'
     * email - 'admin@mail.com'
     * password - 'admin'
     */
    public function actionInit()
    {
        $user = new \backend\models\User();
        $user->username = 'admin';
        $user->email = 'admin@mail.com';
        $user->setPassword('admin');
        $user->generateAuthKey();

        if ($user->save()) {
            echo "User was generated in DB" . PHP_EOL;
        } else {
            echo "ERROR: User was not generated in DB" . PHP_EOL;
        }
    }

}