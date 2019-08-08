<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class ClientsController extends Controller
{
    public function index($request, $response, $args)
    {
        $page = ($request->getParam('page') !== null) ? $request->getParam('page') : 1;
        if ($page < 1) { $page = 1; }

        $per_page = ($request->getParam('per_page') !== null) ? $request->getParam('per_page') : 10;
        $order = ($request->getParam('order') !== null) ? $request->getParam('order') : 'id';
        $direction = ($request->getParam('direction') !== null) ? $request->getParam('direction') : 'desc';
        $search = ($request->getParam('search') !== null) ? $request->getParam('search') : null;
        $type = ($request->getParam('type') !== null) ? $request->getParam('type') : null;

        $query  = 'SELECT id, name, email, cpf, created_at';
        $query .= ' FROM clients ';
        $query .= ($search && $type) ? "WHERE " . $type . " ilike '%". $search . "%'" : "";
        $query .= ' ORDER BY ' . $order . ' ' . $direction;

        try {

            $total = $this->pdo->query($query)->rowCount();

            $query .= ' LIMIT ' . $per_page;
            $query .= ' OFFSET ' . ($page-1) * $per_page;
            
            $clients = $this->pdo->query($query)->fetchAll();

            return $response->withJson([
                'current_page' => $page,
                'per_page' => $per_page,
                'total' => $total,
                'data' => $clients
            ]);

        } catch (Exception $e) {
            return $response->withJson([
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    public function store($request, $response)
    {
        $params = $this->filterParams($request->getParams());
        
        $validation = $this->validateParams($params);
        if ($validation->failed()) {
            return $this->response->withJson($validation->getErrors(), 400);
        }

        try {

            $query = $this->pdo->prepare("INSERT INTO clients ( 
                name, birthdate, cpf, email, zipcode, address, number, 
                complement, district, city, state, phone, obs, created_at, updated_at
            ) VALUES (
                :name, :birthdate, :cpf, :email, :zipcode, :address, :number, 
                :complement, :district, :city, :state, :phone, :obs, NOW(), NOW()
            )");

            $birthdate  = substr($params['birthdate'], 6, 4);
            $birthdate .= '-'.substr($params['birthdate'], 3, 2); 
            $birthdate .= '-'.substr($params['birthdate'], 0, 2);           

            $params['birthdate'] = $birthdate;
        
            $query->execute([
                'name' => $params['name'],
                'birthdate' => $params['birthdate'],
                'cpf' => $params['cpf'],
                'email' => $params['email'],
                'zipcode' => $params['zipcode'],
                'address' => $params['address'],
                'number' => $params['number'],
                'complement' => $params['complement'],
                'district' => $params['district'],
                'city' => $params['city'],
                'state' => $params['state'],
                'phone' => $params['phone'],
                'obs' => $params['obs'],
            ]);

            $params['id'] = $this->pdo->lastInsertId();    
            return $response->withJson($params);

        } catch (Exception $e) {
            return $response->withJson([
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    public function show($request, $response, $args)
    {
        try {
            if ($this->checkClientExist($args['id'])) {
                return $response->withJson([
                    'error' => 'Cliente não encontrado!'
                ], 400);
            }

            $query = $this->pdo->prepare("SELECT * FROM clients WHERE id = :id");
            $query->execute([
                'id' => $args['id']
            ]);
            $client = $query->fetch();
            return $response->withJson($client);
        } catch (Exception $e) {
            return $response->withJson([
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    public function update($request, $response, $args)
    {
        try {

            if ($this->checkClientExist($args['id'])) {
                return $response->withJson([
                    'error' => 'Cliente não encontrado!'
                ], 400);
            }

            $params = $this->filterParams($request->getParams());

            $validation = $this->validateParams($params, $args['id']);
            if ($validation->failed()) {
                return $this->response->withJson($validation->getErrors(), 400);
            }

            $query = $this->pdo->prepare("UPDATE clients SET  
                name = :name, birthdate = :birthdate, cpf = :cpf, email = :email, 
                zipcode = :zipcode, address = :address, number = :number, 
                complement = :complement, district = :district, city = :city, 
                state = :state, phone = :phone, obs = :obs, updated_at = NOW()
                WHERE id = :id
            ");
            
            $birthdate  = substr($params['birthdate'], 6, 4);
            $birthdate .= '-'.substr($params['birthdate'], 3, 2); 
            $birthdate .= '-'.substr($params['birthdate'], 0, 2);           
            
            $params['birthdate'] = $birthdate;

            $query->execute([
                'name' => $params['name'],
                'birthdate' => $params['birthdate'],
                'cpf' => $params['cpf'],
                'email' => $params['email'],
                'zipcode' => $params['zipcode'],
                'address' => $params['address'],
                'number' => $params['number'],
                'complement' => $params['complement'],
                'district' => $params['district'],
                'city' => $params['city'],
                'state' => $params['state'],
                'phone' => $params['phone'],
                'obs' => $params['obs'],
                'id' => $args['id']
            ]);
    
            return $response->withJson($params);
        } catch (Exception $e) {
            return $response->withJson([
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    public function destroy($request, $response, $args)
    {
        try {
            if ($this->checkClientExist($args['id'])) {
                return $response->withJson([
                    'error' => 'Cliente não encontrado!'
                ], 400);
            }

            $query = $this->pdo->prepare("DELETE FROM clients WHERE id = :id");
            $query->execute([
                'id' => $args['id']
            ]);
            return $response->withJson([
                'result' => 'ok'
            ]);
        } catch (Exception $e) {
            return $response->withJson([
                'error' => $e->getMessage() 
            ], 500);
        }
    }

    private function checkClientExist($id)
    {   
        $query = $this->pdo->prepare("SELECT * FROM clients WHERE id = :id");
        $query->execute([
            'id' => $id
        ]);
        return $query->rowCount() === 0;       
    }

    private function validateParams($params, $id = null)
    {
        v::with('App\\Validation\\Rules');
        return $this->validator->validate($params, [
            'name' => v::notEmpty()->max(100)->setName('Nome'),
            'cpf' => v::notEmpty()->cpf()->fieldAvailable($this->pdo, 'clients', 'cpf', $id)->setName('CPF'),
            'email' => v::notEmpty()->email()->fieldAvailable($this->pdo, 'clients', 'email', $id)->setName('E-mail'),
            'birthdate' => v::notEmpty()->date('d/m/Y')->setName('Data de Nascimento'),
            'zipcode' => v::notEmpty()->setName('CEP'),
            'address' => v::notEmpty()->setName('Endereço'),
            'number' => v::notEmpty()->intVal()->setName('Número'),
            'district' => v::notEmpty()->setName('Bairro'),
            'city' => v::notEmpty()->setName('Cidade'),
            'state' => v::notEmpty()->setName('Estado'),
            'phone' => v::notEmpty()->length(10,11)->setName('Telefone')
        ]);
    }

    private function filterParams($params)
    {
        if (isset($params['number'])) {
            $params['number'] = preg_replace('/\D/', '', $params['number']);
        }
        if (isset($params['zipcode'])) {
            $params['zipcode'] = preg_replace('/\D/', '', $params['zipcode']);
        }
        if (isset($params['cpf'])) {
            $params['cpf'] = preg_replace('/\D/', '', $params['cpf']);
        }
        if (isset($params['phone'])) {
            $params['phone'] = preg_replace('/\D/', '', $params['phone']);
        }     
        return $params;
    }
}