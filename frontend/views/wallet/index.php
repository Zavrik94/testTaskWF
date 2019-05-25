<?php
/* @var $this yii\web\View */
?>
<h1>Wallet list</h1>

<?php foreach ($walletsList as $wallet) {?>

    <?= $wallet->wallet_name?>

<?php } ?>
