<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Wallets;

/* @var $this yii\web\View */
/* @var $model common\models\Wallets */
/* @var $form ActiveForm */
?>
<div class="send">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'wallet_name')->textInput()->label('Choose your wallet')->dropDownList(Wallets::getMyWallets()) ?>
        <?= $form->field($model, 'sum')->textInput()->label('Sum to send') ?>
<!--        --><?//= $form->field($model, 'id_wallets_type') ?>
<!--        --><?//= $form->field($model, 'sum') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- send -->
