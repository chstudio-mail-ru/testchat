<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $author_id
 * @property int $date_add
 * @property string $message
 * @property string $deleted
 * @property string|null $remote_addr
 */
class Message extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'date_add', 'message'], 'required'],
            [['author_id', 'date_add'], 'integer'],
            [['deleted'], 'string'],
            [['message'], 'string', 'max' => 1024],
            [['remote_addr'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'author_id' => 'Author ID',
            'date_add' => 'Date Add',
            'message' => 'Message',
            'deleted' => 'Deleted',
            'remote_addr' => 'Remote Addr',
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id'])->one();
    }

    /**
     * @param false $withDeleted
     * @return array|ActiveRecord[]
     */
    public static function getAll($withDeleted = false): array
    {
        return self::find()
            ->select( ['*'] )
            ->where(['deleted' => !$withDeleted ? '1' : ['0','1']])->all();
    }
}
