<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="container">
        <h2>3 standard Users</h2>
        <table class="table">
            <tbody>
                <tr>
                    <td>Login</td>
                    <td>Password</td>
                </tr>
                <tr>
                    <td>test</td>
                    <td>testtest</td>
                </tr>
                <tr>
                    <td>user</td>
                    <td>useruser</td>
                </tr>
                <tr>
                    <td>admin</td>
                    <td>asdasd</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="jumbotron">
        <h1>My Database structure</h1>

        <br>
        <p class="lead">Some additional features of my project:</p>
        <ol>
            <li>Deleted wallets don`t drop from DB. It mark as deleted.</li>
            <li>When you change currency for wallet, sum in wallet converting in new currency.</li>
            <li>In Rates page you can block/unblock updating by checkbox.</li>
        </ol>
        <br><br>

        <img class="img-responsive" src="/images/yml.png">
    </div>

    <div class="container-lg">

    </div>

</div>
