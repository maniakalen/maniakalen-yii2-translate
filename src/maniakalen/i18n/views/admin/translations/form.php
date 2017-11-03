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

$form = \yii\widgets\ActiveForm::begin();
echo $form->field($model, 'category')->textInput();
echo $form->field($model, 'label')->textInput();

$langs = $model->translationsTexts;
if (!empty($langs)) {
    ?>
    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($langs as $lang): ?>
                <li role="presentation" class="<?php echo $ah = isset($ah) ? '' : 'active'; ?>"><a
                            href="#translation<?php echo $lang->language_id; ?>"
                            aria-controls="translation<?php echo $lang->language_id; ?>" role="tab"
                            data-toggle="tab"><?php echo strtoupper($lang->languageCode); ?></a></li>
            <?php endforeach ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php foreach ($langs as $lang): ?>
                <div role="tabpanel" class="tab-pane <?php echo $ab = isset($ab) ? '' : 'active'; ?>"
                     id="translation<?php echo $lang->language_id; ?>">
                    <?php echo $form->field($lang, "[{$lang->id}]text")->textarea(); ?>
                </div>
            <?php endforeach ?>
        </div>

    </div>
    <?php
}
echo \yii\helpers\Html::submitInput(Yii::t('yii', 'Submit'), ['class' => 'btn btn-primary']);
$form::end();