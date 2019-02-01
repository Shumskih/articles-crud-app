<!doctype html>
<html lang="en">
    <?php include '../../views/partials/head.inc.php' ?>
<body>
    <?php include '../../views/partials/nav.inc.php' ?>

    <div class="container">
        <h1 class="text-center mt-5 mb-5"><?php echo $headTitle ?></h1>

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="form-group">
                <input type="text" name="title" id="title" class="form-control" placeholder="Заголовок статьи" required>
            </div>
            <div class="form-group">
                <textarea name="short_desc" id="short_desc" rows="3" class="form-control" placeholder="Короткое превью статьи (до 200 символов)" required></textarea>
            </div>
            <div class="form-group">
                <textarea name="body" id="body" rows="10" class="form-control" placeholder="Текст статьи" required></textarea>
            </div>
            <input type="submit" name="submit" value="Отправить" class="btn btn-outline-primary">
        </form>
    </div>
</body>
</html>