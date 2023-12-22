<?php

/***************************************************************************************
* Objetivo: Arquivo responsavel pela criação de variaveis e constantes do projeto
* Data: 15/12/2023
* Autor: Oswaldo Barbosa
* Versão: 1.0
***************************************************************************************/

$SUCCESS_STATUS = array('status' => 200, 'message' => 'Requisição bem sucedida.');

define('MEU_JSON', '{"status": 200, "message": "Requisição bem sucedida."}');

function createJSON ($arrayDados)
    {
        //Validação para tratar array sem dados
        if (!empty($arrayDados))
        {
            //configura o padrão da conversão para o formato JSON
            header('Content-Type: application/json');
            $dadosJSON = json_encode($arrayDados);
            
            //json_encode(); - converte um array para JSON
            //json_decode(); - converte um JSON para array

            return $dadosJSON;
        }else
        {
            return false;
        }
        

    }

?>