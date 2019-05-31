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

//$js = '
//    $("#send").click(function () {
//        var from = parseInt($("#from").select2("data")[0].text);
//        var to = parseInt($("#to").select2("data")[0].text);
//        var sum = $("#sum_from").attr("value");
//
//        if (from == "Select your wallet"
//        || to == "Select receiver\'s wallet") {
//            alarm("To send money you need to choose both wallets!");
//            return ;
//        }
//
//        $.ajax({
//            type: "POST",
//            url: "' . Yii::$app->request->baseUrl . '/transaction/create' . '",
//            data: {
//                from: from,
//                to: to,
//                sum: sum,
//            },
//            success: function (d) {
//                console.log(d);
//            },
//            error: function () {
//
//            },
//        });
//    });
//';
//$this->registerJs($js);


//echo '<pre>'; var_export($aw); echo '</pre>'; die();

?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'action' => ['transaction/create'],
//            'options' => ['data' => ['pjax' => true]],
        ]); ?>
            <?= $form->field($model, 'walletFrom')
                ->label('Choose your wallet')
                ->widget(Select2::classname(), [
                    'data' => $aw['from'],
                    'size' => 'md',
                    'options' => [
                        'id' => 'from',
                        'placeholder' => 'Select your wallet'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

            <?= $form->field($model, 'walletTo')
                ->label('Choose wallet to send')
                ->widget(Select2::classname(), [
                    'data' => $aw['to'],
                    'size' => 'md',
                    'options' => [
                        'id' => 'to',
                        'placeholder' => "Select receiver's wallet"
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>

            <?= $form->field($model, 'sum_from')->textInput(['maxlength' => true, 'id' => 'sum_from']) ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-success', 'id' => 'send']) ?>
            </div>
        <?php ActiveForm::end(); ?>

    <?php Pjax::begin(['id' => 'toRefreshGV']); ?>
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
