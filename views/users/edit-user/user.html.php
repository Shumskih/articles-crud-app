<!doctype html>
<html lang="en">
<?php require_once ROOT . '/views/partials/head.inc.php' ?>
<body>
<?php require_once ROOT . '/views/partials/nav.inc.php' ?>
<div class="container">
    <h1 class="text-center mt-5 mb-5">
        <?php echo $headTitle ?>
        <hr>
    </h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
        <div class="form-group">
            <input type="text" name="name" class="form-control" value="<?php echo $user['name'] ?>" required>
        </div>
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input type="text" name="email" readonly="" class="form-control-plaintext" value="<?php echo $user['email'] ?>">
            </div>
        </div>
        <h5>Permissions</h5>
        <hr>
        <?php $roleId = []; ?>
        <?php foreach ($userHasRoles as $role): ?>
            <?php array_unshift($roleId, $role['roleId']); ?>
        <?php endforeach; ?>
        <div class="form-group">
            <?php foreach ($roles as $role): ?>
                <?php if (in_array($role['id'], $roleId)): ?>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="permissions[<?php echo $role['id'] ?>]" id="<?php echo $role['id'] ?>" checked="checked" />
                        <label class="custom-control-label" for="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></label>
                    </div>
                    <?php continue; ?>
                <?php endif; ?>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="permissions[<?php echo $role['id'] ?>]" id="<?php echo $role['id'] ?>" />
                    <label class="custom-control-label" for="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <input type="submit" name="edit" value="Изменить" class="btn btn-outline-primary">
        <a href="/users" class="btn btn-outline-warning">Отменить</a>
    </form>
</div>
</body>
<!--scripts-->
<?php require_once ROOT . '/views/partials/scripts.ink.php' ?>
</html>