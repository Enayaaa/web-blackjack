<?php
$json = json_decode(file_get_contents("file.json"), true);

function save_json($e)
{
    file_put_contents("file.json", json_encode($e));
}
