<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use \yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\controllers\WalletsTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$upd_js = '
    $.pjax.defaults.timeout = false;
    $("#rates-upd").click(function updRates() {
        $.ajax({
            url: "' . yii\helpers\Url::to('@web/coinlayer/') . '",
            success: function() {
                $.pjax.reload({container:"#upd-rates"});
            }
        });
    });
';
$this->registerJs($upd_js, yii\web\View::POS_END);

$this->title = 'Wallets Types';
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
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Action',
                    'visibleButtons' => [
                        'update' => false,
                        'delete' => false,
                    ],
                ],
            ],
        ]); ?>
    <?php Pjax::end() ?>


</div>
