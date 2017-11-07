<?php
/**
 * PHP Version 5.5
 *
 *  Default module admin index
 *
 * @category Admin_Control
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 */
    echo \maniakalen\widgets\Flash::widget();

    echo \yii\helpers\Html::a(
        Yii::t('yii', 'Configure languages'),
        ['/translations/admin/languages'],
        ['class' => 'btn btn-link']
    )
    . ' | ' .
    \yii\helpers\Html::a(
        Yii::t('yii', 'Configure translations'),
        ['/translations/admin/translations'],
        ['class' => 'btn btn-link']
    );
?>

