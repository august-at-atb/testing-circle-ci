<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160404184338 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sns_broadcast_log (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, connection_name VARCHAR(255) NOT NULL, topics VARCHAR(255) NOT NULL, event VARCHAR(55) NOT NULL, payload LONGTEXT NOT NULL, attempts_number INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sqs_worker_log (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, sqs_message_id VARCHAR(255) NOT NULL, connection_name VARCHAR(255) NOT NULL, worker VARCHAR(255) NOT NULL, payload LONGTEXT NOT NULL, attempts_number INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX sqs_msg_idx (sqs_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sns_broadcast_log');
        $this->addSql('DROP TABLE sqs_worker_log');
    }
}
