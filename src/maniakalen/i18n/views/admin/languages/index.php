<?php
/**
 * PHP Version 5.5
 *
 *  Languages control listing
 *
 * @category Languages_Listing
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

echo \yii\helpers\Html::a('+', ['/translations/admin/languages-add'], ['class' => 'btn btn-primary']);
?>
