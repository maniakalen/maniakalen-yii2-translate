<?php
/**
 * PHP Version 5.5
 *
 * Controller class for admin interface
 *
 * @category Admin_Ui
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */

namespace maniakalen\i18n\controllers;

use maniakalen\i18n\models\Languages;
use maniakalen\i18n\models\Message;
use maniakalen\i18n\models\SourceMessage;
use maniakalen\i18n\models\Translations;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\i18n\MessageSource;
use yii\web\Controller;
use Yii;
/**
 * Class AdminController
 *
 *  Controller class for admin interface
 *
 * @category Admin_Ui
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
class AdminController extends Controller
{
    /**
     * Sets the behaviors to the controller
     *
     * @param array $behaviors array of behaviors to be set
     *
     * @return null
     */
    public function setBehaviors($behaviors)
    {
        return $this->attachBehaviors($behaviors);
    }

    /**
     * Returns an array of behaviors to be applied to this controller
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['backend/translations/access'],
                    ],
                    [
                        'actions' => ['languages'],
                        'allow' => true,
                        'roles' => ['backend/languages/access'],
                    ],
                    [
                        'actions' => [
                            'languages-add',
                            'languages-update',
                            'languages-delete',
                            'languages-status-toggle'
                        ],
                        'allow' => true,
                        'roles' => ['backend/languages/edit'],
                    ],
                    [
                        'actions' => ['translations'],
                        'allow' => true,
                        'roles' => ['backend/translations/access'],
                    ],
                    [
                        'actions' => [
                            'translations-add',
                            'translations-update',
                            'translations-delete',
                            'languages-status-toggle'
                        ],
                        'allow' => true,
                        'roles' => ['backend/translations/edit'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Index action
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Landing action for languages control
     *
     * @return string
     */
    public function actionLanguages()
    {
        /**
         * Gets Languages model to provide as search Model
         *
         * @var Languages $langs
         */
        $langs = Yii::$app->langsAdmin->getLangModel();
        return $this->render(
            'languages/index',
            [
                'dataProvider' => $langs->search(Yii::$app->request->get()),
                'searchModel' => $langs,
                'columns' => Yii::$app->langsAdmin->getListColumns(),
            ]
        );
    }

    /**
     * Action for adding language. Forwards to the update with no id param
     *
     * @return mixed
     */
    public function actionLanguagesAdd()
    {
        return $this->runAction('languages-update', []);
    }

    /**
     * Updates language with the new values of properties. Creates new record if no id provided
     *
     * @param null|int $lang_id language id for the language to be updated.
     *
     * @return string
     */
    public function actionLanguagesUpdate($lang_id = null)
    {
        /**
         * Languages model fetched for admin manager
         *
         * @var Languages $model
         */
        $model = Yii::$app->langsAdmin->findLanguage($lang_id);
        if ($post = Yii::$app->request->post()) {
            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Language saved successfully');
            } else {
                Yii::$app->session->setFlash('danger', 'Failed to save language');
            }

            Yii::$app->response->redirect(Url::to(['/translations/admin/languages']));
        }

        return $this->render('languages/form', ['model' => $model]);
    }

    /**
     * Landing action for Language delete
     *
     * @param int $lang_id Language id for the language to be manipulated
     *
     * @return null
     */
    public function actionLanguagesDelete($lang_id)
    {
        /**
         * Languages model fetched for admin manager corresponding to given id
         *
         * @var Languages $model
         */
        $model = Yii::$app->langsAdmin->findLanguage($lang_id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Language deleted successfully');
        } else {
            Yii::$app->session->setFlash('danger', 'Failed to delete language');
        }
        Yii::$app->response->redirect(Url::to(['/translations/admin/languages']));

        return null;
    }

    /**
     * Landing action for language status toggle. Redirects to the same listing
     *
     * @param int $lang_id language id for language to be toggled
     *
     * @return null
     */
    public function actionLanguagesStatusToggle($lang_id)
    {
        /**
         * Languages model fetched for admin manager corresponding to given id
         *
         * @var Languages $model
         */
        $model = Yii::$app->langsAdmin->findLanguage($lang_id);
        if ($model->load(['status' => (int)(!$model->status)], '') && $model->save()) {
            Yii::$app->session->setFlash('success', 'Language status changed successfully');
        } else {
            Yii::$app->session->setFlash('danger', 'Failed to change language status');
        }
        Yii::$app->response->redirect(Url::to(['/translations/admin/languages']));

        return null;
    }

    /**
     * Action for listing translations
     *
     * @return string
     */
    public function actionTranslations()
    {
        /**
         * Translations model fetched for admin manager
         *
         * @var MessageSource $model
         */
        $model = Yii::$app->translationsAdmin->findTranslation();
        return $this->render(
            'translations/index',
            [
                'dataProvider' => $model->search(Yii::$app->request->get()),
                'searchModel' => $model,
                'columns' => Yii::$app->translationsAdmin->getListColumns(),
            ]
        );
    }

    /**
     * Landing action for adding new translation
     *
     * @return string
     */
    public function actionTranslationsAdd()
    {
        return $this->runAction('translations-update', []);
    }

    /**
     * Landing action for translation update
     *
     * @param null|int $trans_id translation to be updated
     *
     * @return string
     */
    public function actionTranslationsUpdate($trans_id = null)
    {
        /**
         * Translations model fetched for admin manager
         *
         * @var SourceMessage $model
         */
        $model = Yii::$app->translationsAdmin->findTranslation($trans_id);
        if ($post = Yii::$app->request->post()) {
            if ($model->load($post) && $model->save()) {
                if (isset($post['Message']) && !empty($post['Message'])) {
                    $saves = true;
                    foreach ($post['Message'] as $lang_code => $data) {
                        $messageModel = $model->getMessageForLanguage($lang_code);
                        if ($messageModel instanceof Message) {
                            $saves = $messageModel->load($data, '') && $messageModel->save() && $saves;
                        }
                    }
                    if ($saves) {
                        Yii::$app->session->addFlash('success', Yii::t('yii', 'Translation saved successfully'));
                    } else {
                        Yii::$app->session->addFlash('success', Yii::t('yii', 'Translation saved partially.'));
                    }
                }
                Yii::$app->response->redirect(Yii::$app->translationsAdmin->getTranslationEditUrl($model));

            }
        }

        return $this->render('translations/form', ['model' => $model]);
    }

    /**
     * Landing action for request to delete provided translation
     *
     * @param int $trans_id id of translation to be deleted
     *
     * @return null
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionTranslationsDelete($trans_id)
    {
        /**
         * Translations model fetched for admin manager
         *
         * @var SourceMessage $model
         */
        $model = Yii::$app->translationsAdmin->findTranslation($trans_id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Translation deleted successfully');
        } else {
            Yii::$app->session->setFlash('danger', 'Failed to delete translation');
        }
        return Yii::$app->response->redirect(Yii::$app->translationsAdmin->getTranslationDeleteUrl($model));
    }
}