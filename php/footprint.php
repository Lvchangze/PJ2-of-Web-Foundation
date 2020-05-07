<?php
ini_set('display_startup_errors', 1);//ini_set — 为一个配置选项设置值
ini_set('display_errors', 1);//ini_set ( string $varname , string $newvalue ) : string
error_reporting(-1);

define("COOKIE_HISTORY_ENTRY", "COOKIE_HISTORY_ENTRY");

function pushHistory($name){
    if(!array_key_exists(COOKIE_HISTORY_ENTRY, $_COOKIE)) {      //array_key_exists — 检查数组里是否有指定的键名或索引,第一个参数是要检查的键,第二个是查找的数组
        $_COOKIE[COOKIE_HISTORY_ENTRY] = serialize([]);
    }                                                                  //第一次访问,设置$_COOKIE[COOKIE_HISTORY_ENTRY]为空字符串
    $history = unserialize($_COOKIE[COOKIE_HISTORY_ENTRY]);//将该字符串反序列化为数组
    array_push($history, [ "name" => $name, "url" => $_SERVER['REQUEST_URI']]);//将新的地址和名字加入数组
    for($i = 0; $i < count($history); $i++){
      for($j = $i + 1; $j <count($history); $j++){
        if($history[$i]["name"] == $history[$j]["name"]){
          array_splice($history,$i,$j-$i);
        }
      }
    }
    setcookie(COOKIE_HISTORY_ENTRY, serialize($history));//将数组再次序列化为字符串，并更新coockie
    $_COOKIE[COOKIE_HISTORY_ENTRY] = serialize($history);//更新$_COOKIE[COOKIE_HISTORY_ENTRY]为新的cookie对应的序列化字符串
}

function printHistory(){
    $history = unserialize($_COOKIE[COOKIE_HISTORY_ENTRY]);//重新获取cookie的值，存在数组里
    for($k = 0; $k < count($history); $k++) {
        $entry = $history[$k];
        if($k != 0) {
            echo "→";
        }
          echo <<<EOT
            <a href="{$entry["url"]}">{$entry["name"]}</a>
EOT;
    }
}

?>