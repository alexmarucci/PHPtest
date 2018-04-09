<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180408222658 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE store ADD latitude VARCHAR(30) DEFAULT NULL, ADD longitude VARCHAR(30) DEFAULT NULL');

        $this->addSql('UPDATE store SET latitude = "51.5151483", longitude = "-0.1355497" WHERE postcode="W1F 8ZA" ');
        $this->addSql('UPDATE store SET latitude = "51.5149251", longitude = "-0.1390467" WHERE postcode="W1F 7LW" ');
        $this->addSql('UPDATE store SET latitude = "51.5071662", longitude = "-0.1414235" WHERE postcode="W1J 9BR" ');
        $this->addSql('UPDATE store SET latitude = "51.4609594", longitude = "-0.303119" WHERE postcode="TW9 1AB" ');
        $this->addSql('UPDATE store SET latitude = "51.4598771", longitude = "-0.3060094" WHERE postcode="TW9 1JY" ');
        $this->addSql('UPDATE store SET latitude = "51.4586477", longitude = "-0.3055655" WHERE postcode="TW9 1TW" ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE store DROP latitude, DROP longitude');
    }
}
