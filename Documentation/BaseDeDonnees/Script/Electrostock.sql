-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Electrostock_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Electrostock_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Electrostock_db` DEFAULT CHARACTER SET utf8 ;
USE `Electrostock_db` ;

-- -----------------------------------------------------
-- Table `Electrostock_db`.`Roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`Roles` (
  `idRoles` TINYINT NOT NULL,
  `nom` VARCHAR(15) NULL,
  PRIMARY KEY (`idRoles`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Comptes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`Comptes` (
  `idComptes` INT NOT NULL,
  `fkRoles` TINYINT NOT NULL,
  `nom` VARCHAR(100) NULL,
  `prenom` VARCHAR(50) NULL,
  `email` VARCHAR(255) NULL,
  `motdepasse` VARCHAR(254) NULL,
  PRIMARY KEY (`idComptes`),
  INDEX `fk_Comptes_Roles_idx` (`fkRoles` ASC) ,
  CONSTRAINT `fk_Comptes_Roles`
    FOREIGN KEY (`fkRoles`)
    REFERENCES `Electrostock_db`.`Roles` (`idRoles`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`CategoriesM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`CategoriesM` (
  `idCategoriesM` INT NOT NULL,
  `nom` VARCHAR(50) NULL,
  PRIMARY KEY (`idCategoriesM`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Materiels`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`Materiels` (
  `idMateriels` INT NOT NULL,
  `modele` VARCHAR(50) NULL,
  `n_inventaire` VARCHAR(50) NULL,
  `n_serie` VARCHAR(50) NULL,
  `n_reference` VARCHAR(50) NULL,
  `prix` INT NULL,
  `fkCategoriesM` INT NOT NULL,
  PRIMARY KEY (`idMateriels`),
  INDEX `fk_Materiels_CategoriesM1_idx` (`fkCategoriesM` ASC) ,
  CONSTRAINT `fk_Materiels_CategoriesM1`
    FOREIGN KEY (`fkCategoriesM`)
    REFERENCES `Electrostock_db`.`CategoriesM` (`idCategoriesM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`StatutsE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`StatutsE` (
  `idStatutsE` TINYINT NOT NULL,
  `nom` VARCHAR(15) NULL,
  PRIMARY KEY (`idStatutsE`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Emprunt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`Emprunt` (
  `idEmprunt` INT NOT NULL,
  `fkComptes` INT NOT NULL,
  `fkMateriels` INT NOT NULL,
  `fkStatuts` TINYINT NOT NULL,
  `date_e` DATE NULL,
  `date_r` DATE NULL,
  PRIMARY KEY (`idEmprunt`),
  INDEX `fk_Emprunt_Comptes1_idx` (`fkComptes` ASC) ,
  INDEX `fk_Emprunt_Materiels1_idx` (`fkMateriels` ASC) ,
  INDEX `fk_Emprunt_Statuts1_idx` (`fkStatuts` ASC) ,
  CONSTRAINT `fk_Emprunt_Comptes1`
    FOREIGN KEY (`fkComptes`)
    REFERENCES `Electrostock_db`.`Comptes` (`idComptes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Emprunt_Materiels1`
    FOREIGN KEY (`fkMateriels`)
    REFERENCES `Electrostock_db`.`Materiels` (`idMateriels`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Emprunt_Statuts1`
    FOREIGN KEY (`fkStatuts`)
    REFERENCES `Electrostock_db`.`StatutsE` (`idStatutsE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`CategoriesC`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`CategoriesC` (
  `idCategoriesC` INT NOT NULL,
  `nom` VARCHAR(50) NULL,
  PRIMARY KEY (`idCategoriesC`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Consommables`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`Consommables` (
  `idConsommables` INT NOT NULL,
  `modele` VARCHAR(50) NULL,
  `nb_exemp` INT NULL,
  `fkCategoriesC` INT NOT NULL,
  PRIMARY KEY (`idConsommables`),
  INDEX `fk_Consommables_CategoriesC1_idx` (`fkCategoriesC` ASC) ,
  CONSTRAINT `fk_Consommables_CategoriesC1`
    FOREIGN KEY (`fkCategoriesC`)
    REFERENCES `Electrostock_db`.`CategoriesC` (`idCategoriesC`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`StatutsO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`StatutsO` (
  `idStatutsO` TINYINT NOT NULL,
  `nom` VARCHAR(15) NULL,
  PRIMARY KEY (`idStatutsO`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Octroi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`Octroi` (
  `idOctroi` INT NOT NULL,
  `fkComptes` INT NOT NULL,
  `fkConsommables` INT NOT NULL,
  `fkStatutsO` TINYINT NOT NULL,
  PRIMARY KEY (`idOctroi`),
  INDEX `fk_Octroi_Comptes1_idx` (`fkComptes` ASC) ,
  INDEX `fk_Octroi_Consommables1_idx` (`fkConsommables` ASC) ,
  INDEX `fk_Octroi_StatutsO1_idx` (`fkStatutsO` ASC) ,
  CONSTRAINT `fk_Octroi_Comptes1`
    FOREIGN KEY (`fkComptes`)
    REFERENCES `Electrostock_db`.`Comptes` (`idComptes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Octroi_Consommables1`
    FOREIGN KEY (`fkConsommables`)
    REFERENCES `Electrostock_db`.`Consommables` (`idConsommables`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Octroi_StatutsO1`
    FOREIGN KEY (`fkStatutsO`)
    REFERENCES `Electrostock_db`.`StatutsO` (`idStatutsO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`FournisseursM`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`FournisseursM` (
  `idFournisseursM` INT NOT NULL,
  `nom` VARCHAR(100) NULL,
  `telephone` VARCHAR(15) NULL,
  `lien` VARCHAR(255) NULL,
  PRIMARY KEY (`idFournisseursM`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`FournisseursC`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`FournisseursC` (
  `idFournisseursC` INT NOT NULL,
  `nom` VARCHAR(100) NULL,
  `telephone` VARCHAR(15) NULL,
  `lien` VARCHAR(255) NULL,
  PRIMARY KEY (`idFournisseursC`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Conso_Four`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`Conso_Four` (
  `idConso_Four` INT NOT NULL,
  `fkConsommables` INT NOT NULL,
  `fkFournisseursC` INT NOT NULL,
  PRIMARY KEY (`idConso_Four`),
  INDEX `fk_Conso_Four_Consommables1_idx` (`fkConsommables` ASC) ,
  INDEX `fk_Conso_Four_FournisseursC1_idx` (`fkFournisseursC` ASC) ,
  CONSTRAINT `fk_Conso_Four_Consommables1`
    FOREIGN KEY (`fkConsommables`)
    REFERENCES `Electrostock_db`.`Consommables` (`idConsommables`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Conso_Four_FournisseursC1`
    FOREIGN KEY (`fkFournisseursC`)
    REFERENCES `Electrostock_db`.`FournisseursC` (`idFournisseursC`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Electrostock_db`.`Mate_Four`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Electrostock_db`.`Mate_Four` (
  `idMate_Four` INT NOT NULL,
  `fkMateriels` INT NOT NULL,
  `fkFournisseursM` INT NOT NULL,
  PRIMARY KEY (`idMate_Four`),
  INDEX `fk_Mate_Four_Materiels1_idx` (`fkMateriels` ASC) ,
  INDEX `fk_Mate_Four_FournisseursM1_idx` (`fkFournisseursM` ASC) ,
  CONSTRAINT `fk_Mate_Four_Materiels1`
    FOREIGN KEY (`fkMateriels`)
    REFERENCES `Electrostock_db`.`Materiels` (`idMateriels`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mate_Four_FournisseursM1`
    FOREIGN KEY (`fkFournisseursM`)
    REFERENCES `Electrostock_db`.`FournisseursM` (`idFournisseursM`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
