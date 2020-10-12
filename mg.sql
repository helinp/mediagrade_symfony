-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 11 oct. 2020 à 14:21
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mg`
--

-- --------------------------------------------------------

--
-- Structure de la table `achievement`
--

DROP TABLE IF EXISTS `achievement`;
CREATE TABLE IF NOT EXISTS `achievement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_stars` smallint(6) NOT NULL,
  `icon_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `assessment`
--

DROP TABLE IF EXISTS `assessment`;
CREATE TABLE IF NOT EXISTS `assessment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill_id` int(11) NOT NULL,
  `criterion_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `indicator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_vote` smallint(6) NOT NULL,
  `achievement_id` int(11) DEFAULT NULL,
  `grading_system_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F7523D705585C142` (`skill_id`),
  KEY `IDX_F7523D7097766307` (`criterion_id`),
  KEY `IDX_F7523D70166D1F9C` (`project_id`),
  KEY `IDX_F7523D70B3EC99FE` (`achievement_id`),
  KEY `IDX_F7523D70E383D86E` (`grading_system_id`),
  KEY `IDX_F7523D701F55203D` (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `assessment`
--

INSERT INTO `assessment` (`id`, `skill_id`, `criterion_id`, `project_id`, `indicator`, `max_vote`, `achievement_id`, `grading_system_id`, `topic_id`) VALUES
(5, 17, 11, 5, 'réalisé une photographie relativement bien exposée (pas trop sombre ni trop claire)', 10, NULL, 1, 2),
(6, 32, 12, 5, 'des photographies bien cadrées (sujet pas coupé, photographie droite...)', 5, NULL, 1, 1),
(7, 31, 13, 6, 'utilisé un temps de pose très court (1/200-1/1000s) tout en conservant une exposition correcte', 10, NULL, 1, 1),
(8, 31, 14, 6, 'parfaitement mis au point sur le sujet', 5, NULL, 1, 1),
(9, 26, 15, 6, 'exploité la technique pour exprimer des idées qui ne pourraient pas l\'être autrement', 5, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `assessment_type`
--

DROP TABLE IF EXISTS `assessment_type`;
CREATE TABLE IF NOT EXISTS `assessment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `assessment_type`
--

INSERT INTO `assessment_type` (`id`, `name`, `description`) VALUES
(1, 'F', 'Formative'),
(2, 'C', 'Certificative'),
(3, 'D', 'Diagnostique (hors périodes)');

-- --------------------------------------------------------

--
-- Structure de la table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `attendance_grid_id` int(11) NOT NULL,
  `is_present` tinyint(1) DEFAULT NULL,
  `is_absent` tinyint(1) DEFAULT NULL,
  `is_late` tinyint(1) DEFAULT NULL,
  `is_excused` tinyint(1) DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6DE30D91CB944F1A` (`student_id`),
  KEY `IDX_6DE30D912B368697` (`attendance_grid_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `attendance_grid_id`, `is_present`, `is_absent`, `is_late`, `is_excused`, `status`) VALUES
(20, 6, 4, 1, 0, 0, 0, 'P'),
(21, 7, 4, 0, 1, 0, 0, 'A'),
(22, 8, 4, 1, 0, 0, 1, 'R'),
(23, 2, 5, 0, 1, 0, 0, 'A'),
(24, 3, 5, 1, 0, 0, 0, 'P'),
(25, 6, 6, 1, 0, 0, 0, 'P'),
(26, 7, 6, 1, 0, 0, 0, 'P'),
(27, 8, 6, 1, 0, 0, 0, 'P'),
(28, 2, 7, 0, 1, 0, 0, 'A'),
(29, 3, 7, 1, 0, 0, 0, 'P'),
(30, 6, 8, 0, 1, 0, 0, 'A'),
(31, 7, 8, 1, 0, 0, 0, 'P'),
(32, 8, 8, 1, 0, 0, 1, 'R'),
(33, 9, 8, 0, 1, 0, 0, 'A'),
(34, 10, 8, 0, 1, 0, 0, 'A'),
(35, 11, 8, 0, 1, 0, 0, 'A'),
(36, 12, 8, 1, 0, 0, 0, 'P'),
(37, 13, 8, 1, 0, 0, 0, 'P'),
(38, 14, 8, 0, 1, 0, 0, 'A'),
(39, 15, 8, 0, 1, 0, 0, 'A'),
(40, 16, 8, 0, 1, 0, 0, 'A'),
(41, 17, 8, 1, 0, 0, 0, 'P'),
(42, 18, 8, 0, 1, 0, 0, 'A'),
(43, 25, 8, 0, 1, 0, 0, 'A'),
(44, 6, 9, 1, 0, 0, 0, 'P'),
(45, 7, 9, 0, 1, 0, 0, 'A'),
(46, 8, 9, 1, 0, 0, 0, 'P'),
(47, 9, 9, 0, 1, 0, 0, 'A'),
(48, 10, 9, 1, 0, 0, 1, 'R'),
(49, 11, 9, 0, 1, 0, 0, 'A'),
(50, 12, 9, 0, 1, 0, 0, 'A'),
(51, 13, 9, 0, 1, 0, 0, 'A'),
(52, 14, 9, 1, 0, 0, 0, 'P'),
(53, 15, 9, 1, 0, 0, 0, 'P'),
(54, 16, 9, 1, 0, 0, 0, 'P'),
(55, 17, 9, 1, 0, 0, 0, 'P'),
(56, 18, 9, 1, 0, 0, 0, 'P'),
(57, 25, 9, 1, 0, 0, 0, 'P');

-- --------------------------------------------------------

--
-- Structure de la table `attendance_grid`
--

DROP TABLE IF EXISTS `attendance_grid`;
CREATE TABLE IF NOT EXISTS `attendance_grid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `school_hour` smallint(6) NOT NULL,
  `school_year` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `picture` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_16FE044241807E1D` (`teacher_id`),
  KEY `IDX_16FE0442591CC992` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `attendance_grid`
--

INSERT INTO `attendance_grid` (`id`, `teacher_id`, `course_id`, `date_time`, `school_hour`, `school_year`, `date`, `picture`) VALUES
(4, 1, 1, '2020-09-29 17:11:50', 1, '2020-2021', '2020-09-29', NULL),
(5, 1, 4, '2020-09-29 17:12:17', 2, '2020-2021', '2020-09-29', NULL),
(6, 1, 3, '2020-09-29 17:12:23', 3, '2020-2021', '2020-09-29', NULL),
(7, 1, 2, '2020-10-03 09:47:44', 6, '2020-2021', '2020-09-30', '2020-2021_2020-09-30_6.jpeg'),
(8, 1, 1, '2020-10-03 11:13:23', 8, '2020-2021', '2020-10-03', '2020-2021_2020-10-03_8.jpeg'),
(9, 1, 1, '2020-10-06 10:04:10', 1, '2020-2021', '2020-10-06', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`id`, `name`, `description`) VALUES
(1, '3AV', '3 TTR Audiovisuel'),
(2, '4AV', '4 TTR Audiovisuel'),
(3, '5AV', '5 TTR Audiovisuel'),
(4, '6AV', '6 TTR Audiovisuel');

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classe_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_169E6FB98F5EA509` (`classe_id`),
  KEY `IDX_169E6FB941807E1D` (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`id`, `classe_id`, `teacher_id`, `name`, `description`) VALUES
(1, 1, 1, '3 LABO', '3 TTR AV - Laboratoire'),
(2, 2, 1, '4 LABO', '4 TTR AV - Laboratoire'),
(3, 1, 1, '3 TECH', '3 TTR AV Technologie'),
(4, 2, 1, '4 TECH', '4 TTR AV Technologie'),
(5, 3, 1, '5TECH', '5 TTR AV - Technologie'),
(6, 3, 1, '5 LABO', '5 TTR AV - Laboratoire'),
(7, 4, 1, '6 LABO', '6 TTR AV - Laboratoire'),
(8, 4, 1, '6 TECH', '6 TTR AV - Technologie');

-- --------------------------------------------------------

--
-- Structure de la table `criterion`
--

DROP TABLE IF EXISTS `criterion`;
CREATE TABLE IF NOT EXISTS `criterion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `criterion`
--

INSERT INTO `criterion` (`id`, `name`) VALUES
(7, 'Test critère'),
(8, 'Qualité image'),
(9, 'recherche'),
(10, 'soin'),
(11, 'Exposition'),
(12, 'Cadrage'),
(13, 'Maîtrise APN'),
(14, 'Maîtrise APN'),
(15, 'Expression');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200910153612', '2020-09-10 15:37:54', 1347),
('DoctrineMigrations\\Version20200910154134', '2020-09-10 15:41:38', 150),
('DoctrineMigrations\\Version20200910160000', '2020-09-10 16:00:39', 71),
('DoctrineMigrations\\Version20200910160905', '2020-09-10 16:09:25', 301),
('DoctrineMigrations\\Version20200910161701', '2020-09-10 16:17:04', 165),
('DoctrineMigrations\\Version20200910181202', '2020-09-10 18:12:28', 153),
('DoctrineMigrations\\Version20200910181459', '2020-09-10 18:15:51', 95),
('DoctrineMigrations\\Version20200914170853', NULL, NULL),
('DoctrineMigrations\\Version20200914171044', '2020-09-14 17:12:58', 59),
('DoctrineMigrations\\Version20200915173432', '2020-09-15 17:34:59', 309),
('DoctrineMigrations\\Version20200916142136', '2020-09-16 14:22:32', 266),
('DoctrineMigrations\\Version20200922083843', '2020-09-22 08:56:24', 17),
('DoctrineMigrations\\Version20200922085600', '2020-09-22 08:56:25', 138),
('DoctrineMigrations\\Version20200922090241', '2020-09-22 09:03:04', 74),
('DoctrineMigrations\\Version20200922090730', '2020-09-22 09:07:50', 85),
('DoctrineMigrations\\Version20200926102251', '2020-09-26 10:23:43', 791),
('DoctrineMigrations\\Version20200926161639', '2020-09-26 10:23:43', 791),
('DoctrineMigrations\\Version20200926194023', '2020-09-26 10:23:43', 791),
('DoctrineMigrations\\Version20200927152850', '2020-09-27 15:31:39', 227),
('DoctrineMigrations\\Version20200929093449', '2020-09-29 09:36:40', 879),
('DoctrineMigrations\\Version20200929093906', '2020-09-29 09:39:30', 72),
('DoctrineMigrations\\Version20200929100251', '2020-09-29 10:04:04', 18),
('DoctrineMigrations\\Version20200929100329', '2020-09-29 10:04:04', 59),
('DoctrineMigrations\\Version20200929155418', '2020-09-29 15:56:13', 614),
('DoctrineMigrations\\Version20200929155551', '2020-09-29 15:56:14', 1),
('DoctrineMigrations\\Version20200929161842', '2020-09-29 16:19:51', 70),
('DoctrineMigrations\\Version20200929165105', '2020-09-29 16:51:18', 84),
('DoctrineMigrations\\Version20201003085757', '2020-10-07 13:28:10', 841),
('DoctrineMigrations\\Version20201007132728', '2020-10-07 13:30:01', 91),
('DoctrineMigrations\\Version20201007151020', '2020-10-07 15:10:44', 96);

-- --------------------------------------------------------

--
-- Structure de la table `grading_system`
--

DROP TABLE IF EXISTS `grading_system`;
CREATE TABLE IF NOT EXISTS `grading_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `grading_system`
--

INSERT INTO `grading_system` (`id`, `name`, `description`) VALUES
(1, '3 Lettres', 'Acquis | En Acquisition | A Renforcer'),
(2, 'Points', 'Points de 1 à 10');

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `assessment_type_id` int(11) NOT NULL,
  `school_year` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` longtext COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `hard_deadline` date NOT NULL,
  `soft_deadline` date DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activated` tinyint(1) NOT NULL,
  `external` tinyint(1) NOT NULL,
  `context` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `term_id` int(11) NOT NULL,
  `file_extension` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_files` smallint(6) NOT NULL,
  `teacher_submitted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2FB3D0EE591CC992` (`course_id`),
  KEY `IDX_2FB3D0EE41807E1D` (`teacher_id`),
  KEY `IDX_2FB3D0EE6FB21D5D` (`assessment_type_id`),
  KEY `IDX_2FB3D0EEE2C35FC` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `course_id`, `teacher_id`, `assessment_type_id`, `school_year`, `instructions`, `start_date`, `hard_deadline`, `soft_deadline`, `name`, `activated`, `external`, `context`, `term_id`, `file_extension`, `number_of_files`, `teacher_submitted`) VALUES
(5, 1, 1, 1, '2020-2021', '<p>Remet 3 photographies de lightpainting:</p><ol><li>Une avec ton pr&eacute;nom &eacute;crit en lightpainting</li><li>Une avec un personnage et une boule de feu</li><li>Un photographie cr&eacute;ative et surprenante, mais pas de mauvais go&ucirc;t.</li></ol><p>Les photographies devront &ecirc;tre bien cadr&eacute;es (sujet pas coup&eacute;, photographie droite...)</p>', '2020-09-10', '2020-10-30', '2020-10-04', 'Lightpainting', 1, 1, 'Réalise tes premières photographies en lightpainting', 1, 'jpg', 3, 0),
(6, 1, 1, 1, '2020-2021', '<p>Remets une photographie dans laquelle tu exploites de mani&egrave;re cr&eacute;ative les temps de pose tr&egrave;s courts (1/200 - 1/1000 s).</p>', '2020-10-30', '2020-10-30', '2020-10-06', 'Lévitations', 1, 1, 'Tu découvres les temps de pose très courts, exploite-les afin de produire une photographie créative!', 1, 'jpg', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `project_self_assessment_question`
--

DROP TABLE IF EXISTS `project_self_assessment_question`;
CREATE TABLE IF NOT EXISTS `project_self_assessment_question` (
  `project_id` int(11) NOT NULL,
  `self_assessment_question_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`self_assessment_question_id`),
  KEY `IDX_DFCAB2A3166D1F9C` (`project_id`),
  KEY `IDX_DFCAB2A3C91D5A2B` (`self_assessment_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `project_skill`
--

DROP TABLE IF EXISTS `project_skill`;
CREATE TABLE IF NOT EXISTS `project_skill` (
  `project_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  PRIMARY KEY (`project_id`,`skill_id`),
  KEY `IDX_4D68EDE9166D1F9C` (`project_id`),
  KEY `IDX_4D68EDE95585C142` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `project_skill`
--

INSERT INTO `project_skill` (`project_id`, `skill_id`) VALUES
(5, 17),
(5, 25),
(5, 27),
(5, 30),
(5, 32),
(6, 11),
(6, 17),
(6, 23),
(6, 25),
(6, 26),
(6, 31),
(6, 35),
(6, 39);

-- --------------------------------------------------------

--
-- Structure de la table `result`
--

DROP TABLE IF EXISTS `result`;
CREATE TABLE IF NOT EXISTS `result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `assessment_id` int(11) NOT NULL,
  `max_vote` int(11) NOT NULL,
  `user_vote` double DEFAULT NULL,
  `user_letter` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `was_absent` tinyint(1) DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_136AC113CB944F1A` (`student_id`),
  KEY `IDX_136AC113DD3DD5F1` (`assessment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `result`
--

INSERT INTO `result` (`id`, `student_id`, `assessment_id`, `max_vote`, `user_vote`, `user_letter`, `date`, `was_absent`, `comment`) VALUES
(1, 6, 5, 10, 7, 'EA', '2020-10-06', NULL, '--'),
(2, 6, 6, 5, 5, 'A', '2020-10-06', NULL, '--'),
(3, 10, 7, 10, 7, 'EA', '2020-10-06', NULL, '12'),
(4, 10, 8, 5, 1.5, 'AR', '2020-10-06', NULL, '2'),
(5, 10, 9, 5, 0, 'NR', '2020-10-06', NULL, '3');

-- --------------------------------------------------------

--
-- Structure de la table `self_assessment_answer`
--

DROP TABLE IF EXISTS `self_assessment_answer`;
CREATE TABLE IF NOT EXISTS `self_assessment_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1BA1F6D6CB944F1A` (`student_id`),
  KEY `IDX_1BA1F6D6166D1F9C` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `self_assessment_question`
--

DROP TABLE IF EXISTS `self_assessment_question`;
CREATE TABLE IF NOT EXISTS `self_assessment_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) DEFAULT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4BB1C5EB41807E1D` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `skill`
--

DROP TABLE IF EXISTS `skill`;
CREATE TABLE IF NOT EXISTS `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skills_group_id` int(11) NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `transverse_skill` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_5E3DE477D6044424` (`skills_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `skill`
--

INSERT INTO `skill` (`id`, `skills_group_id`, `short_name`, `description`, `transverse_skill`) VALUES
(1, 3, 'A1', 'Construire le jugement éclairé en structurant la pensée critique (tant vis-à-vis de ses propres réalisations que de celles des autres) et permettre d’échanger ses raisons d’aimer en argumentant : au regard de la logique documentaire ou du reportage qui, là où elle est invoquée, implique une approche objective ; au regard du « quotient créateur » (puissance transformatrice, originalité de l’apport…) ; au regard des possibilités connotatives (ouverture ou fermeture du sens) ; au regard de l’existence formelle, visuelle et sonore (image, musique, texte, voix…) constitutive de l’œuvre (espace, composition, tension, formes, valeurs, couleurs, textures, proportions, lumières, échelle, mouvement, raccords, temps…), mais aussi dans le rapport de la forme et du contenu ; au regard de sa lisibilité et de son intelligibilité, notamment dans la relation aux conditions de production et de réception ; au regard de la norme et du hors norme des codes esthétiques.', 'Argumenter et relativiser le jugement.'),
(2, 2, 'A2', 'Enrichir son jugement esthétique par l’éclairage de connaissances pertinentes du contexte d’émergence de l’œuvre.', 'Relier l’œuvre à son contexte.'),
(3, 2, 'A3', 'Lire et comprendre le fonctionnement des documents audiovisuels existants (presse, annonces, clips, vidéos…), de manière à en assurer la compréhension (aspects sociologiques, sémiologiques, psychologiques…) et la critique de même qu’à pouvoir en évaluer l’impact sur le public.', 'Relativiser l’intérêt des différentes approches scientifiques dans le domaine des sciences humaines.'),
(4, 3, 'A4', 'Apprécier la richesse de ses racines et de son identité culturelle. Imposer le respect naturel et la valorisation des patrimoines.', 'Respect de l’héritage et volonté de le conserver pour les générations futures.'),
(5, 2, 'A5', 'Reconnaitre l’autre dans la spécificité de son langage et de ce qu’il est en lisant les productions audiovisuelles comme projection de l’imaginaire et rencontre de l’inconscient, du fonds culturel, des pulsions, des souvenirs, de la créativité, du savoir-faire et des connaissances.', 'Percevoir et respecter l’autre dans sa spécificité et pour ce qu’il est de mieux. Se dégager des préjugés. Dégager le sens second d’un message.'),
(6, 2, 'A6', 'Approcher les arts issus d’autres cultures et milieux sociaux ou religieux. Dégager des relations avec les différentes valeurs, traditions et idéologies.', 'S’ouvrir avec tolérance à la diversité culturelle.\nSe mesurer par rapport à elle.'),
(7, 2, 'A7', 'S’ouvrir aux expériences esthétiques contemporaines de manière à les intégrer dans sa culture et ses intérêts.', 'S’ouvrir au monde d’aujourd’hui.'),
(8, 2, 'A8', 'Gérer ses choix culturels par confrontation et décodage des moyens de communication actuels (affiche, T.V., radio, cinéma, expositions, spots publicitaires, Internet) en les considérant comme sujets d’analyse.', 'S’ouvrir au changement.'),
(9, 2, 'C01', 'Dégager les caractères stylistiques essentiels d’une écriture audiovisuelle, d’une époque ou d’un style.', 'Capacité à observer, comparer, analyser et conceptualiser.'),
(10, 2, 'C10', 'Considérer comme indispensable ma fréquentation directe des milieux professionnels, des médiathèques, vidéothèques et cinémathèques, des galeries et musées afin de les connaitre dans leurs vraies dimensions spatiales, humaines et sensibles.', 'Se former aux sources du savoir.'),
(11, 1, 'C11', 'Connaitre les techniques de base des systèmes audiovisuels afin de pouvoir effectuer des choix pratiques judicieux.', 'Relier théorie, pratique et sens.'),
(12, 2, 'C02', 'Décrire l’enchainement et penser à relier l’apparition ou la résurgence des formes d’expression à leur contexte historique et social. Comprendre qu’elles s’y inscrivent, ou qu’elles peuvent être une rupture. Apprécier l’interaction dynamique entre ces différentes composantes et en quoi le créateur forge, définit, voire remet en question les valeurs et la sensibilité de la culture de telle ou telle société.', 'Inscrire les phénomènes dans la mesure du temps et de l’espace. Relier les phénomènes dans leur contemporanéité. Opérer des synthèses. Etablir les connexions interdisciplinaires.'),
(13, 2, 'C03', 'Comparer les œuvres du présent et du passé, dégager des correspondances et les convergences fortuites, déceler les influences, apprécier l’impact d’une œuvre à court terme et à long terme, prendre conscience des ruptures, donner du sens.', 'Relier les expressions entre elles pour en dégager du sens.'),
(14, 2, 'C04', 'Connaitre les méthodes d’approche sémiologique et sémantique de base appliquées à la communication (figures et procédés stylistiques, tropes, injonction, redondance…)', 'Démultiplier les méthodologies de la connaissance afin d’en percevoir le sens relatif et complémentaire. Montrer que la vérité n’est pas une.'),
(15, 1, 'C05', 'Tout en proscrivant le jargon, user d’un vocabulaire précis, nuancé et spécifique à l’égard des techniques employées. Assumer de cette façon la richesse du langage professionnel.', 'Exprimer sa pensée clairement pour communiquer. Apprendre à argumenter.'),
(16, 4, 'C06', 'Situer les diverses interventions des acteurs de la production audiovisuelle l’une par rapport à l’autre (chronologie, rôles et interférences).', 'Mesurer la solidarité des intervenants dans tout processus de pensée collective et de production.'),
(17, 1, 'C07', 'Comprendre l’esprit et la logique des différents outils, supports et médias en usage dans le domaine de la communication audiovisuelle.', 'Travailler logiquement dans l’esprit des moyens mis en œuvre ou choisir les moyens en fonction de l’objectif poursuivi.'),
(18, 2, 'C08', 'Connaitre de manière critique les principaux ressorts psychologiques agissant à l’intérieur des œuvres médiatiques ou audiovisuelles.', 'Tenir compte de l’altérité.\nComprendre que toute communication met en jeu des phénomènes psychologiques.'),
(19, 2, 'C09', 'Apprendre à se documenter, à recueillir des témoignages, à recouper son information et à s’informer, en particulier sur l’actualité, l’évolution des médias et des productions audiovisuelles (usage des encyclopédies, des bibliothèques, des médiathèques, des tables des matières, des corrélats, des productions de la presse écrite, des CD-ROM, d’Internet, des dossiers de presse…)', 'Apprendre à apprendre.\nRespecter la déontologie élémentaire de l’information et de la communication.'),
(20, 3, 'E1', 'Positionner ses ambitions expressives soit comme tentative de restitution objective de la réalité, soit comme écart entre cette réalité et une manière personnelle de regarder le monde.', 'Assumer vision (relativement) objective ou délibérément subjective.'),
(21, 2, 'E2', 'Regarder activement le monde extérieur pour donner à voir et/ou à entendre ce qui échappe à la perception commune.', 'Cultiver le regard personnel sur le monde.'),
(22, 3, 'E3', 'Conférer à l’activité audiovisuelle le statut de lieu de critique et d’écart par rapport à la norme, marquant ainsi la puissance créatrice de l’individu responsable s’identifiant à une création personnelle et « s’écrivant » à travers elle.', 'Affirmer sa personnalité.'),
(23, 3, 'E4', 'Dégager des clés pratiques constituant autant d’outils favorisant la créativité (cadrer, monter, éclairer, filtrer, superposer…) et développant l’imagination.', 'Structurer l’imagination créatrice.'),
(24, 3, 'E5', 'Transposer dans un autre registre visuel, sonore ou audiovisuel, déplacer dans un autre domaine de l’expression une première expérience formelle.', 'Opérer des transferts.'),
(25, 3, 'E6', 'Pouvoir tirer profit des hasards, convertir les erreurs, utiliser l’inattendu et détourner les choses de leurs fonctions habituelles.', 'S’adapter et faire son profit de tout. Se montrer créatif et disponible au changement.'),
(26, 3, 'E7', 'Etre capable de détourner un objet ou une image du sens convenu pour lequel il a été fait et se l’approprier en lui donnant un sens nouveau, inattendu et signifiant.', 'Faire preuve d’invention et de créativité.'),
(27, 3, 'E8', 'Exprimer son appréciation sur une œuvre audiovisuelle, justifier ses goûts et en dégager l’intérêt relatif.', 'Confronter ses démarches et ses expériences à celles de l’autre dans le respect réciproque et la tolérance.'),
(28, 3, 'F01', 'Construire le jugement éclairé en structurant la pensée critique (tant vis-à-vis de ses propres réalisations que de celles des autres) et permettre d’échanger ses raisons d’aimer en argumentant.', 'Communiquer clairement à l’aide de moyens logiquement appropriés et en y apportant les exigences d’autocorrection.'),
(29, 1, 'F10', 'Pouvoir utiliser les fonctions de base des logiciels les plus courant dans les domaines de la photographie et de l’audiovisuel.', 'Etre ouvert aux nouvelles technologies appliquées à la communication.'),
(30, 1, 'F11', 'Développer une curiosité pour l’évolution des nouvelles techniques audiovisuelles, être disponible à se les approprier, s’y adapter et à transférer les acquis potentiels dans l’acte de conception lui-même.', 'Manifester de l’intérêt et de la curiosité pour le renouvellement.'),
(31, 1, 'F02', 'Assurer une relative aisance dans la manipulation du matériel audiovisuel de manière à préparer le travail créatif.', 'Exigence personnelle de s’approprier des moyens d’expression et de les utiliser avec aisance.'),
(32, 3, 'F03', 'Etablir des rapports visuels (cadrage, lumières, couleurs, contrastes, raccords, profondeur de champs, mouvement du sujet et de la caméra…), temporels (rythmes, longueur et succession de séquences…), sonores (intensité, timbre, coloration, fréquences, mixage…), parlés (dialogue, timbre, respiration…) et narratifs de manière cohérente en les articulant sur une intention formelle ou expressive structurante.', 'Relier les éléments d’un problème et structurer la pensée créatrice.'),
(33, 3, 'F04', 'Etablir et pouvoir nuancer ses partis pris formels ou expressifs.', 'Témoigner du sens de la nuance et de la sensibilité.'),
(34, 1, 'F05', 'Manipuler et expérimenter les techniques argentiques, analogiques et numériques ainsi que la diversité des émulsions et des outils (tout support de traitement de l’image) en les considérant comme des éléments de production et de recherche.', 'Expérimenter et développer l’aptitude à la réflexion avant, pendant et/ou après l’action.'),
(35, 3, 'F06', 'Mettre en corrélation, observer, écouter, penser et produire (dans le sens de produire dans un champ d’application audiovisuel), articuler ainsi la forme et le contenu, le geste et le sens, l’outil et la pensée, l’œuvre et le soi.', 'Structurer logiquement sa pensée dans le codage et le décodage de l’expression et de la communication.'),
(36, 4, 'F07', 'Prendre en compte des contraintes externes (cadre scolaire et/ou autre, économie des moyens, conventions, consignes, délais…) ou internes (logique des techniques) dans la structuration du travail audiovisuel.', 'S’adapter aux circonstances, faire preuve de créativité au travers de disciplines et de contraintes voulues ou non.'),
(37, 4, 'F08', 'Participer à des projets collectifs ou multidisciplinaires en y apportant son savoir-faire et en se pliant à la discipline qu’impose l’unité globale d’expression ou d’intention qui les justifie.', 'S’engager et s’intégrer dans un projet, une décision collégiale ou un travail collectif. Travailler en équipe. Pratiquer la tolérance et accepter l’autre. Mener à bien une entreprise commune même si elle n’agrée pas complètement la personne.'),
(38, 4, 'F09', 'Organiser son travail en fonction d’un projet choisi ou imposé en y développant ses capacités d’initiative.', 'Développer le sens des responsabilités.'),
(39, 3, 'R1', 'Etablir des rapports de grandeur, de position, de correspondance, de rythme, de proportion, de caractère, de couleurs… au sein de documents visuels et audio visuels.', 'Communiquer clairement à l’aide de moyens logiquement appropriés et en y apportant les exigences d’autocorrection.'),
(40, 3, 'R2', 'Pouvoir justifier le choix d’un cadrage ou d’une composition relativement à la scène, au document, au thème ou à l’objet observé.\nInterpréter l’œuvre audiovisuelle comme un système de signes dont il convient d’objectiver les relations (forme et expression).', 'Dépasser l’esthétisme Poser la question du sens'),
(41, 3, 'R3', 'Distinguer ce qui relève de la dénotation et de la connotation dans l’approche d’une image ou d’un document pour pouvoir établir une analyse aussi objective que possible.', 'Séparer l’objectif du subjectif dans la perception.'),
(42, 2, 'R4', 'Percevoir à travers quelques œuvres majeures du cinéma, de la photographie et des productions musicales et audiovisuelles les récurrences formelles qui caractérisent le style d’un metteur en scène, d’un artiste ou d’une époque.', 'Analyser, synthétiser et globaliser les données sensibles de la perception.');

-- --------------------------------------------------------

--
-- Structure de la table `skills_group`
--

DROP TABLE IF EXISTS `skills_group`;
CREATE TABLE IF NOT EXISTS `skills_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `skills_group`
--

INSERT INTO `skills_group` (`id`, `name`, `short_name`) VALUES
(1, 'Techniques et technologies', 'T'),
(2, 'Analyse', 'A'),
(3, 'Communication et expression', 'E'),
(4, 'Gestion et Organisation', 'O');

-- --------------------------------------------------------

--
-- Structure de la table `student_classe`
--

DROP TABLE IF EXISTS `student_classe`;
CREATE TABLE IF NOT EXISTS `student_classe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `classe_id` int(11) NOT NULL,
  `schoolyear` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1B16716CB944F1A` (`student_id`),
  KEY `IDX_1B167168F5EA509` (`classe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `student_classe`
--

INSERT INTO `student_classe` (`id`, `student_id`, `classe_id`, `schoolyear`) VALUES
(1, 2, 2, '2020-2021'),
(2, 3, 2, '2020-2021'),
(3, 3, 1, '2019-2020'),
(4, 2, 2, '2019-2020'),
(5, 6, 1, '2020-2021'),
(6, 7, 1, '2020-2021'),
(7, 8, 1, '2020-2021'),
(8, 9, 1, '2020-2021'),
(9, 10, 1, '2020-2021'),
(10, 11, 1, '2020-2021'),
(11, 12, 1, '2020-2021'),
(12, 13, 1, '2020-2021'),
(13, 14, 1, '2020-2021'),
(14, 15, 1, '2020-2021'),
(15, 16, 1, '2020-2021'),
(16, 17, 1, '2020-2021'),
(17, 18, 1, '2020-2021'),
(18, 19, 3, '2020-2021'),
(19, 20, 3, '2020-2021'),
(20, 21, 3, '2020-2021'),
(21, 22, 3, '2020-2021'),
(22, 23, 3, '2020-2021'),
(23, 24, 3, '2020-2021'),
(24, 25, 1, '2020-2021'),
(25, 26, 3, '2020-2021'),
(26, 27, 3, '2020-2021'),
(27, 28, 3, '2020-2021'),
(28, 29, 4, '2020-2021'),
(29, 30, 4, '2020-2021'),
(30, 31, 4, '2020-2021'),
(31, 32, 4, '2020-2021'),
(32, 33, 4, '2020-2021'),
(33, 34, 4, '2020-2021'),
(34, 35, 4, '2020-2021'),
(35, 36, 4, '2020-2021'),
(36, 37, 4, '2020-2021'),
(37, 38, 4, '2020-2021'),
(38, 39, 4, '2020-2021'),
(39, 40, 4, '2020-2021'),
(40, 41, 4, '2020-2021');

-- --------------------------------------------------------

--
-- Structure de la table `submission`
--

DROP TABLE IF EXISTS `submission`;
CREATE TABLE IF NOT EXISTS `submission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DB055AF3CB944F1A` (`student_id`),
  KEY `IDX_DB055AF3166D1F9C` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `submission`
--

INSERT INTO `submission` (`id`, `student_id`, `project_id`, `datetime`) VALUES
(1, 6, 5, '2020-10-06 11:29:49');

-- --------------------------------------------------------

--
-- Structure de la table `submission_file`
--

DROP TABLE IF EXISTS `submission_file`;
CREATE TABLE IF NOT EXISTS `submission_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `mime` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int(11) DEFAULT NULL,
  `public` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1E995D7FE1FD4933` (`submission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `submission_file`
--

INSERT INTO `submission_file` (`id`, `submission_id`, `url`, `updated_at`, `mime`, `image_size`, `public`) VALUES
(1, 1, 'COLLE_Valentine_Lightpainting_0.jpeg', '2020-10-06 15:15:33', 'image/jpeg', 214809, 1),
(2, 1, 'COLLE_Valentine_Lightpainting_1.jpeg', '2020-10-06 15:15:33', 'image/jpeg', 980491, 1),
(3, 1, 'COLLE_Valentine_Lightpainting_2.jpeg', '2020-10-06 15:15:33', 'image/jpeg', 114681, 1);

-- --------------------------------------------------------

--
-- Structure de la table `term`
--

DROP TABLE IF EXISTS `term`;
CREATE TABLE IF NOT EXISTS `term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `term`
--

INSERT INTO `term` (`id`, `name`, `description`) VALUES
(1, 'P1', 'Période 1'),
(2, 'EXDEC', 'Examens de décembre'),
(3, 'P2', 'Période 2'),
(4, 'P3', 'Période 3'),
(5, 'EXJUN', 'Examens Juin');

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `topic`
--

INSERT INTO `topic` (`id`, `name`, `description`) VALUES
(1, 'Image', 'L\'image'),
(2, 'Lumière', 'La lumière'),
(3, 'Son', 'Le son'),
(4, 'Almd', 'À la manière de...'),
(5, 'Communication', 'La communication');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `motto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `first_name`, `last_name`, `motto`, `avatar_url`, `email`, `active`, `updated_at`) VALUES
(1, 'pierre.helin', '[\"ROLE_ADMIN\", \"ROLE_TEACHER\"]', '$argon2id$v=19$m=65536,t=4,p=1$VXlUUnp1MkpHVmJ3aEdQdQ$rCOuZX1ZyKrVI4BHmCaQFtWjIgFnxgcRSiUnmyicJZA', 'Pierre', 'Hélin', NULL, NULL, NULL, 1, NULL),
(2, 'john.doe', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$NzgxSENtNnowZG03cjhTNw$bsrCplSak+ej4vjHwyvmHSC9OvdVodcptMQIno4kGVQ', 'John', 'Doe', NULL, NULL, NULL, 1, NULL),
(3, 'jane.doe', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$NzgxSENtNnowZG03cjhTNw$bsrCplSak+ej4vjHwyvmHSC9OvdVodcptMQIno4kGVQ', 'Jane', 'Doe', NULL, NULL, NULL, 1, NULL),
(6, 'valentine.colle', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$aklkZE1IWUxqZ2tacHNZbg$XfPmNZWNUgsaionQ8r6jTJ1AXXyQk7edfsiwmuyBwiY', 'Valentine', 'Colle', 'C\'est quoi?', 'COLLE_Valentine.jpeg', '', 1, '2020-10-07 15:07:13'),
(7, 'wyatt.devillers', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$MjFoNlRJTEdwMDYveWQzRQ$zXHyzKTLO1NMdgSAmnY8W/K8DugVCf6K82cpCh64Glc', 'Wyatt', 'Devillers', NULL, NULL, '', 1, NULL),
(8, 'loic.dieudonne', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$YzdEbkluc29GendGYnNGaQ$8A9EuTobFyWDQZJH7mM2kKK0z57RcrlxVkrajG3HbpM', 'Loic', 'Dieudonne', NULL, NULL, '', 1, NULL),
(9, 'elea.gilis', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$VUpkOW9QRHpQL1JidktYQg$j1Jfq/1DWhF6aE7g2MrviQPtvMZpLyZVE7PtpplP9Wg', 'Éléa', 'Gilis', NULL, NULL, '', 1, NULL),
(10, 'romane.gregoire', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$UXVvYlh3YXJ0YUJRYURjUw$Vi8eJN6fidyZPH9bgpKhNabpOcUrkXBRJh/BJCWL9qs', 'Romane', 'Grégoire', NULL, NULL, '', 1, NULL),
(11, 'tom.jacques', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$L0x4NjlzWEhncHJXMUcxNw$QQ+UGqfbkY5gLiByLLElEsVVgDMFPmCCxdCcd/nr86Q', 'Tom', 'Jacques', NULL, NULL, '', 1, NULL),
(12, 'thalia.krier', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$dWpFYnFZbTY2Q29EcG50Yg$Z3QjrbRjsHNnW/qItv6IJSaqg6HpqHNtV2v23ElxNXo', 'Thalia', 'Krier', NULL, NULL, '', 1, NULL),
(13, 'elea.lambay', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$NW9kZUNXZEFVd3JXRXBCTg$lULgeZ8MzCEaV2gdvcdY/J1jCoEGZj6BvOQWUB1byP4', 'Éléa', 'Lambay', NULL, NULL, '', 1, NULL),
(14, 'hugo.magits', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$aVZHRTUxUUlPS1dOd0IzdQ$oviM+aWfzvkNB0h+CRv4lXJxyoh3yL48AHMWPRCJ9es', 'Hugo', 'Magits', NULL, NULL, '', 1, NULL),
(15, 'amaury.mathieu', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$YmpadGFQck1raTRBY1VjNg$Hg/B/mfi+FiBXVperyoUDjasSB4swVxjMGN08ENzqmw', 'Amaury', 'Mathieu', NULL, NULL, '', 1, NULL),
(16, 'isalyne.poulet', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$NHp5UlJEZzlEZTBBTFhvQQ$kMpehRgfdWg4TheFYcfikT1goU54cyj4yWaQIxx3DjI', 'Isalyne', 'Poulet', NULL, NULL, '', 1, NULL),
(17, 'louis.tancre', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$akppRDlpNFpScnVxT0p4UA$z+MXoyN6apNFR+TVfU7i/luzHqOxHWPUDB5WdU0F6MA', 'Louis', 'Tancre', NULL, NULL, '', 1, NULL),
(18, 'najiallah.temsamani', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$eE41dGJVcGN5VjdsZTBkSQ$h5RAjHE8TxwuGsRHo64q0j4XWqfjBqepIQsCs3PiJ+I', 'Najiallah', 'TEMSAMANI', NULL, NULL, '', 1, NULL),
(19, 'jason.allarding', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$YzFLSEMzSmhBY3QwV2Y3aw$2qj4P780dofnuCeKvANxISrbyPcPtGFxzV6YOqdeMfU', 'Jason', 'ALLARDING', NULL, NULL, '', 1, NULL),
(20, 'edouard.callens', '[\"ROLE_STUDENT\"]', '', 'Edouard', 'CALLENS', NULL, NULL, '', 1, NULL),
(21, 'edgard.claereboudt', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$M3RwTFhjRXgycmF3bHJmeQ$BjPCZHuQ8F6llFcxqwwOgJ+l01fzVq8sOmo0YVO63M0', 'Edgard', 'CLAEREBOUDT', NULL, NULL, '', 1, NULL),
(22, 'lucas.fenn', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$RjZvd0t4a0pHcTJYUnhwZw$A08g44EhVfVBW+25VucaJUjA4VnU5RcY5vI32QX6Gw0', 'Lucas', 'FENN', NULL, NULL, '', 1, NULL),
(23, 'coralie.gobeau', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$ODA4aDFoQ1Z1QTZKaktVUg$Q8seHbxShdZDKe8Ca0iU1tVqZMUyveQCdbLsxke9rNY', 'Coralie', 'GOBEAU', NULL, NULL, '', 1, NULL),
(24, 'emily.selmeci', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$R1pTbFJCbzdkTy5iaXZuQQ$Ar/g44d9SJ1jJ7aYGT+XMcuuDBUcJIjPg2K/3kqLSM0', 'Emily', 'SELMECI', NULL, NULL, '', 1, NULL),
(25, 'edouardo.souza gomez', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$VU12MTJZMFZwYXdGem5scg$DAn2SJMXc00olL+QWrLYdrGAQ1Jm5bsoaXX5DxEufKg', 'Edouardo', 'SOUZA GOMEZ', NULL, NULL, '', 1, NULL),
(26, 'edouardo.souzagomez', '[\"ROLE_STUDENT\"]', '', 'Edouardo', 'SOUZAGOMEZ', NULL, NULL, '', 1, NULL),
(27, 'abdallah.sungura', '[\"ROLE_STUDENT\"]', '', 'Abdallah', 'SUNGURA', NULL, NULL, '', 1, NULL),
(28, 'angelika.szymanowska', '[\"ROLE_STUDENT\"]', '', 'Angelika', 'SZYMANOWSKA', NULL, NULL, '', 1, NULL),
(29, 'arthur.barbiaux', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$dS41MkdWS1pnMlYvbkFqcg$ORxOHyy+g9WM+GeXkVtpmRmNc/dM6mUK2JQuH4NIkO0', 'Arthur', 'BARBIAUX', NULL, NULL, '', 1, NULL),
(30, 'anthony.bellia', '[\"ROLE_STUDENT\"]', '', 'Anthony', 'BELLIA', NULL, NULL, '', 1, NULL),
(31, 'alicia.dustin', '[\"ROLE_STUDENT\"]', '', 'Alicia', 'DUSTIN', NULL, NULL, '', 1, NULL),
(32, 'jamy.evereats', '[\"ROLE_STUDENT\"]', '', 'Jamy', 'EVEREATS', NULL, NULL, '', 1, NULL),
(33, 'jackub.flis', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$SlZELkI5T1JpTFo1YnpWLg$b3U56bRmTCqlX8fH93/jJ/YVv21+ze6+iKYYtlmO2jE', 'Jackub', 'FLIS', NULL, NULL, '', 1, NULL),
(34, 'edward.hage', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$U1NuS2todGlnT29jLy84NQ$H4r1QcRS1LD9hCpS0BdazVTHeN+XRA5vtwFzSiwCYkw', 'Edward', 'HAGE', NULL, NULL, '', 1, NULL),
(35, 'kevin.hejda', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$WWpEMlNKSUEybWxuUHN6UA$uguUmeWOVcTmd/27yoZP6MO2RXMbch5cJY+aLfu41G8', 'Kevin', 'HEJDA', NULL, NULL, '', 1, NULL),
(36, 'matteo.levi', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$WWFPYkt6bDN3eG9ENHVCMg$KafC6tqLBMQw8Ngq4Cc19JCvdzd7mG1gaxvfxdmxbNk', 'Mattéo', 'LEVI', NULL, NULL, '', 1, NULL),
(37, 'pierre.meert', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$Yk5xOU1JRUlkRnovNkdkSg$1Lf2t4+9Ty4f2JSYwOEIP1by1HlHTJCeN//s3g9kImE', 'Pierre', 'MEERT', NULL, NULL, '', 1, NULL),
(38, 'mattheo-hubert.merino', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$ejZVZ2ZXVFN6Z0t3UU9QYg$VIGKwUT7QRlLtByZK8wCiaR2fH7BICfWNshErRBg7GY', 'Mattheo-Hubert', 'MERINO', NULL, NULL, '', 1, NULL),
(39, 'simon.noel', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$dW9sY3k4TERHNGQ4SDRGcw$lwpmFEThQR6UZoPJEXRnh3/7H0NnRRF20nAGLWxG6Og', 'Simon', 'NOEL', NULL, NULL, '', 1, NULL),
(40, 'pierre.tatti', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$aXNRaDgzWnNsU09ZRjFyRg$x2/JxCw7EYM48C2xA4/w4fC6ARwzdjzaSyGYh3ivcPo', 'Pierre', 'TATTI', NULL, NULL, '', 1, NULL),
(41, 'guy-daniel.zanella', '[\"ROLE_STUDENT\"]', '$argon2id$v=19$m=65536,t=4,p=1$amozV1lpY0dnUktlRklsLg$uGt+UPSwv9O0W/ZykYHd+a70iyWaWqFGehg35OrukdQ', 'Guy-Daniel', 'ZANELLA', NULL, NULL, '', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_achievement`
--

DROP TABLE IF EXISTS `user_achievement`;
CREATE TABLE IF NOT EXISTS `user_achievement` (
  `user_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`achievement_id`),
  KEY `IDX_3F68B664A76ED395` (`user_id`),
  KEY `IDX_3F68B664B3EC99FE` (`achievement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_avatar`
--

DROP TABLE IF EXISTS `user_avatar`;
CREATE TABLE IF NOT EXISTS `user_avatar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_73256912A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_avatar`
--

INSERT INTO `user_avatar` (`id`, `user_id`, `updated_at`, `image_name`) VALUES
(5, 6, '2020-10-07 16:04:21', 'COLLE_Valentine.jpeg'),
(6, 1, '2020-10-10 13:51:15', 'HELIN_Pierre.png');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `FK_F7523D70166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `FK_F7523D701F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  ADD CONSTRAINT `FK_F7523D705585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`),
  ADD CONSTRAINT `FK_F7523D7097766307` FOREIGN KEY (`criterion_id`) REFERENCES `criterion` (`id`),
  ADD CONSTRAINT `FK_F7523D70B3EC99FE` FOREIGN KEY (`achievement_id`) REFERENCES `achievement` (`id`),
  ADD CONSTRAINT `FK_F7523D70E383D86E` FOREIGN KEY (`grading_system_id`) REFERENCES `grading_system` (`id`);

--
-- Contraintes pour la table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `FK_6DE30D912B368697` FOREIGN KEY (`attendance_grid_id`) REFERENCES `attendance_grid` (`id`),
  ADD CONSTRAINT `FK_6DE30D91CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `attendance_grid`
--
ALTER TABLE `attendance_grid`
  ADD CONSTRAINT `FK_16FE044241807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_16FE0442591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`);

--
-- Contraintes pour la table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `FK_169E6FB941807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_169E6FB98F5EA509` FOREIGN KEY (`classe_id`) REFERENCES `classe` (`id`);

--
-- Contraintes pour la table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `FK_2FB3D0EE41807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_2FB3D0EE591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  ADD CONSTRAINT `FK_2FB3D0EE6FB21D5D` FOREIGN KEY (`assessment_type_id`) REFERENCES `assessment_type` (`id`),
  ADD CONSTRAINT `FK_2FB3D0EEE2C35FC` FOREIGN KEY (`term_id`) REFERENCES `term` (`id`);

--
-- Contraintes pour la table `project_self_assessment_question`
--
ALTER TABLE `project_self_assessment_question`
  ADD CONSTRAINT `FK_DFCAB2A3166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DFCAB2A3C91D5A2B` FOREIGN KEY (`self_assessment_question_id`) REFERENCES `self_assessment_question` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `project_skill`
--
ALTER TABLE `project_skill`
  ADD CONSTRAINT `FK_4D68EDE9166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4D68EDE95585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `FK_136AC113CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_136AC113DD3DD5F1` FOREIGN KEY (`assessment_id`) REFERENCES `assessment` (`id`);

--
-- Contraintes pour la table `self_assessment_answer`
--
ALTER TABLE `self_assessment_answer`
  ADD CONSTRAINT `FK_1BA1F6D6166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `FK_1BA1F6D6CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `self_assessment_question`
--
ALTER TABLE `self_assessment_question`
  ADD CONSTRAINT `FK_4BB1C5EB41807E1D` FOREIGN KEY (`teacher_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `skill`
--
ALTER TABLE `skill`
  ADD CONSTRAINT `FK_5E3DE477D6044424` FOREIGN KEY (`skills_group_id`) REFERENCES `skills_group` (`id`);

--
-- Contraintes pour la table `student_classe`
--
ALTER TABLE `student_classe`
  ADD CONSTRAINT `FK_1B167168F5EA509` FOREIGN KEY (`classe_id`) REFERENCES `classe` (`id`),
  ADD CONSTRAINT `FK_1B16716CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `submission`
--
ALTER TABLE `submission`
  ADD CONSTRAINT `FK_DB055AF3166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `FK_DB055AF3CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `submission_file`
--
ALTER TABLE `submission_file`
  ADD CONSTRAINT `FK_1E995D7FE1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`);

--
-- Contraintes pour la table `user_achievement`
--
ALTER TABLE `user_achievement`
  ADD CONSTRAINT `FK_3F68B664A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3F68B664B3EC99FE` FOREIGN KEY (`achievement_id`) REFERENCES `achievement` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_avatar`
--
ALTER TABLE `user_avatar`
  ADD CONSTRAINT `FK_73256912A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
