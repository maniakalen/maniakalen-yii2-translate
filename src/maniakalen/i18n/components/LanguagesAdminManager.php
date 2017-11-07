<?php
/**
 * PHP Version 5.5
 *
 *  Manager class to control languages
 *
 * @category Languages
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     LINK
 */

namespace maniakalen\i18n\components;

use maniakalen\i18n\models\Languages;
use yii\base\Component;
use Yii;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class LanguagesAdminManager
 *
 *  Manager class to control languages
 *
 * @category Languages
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class LanguagesAdminManager extends Component
{
    /**
     * Gemerates and configures new Languages model
     *
     * @param array $params array of params to be configured to object
     *
     * @return object
     */
    public function getLangModel($params = [])
    {
        $langs = Yii::createObject(['class' => 'maniakalen\i18n\models\Languages']);
        if (!empty($params)) {
            Yii::configure($langs, $params);
        }
        return $langs;
    }

    /**
     * Returns an instance of Language model corresponding to provided id
     *
     * @param null|int $id Id of the language to be obtained
     *
     * @return object
     */
    public function findLanguage($id = null)
    {
        $lang = $this->getLangModel();
        return $id?$lang::findOne($id):$lang;
    }

    /**
     * Returns array of column configuration for GridView
     *
     * @return array
     */
    public function getListColumns()
    {
        return [
            ['class' => SerialColumn::className()],
            'language_code',
            'language',
            [
                'label' => 'status',
                'attribute' => 'status',
                'value' => function ($m) {
                    return $m->status?'Active': 'Disabled';
                },
                'filter' => [
                    1 => \Yii::t('yii', 'Active'),
                    0 => \Yii::t('app', 'Disabled'),
                ],
                'filterInputOptions' => ['prompt' => \Yii::t('yii', 'All')],
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '<div class="icoBox">{update}&nbsp;{delete}&nbsp;{status}</div>',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $this->getLanguageEditUrl($model),
                            []
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $this->getLanguageDeleteUrl($model),
                            []
                        );
                    },
                    'status' => function ($url, $model) {
                        if ($model->status == 1) {
                            $title = Yii::t('yii', 'Disable');
                            $class = 'glyphicon-ok-circle';
                        } else {
                            $title = Yii::t('yii', 'Activate');
                            $class = 'glyphicon-ban-circle';
                        }
                        $options = [
                            'title' => $title,
                            'aria-label' => $title,
                            'id' => 'status_control_' . $model->id,
                        ];
                        return Html::a(
                            '<span class="glyphicon ' . $class . '"></span>',
                            $this->getLanguageStatusToggleUrl($model),
                            $options
                        );
                    },
                ],
            ]
        ];
    }

    /**
     * Returns url for the model's edit page in admin UI
     *
     * @param Languages $model the model for which to generate url
     *
     * @return string
     */
    public function getLanguageEditUrl(Languages $model)
    {
        return Url::to(['/translations/admin/languages-update', 'lang_id' => $model->id]);
    }

    /**
     * Returns url for the model's delete action in admin UI
     *
     * @param Languages $model the model for which to generate url
     *
     * @return string
     */
    public function getLanguageDeleteUrl(Languages $model)
    {
        return Url::to(['/translations/admin/languages-delete', 'lang_id' => $model->id]);
    }

    /**
     * Returns url for the model's status toggle action in admin UI
     *
     * @param Languages $model the model for which to generate url
     *
     * @return string
     */
    public function getLanguageStatusToggleUrl(Languages $model)
    {
        return Url::to(['/translations/admin/languages-status-toggle', 'lang_id' => $model->id]);
    }
}