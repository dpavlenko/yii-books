<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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
            [['name'], 'required'],
            [['year'], 'safe'],
            [['description'], 'string'],
            [['name', 'isbn'], 'string', 'max' => 255],
//            [['front_page'], 'string', 'max' => 1024],
            [['front_page'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
    public function upload()
    {

        if ($this->validate()) {
            $uploadFile = UploadedFile::getInstance($this, 'front_page');

            if ($uploadFile) {
//                var_dump($uploadFile);
                // Delete the old image if updating
                if ($this->isAttributeChanged('front_page') && !empty($this->front_page) && file_exists($this->getUploadPath($this->front_page))) {
                    unlink($this->getUploadPath($this->front_page));
                }

                $fileName = uniqid() . '.' . $uploadFile->extension;
                $uploadFile->saveAs($this->getUploadPath($fileName));
                $this->front_page = $fileName;
                return true;
            }
            return false;
        }
        return false;
    }

    public function getUploadPath($fileName = '')
    {
        return Yii::getAlias('@webroot/uploads/') . ($fileName ?: $this->front_page);
    }

    public function getImageUrl()
    {
        return Yii::getAlias('@web/uploads/') . $this->front_page;
    }


}
