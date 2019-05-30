<?php

namespace frontend\controllers;

use Yii;
use common\models\WalletsType;
use frontend\models\WalletsTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WalletTypeController implements the CRUD actions for WalletsType model.
 */
class WalletTypeController extends Controller
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
     * Lists all WalletsType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WalletsTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the WalletsType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WalletsType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WalletsType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdIsUpd() {
        $data = Yii::$app->request->post();
        $wt = new WalletsType();
        $cur = $wt::findOne($data['id']);
        $cur->is_update = filter_var($data['is_update'], FILTER_VALIDATE_BOOLEAN);
        return var_export($cur->save());
    }
}
