<?php
$current_route = getCurrentRoute();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img src="../assets/logo.png" height="40"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if($current_route == "dashboard/") echo 'active'?>">
        <a class="nav-link" href="<?php echo getRoute("dashboard") ?>"><i class="fa-solid fa-receipt"></i> Заказы <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item <?php if($current_route == "menu/") echo 'active'?>">
        <a class="nav-link" href="<?php echo getRoute("menu") ?>"><i class="fa-solid fa-pizza-slice"></i> Меню <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item <?php if($current_route == "clients/") echo 'active'?>">
        <a class="nav-link" href="<?php echo getRoute("clients") ?>"><i class="fa-solid fa-users"></i> Клиенты</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href=""><i class="fa-solid fa-chart-pie"></i> Статистика</a>
      </li>
      <li class="nav-item <?php if($current_route == "settings/") echo 'active'?>">
        <a class="nav-link" href="<?php echo getRoute("settings") ?>"><i class="fa-solid fa-gears"></i> Настройки</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <a class="btn btn-outline-danger" href="<?php echo getRoute("logout.php") ?>" role="button"><i class="fa-solid fa-right-from-bracket"></i> Выйти</a>
    </form>
  </div>
</nav>