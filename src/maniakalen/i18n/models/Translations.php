<?php

/**
 * PHP Version 5.5
 *
 *  This is the model class for table "translations".
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */

namespace maniakalen\i18n\models;

use yii\data\ActiveDataProvider;
use yii\db\AfterSaveEvent;

/**
 * This is the model class for table "translations".
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 *
 * @property integer $id
 * @property string $category
 * @property string $label
 *
 * @property TranslationsTexts[] $translationsTexts
 */
class Translations extends \yii\db\ActiveRecord
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
                foreach (Languages::find()->all() as $language) {
                    \Yii::createObject(
                        [
                            'class' => 'maniakalen\i18n\models\TranslationsTexts',
                            'language_id' => $language->id,
                            'translation_id' => $owner->id
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
        return 'translations';
    }

    /**
     * Returns an array of property rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['category'], 'string', 'max' => 45],
            [['label'], 'string', 'max' => 128],
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
            'category' => 'Category',
            'label' => 'Label',
        ];
    }

    /**
     * Returns related translation texts. Returs ActiveQuery if called as method and TranslationsTexts[] if called as
     * property
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslationsTexts()
    {
        return $this->hasMany(TranslationsTexts::className(), ['translation_id' => 'id']);
    }

    /**
     * This method is used when the object is provided as filter for GridView
     *
     * @param array $params an array of input params to filter by
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find()->groupBy(['category', 'label']);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'category' => $this->category?:null,
                'label' => $this->label?:null,
            ]
        );

        return $dataProvider;
    }
}
