<?php

namespace app\models;

use Yii;
use function PHPUnit\Framework\isNull;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property int $user_id
 * @property string $phone
 *
 * @property User $user
 */
class Subscription extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'phone'], 'required'],
            [['user_id'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone' => 'Phone',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function loadUser()
    {
        $this->getUser();
        $user = $this->user || $this->getAttribute('user');
        if (isNull($user) && !empty($this->user_id)) {
            $user = User::findOne(['id' => $this->user_id]);
        }

        return $user;
    }

}
