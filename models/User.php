<?php

namespace app\models;

use Countable;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username;
 * @property string $password;
 * @property integer $deleted
 * @property string $authKey;
 * @property string $accessToken;
 *
 */
class User extends ActiveRecord implements IdentityInterface, Countable
{
    const STATUS_DELETED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function getById($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::find()
            ->where([
                'accessToken' => $token
            ])
            ->one();
        if ($user === null || !count($user)) {
            return null;
        }

        return new static($user);
    }

    /**
     * Finds user by login
     *
     * @param  string $login
     * @return static|null
     */
    public static function findByLogin($login)
    {
        $user = self::find()
            ->where([
                'username' => $login
            ])
            ->one();
        if ($user === null || !count($user)) {
            return null;
        }

        return new static($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public static function getAll() {
        return self::find()
            ->all();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return ($this->deleted !== self::STATUS_DELETED)? 1 : 0;
    }
}
