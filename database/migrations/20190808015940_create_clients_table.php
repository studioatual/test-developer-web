<?php

use Phinx\Migration\AbstractMigration;

class CreateClientsTable extends AbstractMigration
{
    public function up()
    {
        $clients = $this->table('clients');

        $clients->addColumn('name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('birthdate', 'date', ['null' => false])
            ->addColumn('cpf', 'string', ['limit' => 11, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('zipcode', 'string', ['limit' => 8, 'null' => false])
            ->addColumn('address', 'string', ['null' => false])
            ->addColumn('number', 'integer', ['null' => false])
            ->addColumn('complement', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('district', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('city', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('state', 'string', ['limit' => 2, 'null' => false])
            ->addColumn('phone', 'string', ['limit' => 11, 'null' => false])
            ->addColumn('obs', 'text', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => false])
            ->addColumn('updated_at', 'datetime', ['null' => false])
            ->addIndex(['email', 'cpf'], ['unique' => true])
            ->create();
    }

    public function down()
    {
        $this->table('clients')->drop()->save();
    }
}