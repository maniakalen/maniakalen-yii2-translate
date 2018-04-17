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

use maniakalen\i18n\models\SourceMessage;
use yii\db\ActiveRecord;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use yii\helpers\ArrayHelper;

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
        $translation = Yii::createObject(['class' => 'maniakalen\i18n\models\SourceMessage']);
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
     * Returns a list of all available categories for translation
     *
     * @return array
     */
    public function getTranslationCategories()
    {
        try {
            $model = $this->getTranslationModel();
            if ($model instanceof ActiveRecord) {
                $list = $model::find()->groupBy('category')->all();
                return ArrayHelper::getColumn($list, 'category');
            }
        } catch (\Exception $ex) {
            Yii::error($ex->getMessage(), 'translations');
        }
        return [];
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
            'message',
            [
                'class' => ActionColumn::className(),
                'template' => '<div class="icoBox">{update}&nbsp;{delete}</div>',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $this->getTranslationEditUrl($model),
                            []
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $this->getTranslationDeleteUrl($model),
                            []
                        );
                    },
                ],
            ]
        ];
    }

    /**
     * Returns url for the model's edit page in admin UI
     *
     * @param SourceMessage $model the model for which to generate url
     *
     * @return string
     */
    public function getTranslationEditUrl(SourceMessage $model)
    {
        return Url::to(['/translations/admin/translations-update', 'trans_id' => $model->id]);
    }

    /**
     * Returns url for the model's delete action in admin UI
     *
     * @param SourceMessage $model the model for which to generate url
     *
     * @return string
     */
    public function getTranslationDeleteUrl(SourceMessage $model)
    {
        return Url::to(['/translations/admin/translations-delete', 'trans_id' => $model->id]);
    }
}