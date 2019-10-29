<!DOCTYPE html>
<html lang="en">
<?php require_once ROOT . '/views/partials/head.inc.php'; ?>
<body>
<?php require_once ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">

  <h1 class="text-center mt-5 mb-4"><?php echo $headTitle; ?></h1>
  <hr class="hr">

  <div class="row">
    <table class="table table-hover">
      <tbody>
      <?php foreach ($articles as $article): ?>
        <tr class="table-active">
          <th scope="row">
            <a href="/messages/read?articleId=<?php echo $article['id'] ?>">
                <?php echo $article['title']; ?>
            </a>
          </th>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
<!--scripts-->
<?php require_once ROOT . '/views/partials/scripts.ink.php' ?>
</html>