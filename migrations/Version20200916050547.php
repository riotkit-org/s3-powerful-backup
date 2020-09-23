<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200916050547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates backup_object table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('backup_object');

        $table->addColumn('id', 'string', ['length' => 36]);
        $table->addColumn('title', 'string', ['length' => '128']);
        $table->addColumn('description', 'string', ['length' => '4096']);
        $table->addColumn('allowed_file_types', 'json_array');
        $table->addColumn('max_versions', 'integer', ['length' => 3]);
        $table->addColumn('max_one_version_size', 'integer', ['length' => 16]);
        $table->addColumn('max_all_versions_size', 'integer', ['length' => 16]);
        $table->addColumn('created', 'datetime');
        $table->addColumn('is_active', 'boolean');

        // relations
        $table->addColumn('location_id', 'string', ['length' => 36, 'notnull' => false]);
        $table->addColumn('author_id', 'string', ['length' => 36]);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('backup_object');
    }
}
