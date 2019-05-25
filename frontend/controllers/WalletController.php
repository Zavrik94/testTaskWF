<?php

namespace frontend\controllers;

use app\models\Wallets;
use Yii;

class WalletController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $model = new Wallets();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Wallet added');
            return $this->redirect(['wallet/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        return $this->render('delete');
    }

    public function actionIndex()
    {
        $walletsList = Wallets::find()->all();
        return $this->render('index', [
            'walletsList' => $walletsList,
        ]);
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

}
