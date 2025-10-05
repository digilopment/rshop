<?php
declare(strict_types=1);

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Migrations\AbstractMigration;

class InsertDefaultUser extends AbstractMigration
{
    public function up(): void
    {
        $hasher = new DefaultPasswordHasher();
        $password = $hasher->hash('rshop'); // heslo rshop

        $this->table('users')
            ->insert([
                'login' => 'rshop',
                'password' => $password,
                'created' => \date('Y-m-d H:i:s'),
                'modified' => \date('Y-m-d H:i:s')
            ])
            ->saveData();
    }

    public function down(): void
    {
        $this->execute("DELETE FROM users WHERE login = 'rshop'");
    }
}
