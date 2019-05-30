<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;
use \yii\widgets\Pjax;
use \common\models\WalletsType;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\WalletsTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$upd_js = '
    $.pjax.defaults.timeout = false;
    $("#rates-upd").click(function updRates() {
        $.ajax({
            url: "' . Url::to('@web/coinlayer/') . '",
            success: function() {
                $.pjax.reload({container:"#upd-rates"});
            }
        });
    });

    function change_is_update(id) {
        var is_update = $("#" + id).prop("checked");
    
        $.ajax({
            type: "POST",
            url: "' . Yii::$app->request->baseUrl. '/wallet-type/upd-is-upd' . '",
            data: {id:id, is_update:is_update},
        });
    };
';
$this->registerJs($upd_js, View::POS_END);

$this->title = 'Currency rates to USD';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallets-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('ReFresh Rates', null, ['id' => 'rates-upd', 'class' => 'btn btn-lg btn-primary']) ?>
    </p>

    <?php Pjax::begin(['id' => 'upd-rates']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'type_name',
                'short_name',
                'rates',
                [
                    'attribute' => 'update_timestamp',
                    'format' => ['date', 'php:M d Y H:i e'],
                ],
                [
                    'attribute' => 'is_update',
                    'format' => 'raw',
                    'value' => function ($model, $index) {
                        return Html::checkbox('is_update', $model->is_update,
                            ['onclick' => "change_is_update($index)", 'id' => $index]);
                    },
                ],
            ],
        ]); ?>
    <?php Pjax::end() ?>


</div>
