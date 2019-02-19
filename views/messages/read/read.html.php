<!DOCTYPE html>
<html lang="en">
<?php require_once ROOT . '/views/partials/head.inc.php' ?>
<body>
<?php require_once ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">
    <h1 class="text-center mt-md-5"><?php echo $message['title']; ?></h1>
    <hr>

    <div class="card">
        <div class="card-body">
            <div class="card-text">
              <?php echo $message['body']; ?>
            </div>
            <hr>
            <div class="text-lg-right">
              <?php echo $date; ?>
            </div>
            <div class="card-text mb-5">
              <?php echo $message['message']; ?>
            </div>
          <?php if ($user['userId'] == $userId): ?>
              <div class="d-inline-flex p-2">
                  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                      <input type="hidden" name="id" value="<?php echo $message['id'] ?>">
                      <button class="btn btn-outline-danger mr-1" type="submit" name="delete">Удалить</button>
                  </form>
                  <a href="/articles/edit-article?id=<?php echo $message['id'] ?>" class="btn btn-outline-info">Изменить</a>
              </div>
          <?php endif; ?>
        </div>
    </div>
</div>
</body>
<!--scripts-->
<?php require_once ROOT . '/views/partials/scripts.ink.php' ?>
</html>