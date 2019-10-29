<!DOCTYPE html>
<html lang="en">

<?php include ROOT . '/views/partials/head.inc.php'; ?>

<body>
<?php include ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">

  <h1 class="text-center mt-5 mb-4"><?php echo $headTitle; ?></h1>
  <hr class="hr">

  <div class="row">
      <?php while ($article = $articles->fetch()): ?>
        <div class="col-lg-4">
          <div class="bs-component">
            <div class="card mb-3">
              <img style="height: 250px; width: 100%; display: block;"
                   src="<?php echo $article['img'] ?>"
                   alt="Card image">
              <div class="card-body">
                <a href="/articles?id=<?php echo $article['id'] ?>">
                  <h5 class="card-title"><?php echo $article['title']; ?></h5>
                </a>
                <h6 class="card-subtitle text-muted"><?php echo $article['short_desc']; ?></h6>
              </div>
              <div class="card-footer text-muted">
                  <?php echo convertEngDateToRussian(strtotime($article['datetime'])); ?>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
  </div>
</div>
</body>
<!--scripts-->
<?php include ROOT . '/views/partials/scripts.ink.php' ?>
</html>