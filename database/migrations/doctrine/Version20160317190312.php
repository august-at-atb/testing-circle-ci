<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160317190312 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `shipment` (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, ship_date VARCHAR(25) DEFAULT NULL, shipment_tracking VARCHAR(255) DEFAULT NULL, carrier_code VARCHAR(255) DEFAULT NULL, service_code VARCHAR(255) DEFAULT NULL, package_code VARCHAR(255) DEFAULT NULL, shipstation_synced INT NOT NULL, sync_try INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_2CB20DC8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, billing_address_id INT NOT NULL, shipping_address_id INT NOT NULL, order_number VARCHAR(98) NOT NULL, order_date VARCHAR(25) NOT NULL, status VARCHAR(98) NOT NULL, email VARCHAR(255) DEFAULT NULL, coupon_code VARCHAR(255) DEFAULT NULL, payment_method VARCHAR(98) NOT NULL, shipping_amount NUMERIC(12, 4) NOT NULL, tax_amount NUMERIC(12, 4) NOT NULL, discount_amount NUMERIC(12, 4) NOT NULL, grand_total NUMERIC(12, 4) NOT NULL, shipping_method VARCHAR(255) NOT NULL, volume INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F529939879D0C0E4 (billing_address_id), UNIQUE INDEX UNIQ_F52993984D4CFF2B (shipping_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `address` (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(98) NOT NULL, lastname VARCHAR(98) NOT NULL, phone VARCHAR(98) NOT NULL, address_1 VARCHAR(255) NOT NULL, address_2 VARCHAR(255) DEFAULT NULL, city VARCHAR(98) NOT NULL, state VARCHAR(98) NOT NULL, country VARCHAR(2) NOT NULL, zipcode VARCHAR(10) NOT NULL, company VARCHAR(98) DEFAULT NULL, type VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, item_id VARCHAR(98) DEFAULT NULL, parent_item_id VARCHAR(98) DEFAULT NULL, sku VARCHAR(98) DEFAULT NULL, name VARCHAR(98) NOT NULL, product_type VARCHAR(98) DEFAULT NULL, quantity INT NOT NULL, price NUMERIC(12, 4) NOT NULL, item_total_amount NUMERIC(12, 4) DEFAULT NULL, item_tax_amount NUMERIC(12, 4) DEFAULT NULL, item_discount_amount NUMERIC(12, 4) DEFAULT NULL, product_image_url VARCHAR(255) DEFAULT NULL, product_options VARCHAR(255) DEFAULT NULL, INDEX IDX_52EA1F098D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magento_order_data_log (id INT AUTO_INCREMENT NOT NULL, raw_json LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', oms_created_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `shipment` ADD CONSTRAINT FK_2CB20DC8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939879D0C0E4 FOREIGN KEY (billing_address_id) REFERENCES `address` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984D4CFF2B FOREIGN KEY (shipping_address_id) REFERENCES `address` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DC8D9F6D38');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098D9F6D38');
        $this->addSql('ALTER TABLE order DROP FOREIGN KEY FK_F529939879D0C0E4');
        $this->addSql('ALTER TABLE order DROP FOREIGN KEY FK_F52993984D4CFF2B');
        $this->addSql('DROP TABLE `shipment`');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE `address`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE magento_order_data_log');
    }
}
