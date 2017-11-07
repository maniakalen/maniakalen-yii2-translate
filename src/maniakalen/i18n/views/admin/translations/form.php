<?php
/**
 * PHP Version 5.5
 *
 *  Translations control form
 *
 * @category Translations_Control
 * @package  Maniakalen_I18n
 * @author   Peter Georgiev <peter.georgiev@concatel.com>
 * @license  GNU GENERAL PUBLIC LICENSE https://www.gnu.org/licenses/gpl.html
 * @link     -
 *
 * @var \yii\base\Model $model
 */
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;

echo \maniakalen\widgets\Flash::widget();
?>
<div class="col-md-4">
<?php
$form = ActiveForm::begin();
echo $form->field($model, 'category')->textInput();
echo $form->field($model, 'message')->textInput();

$messages = $model->allMessages;
$tabs = [];
foreach ($messages as $msg) {
    $tabs[] = [
        'label' => strtoupper($msg->language),
        'content' => $form->field($msg, "[{$msg->language}]translation")->textarea(),
        'active' => empty($tabs)
    ];
}
echo Tabs::widget(['items' => $tabs]);
echo \yii\helpers\Html::submitInput(Yii::t('yii', 'Submit'), ['class' => 'btn btn-primary']);
$form::end();
?>
</div>
