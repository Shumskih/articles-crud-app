<!doctype html>
<html lang="en">

<?php include '../../views/partials/head.inc.php' ?>

<body>

<?php include '../../views/partials/nav.inc.php' ?>

<div class="container">
    <h1 class="text-center mt-5 mb-5"><?php echo $headTitle ?></h1>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <div class="form-group">
            <input type="text" name="title" id="title" class="form-control" value="<?php echo $title ?>" required>
        </div>
        <div class="form-group">
            <textarea name="short_desc" id="short_desc" rows="3" class="form-control" required><?php echo $short_desc ?></textarea>
        </div>
        <div class="form-group">
            <textarea name="body" id="body" rows="10" class="form-control" required><?php echo $body ?></textarea>
        </div>
        <input type="submit" name="submit" value="Изменить" class="btn btn-outline-primary">
        <input type="submit" name="cancel" value="Отменить" class="btn btn-outline-warning">
    </form>
</div>
</body>
<!--scripts-->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/scripts.ink.php' ?>
</html>