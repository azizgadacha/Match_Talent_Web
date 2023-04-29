-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 avr. 2023 à 20:34
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `oxidus`
--

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE `agence` (
  `id_agence` int(11) NOT NULL,
  `nomAgence` varchar(50) NOT NULL,
  `nbreVehicule` int(11) NOT NULL,
  `emailAg` varchar(50) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`id_agence`, `nomAgence`, `nbreVehicule`, `emailAg`, `ville`, `adresse`) VALUES
(2, 'esprit', 20, 'esprit@gmail.com', 'ariana', 'ghazela'),
(4, 'mtn', 8733, 'gmail.com', 'douala', 'pk10'),
(5, 'yela', 65, 'michelscoot@gmail.com', 'sousse', 'el bassorah'),
(6, 'hh', 55, 'kjdbhai@gmail.com', 'ariana', 'ariana'),
(7, 'hamma', 55, '29883869', 'ariana', 'ariana'),
(8, 'lkfja', 654, '+21629883869', 'vz', 'fa'),
(9, 'ifugz', 2, '+21629883869', 'fafa', 'fafa'),
(10, 'mglkjsmd', 2, 'gmkql', 'mlkgjs', 'gmlskj'),
(11, 'kfjqh:m', 2, 'mlkmk', 'aaa', 'mlkm'),
(12, 'aaa', 2, 'aaa', 'aaa', 'aaa'),
(13, 'leee', 2, 'wlh le', 'vldk', 'nn'),
(14, 'yessine', 2, 'wlh le', 'vldk', 'nn'),
(15, 'jjj', 4, 'aziz.skhiri@esprit.tn', 'ariana', 'goulette'),
(16, 'yessine', 2, 'yessine@esprit.tn', 'ariana', 'halk el wed'),
(17, 'yesssinesensi', 2, 'yesssine@hotmail.fr', 'ariana', 'ariana'),
(18, 'hosni', 4, 'yassine.benjaber@esprit.tn', 'goulette', 'gabes'),
(19, 'jjjjj', 4, 'jjjjj@esprit.tn', 'ggggg', 'ggg'),
(20, 'mecancien', 6, 'mecancien@hotmail.com', 'Gabes', 'yassine.benjaber@esprit.tn'),
(21, 'yassine', 5, 'yassine.benjaber@esprit.tn', 'Gabes', 'goulette');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id_reclamation` int(11) NOT NULL,
  `message_rec` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`id_reclamation`, `message_rec`, `type`, `statut`) VALUES
(9, 'jjj', 'jjjjj', 'jjj'),
(10, 'aaa', 'sss', 'sss'),
(13, 'hhhhh', 'hdhdh', 'user'),
(14, 'jj', 'hh', 'gg'),
(15, 'yyy', 'hhh', 'hhh'),
(17, 'dd', 'ff', 'dd'),
(18, 'hhjjh', 'hhhhh', 'bbb'),
(19, 'njjo', 'johi', 'hihi'),
(20, 'kkk', 'jjjj', 'hhh'),
(21, 'sss', 'sss', 'sss'),
(22, 'aaa', 'aaa', 'aaa'),
(23, 'ddd', 'ddd', 'ddd'),
(24, 'ggg', 'gggg', 'gggg'),
(25, 'aaaaaaaaa', 'bbbbbb', 'gggg'),
(26, 'ppp', 'ppp', 'pppp'),
(28, 'jhhfe', 'kikk', 'kjhh'),
(29, 'kj', 'kjd', 'lk');

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE `reponse` (
  `id_reponse` int(11) NOT NULL,
  `id_reclamation` int(11) NOT NULL,
  `message_rep` varchar(1000) NOT NULL,
  `date_rep` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reponse`
--

INSERT INTO `reponse` (`id_reponse`, `id_reclamation`, `message_rep`, `date_rep`) VALUES
(11, 10, 'bbbb', '2023-03-03'),
(34, 13, 'fffff', '2023-03-07');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(11) NOT NULL,
  `id_voiture` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nom_user` varchar(50) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `prix` int(11) NOT NULL,
  `modele` varchar(50) NOT NULL,
  `email_user` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `id_voiture`, `id_user`, `nom_user`, `date_debut`, `date_fin`, `prix`, `modele`, `email_user`, `status`) VALUES
(1, 3, 4, 'michel', '2023-03-01', '2023-03-01', 300, 'PORSH', 'michelscoot@gmail.com', 'ANNULER'),
(3, 3, 4, 'zae', '2023-03-03', '2023-03-03', -1, 'TOTOYA', 'workesprit22@gmail.com', 'EN COURS'),
(4, 3, 4, 'yre', '2023-03-10', '2023-03-10', -1, 'TOTOYA', 'michelscoot@gmail.com', 'ANNULER'),
(5, 3, 4, 'azer', '2023-03-11', '2023-03-11', 300, 'NISSAN', 'michelscoot@gmail.com', 'EN ATTENTE'),
(6, 3, 4, 'hasni bchara', '2023-03-14', '2023-03-14', 300, 'NISSAN', 'yassine.benjaber@esprit.tn', 'EN ATTENTE'),
(7, 3, 4, 'wajdi', '2023-03-15', '2023-03-15', 300, 'NISSAN', 'wajdi@hotmail.fr', 'EN ATTENTE');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `idu` int(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `idu`, `Nom`, `date_debut`, `date_fin`) VALUES
(257, 32, 'ki', '2023-02-21 05:46:00', '2023-02-21 05:46:08'),
(258, 33, 'gaddour', '2023-02-21 05:51:19', '2023-02-21 05:51:21'),
(260, 33, 'gaddour', '2023-02-21 05:54:32', '2023-02-21 05:54:36'),
(261, 32, 'ki', '2023-02-21 05:55:50', '2023-02-21 05:55:54'),
(262, 33, 'gaddour', '2023-02-21 06:04:15', '2023-02-21 06:04:19'),
(287, 33, 'mohamed', '2023-02-21 23:18:26', NULL),
(288, 32, 'ki', '2023-02-21 23:21:07', NULL),
(289, 20, '1', '2023-02-21 23:26:16', '2023-02-21 23:26:19'),
(290, 32, 'ki', '2023-02-21 23:26:33', '2023-02-21 23:26:36'),
(291, 33, 'mohamed', '2023-02-21 23:26:48', NULL),
(292, 20, '1', '2023-02-21 23:28:41', '2023-02-21 23:28:50'),
(293, 32, 'ki', '2023-02-21 23:29:00', '2023-02-21 23:29:03'),
(294, 33, 'mohamed', '2023-02-21 23:29:30', NULL),
(295, 20, '1', '2023-02-21 23:33:29', NULL),
(296, 20, '1', '2023-02-21 23:45:04', NULL),
(297, 33, 'mohamed', '2023-02-21 23:45:36', NULL),
(298, 32, 'ki', '2023-02-21 23:45:56', '2023-02-21 23:45:58'),
(299, 20, '1', '2023-02-21 23:46:02', NULL),
(300, 20, '1', '2023-02-21 23:48:33', NULL),
(301, 20, '1', '2023-02-21 23:49:37', NULL),
(302, 20, '1', '2023-02-21 23:50:01', NULL),
(303, 20, '1', '2023-02-21 23:53:07', NULL),
(304, 20, '1', '2023-02-21 23:53:27', NULL),
(305, 20, '1', '2023-02-21 23:54:23', NULL),
(306, 20, '1', '2023-02-21 23:56:18', '2023-02-21 23:56:55'),
(307, 32, 'ki', '2023-02-21 23:58:01', '2023-02-21 23:58:05'),
(308, 33, 'mohamed', '2023-02-21 23:58:19', NULL),
(309, 20, '1', '2023-02-22 00:01:20', NULL),
(310, 20, '1', '2023-02-22 00:07:39', NULL),
(311, 20, '1', '2023-02-22 00:11:46', NULL),
(312, 20, '1', '2023-02-22 00:16:36', NULL),
(313, 20, '1', '2023-02-22 00:18:07', NULL),
(314, 20, '1', '2023-02-22 00:20:40', NULL),
(315, 20, '1', '2023-02-22 00:30:35', NULL),
(316, 20, '1', '2023-02-22 00:44:53', NULL),
(317, 20, '1', '2023-02-22 00:46:54', '2023-02-22 00:50:24'),
(318, 20, '1', '2023-02-22 00:58:00', '2023-02-22 00:58:03'),
(319, 33, 'mohamed', '2023-02-22 00:58:10', NULL),
(320, 32, 'ki', '2023-02-22 00:58:49', '2023-02-22 01:01:35'),
(321, 44, 'aboubakar', '2023-02-22 01:57:23', NULL),
(322, 33, 'mohamed', '2023-02-22 01:57:35', NULL),
(323, 20, '1', '2023-02-22 02:05:10', NULL),
(324, 20, '1', '2023-02-22 02:20:59', '2023-02-22 02:44:14'),
(325, 33, 'gadd', '2023-02-22 02:44:37', NULL),
(326, 33, 'gadd', '2023-02-22 02:59:27', NULL),
(327, 33, 'gadd', '2023-02-22 03:00:16', NULL),
(328, 33, 'gadd', '2023-02-22 03:01:26', NULL),
(329, 36, 'ali', '2023-02-22 03:04:09', '2023-02-22 03:05:53'),
(330, 33, 'gadd', '2023-02-22 03:17:20', NULL),
(331, 33, 'gadd', '2023-02-22 03:19:08', NULL),
(332, 33, 'gadd', '2023-02-22 03:19:50', NULL),
(333, 33, 'gadd', '2023-02-22 03:20:32', NULL),
(334, 20, '1', '2023-02-22 13:53:22', '2023-02-22 13:54:17'),
(335, 20, '1', '2023-02-22 13:54:33', '2023-02-22 13:59:10'),
(336, 33, 'gadd', '2023-02-22 14:05:43', NULL),
(337, 32, 'ki', '2023-02-22 14:07:35', '2023-02-22 14:07:39'),
(338, 48, 'aveyro', '2023-02-22 14:11:36', '2023-02-22 14:11:38'),
(339, 32, 'ki', '2023-02-22 14:41:42', NULL),
(340, 32, 'ki', '2023-02-22 14:50:00', NULL),
(341, 32, 'ki', '2023-02-22 14:52:38', NULL),
(342, 32, 'ki', '2023-02-22 14:56:55', NULL),
(343, 32, 'ki', '2023-02-22 14:57:50', NULL),
(344, 32, 'ki', '2023-02-22 15:02:21', NULL),
(345, 32, 'ki', '2023-02-22 15:04:35', NULL),
(346, 32, 'ki', '2023-02-22 15:13:30', NULL),
(347, 32, 'ki', '2023-02-22 15:17:12', NULL),
(348, 32, 'ki', '2023-02-22 15:29:58', NULL),
(349, 32, 'ki', '2023-02-22 15:30:53', NULL),
(350, 32, 'ki', '2023-02-22 15:31:57', NULL),
(351, 32, 'ki', '2023-02-22 15:32:45', NULL),
(352, 32, 'ki', '2023-02-22 15:33:11', NULL),
(353, 32, 'ki', '2023-02-22 15:34:40', NULL),
(354, 32, 'ki', '2023-02-22 15:43:35', NULL),
(355, 32, 'ki', '2023-02-22 15:46:23', NULL),
(356, 32, 'ki', '2023-02-22 16:09:35', NULL),
(357, 35, 'ichrak', '2023-02-22 16:17:53', NULL),
(358, 35, 'ichrak', '2023-02-22 16:30:52', NULL),
(359, 32, 'ka', '2023-02-22 16:32:26', NULL),
(360, 32, 'ka', '2023-02-22 16:35:28', NULL),
(361, 36, 'ali', '2023-02-22 16:38:08', NULL),
(362, 47, '3', '2023-02-22 16:42:54', NULL),
(363, 47, '3', '2023-02-22 16:43:16', NULL),
(364, 47, '3', '2023-02-22 16:54:31', NULL),
(365, 47, '3', '2023-02-22 16:57:03', NULL),
(366, 47, '3', '2023-02-22 16:57:14', NULL),
(367, 47, '3', '2023-02-22 16:58:24', NULL),
(368, 47, '3', '2023-02-22 17:00:57', NULL),
(369, 47, '3', '2023-02-22 17:01:35', NULL),
(370, 47, '3', '2023-02-22 17:08:52', NULL),
(371, 47, '3', '2023-02-22 17:12:34', NULL),
(373, 47, '3', '2023-02-22 17:30:03', NULL),
(374, 47, '3', '2023-02-22 17:35:48', NULL),
(375, 47, '3', '2023-02-22 17:36:58', NULL),
(376, 20, '1', '2023-02-22 17:37:39', '2023-02-22 17:39:07'),
(377, 47, '3', '2023-02-22 17:45:32', NULL),
(378, 47, '3', '2023-02-22 17:46:05', NULL),
(379, 47, '3', '2023-02-22 17:53:11', NULL),
(380, 47, '3', '2023-02-22 18:00:41', NULL),
(381, 47, '3', '2023-02-22 18:01:14', NULL),
(382, 47, '3', '2023-02-22 18:01:48', NULL),
(383, 47, '3', '2023-02-22 18:42:42', NULL),
(384, 47, '3', '2023-02-22 18:43:23', NULL),
(385, 47, '3', '2023-02-22 18:45:44', NULL),
(386, 47, '3', '2023-02-22 18:47:59', NULL),
(387, 20, '1', '2023-02-22 18:48:10', '2023-02-22 18:55:39'),
(388, 47, '3', '2023-02-22 19:10:39', NULL),
(389, 20, '1', '2023-02-22 19:11:03', '2023-02-22 19:11:06'),
(390, 20, '1', '2023-02-22 19:50:42', NULL),
(391, 20, '1', '2023-02-22 19:58:11', '2023-02-22 19:58:28'),
(392, 20, '1', '2023-02-22 19:58:35', NULL),
(393, 20, '1', '2023-02-28 23:22:57', '2023-02-28 23:24:53'),
(394, 20, '1', '2023-02-28 23:25:02', '2023-02-28 23:25:55'),
(395, 55, 'aziz', '2023-02-28 23:36:06', '2023-02-28 23:36:13'),
(396, 49, 'anis ', '2023-02-28 23:36:34', NULL),
(397, 56, 'aymen', '2023-02-28 23:39:44', NULL),
(398, 57, 'aymenn', '2023-02-28 23:40:28', NULL),
(399, 60, 'jabeur', '2023-03-01 00:26:22', NULL),
(400, 20, '1', '2023-03-01 00:27:07', NULL),
(401, 20, '1', '2023-03-01 00:32:16', NULL),
(402, 65, 'ehsen', '2023-03-01 00:56:19', NULL),
(403, 20, '1', '2023-03-01 00:57:05', NULL),
(404, 20, '1', '2023-03-01 00:58:14', NULL),
(405, 67, 'aziz', '2023-03-01 01:14:07', NULL),
(406, 67, 'aziz', '2023-03-01 01:21:57', NULL),
(407, 67, 'aziz', '2023-03-01 01:23:17', NULL),
(408, 68, 'aziz', '2023-03-01 01:30:24', NULL),
(409, 20, '1', '2023-03-01 01:35:28', NULL),
(410, 20, '1', '2023-03-01 01:36:27', NULL),
(411, 20, '1', '2023-03-01 01:37:33', NULL),
(412, 20, '1', '2023-03-01 01:41:13', NULL),
(413, 67, 'aziz', '2023-03-01 01:44:36', NULL),
(414, 62, 'admin', '2023-03-01 01:46:04', NULL),
(415, 69, 'aziz', '2023-03-01 09:28:51', NULL),
(416, 62, 'admin', '2023-03-01 09:29:13', NULL),
(417, 62, 'admin', '2023-03-01 14:44:23', NULL),
(418, 62, 'admin', '2023-03-01 15:45:13', NULL),
(419, 62, 'admin', '2023-03-01 15:45:54', NULL),
(420, 62, 'admin', '2023-03-01 15:46:32', NULL),
(421, 62, 'admin', '2023-03-01 18:15:52', '2023-03-01 18:18:28'),
(422, 60, 'jabeur', '2023-03-01 18:19:12', NULL),
(423, 62, 'admin', '2023-03-01 18:32:58', NULL),
(424, 62, 'admin', '2023-03-02 10:57:58', NULL),
(425, 62, 'admin', '2023-03-02 10:59:01', NULL),
(426, 62, 'admin', '2023-03-02 11:01:03', NULL),
(427, 62, 'admin', '2023-03-02 11:13:44', '2023-03-02 11:14:02'),
(428, 62, 'admin', '2023-03-02 11:18:58', NULL),
(429, 80, 'salma', '2023-03-02 11:50:15', NULL),
(430, 62, 'admin', '2023-03-02 11:50:28', '2023-03-02 11:51:53'),
(431, 64, 'sarra', '2023-03-02 11:52:49', '2023-03-02 11:52:55'),
(432, 62, 'admin', '2023-03-02 13:55:13', NULL),
(433, 62, 'admin', '2023-03-02 14:10:33', NULL),
(434, 62, 'admin', '2023-03-02 14:11:44', NULL),
(435, 62, 'admin', '2023-03-02 14:25:08', NULL),
(436, 62, 'admin', '2023-03-02 14:28:11', '2023-03-02 14:28:24'),
(437, 62, 'admin', '2023-03-02 14:28:34', NULL),
(438, 62, 'admin', '2023-03-02 14:34:54', NULL),
(439, 62, 'admin', '2023-03-02 14:36:07', NULL),
(440, 62, 'admin', '2023-03-02 14:38:20', NULL),
(441, 62, 'admin', '2023-03-02 22:28:52', '2023-03-02 22:29:22'),
(442, 62, 'admin', '2023-03-03 00:31:05', NULL),
(443, 62, 'admin', '2023-03-03 09:53:36', '2023-03-03 09:54:49'),
(444, 96, 'hawess', '2023-03-03 10:00:39', NULL),
(445, 58, 'aziz', '2023-03-03 10:01:36', '2023-03-03 10:01:41'),
(446, 73, 'ah', '2023-03-03 10:02:04', '2023-03-03 10:02:07'),
(447, 62, 'admin', '2023-03-03 13:35:24', NULL),
(448, 62, 'admin', '2023-03-03 14:56:33', NULL),
(449, 108, 'aziz', '2023-03-03 15:03:02', NULL),
(450, 107, 'aa', '2023-03-03 15:04:00', '2023-03-03 15:04:13'),
(451, 62, 'admin', '2023-03-05 15:07:33', NULL),
(452, 62, 'admin', '2023-03-05 15:28:40', '2023-03-05 15:29:43'),
(453, 62, 'admin', '2023-03-05 17:03:12', NULL),
(454, 62, 'admin', '2023-03-05 17:25:55', '2023-03-05 17:26:20'),
(455, 62, 'admin', '2023-03-05 17:26:41', NULL),
(456, 62, 'admin', '2023-03-05 17:51:50', '2023-03-05 17:52:48'),
(457, 62, 'admin', '2023-03-05 18:57:34', '2023-03-05 18:57:48'),
(458, 79, 'spon', '2023-03-05 19:08:32', NULL),
(459, 79, 'spon', '2023-03-05 19:14:27', NULL),
(460, 79, 'spon', '2023-03-05 19:22:00', NULL),
(461, 79, 'spon', '2023-03-05 19:25:00', NULL),
(462, 79, 'spon', '2023-03-05 19:27:16', NULL),
(463, 79, 'spon', '2023-03-05 19:51:59', NULL),
(464, 79, 'spon', '2023-03-05 19:56:20', NULL),
(465, 79, 'spon', '2023-03-05 19:59:48', NULL),
(466, 79, 'spon', '2023-03-05 20:00:48', NULL),
(467, 79, 'spon', '2023-03-05 20:02:37', NULL),
(468, 79, 'spon', '2023-03-05 20:03:21', NULL),
(469, 62, 'admin', '2023-03-05 20:04:55', NULL),
(470, 62, 'admin', '2023-03-05 20:06:42', NULL),
(471, 79, 'spon', '2023-03-06 09:51:11', NULL),
(472, 62, 'admin', '2023-03-06 14:02:33', '2023-03-06 14:02:48'),
(473, 62, 'admin', '2023-03-06 14:06:52', '2023-03-06 14:07:39'),
(474, 79, 'spon', '2023-03-06 16:21:53', NULL),
(475, 79, 'spon', '2023-03-06 16:23:22', NULL),
(476, 79, 'spon', '2023-03-06 16:24:14', NULL),
(477, 62, 'admin', '2023-03-06 16:25:41', NULL),
(478, 62, 'admin', '2023-03-06 18:31:49', NULL),
(479, 62, 'admin', '2023-03-06 18:34:17', NULL),
(480, 62, 'admin', '2023-03-06 22:57:26', NULL),
(481, 62, 'admin', '2023-03-06 23:52:18', '2023-03-06 23:53:19'),
(482, 62, 'admin', '2023-03-06 23:54:17', NULL),
(483, 62, 'admin', '2023-03-07 11:43:50', NULL),
(484, 111, 'ghassen', '2023-03-07 11:50:48', NULL),
(485, 62, 'admin', '2023-03-07 16:01:30', '2023-03-07 16:02:08'),
(486, 79, 'spon', '2023-03-07 16:02:17', NULL),
(487, 112, 'rim', '2023-03-07 16:04:12', NULL),
(488, 62, 'admin', '2023-03-07 16:05:04', '2023-03-07 16:06:45'),
(489, 112, 'rim', '2023-03-07 16:07:21', NULL),
(490, 108, 'aziz', '2023-03-07 16:07:58', NULL),
(491, 62, 'admin', '2023-03-08 01:44:12', NULL),
(492, 62, 'admin', '2023-03-08 09:26:49', '2023-03-08 09:27:32'),
(493, 62, 'admin', '2023-03-08 10:05:13', NULL),
(494, 62, 'admin', '2023-03-08 10:36:19', NULL),
(495, 62, 'admin', '2023-03-08 10:36:25', NULL),
(496, 62, 'admin', '2023-03-08 10:39:13', NULL),
(497, 62, 'admin', '2023-03-08 10:39:43', NULL),
(498, 62, 'admin', '2023-03-08 10:41:18', NULL),
(499, 62, 'admin', '2023-03-08 11:39:23', '2023-03-08 11:39:37'),
(500, 107, 'aa', '2023-03-08 11:39:57', '2023-03-08 11:40:08'),
(501, 79, 'spon', '2023-03-08 11:40:35', NULL),
(502, 62, 'admin', '2023-03-08 22:49:42', NULL),
(503, 62, 'admin', '2023-03-08 22:50:24', NULL),
(504, 62, 'admin', '2023-03-08 22:51:51', NULL),
(505, 62, 'admin', '2023-03-08 22:52:26', '2023-03-08 22:55:45'),
(506, 79, 'spon', '2023-03-08 22:55:54', NULL),
(507, 116, 'sameh', '2023-03-08 22:57:40', NULL),
(508, 62, 'admin', '2023-03-08 23:03:07', NULL),
(509, 79, 'spon', '2023-03-08 23:11:07', NULL),
(510, 118, 'baba', '2023-03-08 23:14:26', NULL),
(511, 62, 'admin', '2023-03-09 09:39:48', NULL),
(512, 62, 'admin', '2023-03-09 12:15:16', NULL),
(513, 119, 'hh', '2023-03-09 12:49:28', NULL),
(514, 62, 'admin', '2023-03-09 12:49:46', NULL),
(515, 62, 'admin', '2023-03-09 12:58:14', NULL),
(516, 62, 'admin', '2023-03-09 13:03:43', NULL),
(517, 62, 'admin', '2023-03-09 13:04:49', NULL),
(518, 62, 'admin', '2023-03-09 13:08:28', NULL),
(519, 62, 'admin', '2023-03-09 13:16:31', NULL),
(520, 62, 'admin', '2023-03-09 13:19:52', NULL),
(521, 62, 'admin', '2023-03-09 13:19:59', NULL),
(522, 62, 'admin', '2023-03-09 13:20:27', NULL),
(523, 79, 'spon', '2023-03-09 17:58:30', NULL),
(524, 79, 'spon', '2023-03-09 18:06:37', NULL),
(525, 79, 'spon', '2023-03-09 18:08:42', NULL),
(526, 79, 'spon', '2023-03-09 18:54:16', NULL),
(527, 79, 'spon', '2023-03-09 19:41:44', NULL),
(528, 108, 'aziz', '2023-03-09 19:43:41', NULL),
(529, 47, 'aziza', '2023-03-09 19:44:26', NULL),
(530, 47, 'aziza', '2023-03-09 19:46:07', NULL),
(531, 47, 'aziza', '2023-03-09 19:46:17', NULL),
(532, 47, 'aziza', '2023-03-09 19:46:55', '2023-03-09 19:46:58'),
(533, 47, 'aziza', '2023-03-09 19:49:44', NULL),
(534, 47, 'aziza', '2023-03-09 19:49:53', NULL),
(535, 47, 'aziza', '2023-03-09 19:50:51', NULL),
(536, 47, 'aziza', '2023-03-09 19:51:46', NULL),
(537, 120, 'kk', '2023-03-09 19:52:24', NULL),
(538, 47, 'aziza', '2023-03-09 19:53:50', NULL),
(539, 79, 'spon', '2023-03-09 19:57:08', NULL),
(540, 47, 'aziza', '2023-03-09 19:57:27', NULL),
(541, 47, 'aziza', '2023-03-09 20:02:35', NULL),
(542, 47, 'aziza', '2023-03-09 20:10:10', NULL),
(543, 47, 'aziza', '2023-03-09 20:12:22', NULL),
(544, 47, 'aziza', '2023-03-09 20:14:48', NULL),
(545, 47, 'aziza', '2023-03-09 20:39:29', NULL),
(546, 47, 'aziza', '2023-03-09 20:41:18', NULL),
(547, 47, 'aziza', '2023-03-09 20:44:04', NULL),
(548, 47, 'aziza', '2023-03-09 20:49:49', NULL),
(549, 47, 'aziza', '2023-03-09 20:51:55', NULL),
(550, 47, 'aziza', '2023-03-09 21:08:29', NULL),
(551, 47, 'aziza', '2023-03-09 21:12:11', NULL),
(552, 47, 'aziza', '2023-03-09 21:14:07', NULL),
(553, 47, 'aziza', '2023-03-09 21:17:07', NULL),
(554, 47, 'aziza', '2023-03-09 21:18:52', NULL),
(555, 47, 'aziza', '2023-03-09 21:20:38', NULL),
(556, 79, 'spon', '2023-03-09 21:23:01', NULL),
(557, 79, 'spon', '2023-03-09 21:26:30', NULL),
(558, 79, 'spon', '2023-03-09 21:28:30', NULL),
(559, 79, 'spon', '2023-03-09 21:30:05', NULL),
(560, 79, 'spon', '2023-03-09 21:33:20', NULL),
(561, 79, 'spon', '2023-03-09 21:37:32', NULL),
(562, 79, 'spon', '2023-03-09 21:42:47', NULL),
(563, 79, 'spon', '2023-03-09 21:43:35', NULL),
(564, 79, 'spon', '2023-03-09 21:44:57', NULL),
(565, 79, 'spon', '2023-03-09 21:47:48', NULL),
(566, 79, 'spon', '2023-03-09 22:05:13', NULL),
(567, 79, 'spon', '2023-03-09 22:08:28', NULL),
(568, 47, 'aziza', '2023-03-09 22:10:33', NULL),
(569, 47, 'aziza', '2023-03-09 22:11:52', NULL),
(570, 47, 'aziza', '2023-03-09 22:16:11', NULL),
(571, 47, 'aziza', '2023-03-09 22:17:45', NULL),
(572, 47, 'aziza', '2023-03-09 22:19:25', NULL),
(573, 47, 'aziza', '2023-03-09 22:21:48', NULL),
(574, 47, 'aziza', '2023-03-09 22:24:51', NULL),
(575, 47, 'aziza', '2023-03-09 22:28:25', NULL),
(576, 47, 'aziza', '2023-03-09 22:29:15', NULL),
(577, 47, 'aziza', '2023-03-09 22:31:07', NULL),
(578, 47, 'aziza', '2023-03-09 22:34:59', NULL),
(579, 47, 'aziza', '2023-03-09 22:35:48', NULL),
(580, 47, 'aziza', '2023-03-09 22:44:05', NULL),
(581, 47, 'aziza', '2023-03-09 22:44:36', NULL),
(582, 47, 'aziza', '2023-03-09 22:45:39', NULL),
(583, 47, 'aziza', '2023-03-09 22:46:29', NULL),
(584, 47, 'aziza', '2023-03-09 22:48:00', NULL),
(585, 47, 'aziza', '2023-03-09 22:48:27', NULL),
(586, 47, 'aziza', '2023-03-09 22:48:56', NULL),
(587, 47, 'aziza', '2023-03-09 22:50:31', NULL),
(588, 47, 'aziza', '2023-03-09 22:51:20', NULL),
(589, 47, 'aziza', '2023-03-09 22:52:46', NULL),
(590, 47, 'aziza', '2023-03-09 22:55:21', NULL),
(591, 47, 'aziza', '2023-03-09 22:56:08', NULL),
(592, 47, 'aziza', '2023-03-09 22:58:34', NULL),
(593, 47, 'aziza', '2023-03-09 22:59:30', NULL),
(594, 47, 'aziza', '2023-03-09 23:00:19', NULL),
(595, 47, 'aziza', '2023-03-09 23:01:02', NULL),
(596, 47, 'aziza', '2023-03-09 23:01:51', NULL),
(597, 47, 'aziza', '2023-03-09 23:03:03', NULL),
(598, 47, 'aziza', '2023-03-09 23:03:51', NULL),
(599, 47, 'aziza', '2023-03-09 23:04:43', NULL),
(600, 47, 'aziza', '2023-03-09 23:05:27', NULL),
(601, 47, 'aziza', '2023-03-09 23:06:56', NULL),
(602, 47, 'aziza', '2023-03-09 23:07:34', NULL),
(603, 47, 'aziza', '2023-03-09 23:08:57', NULL),
(604, 47, 'aziza', '2023-03-09 23:09:46', NULL),
(605, 47, 'aziza', '2023-03-09 23:12:04', NULL),
(606, 47, 'aziza', '2023-03-09 23:13:01', NULL),
(607, 47, 'aziza', '2023-03-09 23:13:37', NULL),
(608, 47, 'aziza', '2023-03-09 23:14:56', NULL),
(609, 47, 'aziza', '2023-03-09 23:15:41', NULL),
(610, 47, 'aziza', '2023-03-09 23:16:53', NULL),
(611, 47, 'aziza', '2023-03-09 23:17:54', NULL),
(612, 47, 'aziza', '2023-03-09 23:18:52', NULL),
(613, 47, 'aziza', '2023-03-09 23:19:18', NULL),
(614, 47, 'aziza', '2023-03-09 23:20:39', NULL),
(615, 47, 'aziza', '2023-03-09 23:21:23', NULL),
(616, 47, 'aziza', '2023-03-09 23:22:40', NULL),
(617, 62, 'admin', '2023-03-09 23:45:56', NULL),
(618, 62, 'admin', '2023-03-09 23:57:25', NULL),
(619, 62, 'admin', '2023-03-09 23:58:33', NULL),
(620, 62, 'admin', '2023-03-09 23:59:08', NULL),
(621, 62, 'admin', '2023-03-09 23:59:44', NULL),
(622, 62, 'admin', '2023-03-10 00:00:04', NULL),
(623, 47, 'aziza', '2023-03-10 00:06:22', NULL),
(624, 62, 'admin', '2023-03-10 00:06:54', NULL),
(625, 62, 'admin', '2023-03-10 00:08:19', NULL),
(626, 62, 'admin', '2023-03-10 00:17:29', NULL),
(627, 47, 'aziza', '2023-03-10 00:18:06', NULL),
(628, 47, 'aziza', '2023-03-10 00:21:23', NULL),
(629, 47, 'aziza', '2023-03-10 00:22:09', NULL),
(630, 47, 'aziza', '2023-03-10 00:23:16', NULL),
(631, 47, 'aziza', '2023-03-10 00:24:41', NULL),
(632, 47, 'aziza', '2023-03-10 00:50:09', NULL),
(633, 47, 'aziza', '2023-03-10 00:55:17', NULL),
(634, 47, 'aziza', '2023-03-10 00:59:06', NULL),
(635, 47, 'aziza', '2023-03-10 01:00:19', NULL),
(636, 47, 'aziza', '2023-03-10 01:02:23', NULL),
(637, 47, 'aziza', '2023-03-10 01:04:05', NULL),
(638, 47, 'aziza', '2023-03-10 01:05:29', NULL),
(639, 47, 'aziza', '2023-03-10 01:07:16', NULL),
(640, 47, 'aziza', '2023-03-10 01:08:59', NULL),
(641, 47, 'aziza', '2023-03-10 01:10:35', NULL),
(642, 62, 'admin', '2023-03-10 01:11:30', NULL),
(643, 62, 'admin', '2023-03-10 01:13:20', NULL),
(644, 62, 'admin', '2023-03-10 01:17:02', NULL),
(645, 47, 'aziza', '2023-03-10 01:18:48', NULL),
(646, 47, 'aziza', '2023-03-10 01:20:48', NULL),
(647, 47, 'aziza', '2023-03-10 01:51:10', NULL),
(648, 47, 'aziza', '2023-03-10 02:29:26', NULL),
(649, 47, 'aziza', '2023-03-10 02:40:04', NULL),
(650, 47, 'aziza', '2023-03-10 02:40:53', NULL),
(651, 47, 'aziza', '2023-03-10 02:57:14', NULL),
(652, 47, 'aziza', '2023-03-10 03:02:37', NULL),
(653, 62, 'admin', '2023-03-10 03:22:59', '2023-03-10 03:23:07'),
(654, 47, 'aziza', '2023-03-10 03:23:31', NULL),
(655, 47, 'aziza', '2023-03-10 03:24:17', NULL),
(656, 47, 'aziza', '2023-03-10 03:29:13', NULL),
(657, 47, 'aziza', '2023-03-10 03:29:40', NULL),
(658, 47, 'aziza', '2023-03-10 03:37:00', NULL),
(659, 47, 'aziza', '2023-03-10 03:39:22', NULL),
(660, 47, 'aziza', '2023-03-10 03:47:58', NULL),
(661, 47, 'aziza', '2023-03-10 03:49:36', NULL),
(662, 47, 'aziza', '2023-03-10 03:51:33', NULL),
(663, 47, 'aziza', '2023-03-10 03:53:48', NULL),
(664, 47, 'aziza', '2023-03-10 03:54:21', NULL),
(665, 47, 'aziza', '2023-03-10 03:56:25', NULL),
(666, 47, 'aziza', '2023-03-10 03:58:36', NULL),
(667, 62, 'admin', '2023-03-10 03:58:53', NULL),
(668, 62, 'admin', '2023-03-10 04:04:18', NULL),
(669, 62, 'admin', '2023-03-10 04:14:23', NULL),
(670, 47, 'aziza', '2023-03-10 04:15:12', NULL),
(671, 62, 'admin', '2023-03-10 04:15:25', NULL),
(672, 62, 'admin', '2023-03-10 04:18:54', NULL),
(673, 121, 'hhhh', '2023-03-10 04:24:43', NULL),
(674, 62, 'admin', '2023-03-10 04:26:12', NULL),
(675, 62, 'admin', '2023-03-10 04:33:42', NULL),
(676, 62, 'admin', '2023-03-10 04:59:08', NULL),
(677, 47, 'aziza', '2023-03-10 05:12:00', NULL),
(678, 47, 'aziza', '2023-03-10 05:15:02', NULL),
(679, 47, 'aziza', '2023-03-10 05:16:16', NULL),
(680, 47, 'aziza', '2023-03-10 05:16:58', NULL),
(681, 47, 'aziza', '2023-03-10 05:18:36', NULL),
(682, 47, 'aziza', '2023-03-10 05:20:03', NULL),
(683, 47, 'aziza', '2023-03-10 05:21:37', NULL),
(684, 47, 'aziza', '2023-03-10 05:22:36', NULL),
(685, 47, 'aziza', '2023-03-10 05:27:13', NULL),
(686, 62, 'admin', '2023-03-10 05:28:00', NULL),
(687, 47, 'aziza', '2023-03-10 05:30:27', NULL),
(688, 47, 'aziza', '2023-03-10 05:31:50', NULL),
(689, 62, 'admin', '2023-03-10 05:32:15', NULL),
(690, 47, 'aziza', '2023-03-10 05:34:16', NULL),
(691, 62, 'admin', '2023-03-10 05:34:35', NULL),
(692, 124, 'baha', '2023-03-10 07:00:00', NULL),
(693, 125, 'sensi', '2023-03-10 07:05:59', NULL),
(694, 79, 'spon', '2023-03-10 07:09:48', NULL),
(695, 79, 'spon', '2023-03-10 07:24:28', NULL),
(696, 47, 'aziza', '2023-03-10 07:25:00', NULL),
(697, 62, 'admin', '2023-03-10 07:25:22', '2023-03-10 07:25:41'),
(698, 47, 'aziza', '2023-03-10 07:25:50', NULL),
(699, 47, 'aziza', '2023-03-10 07:29:49', NULL),
(700, 47, 'aziza', '2023-03-10 07:48:20', NULL),
(701, 47, 'aziza', '2023-03-10 07:53:30', NULL),
(702, 108, 'aziz', '2023-03-10 07:55:34', NULL),
(703, 47, 'aziza', '2023-03-10 07:56:14', NULL),
(704, 47, 'aziza', '2023-03-10 07:57:39', NULL),
(705, 47, 'aziza', '2023-03-10 08:02:02', NULL),
(706, 47, 'aziza', '2023-03-10 08:03:37', NULL),
(707, 47, 'aziza', '2023-03-10 08:09:10', NULL),
(708, 47, 'aziza', '2023-03-10 08:12:20', NULL),
(709, 62, 'admin', '2023-03-10 08:55:43', NULL),
(710, 62, 'admin', '2023-03-10 08:58:57', NULL),
(711, 62, 'admin', '2023-03-10 09:05:20', NULL),
(712, 62, 'admin', '2023-03-10 09:07:57', NULL),
(713, 62, 'admin', '2023-03-10 09:41:11', NULL),
(714, 47, 'aziza', '2023-03-10 09:44:59', NULL),
(715, 79, 'spon', '2023-03-10 09:47:34', NULL),
(716, 79, 'spon', '2023-03-10 09:50:46', NULL),
(717, 62, 'admin', '2023-03-10 10:06:49', NULL),
(718, 62, 'admin', '2023-03-10 13:02:41', '2023-03-10 13:04:24'),
(719, 47, 'aziza', '2023-03-10 13:04:33', NULL),
(720, 79, 'spon', '2023-03-10 13:07:21', NULL),
(721, 79, 'spon', '2023-03-10 13:08:21', NULL),
(722, 126, 'rania', '2023-03-10 13:12:03', NULL),
(723, 62, 'admin', '2023-03-10 13:21:07', NULL),
(724, 62, 'admin', '2023-03-10 13:37:03', NULL),
(725, 47, 'aziza', '2023-03-10 13:37:37', NULL),
(726, 62, 'admin', '2023-03-10 13:45:08', NULL),
(727, 62, 'admin', '2023-03-10 13:46:53', NULL),
(728, 47, 'aziza', '2023-03-10 14:01:15', NULL),
(729, 79, 'spon', '2023-03-10 14:03:02', NULL),
(730, 47, 'aziza', '2023-03-10 14:09:41', NULL),
(731, 79, 'spon', '2023-03-10 14:11:40', NULL),
(732, 62, 'admin', '2023-03-10 14:12:16', NULL),
(733, 62, 'admin', '2023-03-10 14:26:27', NULL),
(734, 47, 'aziza', '2023-03-10 14:37:10', NULL),
(735, 47, 'aziza', '2023-03-10 14:39:53', NULL),
(736, 79, 'spon', '2023-03-10 14:40:55', NULL),
(737, 62, 'admin', '2023-03-10 14:41:21', NULL),
(738, 79, 'spon', '2023-03-10 14:47:41', NULL),
(739, 79, 'spon', '2023-03-10 14:50:15', NULL),
(740, 47, 'aziza', '2023-03-10 14:51:52', NULL),
(741, 62, 'admin', '2023-03-10 14:53:43', NULL),
(742, 62, 'admin', '2023-03-10 14:56:35', NULL),
(743, 47, 'aziza', '2023-03-10 15:00:30', NULL),
(744, 62, 'admin', '2023-03-10 15:01:32', NULL),
(745, 62, 'admin', '2023-03-12 12:24:10', NULL),
(746, 79, 'spon', '2023-03-12 12:25:15', NULL),
(747, 47, 'aziza', '2023-03-12 12:25:40', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `typevehicule`
--

CREATE TABLE `typevehicule` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `typevehicule`
--

INSERT INTO `typevehicule` (`id`, `nom`, `description`) VALUES
(4, 'voiture 90s5', 'voiture qui offre un niveau conduite exceptionnelle, un confort poussé'),
(5, 'voiture course', 'voiture qui offre un niveau conduite exceptionnelle, un confort poussé'),
(6, 'voiture limousins', 'voiture qui offre un niveau conduite exceptionnelle, un confort poussé'),
(7, 'hbc<hbjcs', 'kjscnkscj'),
(8, 'fef', 'njfe'),
(9, 'test', 'test'),
(10, 'cccc', 'ccc'),
(11, 'course', 'tres bien evolué');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'zou@gmail.com', '\"ROLE_ADMIN \"', '12345'),
(2, 'aaa@gmail.com', '', '123456');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `num` int(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `num`, `adresse`, `mdp`, `description`, `photo`, `rate`, `type`, `verified`, `role`) VALUES
(27, '3', '3', 3, '3', '111112', '3', 'f', 0, '3', 0, ''),
(31, '5', '5', 5, '5', '5', '', '', 0, '', 0, ''),
(37, 'skanjjjaa', 'dshfvj:', 45632178, 'dsb ,nc d', '00000', NULL, NULL, NULL, NULL, NULL, 'user'),
(47, 'aziza', '3', 52369874, 's qnx :s', '12345678', NULL, NULL, NULL, NULL, NULL, 'user'),
(51, 'amiraa', 'jazira', 14523690, 'bvbv', '00000', NULL, NULL, NULL, NULL, NULL, 'user'),
(53, 'lord', 'lord', 52199977, 'gabes', 'lord1234', NULL, NULL, NULL, NULL, NULL, 'admin'),
(55, 'azizaa', 'skhiri', 25258258, 'mourouj', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(58, 'aziz', 'sss', 12345678, 'mourouj', '123456789', NULL, NULL, NULL, NULL, NULL, 'admin'),
(62, 'admin', 'skiri', 25258258, 'aapapa', 'admin', NULL, NULL, NULL, NULL, NULL, 'admin'),
(64, 'sarraa', 'parwila', 25258258, 'mourouj3', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(72, 'ah', 'jinj,', 25258258, 'kj,ok', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(73, 'ah', 'akjb', 11111111, 'jhgbjh', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(75, 'yg', 'fgfg', 11111111, 'fsgrg', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(79, 'spon', 'gharbi', 25258258, 'ldldk', '123456789', 'mmmmm', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'moyenne gamme', 1, 'agence'),
(81, 'aa', 'aa', 25258258, 'kaka', '123456789', '', 'C:\\Users\\azizs\\Pictures\\ddd.jpg', 0, 'luxe', 0, 'agence'),
(82, 'aa', 'aa', 11111111, 'aaaa', 'aaaaaaaa', NULL, NULL, NULL, NULL, NULL, 'user'),
(83, 'aa', 'aa', 25258258, 'bkkb', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(84, 'aa', 'aaaa', 55258258, 'igh', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(85, 'iegf', 'fer', 11111111, 're', '11111111', NULL, NULL, NULL, NULL, NULL, 'user'),
(86, 'ef', 'dvfdv', 11111111, 'dfvd', '11111111', NULL, NULL, NULL, NULL, NULL, 'user'),
(87, 'edz', 'dzed', 11111111, 'zefz', '11111111', NULL, NULL, NULL, NULL, NULL, 'user'),
(89, 'AA', 'AA', 11111111, 'SFBS', '11111111', '', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'moyenne gamme', 0, 'agence'),
(90, 'amine', 'jdj', 25258258, 'kkkk', '123456789', '', 'C:\\Users\\azizs\\Pictures\\dd.jpg', 0, 'moyenne gamme', 0, 'agence'),
(91, 'salma', 'gannouni', 25258258, 'aziii', '123456789', '', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'luxe', 0, 'agence'),
(92, 'amir', 'jaziri', 12312322, 'dddd', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(93, 'yasine', 'ben jaber', 12123123, 'ddd', 'ssssssss', NULL, NULL, NULL, NULL, NULL, 'user'),
(94, 'best', 'car', 12345678, 'monastir', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(96, 'hawess', 'bel karhba', 12123123, 'mourouj', '123456789', '', 'C:\\Users\\azizs\\Pictures\\ddd.jpg', 0, 'luxe', 0, 'agence'),
(97, 'aa', 'aaa', 12123123, 'fff', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(98, 'azizzz', 'skhiri', 12123123, 'ddkk', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(99, 'aa', 'zzz', 12345678, 'dd', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(100, 'ZZZ', 'ZEEEE1', 12345678, 'GHDGCBR', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(101, 'AZIZ', 'SKANDER', 12121212, 'SKNFALNJFEN', '00000000', NULL, NULL, NULL, NULL, NULL, 'user'),
(103, 'AAA', 'DDD', 12345678, 'EFEF', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(104, 'AA', 'AAA', 12312312, 'UFDJ', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(105, 'AAA', 'AAA', 12123123, 'AAZZ', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(106, 'AZIZ', 'QQ', 12345678, 'jjfh', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(107, 'aa', 'aa', 12123123, 'grgr', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(108, 'aziz', 'skhiri', 12345678, 'kfkjj', '123456789', '', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'luxe', 0, 'agence'),
(109, 'aaa', 'aaa', 12345678, 'dfff', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(110, 'ttr', 'fggghh', 12345678, 'gfgy', '123456789', '', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'moyenne gamme', 0, 'agence'),
(111, 'ghassen', 'hh', 12123123, 'evfe', '123456789', '', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'luxe', 0, 'agence'),
(112, 'rim', 'bvhgvb', 12312123, 'jun', '123456789', '', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'luxe', 0, 'agence'),
(113, 'ghassen', 'hh', 12123123, 'evfe', '00000', NULL, NULL, NULL, NULL, NULL, 'user'),
(114, 'hamma', 'aa', 25258258, 'kaka', '00000', NULL, NULL, NULL, NULL, NULL, 'user'),
(116, 'sameh', 'ddd', 25258258, 'ddddd', '123456789', '', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'luxe', 0, 'agence'),
(117, 'sss', 'ssss', 12345678, 'll', '123456789', '', 'C:\\Users\\azizs\\Pictures\\ji.png', 0, 'moyenne gamme', 0, 'agence'),
(118, 'baba', 'baba', 12323123, 'hh', '123456789', 'dzzdz', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'luxe', 0, 'agence'),
(119, 'hh', 'hjhh', 12123123, 'jhhh', '123456789', 'hjbuuh', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'luxe', 0, 'agence'),
(121, 'hhhh', 'hggg', 21123123, 'yy', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(122, '3', '3', 35555555, '3', '111112555', '3', 'C:\\Users\\azizs\\Pictures\\final.png', 0, '3', 0, 'agence'),
(123, 'aa', 'aa', 52147789, 'ariana', '12345678', 'hh', 'C:\\Users\\azizs\\Pictures\\ddd.jpg', 0, 'voiture 90s5', 0, 'agence'),
(124, 'baha', 'din', 25258258, 'ariena', '123456789', NULL, NULL, NULL, NULL, NULL, 'user'),
(125, 'sensi', 'sss', 12123456, 'ddd', '123456789', 'sssss', 'C:\\Users\\azizs\\Pictures\\final.png', 0, 'voiture course', 0, 'agence'),
(126, 'rania', 'bouachir', 25258258, 'ariena', '123456789', NULL, NULL, NULL, NULL, NULL, 'user');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `immatriculation` varchar(255) NOT NULL,
  `marque` varchar(255) NOT NULL,
  `puissance` varchar(255) NOT NULL,
  `kilometrage` varchar(255) NOT NULL,
  `nbrdeplace` int(11) NOT NULL,
  `prix` float NOT NULL,
  `typevehicule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`immatriculation`, `marque`, `puissance`, `kilometrage`, `nbrdeplace`, `prix`, `typevehicule_id`) VALUES
('1', '1', '1', '1', 1, 1, 7),
('11', 'klk', '11111', '1111', 11, 111, 6),
('222222', '12', '222', '2222', 222, 2222, 6),
('555512', '11111', '11', '222', 22, 222, 9),
('55655', '12', '11', '222', 222, 222, 6),
('565898656', 'klk', '656', '5665', 6565, 566565, 8),
('566559', '12', '656', '565623', 655656, 326, 7),
('6465656', '1258477', '55', '55', 55, 555, 8),
('6565655', '4556', '56565656', '3565', 65, 32, 6),
('65989565', '656', '656566', '6556', 5656, 5656, 7),
('686569', '545', '56565', '465', 656, 565, 6);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`id_agence`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id_reclamation`);

--
-- Index pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `clé étrangère` (`id_reclamation`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`);

--
-- Index pour la table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typevehicule`
--
ALTER TABLE `typevehicule`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`immatriculation`),
  ADD KEY `typevehicule_id` (`typevehicule_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `id_agence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id_reclamation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id_reponse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=748;

--
-- AUTO_INCREMENT pour la table `typevehicule`
--
ALTER TABLE `typevehicule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `clé étrangère` FOREIGN KEY (`id_reclamation`) REFERENCES `reclamation` (`id_reclamation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `vehicule_ibfk_1` FOREIGN KEY (`typevehicule_id`) REFERENCES `typevehicule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
