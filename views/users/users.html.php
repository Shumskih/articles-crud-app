<!DOCTYPE html>
<html lang="en">
<?php require_once ROOT . '/views/partials/head.inc.php' ?>
<body>
<?php require_once ROOT . '/views/partials/nav.inc.php' ?>

<div class="container">
  <h1 class="text-center mt-5">
      <?php echo $headTitle ?>
    <hr>
  </h1>

  <div class="form-inline float-right has-danger">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
      <input type="text" name="search"
             class="form-control <?php if (isset($message)
                                           && $message
                                              == 'error'): ?>is-invalid<?php endif; ?>"
             placeholder="Найти пользователя">
      <button type="submit" class="btn btn-outline-info">Поиск</button>
        <?php if (isset($message) && $message == 'error'): ?>
          <div class="invalid-feedback">Введена пустая строка</div>
        <?php endif; ?>
    </form>
  </div>


  <table class="table table-hover">
    <thead>
    <tr>
      <th scope="col">
        <a href="/users">
          ID
        </a>
          <?php if ($arrow == 'id'): ?>&uarr;<?php endif; ?>
      </th>
      <th scope="col">
        <a href="/users?sort-by=name">
          Name
        </a>
          <?php if ($arrow == 'name'): ?>&uarr;<?php endif; ?>
      </th>
      <th scope="col">
        <a href="/users?sort-by=email">
          Email
        </a>
          <?php if ($arrow == 'email'): ?>&uarr;<?php endif; ?>
      </th>
      <th scope="col">Permissions</th>
      <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
      <tr>
        <th scope="row"><?php echo $user['id'] ?>
        </th>
        <td>
            <?php echo $user['name'] ?>
        </td>
        <td>
            <?php echo $user['email'] ?>
        </td>
        <td>
            <?php foreach ($roles as $k => $v): ?>
                <?php foreach ($v as $a => $b): ?>
                    <?php if ($a == $user['id']): ?>
                  <span class="badge badge-secondary" data-toggle="tooltip"
                        data-placement="top"
                        title="<?php echo $b['roleDescription'] ?>">
                                        <?php echo $b['roleName']; ?>
                                    </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </td>

        <td>
          <a href="/users/edit-user?id=<?php echo $user['id'] ?>"
             class="btn btn-outline-warning">Edit</a>
          <a href="/users/delete-user?id=<?php echo $user['id'] ?>"
             class="btn btn-outline-danger">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
<!--scripts-->
<?php require_once ROOT . '/views/partials/scripts.ink.php' ?>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
</html>