<?php

/**
 * PHP Version 5.5
 *
 * This is the model class for table "languages".
 *
 * @category Languages
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */

namespace maniakalen\i18n\models;

use yii\data\ActiveDataProvider;
use yii\db\AfterSaveEvent;

/**
 * This is the model class for table "languages".
 *
 * @category Languages
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
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
     * Initialization method
     *
     * @return null
     */
    public function init()
    {
        parent::init();
        $this->on(
            self::EVENT_AFTER_INSERT,
            function (AfterSaveEvent $event) {
                $owner = $event->sender;
                foreach (Translations::find()->all() as $translation) {
                    \Yii::createObject(
                        [
                            'class' => 'maniakalen\i18n\models\TranslationsTexts',
                            'language_id' => $owner->id,
                            'translation_id' => $translation->id
                        ]
                    )->save();
                }
            }
        );

        return null;
    }

    /**
     * Returns table name of the table associated
     *
     * @return string
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * Returns an array of property rules
     *
     * @return array
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
     * Returns an array of property labels
     *
     * @return array
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
     * Returns an array of translations for this language if called as property or ActiveQuery instance if called as
     * method
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translations::className(), ['language_id' => 'id']);
    }

    /**
     * This method is used when the object is provided as filter for GridView
     *
     * @param array $params array of params to filter by
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();
        $dataProvider = new ActiveDataProvider(['query' => $query,]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'language_code' => $this->language_code?:null,
                'language' => $this->language?:null,
                'status' => $this->status,
            ]
        );

        return $dataProvider;
    }
}
