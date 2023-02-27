<?php

$connect = mysqli_connect("localhost", "root", "", "cms");

if (mysqli_connect_errno()) {
    exit("Faild to connect to Mysql: " . mysqli_connect_error());
}
