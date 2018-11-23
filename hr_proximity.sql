CREATE DATABASE  IF NOT EXISTS `hr_proximity` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `hr_proximity`;
-- MySQL dump 10.13  Distrib 5.6.33, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: hr_proximity
-- ------------------------------------------------------
-- Server version	5.6.33-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ausencias`
--

DROP TABLE IF EXISTS `ausencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ausencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador ausencia',
  `fecha` date NOT NULL COMMENT 'fecha ausencia',
  `cant_horas` int(11) NOT NULL COMMENT 'cantidad de horas de ausencia',
  `estado` varchar(50) NOT NULL COMMENT 'estado de la ausencia',
  `comentarios` varchar(150) NOT NULL COMMENT 'comentarios ausencia',
  `id_empleado` int(9) NOT NULL COMMENT 'identificador de empleado',
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `ausencias_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ausencias`
--

LOCK TABLES `ausencias` WRITE;
/*!40000 ALTER TABLE `ausencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `ausencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contratos`
--

DROP TABLE IF EXISTS `contratos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contratos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de contrato',
  `id_empleado` int(9) NOT NULL COMMENT 'identificador de empleado',
  `tipo` varchar(50) NOT NULL COMMENT 'tipo de contrato, ya sea outsorcing o cliente',
  `forma_pago` varchar(50) NOT NULL COMMENT 'forma de pago de contrato, ya sea horas o mensual',
  `monto` int(11) NOT NULL COMMENT 'monto de contrato basado en tipo de pago',
  `fecha_inicio` date NOT NULL COMMENT 'fecha inicio del contrato',
  `fecha_fin` date DEFAULT NULL COMMENT 'fecha final del contrato',
  `nombre` varchar(50) NOT NULL COMMENT 'nombre contrato',
  `multa` int(11) NOT NULL COMMENT 'multa de contrato en caso de que exista',
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `contratos_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contratos`
--

LOCK TABLES `contratos` WRITE;
/*!40000 ALTER TABLE `contratos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contratos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contratos_comprobacion`
--

DROP TABLE IF EXISTS `contratos_comprobacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contratos_comprobacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de comprobacion de contrato',
  `id_contrato` int(11) NOT NULL COMMENT 'identificador de contrato',
  `fecha` date NOT NULL COMMENT 'fecha de ingreso de comprobacion',
  `monto` int(11) NOT NULL COMMENT 'monto de comprobacion',
  PRIMARY KEY (`id`),
  KEY `id_contrato` (`id_contrato`),
  CONSTRAINT `contratos_comprobacion_ibfk_1` FOREIGN KEY (`id_contrato`) REFERENCES `contratos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contratos_comprobacion`
--

LOCK TABLES `contratos_comprobacion` WRITE;
/*!40000 ALTER TABLE `contratos_comprobacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `contratos_comprobacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empleado` (
  `cedula` int(9) NOT NULL COMMENT 'cédula del empleado',
  `nombre` varchar(50) NOT NULL COMMENT 'nombre del empleado',
  `apellidos` varchar(70) NOT NULL COMMENT 'apellidos del empleado',
  `email` varchar(70) NOT NULL COMMENT 'correo electronico de empleado',
  `direccion` varchar(100) NOT NULL COMMENT 'direccion del empleado',
  `celular` int(8) NOT NULL COMMENT 'celular del empleado',
  `puesto` varchar(50) NOT NULL COMMENT 'puesto del empleado',
  `salario` int(20) NOT NULL COMMENT 'salario del empleado',
  `fecha_nacimiento` date NOT NULL COMMENT 'fecha de nacimiento del empleado',
  `fecha_ingreso` date NOT NULL COMMENT 'fecha ingreso del empleado',
  `rol` varchar(50) NOT NULL COMMENT 'rol del empleado, ya sea empleado o administrador',
  `id_manager` int(9) NOT NULL COMMENT 'identificador de manager del empleado',
  PRIMARY KEY (`cedula`),
  KEY `id_manager` (`id_manager`),
  CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`id_manager`) REFERENCES `empleado` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (115840727,'Kevin','Urena Thames','kevin.urena@proximitycr.com','Desamparados',83111466,'Desarrollador de Software',1290000000,'1994-08-10','2016-02-29','administrador',115840727),(123456987,'Laura','Rojas Rojas','laura.rojas@proximitycr.com','Desamparados',12345678,'Project Director',123456789,'1990-09-09','2015-08-08','administrador',115840727);
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incapacidades`
--

DROP TABLE IF EXISTS `incapacidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incapacidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de incapacidad',
  `id_empleado` int(9) NOT NULL COMMENT 'identificador de empleado',
  `fecha_inicio` date NOT NULL COMMENT 'fecha inicio de incapacidad',
  `fecha_fin` date NOT NULL COMMENT 'fecha final de incapacidad',
  `comentarios` varchar(100) NOT NULL COMMENT 'comentarios de incapacidad',
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `incapacidades_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incapacidades`
--

LOCK TABLES `incapacidades` WRITE;
/*!40000 ALTER TABLE `incapacidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `incapacidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de usuario',
  `nombre_usuario` varchar(100) NOT NULL COMMENT 'nombre de usuario',
  `contrasena` varchar(200) NOT NULL COMMENT 'contrasena de usuario',
  `created_at` date NOT NULL COMMENT 'fecha de creacion',
  `updated_at` date NOT NULL COMMENT 'fecha de actualizacion',
  `remember_token` varchar(10000) DEFAULT NULL COMMENT 'toke de recordar contrasena',
  `id_empleado` int(9) NOT NULL COMMENT 'identificador de empleado',
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (2,'kevin.urena','$2y$10$sO1tbYP8Qcp6qK5GuBA6Me98lBVsqkS006cAidywpwazV1NvX76hq','2018-03-12','2018-03-12','7Ss2MAJMpI3NeJor0qr3rmNmX15RxrCo0bovw4oagTTDZQKBm0VTJ1YlLPLG',115840727);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacaciones`
--

DROP TABLE IF EXISTS `vacaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vacaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de vacaciones',
  `id_empleado` int(9) NOT NULL COMMENT 'identificador de empleado',
  `fecha` date NOT NULL COMMENT 'fecha de vacaciones',
  `estado` varchar(50) NOT NULL COMMENT 'estado de la solicitud de vacaciones',
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `vacaciones_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacaciones`
--

LOCK TABLES `vacaciones` WRITE;
/*!40000 ALTER TABLE `vacaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `vacaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacaciones_copia_email`
--

DROP TABLE IF EXISTS `vacaciones_copia_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vacaciones_copia_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de copia email de vacaciones',
  `id_vacaciones` int(11) NOT NULL COMMENT 'identificador de vacaciones',
  `id_empleado` int(9) NOT NULL COMMENT 'identificador de empleado',
  PRIMARY KEY (`id`),
  KEY `id_vacaciones` (`id_vacaciones`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `vacaciones_copia_email_ibfk_1` FOREIGN KEY (`id_vacaciones`) REFERENCES `vacaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `vacaciones_copia_email_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacaciones_copia_email`
--

LOCK TABLES `vacaciones_copia_email` WRITE;
/*!40000 ALTER TABLE `vacaciones_copia_email` DISABLE KEYS */;
/*!40000 ALTER TABLE `vacaciones_copia_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viaticos`
--

DROP TABLE IF EXISTS `viaticos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viaticos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de viatico',
  `id_empleado` int(9) NOT NULL COMMENT 'identificador de empleado',
  `tipo` varchar(50) NOT NULL COMMENT 'tipo de viático, ya sea transporte, viajes o alimentación',
  `total` int(11) NOT NULL COMMENT 'monto total de viático',
  `descripcion` varchar(150) NOT NULL COMMENT 'descripcion de viatico',
  `fecha` date NOT NULL COMMENT 'fecha de ingreso de viatico',
  PRIMARY KEY (`id`),
  KEY `id_empleado` (`id_empleado`),
  CONSTRAINT `viaticos_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viaticos`
--

LOCK TABLES `viaticos` WRITE;
/*!40000 ALTER TABLE `viaticos` DISABLE KEYS */;
/*!40000 ALTER TABLE `viaticos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viaticos_comprobacion`
--

DROP TABLE IF EXISTS `viaticos_comprobacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viaticos_comprobacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador de comprobacion de viatico',
  `id_viatico` int(11) NOT NULL COMMENT 'identificador de viatico',
  `fecha` date NOT NULL COMMENT 'fecha de ingreso de comprobacion de viatico',
  `monto` int(11) NOT NULL COMMENT 'monto de comprobacion de viatico',
  `descripcion` varchar(150) NOT NULL COMMENT 'descripcion de comprobacion de viatico',
  PRIMARY KEY (`id`),
  KEY `id_viatico` (`id_viatico`),
  CONSTRAINT `viaticos_comprobacion_ibfk_1` FOREIGN KEY (`id_viatico`) REFERENCES `viaticos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viaticos_comprobacion`
--

LOCK TABLES `viaticos_comprobacion` WRITE;
/*!40000 ALTER TABLE `viaticos_comprobacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `viaticos_comprobacion` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-12 19:57:43
