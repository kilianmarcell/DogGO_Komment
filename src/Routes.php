<?php

use \Doggo\Komment\Komment;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function(Slim\App $app) {
    $app->get('/komment', function(Request $request, Response $response) {
        $komment = Komment::all();
        $kimenet = $komment->toJson();

        $response->getBody()->write($kimenet);
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/komment', function(Request $request, Response $response) {
        $input = json_decode($request->getBody(), true);
        $komment = Komment::create($input);

        $kimenet = $komment->toJson();
        
        $response->getBody()->write($kimenet);
        return $response
            ->withStatus(201) // "Created" status code
            ->withHeader('Content-Type', 'application/json');
    });

    $app->delete('/komment/{id}',
        function (Request $request, Response $response, array $args) {
            if (!is_numeric($args['id']) || $args['id'] <= 0) {
                $ki = json_encode(['error' => 'Az ID pozitív egész szám kell legyen!']);
                $response->getBody()->write($ki);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }
            $komment = Komment::find($args['id']);
            if ($komment === null) {
                $ki = json_encode(['error' => 'Nincs ilyen ID-jű Komment']);
                $response->getBody()->write($ki);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
            }
            $komment->delete();
            return $response
                ->withStatus(204);
        });

        $app->put('/komment/{id}', function (Request $request, Response $response, array $args) {
            if (!is_numeric($args['id']) || $args['id'] <= 0) {
                $ki = json_encode(['error' => 'Az ID pozitív egész szám kell legyen!']);
                $response->getBody()->write($ki);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }
            $komment = Komment::find($args['id']);
            if ($komment === null) {
                $ki = json_encode(['error' => 'Nincs ilyen ID-jű Komment']);
                $response->getBody()->write($ki);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
            }
            $input = json_decode($request->getBody(), true);
            $komment->fill($input);
            $komment->save();
            $response->getBody()->write($komment->toJson());
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        });

        $app->get('/komment/{id}', function (Request $request, Response $response, array $args) {
            if (!is_numeric($args['id']) || $args['id'] <= 0) {
                $ki = json_encode(['error' => 'Az ID pozitív egész szám kell legyen!']);
                $response->getBody()->write($ki);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(400);
            }
            $komment = Komment::find($args['id']);
            if ($komment === null) {
                $ki = json_encode(['error' => 'Nincs ilyen ID-jű rajzfilm']);
                $response->getBody()->write($ki);
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
            }
            $response->getBody()->write($komment->toJson());
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        });
};