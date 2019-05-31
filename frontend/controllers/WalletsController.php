<?php

namespace frontend\controllers;

use common\models\WalletsType;
use Yii;
use common\models\Wallets;
use frontend\models\WalletsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WalletsController implements the CRUD actions for Wallets model.
 */
class WalletsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Wallets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WalletsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Wallets model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Wallets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Wallets();

        if ($model->load(Yii::$app->request->post())) {
            $model->id_user = $model->id_user ?? Yii::$app->user->id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Wallets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->id != $model->id_user) {
            Yii::$app->session->setFlash('error', 'Permission denied');
            return $this->redirect(['index']);
        }

        $oldIdWalletsType = $model->id_wallets_type;

        if ($model->load(Yii::$app->request->post())) {

            if ($oldIdWalletsType !== $model->id_wallets_type) {
                $model->sum = WalletsType::convertByTypes($oldIdWalletsType, $model->id_wallets_type, $model->sum);
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Wallets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->id != $model->id_user) {
            Yii::$app->session->setFlash('error', "Permission denied");
            return $this->redirect(['index']);
        }

        $model->is_deleted = true;
        if ($model->save()) {
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete');
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Finds the Wallets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wallets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wallets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSend()
    {
        WalletsType::refreshRates();
    }
    public function actionRates() {

    }
}
