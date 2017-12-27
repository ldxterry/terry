<?php

/*spl_autoload_register(function ($class) {
    if ($class) {
        $file = str_replace('\\', '/', $class);
        $file .= '.class.php';
        if (file_exists($file)) {

            include $file;
        }
    }
});*/

require_once('Cbstest.class.php');

$foo = new Cbstest();
$array = array(
    'name'=>'terry',
    'id'=>2,
    'email'=>'helloxxx@foxmail.com',
    'money'=>4,
);
$res  = array2Proto($foo,$array);
$info = proto2Array($foo,$res);

echo '<pre>';
   print_r($info);
echo '</pre>';


//生成probuf信息
function array2Proto($message, $data){
    $codec = new \DrSlump\Protobuf\Codec\PhpArray();
    $codec->decode($message,$data);
    $codec = new \DrSlump\Protobuf();
    $protobuf = $codec->encode($message);
    return $protobuf;

}
//降probuf信息转换为数组
function proto2Array($message, $data){

    $codec = new \DrSlump\Protobuf();
    $codec->decode($message, $data);
    $codec = new \DrSlump\Protobuf\Codec\PhpArray();
    $arr = $codec->encode($message);
    return $arr;

}
