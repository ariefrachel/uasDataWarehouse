<?php
$konek=new mysqli('localhost','root','','dwh');
if ($konek->connect_errno){
    "Database Error".$konek->connect_error;
}
?>