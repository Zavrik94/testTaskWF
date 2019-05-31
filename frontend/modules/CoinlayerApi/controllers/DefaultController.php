<?php

namespace frontend\modules\CoinlayerApi\controllers;

use common\models\WalletsType;
use DateTime;
use yii\web\Controller;

/**
 * Default controller for the `coinlayer` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     */
    public function actionIndex()
    {
        $response = file_get_contents(getenv('CL_URL'));
        $response = json_decode($response, true);

        $dateTime = new DateTime("@{$response['timestamp']}");
        $dateTime = $dateTime->format('Y-m-d H:i:s');

        if ($response['success'] === true) {
            $curRates = WalletsType::find()->all();
            foreach ($curRates as &$cur) {
                if (
                    $cur->is_update &&
                    $cur->short_name !== 'USD' &&
                    $cur->rates !== $response['rates'][$cur->short_name]
                ) {
                    $cur->rates = $response['rates'][$cur->short_name];
                    $cur->update_timestamp = $dateTime;
                    if (!$cur->save()) {
                        throw new yii\base\Exception("Failed to update $cur->short_name");
                    }
                }
            }
        }

        return "Updated at $dateTime";
    }
}
