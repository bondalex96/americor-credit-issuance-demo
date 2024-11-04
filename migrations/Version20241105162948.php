<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241105162948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id VARCHAR(255) NOT NULL, name_first_name VARCHAR(255) NOT NULL, name_last_name VARCHAR(255) NOT NULL, age_value INT NOT NULL, address_city VARCHAR(255) NOT NULL, address_state VARCHAR(2) NOT NULL, address_zip_code VARCHAR(255) NOT NULL, fico_score_score INT NOT NULL, email_value VARCHAR(255) NOT NULL, phone_number_value VARCHAR(255) NOT NULL, monthly_income_amount INT NOT NULL, monthly_income_currency VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credits (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', client_id VARCHAR(255) NOT NULL, product_name VARCHAR(255) NOT NULL, term INT NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE credits');
    }
}
