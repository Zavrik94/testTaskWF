<?php

namespace frontend\controllers;

use common\models\WalletsType;
use Yii;
use common\models\Transaction;
use common\models\Wallets;
use frontend\models\TransactionSearch;
use yii\web\Controller;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
{
    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $wallets = Wallets::getAllWallets();
        $types = WalletsType::getTypesArray();
        $model = new Transaction();

        //'$my_wallet_name $my_wallet_id($my_wallet_cur:$my_wallet_sum)'
        //'$send_email $send_wallet_id($send_wallet_cur)'


        $myWallets = [];
        $receiverWallets = [];
        foreach ($wallets as $wallet) {
            if ($wallet['id_user'] == Yii::$app->user->id) {
                $myWallets []= $wallet['wallet_name'] . ' ' . $wallet['id'] .
                    '(' . $types[$wallet['id_wallets_type']] . ':' . $wallet['sum'] . ')';
            } else {
                $receiverWallets []= $wallet;
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aw' => ['from' => $myWallets, 'to' => $receiverWallets],
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }
}
