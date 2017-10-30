<?php

namespace maniakalen\i18n\models;

/**
 * This is the model class for table "translations".
 *
 * @property integer $id
 * @property integer $language_id
 * @property string $category
 * @property string $label
 * @property string $text
 *
 * @property Languages $language
 */
class Translations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_id'], 'integer'],
            [['text'], 'string'],
            [['category'], 'string', 'max' => 45],
            [['label'], 'string', 'max' => 128],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::className(), 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language_id' => 'Language ID',
            'category' => 'Category',
            'label' => 'Label',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'language_id']);
    }
}
