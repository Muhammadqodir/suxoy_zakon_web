<?php
require "../config.php";
require "../routing.php";
session_start();
if (!isset($_SESSION["is_login"])) {
  goToRoute("login");
  exit();
}

function getStatusColor($order)
{
  switch ($order["status"]) {
    case 'Отправлено':
      return "badge badge-secondary";
    case 'Принято':
      return "badge badge-info";
    case 'Готовится':
      return "badge badge-warning";
    case 'В пути':
      return "badge badge-primary";
    case 'Готово':
      return "badge badge-success";
    default:
      return "badge badge-dark";
  }
}

function getBtnAsArray($title, $status, $class, $icon, $id)
{
  return array("title" => $title, "status" => $status, "class" => $class, "icon" => $icon, "id" => $id);
}

function getStatusBtns($order)
{
  switch ($order["status"]) {
    case 'Отправлено':
      return [
        getBtnAsArray("Принять", "Принято", "btn btn-success", "fa-solid fa-check",  $order["id"]),
        getBtnAsArray("Отменить", "Отменено", "btn btn-danger", "fa-solid fa-xmark", $order["id"]),
      ];
    case 'Принято':
      return [
        getBtnAsArray("Готовится", "Готовится", "btn btn-warning", "fa-solid fa-kitchen-set", $order["id"]),
      ];
    case 'Готовится':
      return [
        getBtnAsArray("В пути", "В пути", "btn btn-success", "fa-solid fa-check", $order["id"]),
      ];
    case 'В пути':
      return [
        getBtnAsArray("Доставлено", "Готово", "btn btn-success", "fa-solid fa-circle-check", $order["id"]),
      ];
    default:
      return [];
  }
}

?>

<?php
require "../db_helper.php";
$db = new DBHelper();
$data = $db->getAllActiveOrders();
?>

<?php if (count($data) == 0) : ?>
  <div style="text-align: center; margin: auto; font-size: 24px;">Нет активных заказов!</div>
<?php endif; ?>

<?php foreach ($data as $item) : ?>
  <div class="col-lg-4 col-md-6">
    <div class="card menu_item" style="width: 100%;">
      <div class="card-body">
        <p style="opacity: .5;">
          <?php echo $item["date"] ?>
        </p>
        <h5 class="card-title menu_title"><?php echo "#" . $item["id"] ?> <span class="<?php echo getStatusColor($item) ?>"><?php echo $item["status"] ?></span></h5>
        <?php $preprocessed = str_replace("\r\n", "", $item["positions"]) ?>
        <?php $positions = json_decode($preprocessed, true)  ?>
        <p class="card-text">
          <b>Позиции:</b> <br>
          <?php foreach ($positions as $position) : ?>

            <?php echo $position["item"]["title"] ?>
            <b>
              x <?php echo $position["count"] ?>
            </b><br>

          <?php endforeach; ?>
        </p>
        <p class="">
          <?php if ($item["user"] != null) : ?>
            <i class="fa-solid fa-user"></i> <?php echo $item["user"]["fullName"] ?><br>
            <i class="fa-solid fa-phone"></i><b> <?php echo $item["user"]["phone"] ?></b>
          <?php else : ?>
        <div style="color: red;"><i class="fa-solid fa-user"></i> Удалённый аккаунт</div>
      <?php endif; ?>
      </p>
      <p>
        <i class="fa-solid fa-location-dot"></i><b> <?php echo $item["destination"]["destination"] ?>, <?php echo $item["address"] ?></b><br>

        <i class="fa-solid fa-comment-dollar"></i><b> <?php echo $item["payment_type"]?>, Сдача: <?php echo $item["stacha"] != "" ? $item["stacha"] : "не нужна" ?></b><br>
        <?php if($item["note"] != ""): ?>
        <i class="fa-solid fa-circle-info"></i><b> <?php echo $item["note"]?></b><br>
        <?php endif; ?>
        
      </p>
      <?php $statusBtns = getStatusBtns($item) ?>
      <div class="row">
        <?php foreach ($statusBtns as $btn) : ?>
          <div class="col-<?php echo 12 / count($statusBtns) ?>" style="margin: 0px; padding: 6px;">
            <button onclick="showConfirmDialog(<?php echo $item["id"] ?>, '<?php echo $btn["status"] ?>')" style="width: 100%;" class="<?php echo $btn["class"] ?>"><i class="<?php echo $btn["icon"] ?>"></i> <?php echo $btn["title"] ?></button>
          </div>
        <?php endforeach; ?>
      </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>