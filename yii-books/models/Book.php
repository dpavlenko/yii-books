<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property string $year
 * @property string $description
 * @property string $isbn
 * @property string $front_page
 *
 * @property BookAuthor[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{

    public array $author_ids = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'year', 'description', 'isbn', 'front_page'], 'required'],
            [['year'], 'safe'],
            [['description'], 'string'],
            [['name', 'isbn'], 'string', 'max' => 255],
            [['front_page'], 'string', 'max' => 1024],
            [['author_ids'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'front_page' => 'Front Page',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * @return void
     */
    public function afterFind() {
        parent::afterFind();
        $this->author_ids = \yii\helpers\ArrayHelper::getColumn($this->authors, 'id');
    }

}
