<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $aw array */
/* @var $model common\models\Transaction */



$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'id')
                ->label('Choose your wallet')
                ->widget(Select2::classname(), [
                    'data' => $model->id,
                    'size' => 'md',
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

            <?= $form->field($model, 'sum_to')
                ->label('Choose wallet to send')
                ->widget(Select2::classname(), [
                    'data' => $model->sum_to,
                    'size' => 'md',
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

            <?= $form->field($model, 'sum_from')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sum_to')->textInput(['maxlength' => true, 'disabled' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
            </div>
        <?php ActiveForm::end(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'id_wallet_from',
                'id_wallet_to',
                'timestamp',
                'sum_from',
                //'sum_to',
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
