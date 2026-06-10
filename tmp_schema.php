<?php
$db = mysqli_connect('localhost', 'root', '', 'crud-dinata');
if (!$db) {
    echo 'connect fail';
    exit;
}
$res = mysqli_query($db, 'SHOW CREATE TABLE barang');
if (!$res) {
    echo 'query fail: ' . mysqli_error($db);
    exit;
}
$row = mysqli_fetch_assoc($res);
print_r($row);
