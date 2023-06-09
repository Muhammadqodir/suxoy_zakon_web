<?php
require "../config.php";
require "../routing.php";
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Сухой законъ - Клиенты</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
  <?php include("../inc/navbar.php") ?>

  <div class="container dashboard_content">
    <div class="d-flex">
      <div class="mr-auto p-2">
        <h3>Клиенты</h3>
      </div>
      <div class="p-2"><a target="_blank" class="btn btn-success" href="<?php echo getRoute("clients/export.php") ?>" role="button"><i class="fa-solid fa-layer-group"></i> Экспорт</a></div>
    </div>

    <!-- Positions -->
    <?php require "../db_helper.php";
    $db = new DBHelper(); ?>
    <div class="row menu_items">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Ф.И.О</th>
            <th scope="col">Номер телефона</th>
            <th scope="col">Пол</th>
            <th scope="col">Дата рождения</th>
            <th scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($db->getUsers() as $item) : ?>
          <tr>
            <th scope="row"><?php echo $item["id"] ?></th>
            <th><?php echo $item["fullName"] ?></th>
            <td><?php echo $item["phone"] ?></td>
            <td><?php echo $item["gender"] ?></td>
            <td><?php echo $item["birth_day"] ?></td>
            <td>
              <button onclick="showConfirmDialog(<?php echo $item["id"] ?>)" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
          </div>
        </div>
      <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </div>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>