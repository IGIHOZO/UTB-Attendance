-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2022 at 07:32 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `utb_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `RecordId` int(11) NOT NULL,
  `RecordUser` int(11) NOT NULL,
  `RecordStatus` tinyint(1) NOT NULL DEFAULT '1',
  `RecordTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`RecordId`, `RecordUser`, `RecordStatus`, `RecordTime`) VALUES
(1, 82, 1, '2022-06-16 17:37:17');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_users`
--

CREATE TABLE `attendance_users` (
  `UserId` int(11) NOT NULL,
  `Names` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Campus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance_users`
--

INSERT INTO `attendance_users` (`UserId`, `Names`, `Position`, `Email`, `Phone`, `Campus`) VALUES
(3, 'CONDO Abel', 'Assistant Lecturer', 'acondo@utb.ac.rw', '788631808', 'KGL'),
(4, 'DUSABE YVES', 'ICT OFFICER', 'ydusabe@utb.ac.rw', '738258097', 'RBV'),
(5, 'GASHEJA CHRISTOPHE', ' Assistant Lecturer', 'cgasheja@utb.ac.rw', '', 'RBV'),
(6, 'GATETE MARCEL', 'Lecturer', 'mgatete@utb.ac.rw', '784003392', 'RBV'),
(7, 'GITENGE CLAIRE', 'Tutorial assistant', 'cgitenge@utb.ac.rw', '', 'KGL'),
(8, 'HABIMANA FIACRE', 'Lecturer', 'fhabimana@utb.ac.rw', '788513752', 'RBV'),
(9, 'HABIMANA JEAN BOSCO', 'Tutorial assistant', 'jbhabimana@utb.a.c.rw', '788613807', 'KGL'),
(10, 'HAKIZIMANA CESAR', 'ACADEMIC REGISTRAR/Gisenyi', 'chakizimana@utb.ac.rwa', '', 'RBV'),
(11, 'HARUBWIRA Flaubert?', 'Dean Faculty Business & Information technology', 'fharubwira@utb.a.crw', '789176625', 'KGL'),
(12, 'HASHAKIMANA Francois Frank', 'Revenue Accountant ', 'fhashakimana@utb.ac.rw', '788526753', 'KGL'),
(13, 'IGIHOZO CYUZUZO YVETTE', 'Assistant Lecturer', 'yigihozo@utb.ac.rw', '788585580', 'KGL'),
(14, 'INGABIRE Julian', 'Dir of Consultancy & Coordinator of Research  & Innovation', 'jingabire@utb.ac.rw', '788305335', 'KGL'),
(15, 'INGABIRE STELLA', 'Assistant Lecturer  & COVID 19 Coordinator-RBV', 'singabire@utb.ac.rw', '788404893', 'RBV'),
(16, 'IRANKUNDA JEROME ', 'Coordinator COVID-19 task force Dean of students Kigali', 'jirankunda@utb.ac.re', '788305030', 'KGL'),
(17, 'KABATESI JACKLINE', 'Professional staff CAC', 'jkabatesi@utb.ac.rw', '788741330', 'KGL'),
(18, 'KAGARAMA Jean Baptiste', 'Lecturer', 'jbkagarama@utb.ac.rw', '788473129', 'RBV'),
(19, 'KALULU Ronald', 'Assistant Lecturer', 'rkalulu@utb.ac.rw', '787560649', 'RBV'),
(20, 'KAMANZI James', 'Customer Services Officer', 'jkamanze@utb.ac.rw', '788361738', 'KGL'),
(21, 'KAMUGASHA Pierrelinos', 'Chief Accountant', 'pkamugasha@utb.ac.rw', '788342018', 'KGL'),
(22, 'KANTENGWA FILDAUS DADINE', 'Director Marketing & CAC & Assistant Lecturer', 'dfildaus@utb.ac.rw', '784112555', 'KGL'),
(23, 'KAREGEYA Faustin', 'Head Examination officer', 'fkaregeya@utb.ac.rw', '788758937', 'KGL'),
(24, 'KASAJJA EMMANUEL', 'Assistant Lecturer', 'ekasajja@utb.ac.rw', '788523134', 'KGL'),
(25, 'KAYIHURA FRANK', 'Assistant Registrar', 'fkayihura@utb.ac.rw', '788466441', 'KGL'),
(26, 'KIRENGA SAPHINE', 'Nurse', 'skirenga@utb.ac.rw', '788327410', 'KGL'),
(27, 'MAKUZA SAMUEL', 'Assistant Lecturer', 'smkauza@utb.ac.rw', '788461015', 'KGL'),
(28, 'MANGWA STEVEN', 'Lecturer', 'smangwa@utb.ac.rw', '788490591', 'KGL'),
(29, 'MANIRAGUHA Lazaro', 'Marketing Officer', 'lmaniraguha@utb.ac.rw', '782400219', 'KGL'),
(30, 'MBABAZI JEAN PAUL', 'Director of Registration &MIS coordinator', 'jpmbabazi@utb.ac.rw', '', 'KGL'),
(31, 'MBANZA SYLVESTRE', 'Assistant Lecturer', 'smbanza@utb.ac.rw', '787375555', 'KGL'),
(32, 'MUCYO PHILBERT', 'Marketing officer', 'pmucyo@utb.ac.rw', '788561785', 'KGL'),
(33, 'MUDAHEMUKA WILLIAM', 'Assistant Lecturer & Researcher ', 'wmudahemuka@utb.ac.rw', '783672649', 'KGL'),
(34, 'MUHAWENIMANA Noe', 'ICT Director', 'noe@utb.ac.rw', '788315351', 'KGL'),
(35, 'MUHOZA O. REGINAL', 'Assistant Lecturer', 'rmuhoza@utb.ac.rw', '788869300', 'KGL'),
(36, 'MUKANTAGENGWA PELAGIE', 'Director of LIBRARY', 'pmukantagengwa@utb.ac.rw', '788451540', 'KGL'),
(37, 'MUKIZA Patience ', 'Estates Officer/ Ruhavu', 'pmukiza@utb.ac.rw', '788607893', 'RBV'),
(38, 'MUNYANA PENINA', 'Assistant Registrar Gisenyi', 'pmunyana@utb.ac.rw', '783546549', 'RBV'),
(39, 'MUNYEMANA Edouard', 'Academic secretary ', 'emunyemana@utb.ac.rw', '786960684', 'KGL'),
(40, 'MURENZI Abdallah', 'Institutionalization and Placement Coordinator', 'amurenzi@utb.ac.rw', '', 'KGL'),
(41, 'MURORUNKWERE JOIE LEA', 'Assistant Lecturer', 'lmurorunkwere@utb.ac.rw', '', 'KGL'),
(42, 'MUSONI EMMANUEL ISMAEL', 'Estates Officer/ Kigali ', 'imusoni@utb.ac.rw', '788304165', 'KGL'),
(43, 'MUTABAZI FAUSTIN', 'Assistant Lecturer Rubavu', 'fmutabazi@utb.ac.rw', '784509915', 'RBV'),
(44, 'MWITENDE Jeanne', 'Academic Assistant', 'jmwitende@utb.ac.rw', '', 'KGL'),
(45, 'NAHO RICHTER RICHARD', 'CHIEF OF FINANCE OFFICER', 'rnaho@utb.ac.rw', '788755881', 'KGL'),
(46, 'NDABUKIYE R. INNOCENT', 'Accountant - Kigali', 'indabukiye@utb.ac.rw', '784262644', 'KGL'),
(47, 'NIZEYIMANA Jean D\'Amour', 'Assistant Registrar', 'jdnizeyimana@utb.ac.rw', '784504845', 'KGL'),
(48, 'NIZEYIMANA JEAN PAUL', 'Assistant Lecturer', 'jnizeyimana@utb.ac.rw', '788771540', 'KGL'),
(49, 'NIZEYIMANA PATRICK', 'Assistant Lecturer, Director Marketing & CAC Rubavu Campus ', 'pnizeyimana@utb.ac.rw', '788461246', 'RBV'),
(50, 'NIZEYIMANA Sylvain ', 'Languages coordinator Rubavu', 'snizeyimana|@utb.ac.rw', '788800123', 'RBV'),
(51, 'NIZEYIMANA Yazid', 'Procurement Officer', 'ynizeyimana@utb.ac.rw', '788621149', 'KGL'),
(52, 'NKURUNZIZA Pacifique', 'Recovery Accountant ', 'pnkurunziza@utb.ac.rw', '787345341', 'RBV'),
(53, 'NSANZIMANA BERNARD', 'Legal advisor & Assistant Lecturer', 'bnsanzimana@utb.ac.rw', '788640134', 'KGL'),
(54, 'NSHIMIYIMANA HENRY VICTOR', 'Software developer & Webmaster', 'vnshimiyimana@utb.ac.rw', '', 'KGL'),
(55, 'NSHIMIYIMANA JANVIER', 'Lab attendant', 'jnshimiyimana@utb.ac.rw', '788837934', 'KGL'),
(56, 'NSHUNGUYE JUSTIN', 'Assistant Lecturer', 'jnshunguye@utb.ac.rw', '788419808', 'RBV'),
(57, 'NTAGENGWA Olivier', 'Examination officer', 'ontagengwa@utb.ac.rw', '785163009', 'KGL'),
(58, 'NTAHEMUKA John', 'HOD/HRM, Assistant Lecturer', 'jntihemuka@utb.ac.rw', '788307231', 'KGL'),
(59, 'NYABOGA KIAGE ENOCK', 'Lecturer', 'enyaboga@utb.ac.rw', '782179048', 'KGL'),
(60, 'NYANDUSI MATUNDURA  MOSES', 'HOD B&IT Lecturer Rubavu', 'mmatundura@utb.ac.rw', '788978200', 'RBV'),
(61, 'NYIRAGIRINKA CONSOLEE', 'ASSISTANT REGISTRAR', 'cnyiragirinka@utb.ac.rw', '785060007', 'KGL'),
(62, 'NYIRAMUGWERA N. Anathalie', 'Lecturer', 'aniyigena@utb.ac.rw', '783222852', 'RBV'),
(63, 'NYISINGIZE Enock', 'Director of Academic Affairs & Quality Assurance ', 'enyisingize@utb.ac.rw', '788877997', 'KGL'),
(64, 'NZABANDORA DOMINIQUE', 'Assistant Lecturer-Rubavu', 'dnzabandora@utb.ac.rw', '783855847', 'RBV'),
(65, 'PRINCE WASAJJA KIWANUKA', 'Director of CELC', 'wpkiwanuka@utb.ac.rw', '780874663', 'KGL'),
(66, 'RUGAMBA EGIDE ', 'DIRECTOR RUBAVU CAMPUS ', 'erugamba@utb.ac.rw', '788306757', 'RBV'),
(67, 'RUGEMA ANGELIQUE ', 'Senior Accountant - Rubavu', 'arugema@utb.ac.rw', '786381786', 'RBV'),
(68, 'RUGINA Justin', 'Tutorial assistant', 'jrugina@utb.ac.rw', '788533995', 'KGL'),
(69, 'RUHORIMBERE JEAN PAUL', 'Assistant Lecturer', 'jpruhorimbere@utb.ac.rw', '', 'KGL'),
(70, 'RUHUMULIZA David', 'Assistant Lecturer', 'druhumuliza@utb.ac.rw', '788682011', 'RBV'),
(71, 'RUJUGIRO ALICE', 'Assistant Examination officer /Gisenyi', 'arujugiro@utb.ac.rw', '788969766', 'RBV'),
(72, 'RURANGIRWA Jean Bosco', 'DVC-PAF', 'jbrurangirwa@utb.ac.rw', '782767206', 'KGL'),
(73, 'SAMMIE CHOMBO', 'Assistant Lecturer', 'schombo@utb.ac.rw', '782061394', 'KGL'),
(74, 'SENTONGO ANDERSON BOOKER', 'Lecturer', 'bssentongo@utb.ac.rw', '785220502', 'KGL'),
(75, 'SHIMIRWA Dominique Savio', 'Examination Officer', '', '785137265', 'RBV'),
(76, 'SHUMBUSHO JACKSON', 'Ass. Accountant', 'jshumbusho@utb.ac.rw', '788791526', 'RBV'),
(77, 'SIBOMANA SIMON', ' Assistant Lecturer', 'ssibomana@utb.ac.rw', '785741775', 'KGL'),
(78, 'TUMUHAISE Gloria', 'Career Guidance Officer', 'gtumuhaise@utb.ac.rw', '785832430', 'KGL'),
(79, 'TUMWINE ISAAC', 'IT Lab Attendant ', '', '786896515', 'KGL'),
(80, 'TUSHABE EMMY', 'HOD Hosp.Tourism/ Lecturer', 'etushabe|@utb.ac.rw', '782469995', 'KGL'),
(81, 'TWAGIRAYEZU JEAN PIERRE', 'Assistant Lecturer', 'jptwagirayezu@utb.ac.rw', '788831132', 'RBV'),
(82, 'TWISUNZENYINAWAJAMBO Christine', 'Logistic officer', 'ctwisunze@utb.ac.rw', '788864630', 'KGL'),
(83, 'UHAWENAYO JEAN BOSCO', ' Assistant Lecturer', 'jbuhawenayo@utb.ac.rw', '788876981', 'KGL'),
(84, 'UMUGANWA Jackline', 'Assistant Lecturer', 'jumuganwa@utb.ac.rw', '788435326', 'KGL'),
(85, 'UMUHOZA Nadia', 'Accountant', 'numuhoza@utb.ac.rw', '788644731', 'KGL'),
(86, 'UMUTESI LILIANE', 'DVC-Academics ', 'lumutesi@utb.ac.rw', '788462326', 'KGL'),
(87, 'UWABABYEYI Anastasie', 'Assistant Lecturer', 'auwababyeyi@utb.ac.rw', '788497419', 'KGL'),
(88, 'UWASE CARINE', 'Admin. Assist. To VC', 'cuwase@utb.ac.rw', '788490646', 'KGL'),
(89, 'UWASE SHADIA', 'Librarian', 'suwase@utb.ac.rw', '788655187', 'KGL'),
(90, 'UWIMANA OLIVER', 'Examination officer', 'ouwimana@utb.ac.rw', '783200822', 'KGL'),
(91, 'UWIMPUHWE DENYS', 'Lecturer & HOD H&TM Rbv', 'duwimpuhwe@utb.ac.rw', '786120724', 'RBV'),
(92, 'UWIMPUHWE EMIMA', 'Librarian/ American corner Rubavu', 'euwumouhwe@utb.ac.rw', '', 'RBV'),
(93, 'UWITONZE Gilbert', ' Assistant Lecturer', 'guwitonze@utb.ac.rw', '788778217', 'RBV'),
(94, 'UWIZERA MARIE LOUISE', 'Accountant', 'luwizera@utb.ac.rw', '788440369', 'KGL'),
(95, 'UWURUKUNDO VALENS', 'Network Administrator ', 'vuwurukundu@utb.ac.rw', '788851708', 'KGL'),
(96, 'WANYERA Francis', 'Lecturer', 'fwanyera@utb.ac.rw', '', 'KGL'),
(97, 'WIELHER Simeon', 'Vice Chancellor', 'swielher@utb.ac.rw', '785316799', 'KGL');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `Names` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(50) NOT NULL,
  `Campus` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Names`, `Email`, `Password`, `Position`, `Campus`, `Status`, `Date`) VALUES
(1, 'IGIHOZO Didier', 'ddrigihozo@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'Reception', 1, 1, '2022-06-13 22:21:55'),
(2, 'MUHAWENIMANA Noe', 'noe.redhat@gmail.com', '42f749ade7f9e195bf475f37a44cafcb', 'HR', 1, 1, '2022-06-13 22:21:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`RecordId`);

--
-- Indexes for table `attendance_users`
--
ALTER TABLE `attendance_users`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `RecordId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_users`
--
ALTER TABLE `attendance_users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
