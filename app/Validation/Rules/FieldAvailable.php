<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class FieldAvailable extends AbstractRule
{
    protected $pdo;
    protected $table;
    protected $field;
    protected $id;   
    protected $id_field; 

    public function __construct($pdo, $table, $field, $id = null, $id_field = 'id')
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->field = $field;
        $this->id = $id;
        $this->id_field = $id_field;
    }

    public function validate($input)
    {
        if (!$input) {
            return true;
        }
        $query  = "SELECT * FROM $this->table";
        $query .= " WHERE $this->field = '$input'";
        if ($this->id) {
            $query .= " AND $this->id_field != $this->id";        
        }
        $result = $this->pdo->query($query);
        return $result->rowCount() === 0;   
    }
}