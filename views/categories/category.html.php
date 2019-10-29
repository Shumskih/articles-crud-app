<!DOCTYPE html>
<html lang="en">
<?php include ROOT . '/views/partials/head.inc.php' ?>
<body>
<?php include ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">
  <h1 class="text-center mt-md-5"><?php echo $categoryName; ?></h1>

    <?php if (isset($_SESSION['site_administrator'])): ?>
      <div class="d-inline-flex p-2">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
          <input type="hidden" name="id" value="<?php echo $categoryId; ?>">
          <button class="btn btn-outline-danger mr-1" type="submit" name="delete">Удалить</button>
        </form>
        <a href="/categories/edit-category?id=<?php echo $categoryId; ?>" class="btn btn-outline-info">Изменить</a>
      </div>
    <?php endif; ?>
  <hr>
    <?php foreach ($articles as $article): ?>
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
<!--scripts-->
<?php include ROOT . '/views/partials/scripts.ink.php' ?>
</html>