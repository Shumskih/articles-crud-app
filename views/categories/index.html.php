<!DOCTYPE html>
<html lang="en">
<?php include ROOT . '/views/partials/head.inc.php'; ?>
<body>
<?php include ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">

  <h1 class="text-center mt-5 mb-4"><?php echo $headTitle; ?></h1>
  <hr class="hr">

    <?php foreach ($categories as $category): ?>
      <div class="card">
        <h4 class="card-header">
          <a href="/categories?id=<?php echo $category['id'] ?>">
              <?php echo $category['name']; ?>
          </a>
        </h4>
      </div>
      <hr>
    <?php endforeach; ?>
</div>
</body>
<!--scripts-->
<?php include ROOT . '/views/partials/scripts.ink.php' ?>
</html>