<?php

use yii\db\Migration;

class m170722_165426_create_application_user extends Migration
{
    public function safeUp()
    {
        $user = new \backend\models\User();
        $user->username = 'admin';
        $user->email = 'admin@mail.com';
        $user->setPassword('admin');
        $user->generateAuthKey();

        if (!$user->save()) {

            echo "m170804_165426_create_application_user falis. Application user was not saved\n";

            return false;
        }
    }

    public function safeDown()
    {

    }
}
