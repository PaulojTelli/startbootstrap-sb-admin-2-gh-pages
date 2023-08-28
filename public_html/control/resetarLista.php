<?php
 require  $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';
novoMes();
header("Location:/public_html/pages/list.php?categoria=todos");
exit;
