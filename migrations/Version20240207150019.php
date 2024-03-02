<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240207150019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE categorie_produit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_devis_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_facture_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE agence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE agence_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE devis_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE facture_payment_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_trait_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE agence (id INT NOT NULL, status_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville INT NOT NULL, tel VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, create_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, delete_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, conseils VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19AA96BF700BD ON agence (status_id)');
        $this->addSql('CREATE TABLE agence_status (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE devis_status (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE facture_payment_status (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ligne_status (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ligne_trait (id INT NOT NULL, status_id INT NOT NULL, devis_id INT NOT NULL, ordre INT NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, additional VARCHAR(255) NOT NULL, taxe DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2A8F7E96BF700BD ON ligne_trait (status_id)');
        $this->addSql('CREATE INDEX IDX_A2A8F7E941DEFADA ON ligne_trait (devis_id)');
        $this->addSql('CREATE TABLE ligne_trait_produit (ligne_trait_id INT NOT NULL, produit_id INT NOT NULL, PRIMARY KEY(ligne_trait_id, produit_id))');
        $this->addSql('CREATE INDEX IDX_9F0368324382721D ON ligne_trait_produit (ligne_trait_id)');
        $this->addSql('CREATE INDEX IDX_9F036832F347EFB ON ligne_trait_produit (produit_id)');
        $this->addSql('CREATE TABLE produit_type (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, genre_id INT NOT NULL, status_id INT NOT NULL, role_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, city INT NOT NULL, create_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, delete_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3F85E0677 ON utilisateur (username)');
        $this->addSql('CREATE INDEX IDX_1D1C63B34296D31F ON utilisateur (genre_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B36BF700BD ON utilisateur (status_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3D60322AC ON utilisateur (role_id)');
        $this->addSql('CREATE TABLE utilisateur_agence (utilisateur_id INT NOT NULL, agence_id INT NOT NULL, PRIMARY KEY(utilisateur_id, agence_id))');
        $this->addSql('CREATE INDEX IDX_56CA022FB88E14F ON utilisateur_agence (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_56CA022D725330D ON utilisateur_agence (agence_id)');
        $this->addSql('CREATE TABLE utilisateur_genre (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur_role (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur_status (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA96BF700BD FOREIGN KEY (status_id) REFERENCES agence_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_trait ADD CONSTRAINT FK_A2A8F7E96BF700BD FOREIGN KEY (status_id) REFERENCES ligne_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_trait ADD CONSTRAINT FK_A2A8F7E941DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_trait_produit ADD CONSTRAINT FK_9F0368324382721D FOREIGN KEY (ligne_trait_id) REFERENCES ligne_trait (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_trait_produit ADD CONSTRAINT FK_9F036832F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34296D31F FOREIGN KEY (genre_id) REFERENCES utilisateur_genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B36BF700BD FOREIGN KEY (status_id) REFERENCES utilisateur_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3D60322AC FOREIGN KEY (role_id) REFERENCES utilisateur_role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_agence ADD CONSTRAINT FK_56CA022FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_agence ADD CONSTRAINT FK_56CA022D725330D FOREIGN KEY (agence_id) REFERENCES agence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE ligne_devis');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE categorie_produit');
        $this->addSql('DROP TABLE ligne_facture');
        $this->addSql('ALTER TABLE client ADD prenom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client ADD ville INT NOT NULL');
        $this->addSql('ALTER TABLE devis ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE devis ADD facture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE devis ADD end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE devis DROP date_creation');
        $this->addSql('ALTER TABLE devis RENAME COLUMN numero TO termes');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B6BF700BD FOREIGN KEY (status_id) REFERENCES devis_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8B27C52B6BF700BD ON devis (status_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B27C52B7F2DEE08 ON devis (facture_id)');
        $this->addSql('ALTER TABLE facture ADD payment_status_id INT NOT NULL');
        $this->addSql('ALTER TABLE facture ADD termes VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE facture ADD start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE facture ADD end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE facture ADD payment_address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE facture ADD payment_city INT NOT NULL');
        $this->addSql('ALTER TABLE facture DROP montant_total');
        $this->addSql('ALTER TABLE facture DROP numero');
        $this->addSql('ALTER TABLE facture DROP statut_paiement');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641028DE2F95 FOREIGN KEY (payment_status_id) REFERENCES facture_payment_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FE86641028DE2F95 ON facture (payment_status_id)');
        $this->addSql('ALTER TABLE produit ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP description');
        $this->addSql('ALTER TABLE produit DROP prix_unitaire');
        $this->addSql('ALTER TABLE produit RENAME COLUMN nom TO libelle');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27C54C8C93 FOREIGN KEY (type_id) REFERENCES produit_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_29A5EC27C54C8C93 ON produit (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52B6BF700BD');
        $this->addSql('ALTER TABLE facture DROP CONSTRAINT FK_FE86641028DE2F95');
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC27C54C8C93');
        $this->addSql('DROP SEQUENCE agence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE agence_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE devis_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE facture_payment_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_trait_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_genre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_status_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE categorie_produit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_devis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_facture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ligne_devis (id INT NOT NULL, quantitee INT NOT NULL, montant_ligne NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_4fbf094fe7927c74 ON company (email)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE categorie_produit (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ligne_facture (id INT NOT NULL, quantitee INT NOT NULL, montant_ligne NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE agence DROP CONSTRAINT FK_64C19AA96BF700BD');
        $this->addSql('ALTER TABLE ligne_trait DROP CONSTRAINT FK_A2A8F7E96BF700BD');
        $this->addSql('ALTER TABLE ligne_trait DROP CONSTRAINT FK_A2A8F7E941DEFADA');
        $this->addSql('ALTER TABLE ligne_trait_produit DROP CONSTRAINT FK_9F0368324382721D');
        $this->addSql('ALTER TABLE ligne_trait_produit DROP CONSTRAINT FK_9F036832F347EFB');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B34296D31F');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B36BF700BD');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3D60322AC');
        $this->addSql('ALTER TABLE utilisateur_agence DROP CONSTRAINT FK_56CA022FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_agence DROP CONSTRAINT FK_56CA022D725330D');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE agence_status');
        $this->addSql('DROP TABLE devis_status');
        $this->addSql('DROP TABLE facture_payment_status');
        $this->addSql('DROP TABLE ligne_status');
        $this->addSql('DROP TABLE ligne_trait');
        $this->addSql('DROP TABLE ligne_trait_produit');
        $this->addSql('DROP TABLE produit_type');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_agence');
        $this->addSql('DROP TABLE utilisateur_genre');
        $this->addSql('DROP TABLE utilisateur_role');
        $this->addSql('DROP TABLE utilisateur_status');
        $this->addSql('ALTER TABLE devis DROP CONSTRAINT FK_8B27C52B7F2DEE08');
        $this->addSql('DROP INDEX IDX_8B27C52B6BF700BD');
        $this->addSql('DROP INDEX UNIQ_8B27C52B7F2DEE08');
        $this->addSql('ALTER TABLE devis ADD date_creation DATE NOT NULL');
        $this->addSql('ALTER TABLE devis DROP status_id');
        $this->addSql('ALTER TABLE devis DROP facture_id');
        $this->addSql('ALTER TABLE devis DROP start_date');
        $this->addSql('ALTER TABLE devis DROP end_date');
        $this->addSql('ALTER TABLE devis RENAME COLUMN termes TO numero');
        $this->addSql('DROP INDEX IDX_FE86641028DE2F95');
        $this->addSql('ALTER TABLE facture ADD montant_total NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE facture ADD numero VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE facture ADD statut_paiement VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE facture DROP payment_status_id');
        $this->addSql('ALTER TABLE facture DROP termes');
        $this->addSql('ALTER TABLE facture DROP start_date');
        $this->addSql('ALTER TABLE facture DROP end_date');
        $this->addSql('ALTER TABLE facture DROP payment_address');
        $this->addSql('ALTER TABLE facture DROP payment_city');
        $this->addSql('DROP INDEX IDX_29A5EC27C54C8C93');
        $this->addSql('ALTER TABLE produit ADD description TEXT NOT NULL');
        $this->addSql('ALTER TABLE produit ADD prix_unitaire NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE produit DROP type_id');
        $this->addSql('ALTER TABLE produit RENAME COLUMN libelle TO nom');
        $this->addSql('ALTER TABLE client DROP prenom');
        $this->addSql('ALTER TABLE client DROP ville');
    }
}
