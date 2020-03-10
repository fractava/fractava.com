<?php
spl_autoload_register(function ($pClassName) {
    require($_SERVER['DOCUMENT_ROOT'] ."/inc/" . str_replace("\\", "/", $pClassName) . ".inc.php");
  }
);