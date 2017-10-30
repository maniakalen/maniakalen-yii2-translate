<?php

namespace maniakalen\y18n\models;

use Yii;

/**
 * This is the model class for table "languages".
 *
 * @property integer $id
 * @property string $language_code
 * @property string $language
 * @property integer $status
 *
 * @property Translations[] $translations
 */
class Languages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['language_code'], 'string', 'max' => 8],
            [['language'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language_code' => 'Language Code',
            'language' => 'Language',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translations::className(), ['language_id' => 'id']);
    }
}
