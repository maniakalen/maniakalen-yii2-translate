<?php
/**
 * PHP Version 5.5
 *
 *  DESCRIPTION
 *
 * @category Category
 * @package  Package
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */

namespace maniakalen\i18n\components;

use maniakalen\i18n\models\Languages;
use maniakalen\i18n\models\Translations;
use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * Class TranslationsManager
 *
 *  CLASSDESCRIPTION
 *
 * @category CATEGORY
 * @package  PACKAGE
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class TranslationsManager extends Component
{
    public function getLanguages()
    {
        return Languages::findAll(['status' => 1]);
    }

    public function getTranslations($language, $category)
    {
        $query = Translations::find()
            ->innerJoin(
                ['l' => Languages::tableName()],
                Translations::tableName() . '.language_id = l.id'
            )->where(['language_code' => $language, 'category' => $category]);
        return ArrayHelper::map($query->all(), 'label', 'text');
    }
}