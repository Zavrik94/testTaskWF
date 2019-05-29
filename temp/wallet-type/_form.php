<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WalletsType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallets-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rates')->textInput() ?>

    <?= $form->field($model, 'update_timestamp')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
