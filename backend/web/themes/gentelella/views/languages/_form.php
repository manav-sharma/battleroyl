<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\State */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="x_content">
    <p>All fields are mandatory:</p>

    <?php $form = ActiveForm::begin(['id' => 'form-language',
            'options' => ['class' => 'form-horizontal form-label-left'],
            'fieldConfig' => [
                'template' => "<div class=\"item form-group\">\n
                                {label}\n
                                <div class=\"col-md-6 col-sm-6 col-xs-12\">
                                    {input}
                                    <div class=\"col-lg-10\">
                                    {error}
                                    </div>
                                </div>
                            </div>",
                'labelOptions' => ['class' => 'control-label col-md-3'],
            ],
    ]);
    ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->dropDownList(['' => 'Status', '1' => 'Active', '0' => 'Inactive']) ?>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary" onclick="javascript:window.location.href = '<?php echo Url::home(); ?>/languages'">Cancel</button>
            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
