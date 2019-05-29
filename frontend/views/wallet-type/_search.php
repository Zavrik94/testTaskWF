<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\WalletsTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wallets-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type_name') ?>

    <?= $form->field($model, 'short_name') ?>

    <?= $form->field($model, 'rates') ?>

    <?= $form->field($model, 'update_timestamp') ?>

    <?php  echo $form->field($model, 'is_update')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
