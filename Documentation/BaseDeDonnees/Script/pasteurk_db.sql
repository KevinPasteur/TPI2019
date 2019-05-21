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
-- Table `pasteurk_db`.`categoriesc`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`CategoriesC` (
  `idCategoriesC` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idCategoriesC`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`categoriesm`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`CategoriesM` (
  `idCategoriesM` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`idCategoriesM`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Roles` (
  `idRoles` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`idRoles`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`comptes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Comptes` (
  `idComptes` INT(11) NOT NULL AUTO_INCREMENT,
  `fkRoles` TINYINT(4) NOT NULL,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `motdepasse` VARCHAR(254) NOT NULL,
  PRIMARY KEY (`idComptes`),
  INDEX `fk_Comptes_Roles_idx` (`fkRoles` ASC),
  CONSTRAINT `fk_Comptes_Roles`
    FOREIGN KEY (`fkRoles`)
    REFERENCES `pasteurk_db`.`Roles` (`idRoles`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`consommables`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Consommables` (
  `idConsommables` INT(11) NOT NULL AUTO_INCREMENT,
  `modele` VARCHAR(50) NOT NULL,
  `nb_exemp` INT(11) NOT NULL,
  `fkCategoriesC` INT(11) NOT NULL,
  PRIMARY KEY (`idConsommables`),
  INDEX `fk_Consommables_CategoriesC1_idx` (`fkCategoriesC` ASC),
  CONSTRAINT `fk_Consommables_CategoriesC1`
    FOREIGN KEY (`fkCategoriesC`)
    REFERENCES `pasteurk_db`.`CategoriesC` (`idCategoriesC`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`fournisseursc`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Fournisseursc` (
  `idFournisseursC` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  `telephone` VARCHAR(15) NOT NULL,
  `lien` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idFournisseursC`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`conso_four`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Conso_four` (
  `idConso_Four` INT(11) NOT NULL AUTO_INCREMENT,
  `fkConsommables` INT(11) NOT NULL,
  `fkFournisseursC` INT(11) NOT NULL,
  PRIMARY KEY (`idConso_Four`),
  INDEX `fk_Conso_Four_Consommables1_idx` (`fkConsommables` ASC),
  INDEX `fk_Conso_Four_FournisseursC1_idx` (`fkFournisseursC` ASC),
  CONSTRAINT `fk_Conso_Four_Consommables1`
    FOREIGN KEY (`fkConsommables`)
    REFERENCES `pasteurk_db`.`Consommables` (`idConsommables`),
  CONSTRAINT `fk_Conso_Four_FournisseursC1`
    FOREIGN KEY (`fkFournisseursC`)
    REFERENCES `pasteurk_db`.`FournisseursC` (`idFournisseursC`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`statutsM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`StatutsM` (
  `idstatutsM` INT NOT NULL auto_increment,
  `nom` VARCHAR(15) NULL,
  PRIMARY KEY (`idstatutsM`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`materiels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Materiels` (
  `idMateriels` INT(11) NOT NULL AUTO_INCREMENT,
  `modele` VARCHAR(50) NOT NULL,
  `n_inventaire` INT(11) NULL DEFAULT NULL,
  `n_serie` VARCHAR(50) NULL DEFAULT NULL,
  `n_reference` VARCHAR(50) NULL DEFAULT NULL,
  `prix` INT(11) NULL DEFAULT NULL,
  `fkCategoriesM` INT(11) NOT NULL,
  `fkStatutsM` INT(11) NOT NULL,
  PRIMARY KEY (`idMateriels`),
  INDEX `fk_Materiels_CategoriesM1_idx` (`fkCategoriesM` ASC) ,
  INDEX `fk_materiels_statutsM1_idx` (`fkStatutsM` ASC) ,
  CONSTRAINT `fk_Materiels_CategoriesM1`
    FOREIGN KEY (`fkCategoriesM`)
    REFERENCES `pasteurk_db`.`CategoriesM` (`idCategoriesM`),
  CONSTRAINT `fk_materiels_statutsM1`
    FOREIGN KEY (`fkStatutsM`)
    REFERENCES `pasteurk_db`.`StatutsM` (`idstatutsM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`statutse`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`StatutsE` (
  `idStatutsE` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`idStatutsE`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`emprunt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Emprunt` (
  `idEmprunt` INT(11) NOT NULL AUTO_INCREMENT,
  `fkComptes` INT(11) NOT NULL,
  `fkMateriels` INT(11) NOT NULL,
  `fkStatutsE` TINYINT(4) NOT NULL,
  `date_e` DATE NULL DEFAULT NULL,
  `date_r` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`idEmprunt`),
  INDEX `fk_Emprunt_Comptes1_idx` (`fkComptes` ASC) ,
  INDEX `fk_Emprunt_Materiels1_idx` (`fkMateriels` ASC) ,
  INDEX `fk_Emprunt_Statuts1_idx` (`fkStatutsE` ASC) ,
  CONSTRAINT `fk_Emprunt_Comptes1`
    FOREIGN KEY (`fkComptes`)
    REFERENCES `pasteurk_db`.`Comptes` (`idComptes`),
  CONSTRAINT `fk_Emprunt_Materiels1`
    FOREIGN KEY (`fkMateriels`)
    REFERENCES `pasteurk_db`.`Materiels` (`idMateriels`),
  CONSTRAINT `fk_Emprunt_Statuts1`
    FOREIGN KEY (`fkStatutsE`)
    REFERENCES `pasteurk_db`.`StatutsE` (`idStatutsE`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`statutso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`StatutsO` (
  `idStatutsO` TINYINT(4) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`idStatutsO`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `pasteurk_db`.`octroi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasteurk_db`.`Octroi` (
  `idOctroi` INT(11) NOT NULL AUTO_INCREMENT,
  `fkComptes` INT(11) NOT NULL,
  `fkConsommables` INT(11) NOT NULL,
  `fkStatutsO` TINYINT(4) NOT NULL,
  PRIMARY KEY (`idOctroi`),
  INDEX `fk_Octroi_Comptes1_idx` (`fkComptes` ASC) ,
  INDEX `fk_Octroi_Consommables1_idx` (`fkConsommables` ASC) ,
  INDEX `fk_Octroi_StatutsO1_idx` (`fkStatutsO` ASC) ,
  CONSTRAINT `fk_Octroi_Comptes1`
    FOREIGN KEY (`fkComptes`)
    REFERENCES `pasteurk_db`.`Comptes` (`idComptes`),
  CONSTRAINT `fk_Octroi_Consommables1`
    FOREIGN KEY (`fkConsommables`)
    REFERENCES `pasteurk_db`.`Consommables` (`idConsommables`),
  CONSTRAINT `fk_Octroi_StatutsO1`
    FOREIGN KEY (`fkStatutsO`)
    REFERENCES `pasteurk_db`.`StatutsO` (`idStatutsO`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

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


INSERT INTO Materiels (modele, n_inventaire ,n_serie, n_reference, prix,fkStatutsM, fkCategoriesM) values ('Synology','1','Vf4fsd','1214151','300','1','1');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix,fkStatutsM, fkCategoriesM) values ('MKR Zero','2','afdsa4f5','4556121','90','1','2');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix,fkStatutsM, fkCategoriesM) values ('Proto Shield','3','adsf88','5175371','25','1','2');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix, fkStatutsM,fkCategoriesM) values ('Dell','4','ez7rt5','175134147','1200','1','5');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix,fkStatutsM, fkCategoriesM) values ('Banggood','5','bcx5xb5','471243147','50','1','3');
INSERT INTO Materiels (modele, n_inventaire, n_serie, n_reference, prix,fkStatutsM, fkCategoriesM) values ('Zero','6','wer5qr465','14624713471','75','1','4');


INSERT into StatutsE (nom) values ('En attente');
INSERT into StatutsE (nom) values ('En cours');
INSERT into StatutsE (nom) values ('Archivé / Validé');
INSERT into StatutsE (nom) values ('Archivé / Refusé');

INSERT into StatutsO (nom) values ('Archivé / Validé');
INSERT into StatutsO (nom) values ('Archivé / Refusé');

INSERT into StatutsM (nom) values ('Disponible');
INSERT into StatutsM (nom) values ('Indisponible');


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
