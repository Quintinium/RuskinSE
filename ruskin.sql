-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 09, 2016 at 12:22 AM
-- Server version: 5.7.11-log
-- PHP Version: 5.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ruskin`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `doctype` text NOT NULL,
  `divtype` text NOT NULL,
  `rhyme` text NOT NULL,
  `meter` text NOT NULL,
  `ispoem` tinyint(1) NOT NULL,
  `text` mediumtext NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `title`, `doctype`, `divtype`, `rhyme`, `meter`, `ispoem`, `text`, `url`) VALUES
(1, 'some random title', 'witness', '', 'aa', '--+_-+=_=-', 1, 'lalalala search these words', ''),
(2, '"Glen of Glenfarg" ("Glen of Glenfarg thy beauteous rill")', 'glosses', '', '', '', 0, '<body>\r\n            <div type="glosses">\r\n                <note xml:id="CHARLESSWAINGLOSS" resp="#DCH">&#x201C;charles&#x02BC;s wain&#x201D; (MS III; <hi rend="italic">Poems</hi> [1891]; <hi rend="italic">Works</hi> [1903])&#x2014;Noting \r\n                    the reference to <name type="constellation" corresp="#CHARLESSWAIN">Charles&#x02BC;s Wain</name>,\r\n                <ref type="note" subtype="biographical" target="viljoen_h_g_note.php"><persName corresp="#HGV">Helen Gill Viljoen</persName></ref>\r\n                (<ref type="bibliography" target="bibliography.php#VILJOENPAPERS">&#x201C;Viljoen Papers&#x201D;</ref>,\r\n                box F.X) remarks that <persName corresp="#JR">Ruskin</persName> could have learned the constellations from\r\n                <ref type="note" subtype="biographical" target="joyce_jeremiah.php"><persName corresp="#JJ">Jeremiah Joyce</persName></ref>\r\n                (<ref type="bibliography" target="bibliography.php#SCIENTIFICDIALOGUES">Joyce, <hi rend="italic">Scientific Dialogues</hi></ref>, <!--Entry needed here.-->) or from\r\n                <ref type="note" subtype="biographical" target="day_thomas_note.php"><persName corresp="#TD">Thomas Day</persName></ref>\r\n                (<ref type="bibliography" target="bibliography.php#SANDFORDANDMERTON">Day, <hi rend="italic">Sandford and Merton</hi></ref>, <!--Entry needed here.-->). For\r\n                <persName corresp="#JR">Ruskin</persName>&#x02BC;s interest in this constellation, see also &#x201C;Harry and Lucy,&#x201D; Vol. 2, chap. 1; and &#x201C;The\r\n                Constellations: Northern, Some of the Zodiac, and Some of the Southern.&#x201D;</note>\r\n                 \r\n                <note xml:id="SEPTEMBER1826GLOSS" resp="#DCH">Between lines 24 and 25&#x2014;The Library Edition incorrectly identifies <persName corresp="#JJR">John James Ruskin</persName> as adding the date <date when="1826-09-09">9 September 1826</date>.\r\n                The hand, which is certainly <persName corresp="#MR">Margaret Ruskin</persName>&#x02BC;s, is identical to that for a similar annotation in MS I.</note>\r\n                 \r\n                <note xml:id="WORDINBRACKETSGLOSS" resp="#CWB">&#x201C;[lost]&#x201D; (<hi rend="italic">Poems</hi> [1891]; <hi rend="italic">Works</hi> [1903])&#x2014;<ref type="note" subtype="biographical" target="collingwood_w_g_note.php">W. G. Collingwood</ref> \r\n                    comments that the &#x201C;word in square brackets,&#x201D; which he supplied, &#x201C;is wanting in the original&#x201D; \r\n                    (<ref type="bibliography" target="bibliography.php#POEMS4D1891"><hi rend="italic">Poems</hi> [4<hi rend="superscript">o</hi>, 1891]</ref>, 1:xxv; \r\n                    <ref type="bibliography" target="bibliography.php#POEMS8D1891"><hi rend="italic">Poems</hi> [8<hi rend="superscript">o</hi>, 1891]</ref>, 1:xii). \r\n                    In the sole extant manuscript version, there is no evidence of such a word existing. <persName corresp="#WGC">Collingwood</persName> assumes <persName corresp="#JR">Ruskin</persName>&#x02BC;s intention, \r\n                    since, without the word, the second line in the stanza would deviate from the &#x201C;abab&#x201d; rhyme scheme that prevails throughout the remainder of poem.</note>\r\n            </div>\r\n        </body>', '');

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL,
  `docid` int(11) NOT NULL,
  `tag` text NOT NULL,
  `subtag` text NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keywords`
--

INSERT INTO `keywords` (`id`, `docid`, `tag`, `subtag`, `content`) VALUES
(1, 2, 'name', 'constellation', 'Charles&#x02BC;s Wain'),
(2, 2, 'persName', '', 'Helen Gill Viljoen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keywords`
--
ALTER TABLE `keywords`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `keywords`
--
ALTER TABLE `keywords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
