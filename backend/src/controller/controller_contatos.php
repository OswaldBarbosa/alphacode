<?php

/***************************************************************************************
 * Objetivo: Arquivo para fazer o controle dos dados de contatos
 * Data: 15/12/2023
 * Autor: Oswaldo Barbosa
 * Versão: 1.0
 ***************************************************************************************/

require_once('./src/model/DAO/contatosDAO.php');

//retorna a lista de todos os contatos
function getContatos()
{

    $dados = selectAllContatos();

    if (!empty($dados)) {

        $sucessRequest = array(
            'status' => 200,
            'message' => 'Requisição bem sucedida.',
            'quantidade' => count($dados),
            'contatos' => $dados
        );

        $dadosJSON = json_encode($sucessRequest);

        return $dadosJSON;
    } else {
        return false;
    }
}

//retorna um contato filtrando pelo id
function getContatoById($id)
{

    if ($id == 0 || empty($id) || !is_numeric($id)) {

        $errorInvalidId = array(
            'status' => 400,
            'message' => 'O ID informado na requisição não é válido ou não foi encaminhado.'
        );

        $dadosJSON = json_encode($errorInvalidId);

        return $dadosJSON;
    } else {

        $statusId = selectContatoById($id);

        if ($statusId) {

            $dados = selectContatoById($id);

            if (!empty($dados)) {
    
                $sucessRequest = array(
                    'status' => 200,
                    'message' => 'Requisição bem sucedida.',
                    'contato' => $dados
                );
    
                $dadosJSON = json_encode($sucessRequest);
    
                return $dadosJSON;
            } else {
                return false;
            }
        
        } else {

            $errorIdNotFound = array(
                'status' => 404,
                'message' => 'O ID informado é válido, mas não existe.',
            );

            $dadosJSON = json_encode($errorIdNotFound);

            return $dadosJSON;

        } 
    }
}

//inserir um novo contato
function inserirContato($dadosContato)
{

    if (
        empty($dadosContato[0]['nome'])                     || is_numeric($dadosContato[0]['nome'])             || strlen($dadosContato[0]['nome']) > 150           ||
        empty($dadosContato[0]['data_nascimento'])          || is_numeric($dadosContato[0]['data_nascimento'])  || strlen($dadosContato[0]['data_nascimento']) > 10 ||
        empty($dadosContato[0]['email'])                    || is_numeric($dadosContato[0]['email'])            || strlen($dadosContato[0]['email']) > 255          ||
        empty($dadosContato[0]['profissao'])                || is_numeric($dadosContato[0]['profissao'])        || strlen($dadosContato[0]['profissao']) > 100      ||
        empty($dadosContato[0]['telefone'])                 || is_numeric($dadosContato[0]['telefone'])         || strlen($dadosContato[0]['telefone']) > 15        ||
        empty($dadosContato[0]['celular'])                  || is_numeric($dadosContato[0]['celular'])          || strlen($dadosContato[0]['celular']) > 15         ||
        !is_numeric($dadosContato[0]['numero_whatsapp'])    ||
        !is_numeric($dadosContato[0]['notificacao_email'])  ||
        !is_numeric($dadosContato[0]['notificacao_sms'])
    ) {

        $errorRequiredFields = array(
            'status' => 400,
            'message' => 'Campos obrigatórios não foram preenchidos devidamente.'
        );

        return $errorRequiredFields;
    } else {

        $arrayDados = array(
            "nome"              => $dadosContato[0]['nome'],
            "data_nascimento"   => $dadosContato[0]['data_nascimento'],
            "email"             => $dadosContato[0]['email'],
            "profissao"         => $dadosContato[0]['profissao'],
            "telefone"          => $dadosContato[0]['telefone'],
            "celular"           => $dadosContato[0]['celular'],
            "numero_whatsapp"   => $dadosContato[0]['numero_whatsapp'],
            "notificacao_email" => $dadosContato[0]['notificacao_email'],
            "notificacao_sms"   => $dadosContato[0]['notificacao_sms']
        );

        if (insertContato($arrayDados)) {

            $novoContato = selectLastId();

            $sucessCreateItem = array(
                'status'    => 201,
                'message'   => 'Item criado com sucesso.',
                'contato'   => $novoContato
            );

            return $sucessCreateItem;
        } else {

            $errorInternalServer = array(
                'status' => 500,
                'message' => 'Devido a um erro interno no servidor, não foi possível processar a requisição.',
            );

            return $errorInternalServer;
        }
    }
}

//atualiza um contato existente
function atualizarContato($dadosContato)
{

    $id = $dadosContato['id'];

    if (
        empty($dadosContato[0]['nome'])                     || is_numeric($dadosContato[0]['nome'])             || strlen($dadosContato[0]['nome']) > 150           ||
        empty($dadosContato[0]['data_nascimento'])          || is_numeric($dadosContato[0]['data_nascimento'])  || strlen($dadosContato[0]['data_nascimento']) > 10 ||
        empty($dadosContato[0]['email'])                    || is_numeric($dadosContato[0]['email'])            || strlen($dadosContato[0]['email']) > 255          ||
        empty($dadosContato[0]['profissao'])                || is_numeric($dadosContato[0]['profissao'])        || strlen($dadosContato[0]['profissao']) > 100      ||
        empty($dadosContato[0]['telefone'])                 || is_numeric($dadosContato[0]['telefone'])         || strlen($dadosContato[0]['telefone']) > 15        ||
        empty($dadosContato[0]['celular'])                  || is_numeric($dadosContato[0]['celular'])          || strlen($dadosContato[0]['celular']) > 15         ||
        !is_numeric($dadosContato[0]['numero_whatsapp'])    ||
        !is_numeric($dadosContato[0]['notificacao_email'])  ||
        !is_numeric($dadosContato[0]['notificacao_sms'])
    ) {

        $errorRequiredFields = array(
            'status' => 400,
            'message' => 'Campos obrigatórios não foram preenchidos devidamente.'
        );

        return $errorRequiredFields;
    } else if ($id == 0 || empty($id) || !is_numeric($id)) {

        $errorInvalidId = array(
            'status' => 400,
            'message' => 'O ID informado na requisição não é válido ou não foi encaminhado.'
        );

        return $errorInvalidId;
    } else {

        $statusId = selectContatoById($id);

        if ($statusId) {

            $arrayDados = array(
                "id"                => $id,
                "nome"              => $dadosContato[0]['nome'],
                "data_nascimento"   => $dadosContato[0]['data_nascimento'],
                "email"             => $dadosContato[0]['email'],
                "profissao"         => $dadosContato[0]['profissao'],
                "telefone"          => $dadosContato[0]['telefone'],
                "celular"           => $dadosContato[0]['celular'],
                "numero_whatsapp"   => $dadosContato[0]['numero_whatsapp'],
                "notificacao_email" => $dadosContato[0]['notificacao_email'],
                "notificacao_sms"   => $dadosContato[0]['notificacao_sms']
            );

            if (updateContato($arrayDados, $id)) {

                $sucessUpdateItem = array(
                    'status'    => 200,
                    'message'   => 'Item atualizado com sucesso.',
                    'contato'   => $arrayDados
                );

                return $sucessUpdateItem;
            } else {

                $errorInternalServer = array(
                    'status' => 500,
                    'message' => 'Devido a um erro interno no servidor, não foi possível processar a requisição.',
                );

                return $errorInternalServer;
            }
        } else {

            $errorIdNotFound = array(
                'status' => 404,
                'message' => 'O ID informado é válido, mas não existe.',
            );

            return $errorIdNotFound;
        }
    }
}

//deleta um contato existente
function excluirContato($id)
{

    if ($id == 0 || empty($id) || !is_numeric($id)) {

        $errorInvalidId = array(
            'status' => 400,
            'message' => 'O ID informado na requisição não é válido ou não foi encaminhado.'
        );

        return $errorInvalidId;
    } else {

        $statusId = selectContatoById($id);

        if ($statusId) {

            if (deleteContato($id)) {

                $sucessDeleteItem = array(
                    'status'    => 200,
                    'message'   => 'Item apagado com sucesso.'
                );

                return $sucessDeleteItem;
            } else {

                $errorInternalServer = array(
                    'status' => 500,
                    'message' => 'Devido a um erro interno no servidor, não foi possível processar a requisição.',
                );

                return $errorInternalServer;
            }
        } else {

            $errorIdNotFound = array(
                'status' => 404,
                'message' => 'O ID informado é válido, mas não existe.',
            );

            return $errorIdNotFound;
        }
    }
}
