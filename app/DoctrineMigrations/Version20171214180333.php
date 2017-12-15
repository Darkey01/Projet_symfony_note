<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171214180333 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, redacteur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, note VARCHAR(255) DEFAULT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_B8755515764D0490 (redacteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE charge (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, dateEcheance DATE NOT NULL, statut ENUM(\'Paye\', \'A payer\'), pieceJointe LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, dateSignature DATE NOT NULL, dateFin DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, projet_id_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8A8E26E9D4E271E1 (projet_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, id_conversation_id INT DEFAULT NULL, text VARCHAR(510) NOT NULL, dateMessage DATE NOT NULL, INDEX IDX_B6BD307F79F37AE5 (id_user_id), INDEX IDX_B6BD307FE0F2C01E (id_conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_jointe (id INT AUTO_INCREMENT NOT NULL, versement_id INT DEFAULT NULL, id_projet_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, fichier LONGBLOB NOT NULL, INDEX IDX_AB5111D4DBBF8D62 (versement_id), INDEX IDX_AB5111D480F43E55 (id_projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(500) NOT NULL, statut ENUM(\'En discussion\', \'En attente d execution\', \'Execute\'), dateOuverture DATE NOT NULL, dateCloture DATE DEFAULT NULL, projetId INT NOT NULL, UNIQUE INDEX UNIQ_50159CA9ACC1CB28 (projetId), INDEX IDX_50159CA976C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE propietaire (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, mail VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnesConversations (user_id INT NOT NULL, conversation_id INT NOT NULL, INDEX IDX_D0C86C7EA76ED395 (user_id), INDEX IDX_D0C86C7E9AC0396 (conversation_id), PRIMARY KEY(user_id, conversation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnesCharges (user_id INT NOT NULL, charge_id INT NOT NULL, INDEX IDX_8504FA62A76ED395 (user_id), INDEX IDX_8504FA6255284914 (charge_id), PRIMARY KEY(user_id, charge_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnesProjet (user_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_6BDEF29AA76ED395 (user_id), INDEX IDX_6BDEF29AC18272 (projet_id), PRIMARY KEY(user_id, projet_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Votes (user_id INT NOT NULL, reponse_id INT NOT NULL, INDEX IDX_904A55CBA76ED395 (user_id), INDEX IDX_904A55CBCF18BB82 (reponse_id), PRIMARY KEY(user_id, reponse_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_sondage (id INT AUTO_INCREMENT NOT NULL, id_sondage_id INT DEFAULT NULL, reponse VARCHAR(255) NOT NULL, INDEX IDX_FC7EB7A61F7E2E81 (id_sondage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sondage (id INT AUTO_INCREMENT NOT NULL, id_projet_id INT DEFAULT NULL, question VARCHAR(500) NOT NULL, INDEX IDX_7579C89F80F43E55 (id_projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE versement (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT DEFAULT NULL, charge_liee_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, date DATE NOT NULL, type ENUM(\'Cheque\', \'Virement bancaire\'), INDEX IDX_716E936776C50E4A (proprietaire_id), INDEX IDX_716E93676E40B0F6 (charge_liee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activite ADD CONSTRAINT FK_B8755515764D0490 FOREIGN KEY (redacteur_id) REFERENCES propietaire (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9D4E271E1 FOREIGN KEY (projet_id_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES propietaire (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE0F2C01E FOREIGN KEY (id_conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE piece_jointe ADD CONSTRAINT FK_AB5111D4DBBF8D62 FOREIGN KEY (versement_id) REFERENCES versement (id)');
        $this->addSql('ALTER TABLE piece_jointe ADD CONSTRAINT FK_AB5111D480F43E55 FOREIGN KEY (id_projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9ACC1CB28 FOREIGN KEY (projetId) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA976C50E4A FOREIGN KEY (proprietaire_id) REFERENCES propietaire (id)');
        $this->addSql('ALTER TABLE personnesConversations ADD CONSTRAINT FK_D0C86C7EA76ED395 FOREIGN KEY (user_id) REFERENCES propietaire (id)');
        $this->addSql('ALTER TABLE personnesConversations ADD CONSTRAINT FK_D0C86C7E9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE personnesCharges ADD CONSTRAINT FK_8504FA62A76ED395 FOREIGN KEY (user_id) REFERENCES propietaire (id)');
        $this->addSql('ALTER TABLE personnesCharges ADD CONSTRAINT FK_8504FA6255284914 FOREIGN KEY (charge_id) REFERENCES charge (id)');
        $this->addSql('ALTER TABLE personnesProjet ADD CONSTRAINT FK_6BDEF29AA76ED395 FOREIGN KEY (user_id) REFERENCES propietaire (id)');
        $this->addSql('ALTER TABLE personnesProjet ADD CONSTRAINT FK_6BDEF29AC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE Votes ADD CONSTRAINT FK_904A55CBA76ED395 FOREIGN KEY (user_id) REFERENCES propietaire (id)');
        $this->addSql('ALTER TABLE Votes ADD CONSTRAINT FK_904A55CBCF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse_sondage (id)');
        $this->addSql('ALTER TABLE reponse_sondage ADD CONSTRAINT FK_FC7EB7A61F7E2E81 FOREIGN KEY (id_sondage_id) REFERENCES sondage (id)');
        $this->addSql('ALTER TABLE sondage ADD CONSTRAINT FK_7579C89F80F43E55 FOREIGN KEY (id_projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE versement ADD CONSTRAINT FK_716E936776C50E4A FOREIGN KEY (proprietaire_id) REFERENCES propietaire (id)');
        $this->addSql('ALTER TABLE versement ADD CONSTRAINT FK_716E93676E40B0F6 FOREIGN KEY (charge_liee_id) REFERENCES charge (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personnesCharges DROP FOREIGN KEY FK_8504FA6255284914');
        $this->addSql('ALTER TABLE versement DROP FOREIGN KEY FK_716E93676E40B0F6');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE0F2C01E');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9ACC1CB28');
        $this->addSql('ALTER TABLE personnesConversations DROP FOREIGN KEY FK_D0C86C7E9AC0396');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9D4E271E1');
        $this->addSql('ALTER TABLE piece_jointe DROP FOREIGN KEY FK_AB5111D480F43E55');
        $this->addSql('ALTER TABLE personnesProjet DROP FOREIGN KEY FK_6BDEF29AC18272');
        $this->addSql('ALTER TABLE sondage DROP FOREIGN KEY FK_7579C89F80F43E55');
        $this->addSql('ALTER TABLE activite DROP FOREIGN KEY FK_B8755515764D0490');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F79F37AE5');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA976C50E4A');
        $this->addSql('ALTER TABLE personnesConversations DROP FOREIGN KEY FK_D0C86C7EA76ED395');
        $this->addSql('ALTER TABLE personnesCharges DROP FOREIGN KEY FK_8504FA62A76ED395');
        $this->addSql('ALTER TABLE personnesProjet DROP FOREIGN KEY FK_6BDEF29AA76ED395');
        $this->addSql('ALTER TABLE Votes DROP FOREIGN KEY FK_904A55CBA76ED395');
        $this->addSql('ALTER TABLE versement DROP FOREIGN KEY FK_716E936776C50E4A');
        $this->addSql('ALTER TABLE Votes DROP FOREIGN KEY FK_904A55CBCF18BB82');
        $this->addSql('ALTER TABLE reponse_sondage DROP FOREIGN KEY FK_FC7EB7A61F7E2E81');
        $this->addSql('ALTER TABLE piece_jointe DROP FOREIGN KEY FK_AB5111D4DBBF8D62');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE charge');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE piece_jointe');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE propietaire');
        $this->addSql('DROP TABLE personnesConversations');
        $this->addSql('DROP TABLE personnesCharges');
        $this->addSql('DROP TABLE personnesProjet');
        $this->addSql('DROP TABLE Votes');
        $this->addSql('DROP TABLE reponse_sondage');
        $this->addSql('DROP TABLE sondage');
        $this->addSql('DROP TABLE versement');
    }
}
