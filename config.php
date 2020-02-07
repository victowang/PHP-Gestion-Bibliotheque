<?php
   try {
      $pdo = new PDO('mysql:host=localhost;dbname=devweb','devweb','devweb');
      $pdo->exec('SET NAMES utf8');
   }
   catch(PDOException $e) {
      $msg = 'ERREUR PDO dans' .$e->getFile().'L.'.$e->getLine().' : '.$e->getMessage();
      die($msg);
   }
?>