<?php

declare(strict_types=1);

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;
use yii\base\Security;

class UserController extends Controller
{
    public function actionCreate($username, $password)
    {
        $user           = new User();
        $user->username = $username;
//        $user->email    = $email;
        $user->passwordHash = Yii::$app->getSecurity()->generatePasswordHash($password);

//        $user->status = User::STATUS_ACTIVE;

        if ($user->save()) {
            echo "User created successfully.\n";
        } else {
            print_r($user->getErrors());
        }
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
//        echo "yii user/create <email> <username> <password>\n";
        echo "yii user/create <email> <username> <password>\n";
        return ExitCode::OK;
    }
}
