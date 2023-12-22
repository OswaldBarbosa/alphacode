<?php

/***************************************************************************************
 * Objetivo: Arquivo responsavel pela manipulação dos contatos no banco de dados
 * Data: 15/12/2023
 * Autor: Oswaldo Barbosa  
 * Versão: 1.0
 ***************************************************************************************/

require_once('./src/model/conexao.php');

//função para listar todos os contatos
function selectAllContatos()
{

    $conexao = conexaoMysql();

    $sql = "select * from tbl_contatos order by id desc";

    $result = mysqli_query($conexao, $sql);

    if ($result) {

        $cont = 0;

        while ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados[$cont] = array(
                "id"                =>  $rsDados['id'],
                "nome"              =>  $rsDados['nome'],
                "data_nascimento"   =>  $rsDados['data_nascimento'],
                "email"             =>  $rsDados['email'],
                "profissao"         =>  $rsDados['profissao'],
                "telefone"          =>  $rsDados['telefone'],
                "celular"           =>  $rsDados['celular'],
                "numero_whatsapp"   =>  $rsDados['numero_whatsapp'],
                "notificacao_email" =>  $rsDados['notificacao_email'],
                "notificacao_sms"   =>  $rsDados['notificacao_sms'],
            );
            $cont++;
        }

        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}

//função para buscar um contato pelo id
function selectContatoById($id)
{

    $conexao = conexaoMysql();

    $sql = "select * from tbl_contatos where id =" . $id;

    $result = mysqli_query($conexao, $sql);

    if ($result) {

        while ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"                =>  $rsDados['id'],
                "nome"              =>  $rsDados['nome'],
                "data_nascimento"   =>  $rsDados['data_nascimento'],
                "email"             =>  $rsDados['email'],
                "profissao"         =>  $rsDados['profissao'],
                "telefone"          =>  $rsDados['telefone'],
                "celular"           =>  $rsDados['celular'],
                "numero_whatsapp"   =>  $rsDados['numero_whatsapp'],
                "notificacao_email" =>  $rsDados['notificacao_email'],
                "notificacao_sms"   =>  $rsDados['notificacao_sms'],
            );
        }

        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}

//função para inserir um novo contato
function insertContato($dadosContato)
{

    $statusResposta = (bool) false;

    $conexao = conexaoMysql();

    $sql = "insert into tbl_contatos (
            nome, 
            data_nascimento, 
            email, 
            profissao, 
            telefone,
            celular,
            numero_whatsapp,
            notificacao_email,
            notificacao_sms
            ) values (
            '" . $dadosContato['nome'] . "', 
            '" . $dadosContato['data_nascimento'] . "', 
            '" . $dadosContato['email'] . "', 
            '" . $dadosContato['profissao'] . "', 
            '" . $dadosContato['telefone'] . "',
            '" . $dadosContato['celular'] . "',
            '" . $dadosContato['numero_whatsapp'] . "',
            '" . $dadosContato['notificacao_email'] . "',
            '" . $dadosContato['notificacao_sms'] . "'
    );";

    if (mysqli_query($conexao, $sql)) {

        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    return $statusResposta;
}

//função para atualizar um contato existente
function updateContato($dadosContato)
{

    $statusResposta = (bool) false;

    $conexao = conexaoMysql();

    $sql = "update tbl_contatos set 
            nome                = '" . $dadosContato['nome'] . "', 
            data_nascimento     = '" . $dadosContato['data_nascimento'] . "', 
            email               = '" . $dadosContato['email'] . "', 
            profissao           = '" . $dadosContato['profissao'] . "', 
            telefone            = '" . $dadosContato['telefone'] . "',
            celular             = '" . $dadosContato['celular'] . "',
            numero_whatsapp     = '" . $dadosContato['numero_whatsapp'] . "',
            notificacao_email   = '" . $dadosContato['notificacao_email'] . "',
            notificacao_sms     = '" . $dadosContato['notificacao_sms'] . "'
            WHERE id = " . $dadosContato['id'];


    if (mysqli_query($conexao, $sql))
        $statusResposta = true;

        return $statusResposta;
}

//função para deletar um contato existente
function deleteContato($id)
{

    $statusResposta = (bool) false;

    $conexao = conexaoMysql();

    $sql = "delete from tbl_contatos where id = " . $id;

    if (mysqli_query($conexao, $sql)) {
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    return $statusResposta;
}

//função que retorna o último id inserido
function selectLastId()
{

    $conexao = conexaoMysql();

    $sql = "select * from tbl_contatos order by id desc limit 1";

    $result = mysqli_query($conexao, $sql);

    if ($result) {

        while ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"                =>  $rsDados['id'],
                "nome"              =>  $rsDados['nome'],
                "data_nascimento"   =>  $rsDados['data_nascimento'],
                "email"             =>  $rsDados['email'],
                "profissao"         =>  $rsDados['profissao'],
                "telefone"          =>  $rsDados['telefone'],
                "celular"           =>  $rsDados['celular'],
                "numero_whatsapp"   =>  $rsDados['numero_whatsapp'],
                "notificacao_email" =>  $rsDados['notificacao_email'],
                "notificacao_sms"   =>  $rsDados['notificacao_sms'],
            );
        }

        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}
