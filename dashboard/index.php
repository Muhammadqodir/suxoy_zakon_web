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
  <title>Сухой законъ - Заказы</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
  <?php include("../inc/navbar.php") ?>


  <div class="container dashboard_content">
    <div class="d-flex">
      <div class="p-1" id="indicator"></div>
      <div class="mr-auto">
        <h3 style="margin: 8px">Активные заказы:</h3>
      </div>
      <div class="p-2">
        <a class="btn btn-success" href="<?php echo getRoute("orders") ?>" role="button"><i class="fa-solid fa-clock-rotate-left"></i> История заказов</a>
      </div>

    </div>
    <!-- Positions -->
    <div class="row menu_items" id="items">

    </div>

  </div>

  <div class="modal fade" id="confirmationDialog" tabindex="-1" role="dialog" aria-labelledby="confirmationDialogTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Подтвердите действие</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Вы действительно хотите изменить статус заказа?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
          <button type="button" onclick="changeStatus()" class="btn btn-primary">Да изменить</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Уведомления о новых заказах</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Разрешите отправку звуковых уведомлений
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Разрешить</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    var selectedId = -1;
    var selectedStatus = "";

    function showConfirmDialog(id, status) {
      selectedId = id;
      selectedStatus = status;
      $('#confirmationDialog').modal('toggle');
    }

    function changeStatus() {
      fetch('https://suxoy-zakon.ru/dashboard/changeStatus.php?id=' + selectedId + '&status=' + selectedStatus)
        .then(response => response.text());
      $('#confirmationDialog').modal('toggle');
    }

    var ordersCount = 0;

    setInterval(function() {
      fetch('https://suxoy-zakon.ru/dashboard/activeOrders.php')
        .then(response => response.text())
        .then(text => {
          $("#items").html(text);
          if (ordersCount < $('.menu_item').length) {
            var audio = new Audio('https://suxoy-zakon.ru/dashboard/notification.wav');
            audio.play();
          }
          ordersCount = $('.menu_item').length;
          $("#indicator").css("background-color", "green");
          setTimeout(() => {
            $("#indicator").css("background-color", "orange");
          }, 3000);
        })
    }, 3000);
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script>
    $('#exampleModal').modal("show");
  </script>
</body>

</html>