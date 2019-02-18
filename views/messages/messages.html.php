<!DOCTYPE html>
<html lang="en">

<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/head.inc.php'; ?>

<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/nav.inc.php' ?>

<div class="container">

    <h1 class="text-center mt-5 mb-4"><?php echo $headTitle; ?></h1>
    <hr class="hr">

    <div class="row">
        <table class="table table-hover">
            <tbody>
                <?php while ($article = $articles->fetch()): ?>
                    <tr class="table-active">
                        <th scope="row">
                            <a href="/messages/read?articleId=<?php echo $article['id'] ?>">
                                <?php echo $article['title']; ?>
                            </a>
                        </th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
<!--scripts-->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/scripts.ink.php' ?>
</html>