<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    protected $errors;

    public function validate($params, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $value = (isset($params[$field])) ? $params[$field] : "";
                $rule->assert($value);
            } catch (NestedValidationException $e) {
                $e->findMessages([
                    'alpha' => '{{name}} deve ter apenas letras (a-z)',
                    'email' => 'E-mail inválido!',
                    'notEmpty' => 'Preencha o campo {{name}}!',
                    'noWhitespace' => '{{name}} não é permitido espaços!',
                    'date' => '{{name}} inválida!',
                    'equals' => '{{name}} não confere!',
                    'intVal' => '{{name}} deve ter apenas numeros',
                    'cpf' => 'CPF Inválido!',
                    'postalCode' => '{{name}} inválido!',
                    'length' => '{{name}} deve conter entre {{minValue}} - {{maxValue}} caracteres!'
                ]);
                $this->errors[$field] = $e->getMessages();
            } 
        }
        $_SESSION['errors'] = $this->errors;
        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
