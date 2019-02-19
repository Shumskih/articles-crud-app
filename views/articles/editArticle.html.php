<!doctype html>
<html lang="en">
<?php include ROOT . '/views/partials/head.inc.php' ?>
<body>
<?php include ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">
    <h1 class="text-center mt-5 mb-5"><?php echo $headTitle ?></h1>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $articleId ?>">
        <div class="form-group">
            <input type="text" name="title" id="title" class="form-control" value="<?php echo $title ?>" required>
        </div>
        <div class="form-group">
            <textarea name="short_desc" id="short_desc" rows="3" class="form-control" required><?php echo $short_desc ?></textarea>
        </div>
        <div class="form-group">
            <textarea name="body" id="body" rows="10" class="form-control" required><?php echo $body ?></textarea>
        </div>
        <div class="form-group">
            <div class="input-group ml-n2 col-lg-7">
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="file">
                    <label class="custom-file-label" for="file">Загрузите изображение</label>
                </div>
            </div>
        </div>
        <input type="submit" name="submit" value="Изменить" class="btn btn-outline-primary">
        <a href="/articles?id=<?php echo $articleId ?>" class="btn btn-outline-warning">Отменить</a>
    </form>
</div>
</body>
<!--scripts-->
<?php include ROOT . '/views/partials/scripts.ink.php' ?>
</html>