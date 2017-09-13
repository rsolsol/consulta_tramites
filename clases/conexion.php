<?php 
	$localhost = 'XXXX';
        $user ='XXXX';
        $pass = 'XXXXX';
        $db = 'XXXX';
	$con = mysqli_connect($localhost,$user,$pass,$db) or die('no se pudo conectar al servidor'.mysqli_error());