<?php
/**
 * PHP Version 5.5
 *
 *  Languages control form
 *
 * @category Languages_Control
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 *
 * @var \yii\base\Model $model
 */

$form = \yii\widgets\ActiveForm::begin();
echo $form->field($model, 'language_code')->textInput();
echo $form->field($model, 'language')->textInput();
echo $form->field($model, 'status')->dropDownList([1=> 'Active', 0 => 'Disabled']);
echo \yii\helpers\Html::submitInput(Yii::t('yii', 'Submit'), ['class' => 'btn btn-primary']);
$form::end();

?>


