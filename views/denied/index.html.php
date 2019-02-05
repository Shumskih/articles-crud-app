<!DOCTYPE html>
<html lang="en">

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/head.inc.php' ?>

<body>
<?php include  $_SERVER['DOCUMENT_ROOT'] . '/views/partials/nav.inc.php' ?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <?php if (!isset($_SESSION['loggedIn'])): ?>
                        <h1 class="card-title text-center">У вас нет доступа к этой странице!</h1>
                        <div class="card-text text-center">
                            <a href="/login" class="btn btn-outline-info ">Вход</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
</body>
<!--scripts-->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/scripts.ink.php' ?>
</html>