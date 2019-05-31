<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\WalletsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wallets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallets-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Wallet', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'email',
                'value' => function($data) {
                    return $data->user->email;
                },
            ],
            'wallet_name',
            [
                'attribute' => 'short_name',
                'value' => function($data) {
                    return $data->walletsType->short_name;
                },
            ],
            'sum',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'visibleButtons' => [
                    'update' => function ($model) {
                        return $model->id_user == Yii::$app->user->id;
                    },
                    'delete' => function ($model) {
                        return $model->id_user == Yii::$app->user->id;
                    },
                ],
            ],
        ],
    ]); ?>


</div>
