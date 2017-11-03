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
 * @property Translations $translation
 * @property Languages $language
 */
class TranslationsTexts extends \yii\db\ActiveRecord
{
    /**
     * A property to contain the language code corresponding to the language assigned
     *
     * @var string $languageCode the code of language to be assigned to
     */
    public $languageCode;

    /**
     * Returns the table name assigned to this ActiveRecord
     *
     * @return string
     */
    public static function tableName()
    {
        return 'translations_texts';
    }

    /**
     * Returns a set of rules to apply to the ActiveRecord properties
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['translation_id', 'language_id'], 'required'],
            [['translation_id', 'language_id'], 'integer'],
            [['text'], 'string'],
            [
                ['translation_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Translations::className(),
                'targetAttribute' => ['translation_id' => 'id']
            ],
            [
                ['language_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Languages::className(),
                'targetAttribute' => ['language_id' => 'id']
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
            'translation_id' => 'Translation ID',
            'language_id' => 'Language ID',
            'text' => 'Text',
        ];
    }

    /**
     * Returns related translation. Returns ActiveQuery if called as method and Translation if called as property
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslation()
    {
        return $this->hasOne(Translations::className(), ['id' => 'translation_id']);
    }

    /**
     * Returns related language. Returns ActiveQuery if called as method and Language if called as property
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Languages::className(), ['id' => 'language_id']);
    }

    /**
     * Gets the language code corresponding to the current record's language_id
     *
     * @return string
     */
    public function getLanguageCode()
    {
        static $langs;
        if ($langs === null) {
            $langs = ArrayHelper::map(Languages::find()->all(), 'id', 'language_code');
        }

        return isset($langs[$this->language_id])?$langs[$this->language_id]:'';
    }
}
