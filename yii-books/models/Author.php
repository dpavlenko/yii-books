<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $second_name
 *
 * @property BookAuthor[] $bookAuthors
 */
class Author extends \yii\db\ActiveRecord
{
    public array $book_ids = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'surname', 'second_name'], 'string', 'max' => 255],
            [['book_ids'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Name',
            'surname'     => 'Surname',
            'second_name' => 'Second Name',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('book_author', ['author_id' => 'id']);
    }

    public function getFullName()
    {
        return "{$this->name} {$this->surname} {$this->second_name}";
    }

    public static function getTop10()
    {
        $rows = (new \yii\db\Query())
            ->select(['author.id as id', 'count(book.id) as book_count','author.name', 'surname', 'second_name'])
            ->from('author')
            ->leftJoin('book_author', 'book_author.author_id = author.id')
            ->leftJoin('book', 'book.id = book_author.book_id')
            ->groupBy('author.id')
            ->orderBy('book_count DESC, id ASC')
            ->limit(10)
            ->all();

        return $rows;
    }

}
