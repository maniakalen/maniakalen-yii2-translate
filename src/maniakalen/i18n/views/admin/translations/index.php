<?php
/**
 * PHP Version 5.5
 *
 *  Translations list
 *
 * @category Translations
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 *
 * @var \yii\data\BaseDataProvider $dataProvider
 * @var \yii\base\Model $searchModel
 * @var array $columns
 */

echo \yii\grid\GridView::widget(
    [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]
);

echo \yii\helpers\Html::a('+', ['/translations/admin/translations-add'], ['class' => 'btn btn-primary']);