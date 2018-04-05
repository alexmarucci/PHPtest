<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180405202824 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // Add Store data
        $this->addSql("INSERT INTO store (`id`,`name`,`address`,`postcode`) VALUES ('1', 'Jiselle & friends', 'Wardour St, Soho, London', 'W1F 8ZA') ");
        $this->addSql("INSERT INTO store (`id`,`name`,`address`,`postcode`) VALUES ('2', 'Saj & friends', 'Ramillies St, Soho, London', 'W1F 7LW') ");
        $this->addSql("INSERT INTO store (`id`,`name`,`address`,`postcode`) VALUES ('3', 'Sam & friends', 'Piccadilly, St. James\'s', 'W1J 9BR') ");
        $this->addSql("INSERT INTO store (`id`,`name`,`address`,`postcode`) VALUES ('4', 'Ben & friends', 'George St, Richmond', 'TW9 1AB') ");
        $this->addSql("INSERT INTO store (`id`,`name`,`address`,`postcode`) VALUES ('5', 'Chris & friends', 'George St, Richmond', 'TW9 1JY') ");
        $this->addSql("INSERT INTO store (`id`,`name`,`address`,`postcode`) VALUES ('6', 'Unai & friends', 'Hill St, Richmond', 'TW9 1TW') ");


    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
