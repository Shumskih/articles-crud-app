<?php include $_SERVER['DOCUMENT_ROOT'] . '/helpers/categoriesMenu.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/helpers/moderateArticlesCounter.php' ?>
<div class="bs-component">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="/">Article</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarColor01" aria-controls="navbarColor01"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
                </li>
                <ul class="nav nav-pills">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Категории</a>
                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 50px, 0px); top: 0px; left: 0px; will-change: transform;">
                          <a class="dropdown-item" href="/categories">All Categories</a>
                          <div class="dropdown-divider"></div>
                            <?php foreach ($categories as $category): ?>
                                <a class="dropdown-item" href="/categories?id=<?php echo $category['id'] ?>"><?php echo $category['name'] ?></a>
                                <div class="dropdown-divider"></div>
                            <?php endforeach; ?>

                        </div>
                    </li>
                </ul>

                <?php if (isset($_SESSION['writer']) or isset($_SESSION['editor'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/articles/add-article">Добавить статью</a>
                    </li>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="/messages">
                                Сообщения
                            </a>
                            <span class="badge badge-primary badge-pill"><?php echo $returnedArticles; ?></span>
                        </li>
                    </ul>
                <?php endif; ?>

                <?php if (isset($_SESSION['site_administrator'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/categories/add-category">Добавить категорию</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['account_administrator'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/users">Редактировать пользователей</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['moderator'])): ?>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="/articles/moderate">
                                Модерировать
                            </a>
                            <span class="badge badge-primary badge-pill"><?php echo $moderateArticlesCount ?></span>
                        </li>
                    </ul>
                <?php endif; ?>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text"
                       placeholder="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">
                    Search
                </button>
            </form>
            <div class="my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">
                    <?php if (isset($_SESSION['loggedIn'])): ?>
                        <li class="nav-item">
                            <a class="nav-link">
                                Здравствуйте, <?php echo $_SESSION['name']; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/logout?logout" class="nav-link">Выход</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="/login">Вход</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="/registration">Регистрация</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</div>