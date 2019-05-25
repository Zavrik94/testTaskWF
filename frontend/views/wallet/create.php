<?php
/* @var $this yii\web\View */
/* $var $model frontend\models\Author */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>

    <h1>Create new wallet</h1>

<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'wallet_name'); ?>
<?php echo $form->field($model, 'currency'); ?>


<?php echo Html::submitButton('Save', [
    'class' => 'btn btn-primary'
]); ?>

<?php ActiveForm::end();