<?php

$json = '[{"count":2,"item":{"id":38,"title":"Креветки в соевом соусе","desc":"Креветки в соевом соусе","price":"720","imageUrl":"https://suxoy-zakon.ru/uploads/Krevetki_v_soevom_souse.jpg"}},{"count":2,"item":{"id":37,"title":"Креветки в горчичном соусе","desc":"Креветки в горчичном соусе","price":"720","imageUrl":"https://suxoy-zakon.ru/uploads/Krevetki_v_gorcicnom_souse.jpg"}},{"count":1,"item":{"id":35,"title":"Клаб сэндвич с ветчиной","desc":"Пшеничный хлеб, филе цыпленка, листья салата Айсберг, сыр, помидор, белый соус. Картофель Фри бонус","price":"235","imageUrl":"https://suxoy-zakon.ru/uploads/Klab_sendvic_s_vetcinoĭ.jpg"}},{"count":1,"item":{"id":33,"title":"Картофель по-деревенски","desc":"​*1 порция- 200 гр.","price":"155","imageUrl":"https://suxoy-zakon.ru/uploads/Kartofely_po-derevenski.jpg"}}]';

$arr = json_decode($json);

print_r($arr);