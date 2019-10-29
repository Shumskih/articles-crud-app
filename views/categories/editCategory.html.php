<!doctype html>
<html lang="en">
<?php include ROOT . '/views/partials/head.inc.php' ?>

<body>

<?php include ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">
  <h1 class="text-center mt-5 mb-5"><?php echo $headTitle ?></h1>

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
    <input type="hidden" name="id" value="<?php echo $categoryId ?>">
    <div class="form-group">
      <input type="text" name="name" id="name" class="form-control" value="<?php echo $categoryName ?>" required>
    </div>
    <input type="submit" name="submit" value="Изменить" class="btn btn-outline-primary">
    <input type="submit" name="cancel" value="Отменить" class="btn btn-outline-warning">
  </form>
</div>
</body>
<!--scripts-->
<?php include ROOT . '/views/partials/scripts.ink.php' ?>
</html>
