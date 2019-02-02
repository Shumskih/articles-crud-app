<!DOCTYPE html>
<html lang="en">

<?php include '../views/partials/head.inc.php' ?>

<body>
<?php include '../views/partials/nav.inc.php' ?>

<div class="container">
    <h1 class="text-center mt-md-5"><?php echo $res['name']; ?></h1>
    <div class="d-inline-flex p-2">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $res['id'] ?>">
            <button class="btn btn-outline-danger mr-1" type="submit" name="delete">Удалить</button>
        </form>
        <a href="/categories/change-category?id=<?php echo $res['id'] ?>" class="btn btn-outline-info">Изменить</a>
    </div>
    <hr>

    <?php foreach ($articlesArr as $article): ?>
        <div class="card">
            <div class="card-header">
                <a href="/articles?id=<?php echo $article['id'] ?>">
                    <?php echo $article['title']; ?>
                </a>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <?php echo $article['short_desc']; ?>
                </div>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>
</div>
</body>
</html>