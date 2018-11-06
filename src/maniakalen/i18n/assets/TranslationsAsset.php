<?php
/**
 * Created by PhpStorm.
 * User: peter.georgiev
 * Date: 06/11/2018
 * Time: 9:46
 */

namespace maniakalen\i18n\assets;


use yii\web\AssetBundle;

class TranslationsAsset  extends AssetBundle
{
    public $sourcePath = '@translations/resources';

    public $css = [
        'css/styles.css',
    ];
}