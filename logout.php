<?php

require 'database.php';
session_start();
session_unset();
session_destroy();
header("Location: /$foldername/login.php");
