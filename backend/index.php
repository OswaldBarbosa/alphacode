<?php

/***************************************************************************************
 * Objetivo: API para integração entre backend e banco de dados (GET, POST, PUT, DELETE)
 * Data: 15/12/2023
 * Autor: Oswaldo Barbosa
 * Versão: 1.0
 ***************************************************************************************/

header("Access-Control-Allow-Origin: *");

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json');

require_once('./vendor/autoload.php');
require_once('./src/controller/controller_contatos.php');
include('./src/controller/modulo/config.php');

$config = ['settings' => ['displayErrorDetails' => true]];

$app = new \Slim\App($config);

//endpoint: retorna todos os dados de contatos
$app->get('/contatos', function ($request, $response, $args) {

    if ($dadosContatos = getContatos()) {

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($dadosContatos);
    } else {
        return $response->withStatus(404);
    }
});

//endpoint: retorna um contato filtrando pelo id
$app->get('/contatos/{id}', function ($request, $response, $args) {

    $id = $args['id'];

    if ($dadosContatos = getContatoById($id)) {

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($dadosContatos);
    } else {
        return $response->withStatus(404);
    }
});

//endpoint: insere um novo contato
$app->post('/contatos', function ($request, $response, $args) {

    $contentTypeHeader = $request->getHeaderLine('Content-Type');

    $contentType =  explode(";", $contentTypeHeader);

    switch ($contentType[0]) {

        case 'application/json':

            $dadosBody = $request->getParsedBody();

            $arrayDados = array($dadosBody);

            $resposta = inserirContato($arrayDados);

            $dadosJSON = createJSON($resposta);

            if ($resposta == true) {

                return $response->withStatus(201)
                    ->withHeader('Content-Type', 'application/json')
                    ->write($dadosJSON);
            } elseif (is_array($resposta)) {

                return $response->withStatus(400)
                    ->withHeader('Content-Type', 'application/json')
                    ->write($dadosJSON);
            }

            break;

        case 'multipart/form-data':

        default:

            return $response->withStatus(415)
                ->withHeader('Content-Type', 'application/json')
                ->write('{"status": 415, "message": "O tipo de mídia Content-type da solicitação não é compatível com o servidor. Tipo aceito:[application/json]"}');

            break;
    }
});

//endpoint: atualiza um contato existente filtrando pelo id
$app->put('/contatos/{id}', function ($request, $response, $args) {

    if (is_numeric($args['id'])) {

        $id = $args['id'];

        $contentTypeHeader = $request->getHeaderLine('Content-Type');

        $contentType =  explode(";", $contentTypeHeader);

        switch ($contentType[0]) {

            case 'application/json':

                $dadosBody = $request->getParsedBody();

                $arrayDados = array(
                    $dadosBody,
                    "id"    => $id,
                );

                $resposta = atualizarContato($arrayDados);

                $dadosJSON = createJSON($resposta);

                if ($resposta == true) {

                    return $response->withStatus(200)
                        ->withHeader('Content-Type', 'application/json')
                        ->write($dadosJSON);
                } elseif (is_array($resposta)) {

                    return $response->withStatus(400)
                        ->withHeader('Content-Type', 'application/json')
                        ->write($dadosJSON);
                }

                break;

            case 'multipart/form-data':

            default:

                return $response->withStatus(415)
                    ->withHeader('Content-Type', 'application/json')
                    ->write('{"status": 415, "message": "O tipo de mídia Content-type da solicitação não é compatível com o servidor. Tipo aceito:[application/json]"}');
                break;
        }
    } else {

        return $response->withStatus(400)
            ->withHeader('Content-Type', 'application/json')
            ->write('{"status": 400, "message": "O formato do ID não é valido. Formato válido: (número)"}');
    }
});

//endpoint: deleta um contato existente filtrando pelo id
$app->delete('/contatos/{id}', function ($request, $response, $args) {

    if (is_numeric($args['id'])) {

        $id = $args['id'];

        $resposta = excluirContato($id);

        if ($resposta == true) {

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($resposta));
        } else {

            return $response->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($resposta));
        }
    } else {

        return $response->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write('{"status": 400, "message": "O formato do ID não é valido. Formato válido: (número)"}');
    }
});

$app->run()

?>