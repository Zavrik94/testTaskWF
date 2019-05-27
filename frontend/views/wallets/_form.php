<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\WalletsType;

/* @var $this yii\web\View */
/* @var $model frontend\models\Wallets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wallet_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_wallets_type')->dropDownList(WalletsType::getTypesArray()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
