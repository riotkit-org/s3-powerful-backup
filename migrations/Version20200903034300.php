<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200903034300 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'User entity';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('users');
        $table->addColumn('id', 'string',           ['length' => 36]);
        $table->addColumn('email', 'string',        ['length' => 64]);
        $table->addColumn('password', 'string',     ['length' => 64]); // sha256
        $table->addColumn('salt', 'string',         ['length' => 96]);
        $table->addColumn('organization', 'string', ['length' => 64]);
        $table->addColumn('about', 'string',        ['length' => 256]);
        $table->addColumn('roles', 'json');

        $table->addUniqueIndex(['email'], 'user_primary_id');
        $table->addIndex(['id'], 'user_internal_id');
        $table->addIndex(['email', 'password'], 'user_login_index');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('users');
    }
}
