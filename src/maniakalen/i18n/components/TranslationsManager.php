<?php
/**
 * PHP Version 5.5
 *
 *  Class TranslationsManager
 *
 * @category Category
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

namespace maniakalen\i18n\components;

use maniakalen\i18n\models\Languages;
use maniakalen\i18n\models\Translations;
use maniakalen\i18n\models\TranslationsTexts;
use yii\base\Component;
use yii\db\Exception;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class TranslationsManager
 *
 *  CLASSDESCRIPTION
 *
 * @category Managers
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class TranslationsManager extends Component
{
    /**
     * Returns an array of available languages
     *
     * @return Languages[]
     */
    public function getLanguages()
    {
        return Languages::findAll(['status' => 1]);
    }

    /**
     * Gets an array of available translations for this language and category
     *
     * @param string $language Language for which to search translations
     * @param string $category Category for which to search translation
     *
     * @return array
     */
    public function getTranslations($language, $category)
    {
        try {
            /**
             * Query variable to fetch all the translations for this language and category
             *
             * @var Query $query
             */
            $query = \Yii::createObject(Query::className())->select(['label', 'text'])
                ->from(['tr' => Translations::tableName()])
                ->innerJoin(
                    ['t' => TranslationsTexts::tableName()],
                    'tr.id = t.translation_id'
                )->innerJoin(
                    ['l' => Languages::tableName()],
                    't.language_id = l.id'
                )->where(['language_code' => $language, 'category' => $category]);

            return ArrayHelper::map($query->all(), 'label', 'text');
        } catch (Exception $ex) {
            return [];
        }
    }
}