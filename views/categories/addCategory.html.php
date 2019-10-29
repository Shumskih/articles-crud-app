<!doctype html>
<html lang="en">

<?php include '../../views/partials/head.inc.php' ?>

<body>

<?php include '../../views/partials/nav.inc.php' ?>

<div class="container">
  <h1 class="text-center mt-5 mb-5"><?php echo $headTitle ?></h1>

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="form-group">
      <input type="text" name="name" id="name" class="form-control" placeholder="Название категории" required>
    </div>
    <input type="submit" name="submit" value="Отправить" class="btn btn-outline-primary">
  </form>
</div>
</body>
<!--scripts-->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/scripts.ink.php' ?>
</html>
