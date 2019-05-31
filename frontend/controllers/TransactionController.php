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

        // '$my_wallet_name $my_wallet_id($my_wallet_cur:$my_wallet_sum)'
        // '$send_email $send_wallet_id($send_wallet_cur)'

        $myWallets = [];
        $receiverWallets = [];
        foreach ($wallets as $wallet) {
            if ($wallet['id_user'] == Yii::$app->user->id) {
                $myWallets[$wallet['id']] = $wallet['id'] . '. ' . $wallet['wallet_name'] .
                    '(' . $types[$wallet['id_wallets_type']] . ':' . $wallet['sum'] . ')';
            } else {
                $receiverWallets[$wallet['id']] =  $wallet['id'] . '. ' . $wallet['user']['email'] .
                    '(' . $types[$wallet['id_wallets_type']] . ')';
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aw' => ['from' => $myWallets, 'to' => $receiverWallets],
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Transaction();
        $post = Yii::$app->request->post();
        $isSuccess = $model->load($post);

        if ($isSuccess) {
            $model->id_wallet_from = (int)$post['Transaction']['walletFrom'];
            $model->id_wallet_to = (int)$post['Transaction']['walletTo'];
            $model->sum_from = (float)$post['Transaction']['sum_from'];
            $model->sum_to = WalletsType::convert($model->id_wallet_from, $model->id_wallet_to, $model->sum_from);

            $isSuccess = $model->save();
        }

        ($isSuccess)
            ? Yii::$app->session->setFlash('success', "Transaction success")
            : Yii::$app->session->setFlash('error', "Transaction failed")
        ;

        return $this->redirect(['transaction/index']);
    }
}
