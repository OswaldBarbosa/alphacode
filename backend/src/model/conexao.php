<?php

/***************************************************************************************
 * Objetivo: Arquivo para criar a conexão com o BD Mysql
 * Data: 15/12/2023
 * Autor: Oswaldo Barbosa
 * Versão: 1.0
 ***************************************************************************************/

const SERVER = 'localhost';
const USER = 'root';
const PASSWORD = '78321875';
const DATABASE = 'db_alphacode';

function conexaoMysql()
{

   $mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);

   if ($mysqli->connect_errno) {
      echo "Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_errno;
   } else 
   
   return $mysqli;
}