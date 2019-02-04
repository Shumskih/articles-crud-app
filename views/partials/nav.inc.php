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
                <li class="nav-item">
                    <a class="nav-link" href="/categories">Категории</a>
                </li>

                <?php if (isset($_SESSION['writer']) or isset($_SESSION['editor'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/articles/add-article">Добавить статью</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['site_administrator'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/categories/add-category">Добавить категорию</a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['account_administrator'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/categories/add-category">Редактировать пользователей</a>
                    </li>
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
                            <a class="nav-link">Здравствуйте,
                                <?php if (isset($_SESSION['name']))
                                        echo $_SESSION['name'];
                                      else
                                        echo $_SESSION['email'] ?>
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