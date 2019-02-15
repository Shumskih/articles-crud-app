<!doctype html>
<html lang="en">
    <?php include '../../views/partials/head.inc.php' ?>

<body>
    <?php include '../../views/partials/nav.inc.php' ?>

    <div class="container">
        <h1 class="text-center mt-5 mb-5">
            <?php echo $headTitle ?>
            <hr>
        </h1>

        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="mb-5">
            <div class="form-group">
                <select class="custom-select" name="category">
                    <option selected="">Выбор категории:</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id'] ?>">
                            <?php echo $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="title" id="title" class="form-control" placeholder="Заголовок статьи" required>
            </div>
            <div class="form-group">
                <textarea name="short_desc" id="short_desc" rows="3" class="form-control" placeholder="Короткое превью статьи (до 200 символов)" required></textarea>
            </div>
            <div class="form-group">
                <textarea name="body" id="body" rows="10" class="form-control" placeholder="Текст статьи" required></textarea>
            </div>
            <div class="form-group">
                <div class="input-group ml-n2 col-lg-7">
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="file">
                        <label class="custom-file-label" for="file">Загрузите изображение</label>
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" value="Отправить" class="btn btn-outline-primary">
        </form>



    </div>
</body>
    <!--scripts-->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/partials/scripts.ink.php' ?>
</html>