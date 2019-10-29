<!DOCTYPE html>
<html lang="en">
<!--head-->
<?php include ROOT . '/views/partials/head.inc.php' ?>
<body>
<!--navigation-->
<?php include ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">
  <h1 class="text-center mt-md-5"><?php echo $article['title']; ?></h1>
  <hr>

  <div class="card">
    <div class="card-body">
      <div class="card-text">
          <?php echo $article['body']; ?>
      </div>
      <hr>
      <div>
        <div class="text-lg-right">
            <?php echo $date; ?>
        </div>

          <?php if (isset($_SESSION['editor'])): ?>
            <div class="d-inline-flex p-2">
              <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $article['articleId'] ?>">
                <button class="btn btn-outline-danger mr-1" type="submit" name="delete">Удалить</button>
              </form>
              <a href="/articles/edit-article?id=<?php echo $article['articleId'] ?>" class="btn btn-outline-info">Изменить</a>
            </div>
          <?php endif; ?>

      </div>
    </div>
  </div>
</div>
</body>
<!--scripts-->
<?php include ROOT . '/views/partials/scripts.ink.php' ?>
</html>