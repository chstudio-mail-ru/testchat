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
 * @property string $authKey;
 * @property string $accessToken;
 *
 */
class User extends ActiveRecord implements IdentityInterface, Countable
{
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
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'unique', 'targetAttribute' => ['username'], 'message' => 'В БД есть пользователь с таким именем'],
            [['password'], 'safe'],
            [['username'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)){
            $this->password = md5($this->password);
            return true;
        } else {
            return false;
        }
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
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'password' => 'Пароль',
        ];
    }

    public function getUserRoles(): array
    {
        $roles = [];
        $assignments = Yii::$app->authManager->getAssignments($this->id);
        foreach($assignments as $userAssign){
            $roles[] = $userAssign->roleName;
        }

        return $roles;
    }

    /**
     * Set users access.
     * @param int $id
     * @param int $access   //1 - admin, 2 - register, 0 - no access
     * @throws \Exception
     */
    public static function setAccess(int $id, int $access)
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $register = $auth->getRole('register');

        switch ($access) {
            case 1:
                $auth->revokeAll($id);
                $auth->assign($admin, $id);
                break;
            case 2:
                $auth->revokeAll($id);
                $auth->assign($register, $id);
                break;
            case 0:
                $auth->revokeAll($id);
        }
    }
}
