<?php

spl_autoload_register(function ($class) {
    if ($class) {
        $file = str_replace('\\', '/', $class);
        $file .= '.class.php';
        if (file_exists($file)) {

            include $file;
        }
    }
});

$foo = new Person();
$foo->setName('hellojammy');
$foo->setId(2);
$foo->setEmail('helloxxx@foxmail.com');
$foo->setMoney(1988894.995);
$packed = $foo->serializeToString();
$foo->parseFromString($packed);

echo '<pre>';
  print_r($foo);
echo '</pre>';

