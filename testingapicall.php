<?php 

$content = file_get_contents("https://itunes.apple.com/search?entity=album&term=the+eminem+show&limit=1");
$array = json_decode($content);
var_dump($array->results[0]->collectionPrice / 0.02);
?>