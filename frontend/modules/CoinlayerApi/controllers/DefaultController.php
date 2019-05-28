<?php

namespace frontend\modules\CoinlayerApi\controllers;

use common\models\WalletsType;
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
        $wtype = new WalletsType();

        $response = file_get_contents(getenv('CL_URL'));
        $response = json_decode($response, true);
        $dateTime = new \DateTime("@{$response['timestamp']}");
        echo '<pre>'; var_export($dateTime->format('Y-m-d H:i:s')); echo '</pre>';
        if ($response['success'] === true) {
            $curRates = $wtype::find()->all();
            foreach ($curRates as &$cur) {
                if ($cur['short_name'] !== 'USD' && $cur['rates'] !== $response['rates'][$cur['short_name']]) {
                    $cur->rates = $response['rates'][$cur['short_name']];
                    $cur->update_timestamp = $dateTime->format('Y-m-d H:i:s');
                    echo '<pre>'; var_export($cur->update()); echo '</pre>';
                }
            }
        }
    }
}
