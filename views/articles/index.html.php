<!DOCTYPE html>
<html lang="en">

<?php include 'views/partials/head.inc.php'; ?>

<body>
<?php include 'views/partials/nav.inc.php' ?>

<div class="container">

    <h1 class="text-center mt-5 mb-4"><?php echo $headTitle; ?></h1>
    <hr class="hr">

    <?php foreach ($articlesArr as $article): ?>

        <div class="card">
            <h4 class="card-header">
                <a href="/articles?id=<?php echo $article['id'] ?>">
                    <?php echo $article['title']; ?>
                </a>
            </h4>
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