<?php
/**
 * PHP Version 5.5
 *
 *  TranslationsAdminManager to control the translations from the admin
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */

namespace maniakalen\i18n\components;

use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

/**
 * Class TranslationsAdminManager
 *
 *  TranslationsAdminManager to control the translations from the admin
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class TranslationsAdminManager
{

    /**
     * Returns an instance of Translations model
     *
     * @param array $params array of params to be configured to the new object
     *
     * @return object
     */
    public function getTranslationModel($params = [])
    {
        $translation = Yii::createObject(['class' => 'maniakalen\i18n\models\Translations']);
        if (!empty($params)) {
            Yii::configure($translation, $params);
        }
        return $translation;
    }

    /**
     * Finds a Translation object if existing
     *
     * @param null|int $id Id of the translation to be obtained
     *
     * @return object
     */
    public function findTranslation($id = null)
    {
        $translation = $this->getTranslationModel();
        return $id?$translation::findOne($id):$translation;
    }

    /**
     * Returns an array configuration for GridView columns
     *
     * @return array
     */
    public function getListColumns()
    {
        return [
            ['class' => SerialColumn::className()],
            'category',
            'label',
            [
                'class' => ActionColumn::className(),
                'template' => '<div class="icoBox">{update}&nbsp;{delete}</div>',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Url::to(['/translations/admin/translations-update', 'id' => $model->id]),
                            []
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            Url::to(['/translations/admin/translations-delete', 'id' => $model->id]),
                            []
                        );
                    },
                ],
            ]
        ];
    }
}