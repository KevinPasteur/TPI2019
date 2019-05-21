-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Electrostock_db
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `pasteurk_db`;
CREATE SCHEMA IF NOT EXISTS `pasteurk_db` DEFAULT CHARACTER SET utf8 ;

-- Schema electrostock_db
-- -----------------------------------------------------
USE `pasteurk_db`;

-- -----------------------------------------------------
-- Table `Electrostock_db`.`Roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Roles` (
  `idRoles`  TINYINT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`idRoles`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Comptes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Comptes` (
  `idComptes` INT NOT NULL AUTO_INCREMENT,
  `fkRoles` TINYINT NOT NULL,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `motdepasse` VARCHAR(254) NOT NULL,
  PRIMARY KEY (`idComptes`),
  INDEX `fk_Comptes_Roles_idx` (`fkRoles` ASC),
  CONSTRAINT `fk_Comptes_Roles`
    FOREIGN KEY (`fkRoles`)
    REFERENCES `pasteurk_db`.`Roles` (`idRoles`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`CategoriesM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`CategoriesM` (
  `idCategoriesM` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idCategoriesM`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Materiels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Materiels` (
  `idMateriels` INT NOT NULL AUTO_INCREMENT,
  `modele` VARCHAR(50) NOT NULL,
  `n_inventaire` INT NULL,
  `n_serie` VARCHAR(50) NULL,
  `n_reference` VARCHAR(50) NULL,
  `prix` INT NULL,
  `fkCategoriesM` INT NOT NULL,
  PRIMARY KEY (`idMateriels`),
  INDEX `fk_Materiels_CategoriesM1_idx` (`fkCategoriesM` ASC) ,
  CONSTRAINT `fk_Materiels_CategoriesM1`
    FOREIGN KEY (`fkCategoriesM`)
    REFERENCES `pasteurk_db`.`CategoriesM` (`idCategoriesM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`StatutsE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`StatutsE` (
  `idStatutsE` TINYINT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`idStatutsE`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Emprunt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Emprunt` (
  `idEmprunt` INT NOT NULL AUTO_INCREMENT,
  `fkComptes` INT NOT NULL,
  `fkMateriels` INT NOT NULL,
  `fkStatutsE` TINYINT NOT NULL,
  `date_e` DATE NULL,
  `date_r` DATE NULL,
  PRIMARY KEY (`idEmprunt`),
  INDEX `fk_Emprunt_Comptes1_idx` (`fkComptes` ASC) ,
  INDEX `fk_Emprunt_Materiels1_idx` (`fkMateriels` ASC) ,
  INDEX `fk_Emprunt_Statuts1_idx` (`fkStatutsE` ASC) ,
  CONSTRAINT `fk_Emprunt_Comptes1`
    FOREIGN KEY (`fkComptes`)
    REFERENCES `pasteurk_db`.`Comptes` (`idComptes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Emprunt_Materiels1`
    FOREIGN KEY (`fkMateriels`)
    REFERENCES `pasteurk_db`.`Materiels` (`idMateriels`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Emprunt_Statuts1`
    FOREIGN KEY (`fkStatutsE`)
    REFERENCES `pasteurk_db`.`StatutsE` (`idStatutsE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`CategoriesC`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`CategoriesC` (
  `idCategoriesC` INT NOT NULL auto_increment,
  `nom` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idCategoriesC`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Consommables`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Consommables` (
  `idConsommables` INT NOT NULL AUTO_INCREMENT,
  `modele` VARCHAR(50) NOT NULL,
  `nb_exemp` INT NOT NULL,
  `fkCategoriesC` INT NOT NULL,
  PRIMARY KEY (`idConsommables`),
  INDEX `fk_Consommables_CategoriesC1_idx` (`fkCategoriesC` ASC) ,
  CONSTRAINT `fk_Consommables_CategoriesC1`
    FOREIGN KEY (`fkCategoriesC`)
    REFERENCES `pasteurk_db`.`CategoriesC` (`idCategoriesC`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`StatutsO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`StatutsO` (
  `idStatutsO` TINYINT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`idStatutsO`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Octroi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Octroi` (
  `idOctroi` INT NOT NULL AUTO_INCREMENT,
  `fkComptes` INT NOT NULL,
  `fkConsommables` INT NOT NULL,
  `fkStatutsO` TINYINT NOT NULL,
  PRIMARY KEY (`idOctroi`),
  INDEX `fk_Octroi_Comptes1_idx` (`fkComptes` ASC) ,
  INDEX `fk_Octroi_Consommables1_idx` (`fkConsommables` ASC) ,
  INDEX `fk_Octroi_StatutsO1_idx` (`fkStatutsO` ASC) ,
  CONSTRAINT `fk_Octroi_Comptes1`
    FOREIGN KEY (`fkComptes`)
    REFERENCES `pasteurk_db`.`Comptes` (`idComptes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Octroi_Consommables1`
    FOREIGN KEY (`fkConsommables`)
    REFERENCES `pasteurk_db`.`Consommables` (`idConsommables`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Octroi_StatutsO1`
    FOREIGN KEY (`fkStatutsO`)
    REFERENCES `pasteurk_db`.`StatutsO` (`idStatutsO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`FournisseursC`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`FournisseursC` (
  `idFournisseursC` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `telephone` VARCHAR(15) NOT NULL,
  `lien` VARCHAR(255) NULL,
  PRIMARY KEY (`idFournisseursC`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Conso_Four`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Conso_Four` (
  `idConso_Four` INT NOT NULL AUTO_INCREMENT,
  `fkConsommables` INT NOT NULL,
  `fkFournisseursC` INT NOT NULL,
  PRIMARY KEY (`idConso_Four`),
  INDEX `fk_Conso_Four_Consommables1_idx` (`fkConsommables` ASC) ,
  INDEX `fk_Conso_Four_FournisseursC1_idx` (`fkFournisseursC` ASC) ,
  CONSTRAINT `fk_Conso_Four_Consommables1`
    FOREIGN KEY (`fkConsommables`)
    REFERENCES `pasteurk_db`.`Consommables` (`idConsommables`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Conso_Four_FournisseursC1`
    FOREIGN KEY (`fkFournisseursC`)
    REFERENCES `pasteurk_db`.`FournisseursC` (`idFournisseursC`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

Insert into Roles (nom) values ('Administrateur');
Insert into Roles (nom) values ('Client');

Insert into Comptes (fkRoles,nom,prenom,email,motdepasse) values ('1','Pasteur','Kevin','kevin.pasteur@cpnv.ch','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3');

Insert into CategoriesC (nom) values ('Résistances');
Insert into CategoriesC (nom) values ('Condensateurs');
Insert into CategoriesC (nom) values ('Boutons Poussoir');
Insert into CategoriesC (nom) values ('LEDs Bleu');

INSERT into CategoriesM (nom) values ('NAS');
INSERT into CategoriesM (nom) values ('Arduino');
INSERT into CategoriesM (nom) values ('Alimentations');
INSERT into CategoriesM (nom) values ('Raspberry');
INSERT into CategoriesM (nom) values ('PC');

INSERT INTO Consommables (modele, nb_exemp, fkCategoriesC) values ('220 kOhm/2W','75', '1');
INSERT INTO Consommables (modele, nb_exemp, fkCategoriesC) values ('450mF/63V','50', '2');
INSERT INTO Consommables (modele, nb_exemp, fkCategoriesC) values ('1NO','26', '3');
INSERT INTO Consommables (modele, nb_exemp, fkCategoriesC) values ('2.2uF/450V','18', '2');
INSERT INTO Consommables (modele, nb_exemp, fkCategoriesC) values ('120 Ohm/2W','65', '1');
INSERT INTO Consommables (modele, nb_exemp, fkCategoriesC) values ('5 mm','75', '4');


INSERT INTO Materiels (modele, n_inventaire ,n_serie, n_reference, prix, fkCategoriesM) values ('Synology','1','Vf4fsd','1214151','300','1');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix, fkCategoriesM) values ('MKR Zero','2','afdsa4f5','4556121','90','2');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix, fkCategoriesM) values ('Proto Shield','3','adsf88','5175371','25','2');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix, fkCategoriesM) values ('Dell','4','ez7rt5','175134147','1200','5');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix, fkCategoriesM) values ('Banggood','5','bcx5xb5','471243147','50','3');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix, fkCategoriesM) values ('Zero','6','wer5qr465','14624713471','75','4');


INSERT into StatutsE (nom) values ('En attente');
INSERT into StatutsE (nom) values ('En cours');
INSERT into StatutsE (nom) values ('Archivé / Validé');
INSERT into StatutsE (nom) values ('Archivé / Refusé');

INSERT into StatutsO (nom) values ('Archivé / Validé');
INSERT into StatutsO (nom) values ('Archivé / Refusé');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
