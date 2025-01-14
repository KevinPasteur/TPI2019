-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema pasteurk_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema pasteurk_db
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `pasteurk_db`;
CREATE SCHEMA IF NOT EXISTS `pasteurk_db` DEFAULT CHARACTER SET utf8 ;
USE `pasteurk_db` ;

-- -----------------------------------------------------
-- Table `pasteurk_db`.`CategoriesC`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`CategoriesC` (
  `idCategoriesC` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `actif` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`idCategoriesC`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`CategoriesM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`CategoriesM` (
  `idCategoriesM` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `actif` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`idCategoriesM`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`Roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Roles` (
  `idRoles` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`idRoles`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`Comptes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Comptes` (
  `idComptes` INT(11) NOT NULL AUTO_INCREMENT,
  `fkRoles` TINYINT(4) NOT NULL,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `motdepasse` VARCHAR(254) NOT NULL,
  `actif` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`idComptes`),
  INDEX `fk_Comptes_Roles_idx` (`fkRoles` ASC) ,
  CONSTRAINT `fk_Comptes_Roles`
    FOREIGN KEY (`fkRoles`)
    REFERENCES `pasteurk_db`.`Roles` (`idRoles`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`FournisseursC`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`FournisseursC` (
  `idFournisseursC` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `telephone` VARCHAR(15) NOT NULL,
  `lien` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idFournisseursC`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`Consommables`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Consommables` (
  `idConsommables` INT(11) NOT NULL AUTO_INCREMENT,
  `modele` VARCHAR(50) NOT NULL,
  `nb_exemp` INT(11) NOT NULL,
  `n_reference` VARCHAR(50) NOT NULL,
  `prix` FLOAT(11) NOT NULL,
  `limite_inf` TINYINT(11) NULL,
  `fkCategoriesC` INT(11) NOT NULL,
  `fkFournisseursC` INT(11) NOT NULL,
  `actif` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`idConsommables`),
  INDEX `fk_Consommables_CategoriesC1_idx` (`fkCategoriesC` ASC) ,
  INDEX `fk_consommables_fournisseursc1_idx` (`fkFournisseursC` ASC) ,
  CONSTRAINT `fk_Consommables_CategoriesC1`
    FOREIGN KEY (`fkCategoriesC`)
    REFERENCES `pasteurk_db`.`CategoriesC` (`idCategoriesC`),
  CONSTRAINT `fk_consommables_fournisseursc1`
    FOREIGN KEY (`fkFournisseursC`)
    REFERENCES `pasteurk_db`.`FournisseursC` (`idFournisseursC`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`StatutsE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`StatutsE` (
  `idStatutsE` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`idStatutsE`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`Emprunt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Emprunt` (
  `idEmprunt` INT(11) NOT NULL AUTO_INCREMENT,
  `fkComptes` INT(11) NOT NULL,
  `fkStatutsE` TINYINT(4) NULL,
  `date_e` DATE NULL DEFAULT NULL,
  `date_r` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`idEmprunt`),
  INDEX `fk_Emprunt_Comptes1_idx` (`fkComptes` ASC) ,
  INDEX `fk_Emprunt_Statuts1_idx` (`fkStatutsE` ASC) ,
  CONSTRAINT `fk_Emprunt_Comptes1`
    FOREIGN KEY (`fkComptes`)
    REFERENCES `pasteurk_db`.`Comptes` (`idComptes`),
  CONSTRAINT `fk_Emprunt_Statuts1`
    FOREIGN KEY (`fkStatutsE`)
    REFERENCES `pasteurk_db`.`StatutsE` (`idStatutsE`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`StatutsM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`StatutsM` (
  `idstatutsM` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`idstatutsM`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`Materiels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Materiels` (
  `idMateriels` INT(11) NOT NULL AUTO_INCREMENT,
  `modele` VARCHAR(50) NOT NULL,
  `n_inventaire` VARCHAR(50) NOT NULL,
  `n_serie` VARCHAR(50) NULL DEFAULT NULL,
  `prix` FLOAT(11) NULL DEFAULT NULL,
  `fkCategoriesM` INT(11) NOT NULL,
  `fkStatutsM` INT(11) NOT NULL,
  `actif` BOOLEAN NOT NULL DEFAULT 1,
  PRIMARY KEY (`idMateriels`),
  INDEX `fk_Materiels_CategoriesM1_idx` (`fkCategoriesM` ASC) ,
  INDEX `fk_materiels_statutsM1_idx` (`fkStatutsM` ASC) ,
  CONSTRAINT `fk_Materiels_CategoriesM1`
    FOREIGN KEY (`fkCategoriesM`)
    REFERENCES `pasteurk_db`.`CategoriesM` (`idCategoriesM`),
  CONSTRAINT `fk_materiels_statutsM1`
    FOREIGN KEY (`fkStatutsM`)
    REFERENCES `pasteurk_db`.`StatutsM` (`idstatutsM`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`StatutsO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`StatutsO` (
  `idStatutsO` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`idStatutsO`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`Octroi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Octroi` (
  `idOctroi` INT(11) NOT NULL AUTO_INCREMENT,
  `fkComptes` INT(11) NOT NULL,
  `fkStatutsO` TINYINT(4) NOT NULL,
  PRIMARY KEY (`idOctroi`),
  INDEX `fk_Octroi_Comptes1_idx` (`fkComptes` ASC) ,
  INDEX `fk_Octroi_StatutsO1_idx` (`fkStatutsO` ASC) ,
  CONSTRAINT `fk_Octroi_Comptes1`
    FOREIGN KEY (`fkComptes`)
    REFERENCES `pasteurk_db`.`Comptes` (`idComptes`),
  CONSTRAINT `fk_Octroi_StatutsO1`
    FOREIGN KEY (`fkStatutsO`)
    REFERENCES `pasteurk_db`.`StatutsO` (`idStatutsO`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`OctroiConso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`OctroiConso` (
  `fkOctroi` INT(11) NOT NULL,
  `fkConsommables` INT(11) NOT NULL,
  `nb_octroi` INT(11) NOT NULL,
  PRIMARY KEY (`fkOctroi`, `fkConsommables`),
  INDEX `fk_octroi_has_consommables_consommables1_idx` (`fkConsommables` ASC) ,
  INDEX `fk_octroi_has_consommables_octroi1_idx` (`fkOctroi` ASC) ,
  CONSTRAINT `fk_octroi_has_consommables_octroi1`
    FOREIGN KEY (`fkOctroi`)
    REFERENCES `pasteurk_db`.`Octroi` (`idOctroi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_octroi_has_consommables_consommables1`
    FOREIGN KEY (`fkConsommables`)
    REFERENCES `pasteurk_db`.`Consommables` (`idConsommables`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`EmpruntMate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`EmpruntMate` (
  `fkEmpruntMate` INT(11) NOT NULL AUTO_INCREMENT,
  `fkEmprunt` INT(11) NOT NULL,
  `fkMateriels` INT(11) NULL,
  PRIMARY KEY (`fkEmpruntMate`),
  INDEX `fk_emprunt_has_materiels_materiels1_idx` (`fkMateriels` ASC) ,
  INDEX `fk_emprunt_has_materiels_emprunt1_idx` (`fkEmprunt` ASC) ,
  CONSTRAINT `fk_emprunt_has_materiels_emprunt1`
    FOREIGN KEY (`fkEmprunt`)
    REFERENCES `pasteurk_db`.`Emprunt` (`idEmprunt`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_emprunt_has_materiels_materiels1`
    FOREIGN KEY (`fkMateriels`)
    REFERENCES `pasteurk_db`.`Materiels` (`idMateriels`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


Insert into Roles (nom) values ('Administrateur');
Insert into Roles (nom) values ('Client');

Insert into Comptes (fkRoles,nom,prenom,email,motdepasse) values ('1','Pasteur','Kevin','kevin.pasteur@cpnv.ch','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),('1','Admin','Admin','Admin@electrostock.mycpnv.ch','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3');

Insert into CategoriesC (nom) values ('Résistances');
Insert into CategoriesC (nom) values ('Condensateurs');
Insert into CategoriesC (nom) values ('Boutons Poussoir');
Insert into CategoriesC (nom) values ('LEDs Bleu');

INSERT into CategoriesM (nom) values ('NAS');
INSERT into CategoriesM (nom) values ('Arduino');
INSERT into CategoriesM (nom) values ('Alimentations');
INSERT into CategoriesM (nom) values ('Raspberry');
INSERT into CategoriesM (nom) values ('PC');

INSERT INTO Consommables (modele, nb_exemp, n_reference,prix,fkCategoriesC,fkFournisseursC) values ('220 kOhm/2W','75','300-47-011' , '2.45','1','1');
INSERT INTO Consommables (modele, nb_exemp, n_reference,prix,fkCategoriesC,fkFournisseursC) values ('100uF/63VDC','50','301-08-251','0.61', '2','1');
INSERT INTO Consommables (modele, nb_exemp, n_reference,prix,fkCategoriesC,fkFournisseursC) values ('1NO','26', '135-55-059','2.30','3','1');
INSERT INTO Consommables (modele, nb_exemp, n_reference,prix,fkCategoriesC,fkFournisseursC) values ('2.2uF/100VDC','18', '301-12-255','0.1182','2','1');
INSERT INTO Consommables (modele, nb_exemp, n_reference,prix,fkCategoriesC,fkFournisseursC) values ('120 Ohm/2W','65', '300-47-002','1.43','1','1');
INSERT INTO Consommables (modele, nb_exemp, n_reference,prix,fkCategoriesC,fkFournisseursC) values ('5 mm','75','301-18-983','0.3621', '4','1');


INSERT INTO Materiels (modele, n_inventaire, n_serie, prix,fkStatutsM, fkCategoriesM) values ('Synology','1','Vf4fsd','300','1','1');
INSERT INTO Materiels (modele, n_inventaire, n_serie, prix,fkStatutsM, fkCategoriesM) values ('MKR Zero','2','afdsa4f5','90','1','2');
INSERT INTO Materiels (modele, n_inventaire, n_serie, prix,fkStatutsM, fkCategoriesM) values ('Proto Shield','3','adsf88','25','1','2');
INSERT INTO Materiels (modele, n_inventaire, n_serie, prix, fkStatutsM,fkCategoriesM) values ('Dell','4','ez7rt5','1200','1','5');
INSERT INTO Materiels (modele, n_inventaire, n_serie, prix,fkStatutsM, fkCategoriesM) values ('Banggood','5','bcx5xb5','50','1','3');
INSERT INTO Materiels (modele, n_inventaire, n_serie, prix,fkStatutsM, fkCategoriesM) values ('Zero','6','wer5qr465','75','1','4');


INSERT into StatutsE (nom) values ('En attente');
INSERT into StatutsE (nom) values ('En cours');
INSERT into StatutsE (nom) values ('Archivé / Validé');
INSERT into StatutsE (nom) values ('Archivé / Refusé');

INSERT into StatutsO (nom) values ('En attente');
INSERT into StatutsO (nom) values ('Archivé / Validé');
INSERT into StatutsO (nom) values ('Archivé / Refusé');

INSERT into StatutsM (nom) values ('Disponible');
INSERT into StatutsM (nom) values ('Indisponible');

INSERT INTO FournisseursC (nom, telephone ,lien) values ('Distrelec','044 944 99 22','https://www.distrelec.ch/');



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
