<!DOCTYPE html>
<html lang="en">

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/head.inc.php' ?>

<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/nav.inc.php' ?>

<div class="container">
    <h1 class="text-center mt-md-5"><?php echo $res['title']; ?></h1>
    <hr>

    <div class="card">
        <div class="card-body">
            <div class="card-text">
                <?php echo $res['body']; ?>
            </div>
            <hr>
            <div>
                <div class="text-lg-right">
                    <?php echo $date; ?>
                </div>

                <?php if (isset($_SESSION['editor'])): ?>
                    <div class="d-inline-flex p-2">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group mt-4">
                                <textarea class="form-control" name="messageBody" rows="7" placeholder="Если необходимо внести правки, здесь пишется сообщение автору, в котором описывается, что нужно изменить."></textarea>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $res['id'] ?>">
<!--                            <button class="btn btn-outline-success mr-1" type="submit" name="publish">Опубликовать</button>-->
                            <input class="btn btn-outline-warning mr-1" type="submit" name="message" value="Сообщение автору">
                        </form>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
<!--scripts-->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/scripts.ink.php' ?>
</html>