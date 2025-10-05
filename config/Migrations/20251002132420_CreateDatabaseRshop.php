<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateDatabaseRshop extends AbstractMigration
{
    public function up(): void
    {
        $this->execute('CREATE DATABASE IF NOT EXISTS rshop CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;');
    }

    public function down(): void
    {
        $this->execute('DROP DATABASE IF EXISTS rshop;');
    }
}
