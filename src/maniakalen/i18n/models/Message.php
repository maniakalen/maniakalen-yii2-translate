<?php
/**
 * PHP Version 5.5
 *
 *  TranslationTexts database model class. Used to control db records for the table translations_texts
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */

namespace maniakalen\i18n\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "translations_texts".
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 *
 * @property integer $id
 * @property integer $translation_id
 * @property integer $language_id
 * @property string $text
 *
 * @property SourceMessage $translation
 * @property Languages $language
 */
class Message extends \yii\db\ActiveRecord
{

    /**
     * Returns the table name assigned to this ActiveRecord
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * Returns a set of rules to apply to the ActiveRecord properties
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['language'], 'string', 'max' => 16],
            [['translation'], 'string'],
            [
                ['id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => SourceMessage::className(),
                'targetAttribute' => ['id' => 'id']
            ],
            [
                ['language'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Languages::className(),
                'targetAttribute' => ['language' => 'language_code']
            ],
        ];
    }

    /**
     * Returns an array of labels for the properties
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language' => 'Language',
            'translation' => 'Translation',
        ];
    }

    /**
     * Returns related translation. Returns ActiveQuery if called as method and Translation if called as property
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessageSource()
    {
        return $this->hasOne(SourceMessage::className(), ['id' => 'id']);
    }

    /**
     * Returns related language. Returns ActiveQuery if called as method and Language if called as property
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageItem()
    {
        return $this->hasOne(Languages::className(), ['language_code' => 'language']);
    }
}
