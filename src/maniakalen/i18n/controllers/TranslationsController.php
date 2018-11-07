<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 07/11/2018
 * Time: 15:36
 */

namespace maniakalen\i18n\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class TranslationsController extends Controller
{
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
                        'actions' => ['json'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    public function actionJson()
    {
        \Yii::$app->response->format = Response::FORMAT_RAW;
        return 'var maniakalen = maniakalen || {}; maniakalen.translations = maniakalen.translations || {};
        maniakalen.translations.data = ' . json_encode(\Yii::$app->translationsManager->getCurrentMessages(), JSON_UNESCAPED_UNICODE) . ';';
    }
}