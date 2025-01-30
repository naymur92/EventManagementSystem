-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2025 at 03:36 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

CREATE TABLE `attendees` (
  `attendee_id` bigint UNSIGNED NOT NULL,
  `event_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_trnx_no` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_amount` int DEFAULT NULL,
  `payment_account_no` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registration_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=>cancelled, 1=>registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `google_map_location` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `max_capacity` int UNSIGNED NOT NULL DEFAULT '0',
  `registration_fee` int NOT NULL DEFAULT '0',
  `current_capacity` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive, 1=>active',
  `user_id` bigint UNSIGNED NOT NULL COMMENT 'Host id from users table',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `name`, `location`, `google_map_location`, `description`, `start_time`, `end_time`, `max_capacity`, `registration_fee`, `current_capacity`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Climate Hope Bangladesh 2024', 'BUET, Dhaka, Bangladesh', '&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.5832856970096!2d90.39008467609905!3d23.726570789689337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8dd4855f073%3A0x27aa71bcab92ae5a!2sBangladesh%20University%20of%20Engineering%20and%20Technology%20(BUET)!5e0!3m2!1sen!2sbd!4v1738203176669!5m2!1sen!2sbd&quot; width=&quot;600&quot; height=&quot;450&quot; style=&quot;border:0;&quot; allowfullscreen=&quot;&quot; loading=&quot;lazy&quot; referrerpolicy=&quot;no-referrer-when-downgrade&quot;&gt;&lt;/iframe&gt;', '&lt;p&gt;&lt;span style=&quot;font-size: 16px; line-height: 26px; text-transform: none; font-weight: 600; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; color: #2e363f; margin-bottom: 5px; display: inline-block;&quot;&gt;Climate Hope Bangladesh 2024&lt;/span&gt;\r\n						&lt;br&gt;\r\n						&lt;/p&gt;&lt;div class=&quot;event-description-html&quot; id=&quot;event_description&quot;&gt;\r\n							\r\n							      In the face of escalating climate challenges, Bangladesh \r\nstands as a resilient nation grappling with the impacts of climate \r\nchange. The project &quot;Climate Hope Bangladesh 2024&quot; emerges as a beacon \r\nof optimism, designed to address the multifaceted issues arising from \r\nchanging climate patterns and create a sustainable pathway towards a \r\nresilient future.&lt;br&gt;\r\n&lt;br&gt;\r\nBangladesh, with its low-lying geography and dense population, is \r\nparticularly vulnerable to the adverse effects of climate change, \r\nincluding rising sea levels, extreme weather events, and changing \r\nprecipitation patterns. These factors pose severe threats to the \r\ncountry&#039;s agricultural productivity, water resources, and overall \r\nsocio-economic stability. Recognizing the urgency of the situation, \r\n&quot;Climate Hope Bangladesh&quot; strives to empower local communities, foster \r\nadaptation strategies, and promote environmental stewardship.&lt;br&gt;\r\n&lt;br&gt;\r\n“Climate Hope Bangladesh: CHOPE24” is the largest youth-oriented \r\nclimate-based seminar, along with events associated with our CCAP \r\nprogram in Bangladesh.&lt;br&gt;\r\n&lt;br&gt;\r\nWe are arranging this event to achieve certain goals or objectives. The \r\nmain goal of this event is to encourage students by engaging them with \r\nclimate scholars and international speakers, presenters, climate \r\nactivists, and innovators.&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nA Project By: GYCM-Global Youth Changemaker&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nProject Name: “Climate Hope Bangladesh: CHOPE24”&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nProject Aim: Create awareness about climate change by gathering students\r\n and young activists, initiators, inventors, social workers, \r\nmid-researchers, scientists, academia, organizations, and policymakers \r\nall together so that they can share their contributions on a single \r\nplatform. &lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n🗓️ Date: 1st and 2nd November, 2024&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n⌖ Venue: Bangladesh University of Engineering And Technology, BUET&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n⤵ Categories:&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nPrimary: Class 01-05 (pre-primary included)&lt;br&gt;\r\n&lt;br&gt;\r\nJunior: 06–08&lt;br&gt;\r\n&lt;br&gt;\r\nSecondary: 09–10&lt;br&gt;\r\n&lt;br&gt;\r\nHigher Secondary: Class 11–12&lt;br&gt;\r\n&lt;br&gt;\r\nSenior: Undergraduate and Graduation Level&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nOur event will be conducted in two parts&lt;br&gt;\r\n&lt;br&gt;\r\n1. Seminar&lt;br&gt;\r\n&lt;br&gt;\r\n2. Event or Competition &lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n⚑ Segments:&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nSeminar: Climate Hope Bangladesh: CHOPE24 Conference &lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nIndividual Events:&lt;br&gt;\r\n&lt;br&gt;\r\n1. Climate Science Olympiad Online and Offline&lt;br&gt;\r\n&lt;br&gt;\r\n2. Climate Conservation Photography Contests&lt;br&gt;\r\n&lt;br&gt;\r\n3. Climate Drawing Competition&lt;br&gt;\r\n&lt;br&gt;\r\n4. Scrapbook&lt;br&gt;\r\n&lt;br&gt;\r\n5. Climate Crossword&lt;br&gt;\r\n&lt;br&gt;\r\n6. Climate Speech&lt;br&gt;\r\n&lt;br&gt;\r\n7. Essay Competition &lt;br&gt;\r\n&lt;br&gt;\r\n8. Climate Quiz&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nTeam Events:&lt;br&gt;\r\n&lt;br&gt;\r\n1. Wall Magazine &lt;br&gt;\r\n&lt;br&gt;\r\n2. Climate Resilience Project Display&lt;br&gt;\r\n&lt;br&gt;\r\n3. Climate Hackathon&lt;br&gt;\r\n&lt;br&gt;\r\n4. Power Point Presentation &lt;br&gt;\r\n&lt;br&gt;\r\n5. Case Study Competition &lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nSpecial Segment: &lt;br&gt;\r\n&lt;br&gt;\r\nNational Climate Science Olympiad 2024 (Online)&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n💲Total Prize Pool: 1,00,000 BDT&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n🔗 Registration Link:  &lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n⏳Registration deadline: 28 October, 2024&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n💸 Registration Fee: &lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n🌿 Climate Hope Bangladesh: CHOPE24 &lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nConference Fee: 550 BDT&lt;br&gt;\r\n&lt;br&gt;\r\n📦 Includes: 2-day meal, t-shirt, pen, notepad, goodie bag, snacks and unlimited tea&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nEvent Fee: 350 BDT &lt;br&gt;\r\n&lt;br&gt;\r\nAll the events together (14 Segments)&lt;br&gt;\r\n&lt;br&gt;\r\n(T-shir and snacks may be provided)&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nConference along with all the events fee: 750 BDT only&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nNational Climate Science Olympiad (Online) Fee: 100 BDT&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nEvent Descriptions: Will be posted on Event Discussion.&lt;br&gt;\r\n&lt;br&gt;\r\nAbout Team Registration:&lt;br&gt;\r\nAll the team members must register individually.&lt;br&gt;\r\nAfter Registering they have to complete the following Team Registration form.&lt;br&gt;\r\n&lt;br&gt;\r\nTeam Registration Link:  &lt;br&gt;\r\n&lt;br&gt;\r\nA team can consist of a maximum of five members. But maximum 3 \r\nparticipants can participate at a time in a segment. Team members can be\r\n substituted in round based segments. A participant can not register in \r\nmultiple teams.&lt;br&gt;\r\n&lt;br&gt;\r\n🔴 Special_Note&lt;br&gt;\r\n&lt;br&gt;\r\n1. The event registration fee is non-refundable.&lt;br&gt;\r\n&lt;br&gt;\r\n2. Global Youth Changemaker reserves the right to make changes to the \r\nschedule, format, or any other aspect of the event. Participants will be\r\n informed of any modifications in a timely manner.&lt;br&gt;\r\n&lt;br&gt;\r\n3. The event organizers reserve the right to cancel the event due to \r\nunforeseen circumstances. In such cases, participants will be informed, \r\nand reasonable efforts will be made to provide alternatives or refunds.&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n📞 Contact&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n1. Safkat Tasin&lt;br&gt;\r\n&lt;br&gt;\r\nPublic Relations and Operations Team&lt;br&gt;\r\n&lt;br&gt;\r\nGYCM - Global Youth Changemaker&lt;br&gt;\r\n&lt;br&gt;\r\nContact : 01595640628&lt;br&gt;\r\n&lt;br&gt;\r\nFacebook Id :  &lt;a rel=&quot;nofollow noopener noreferrer&quot; class=&quot;extl track&quot; data-track=&quot;EventPage|clicks-external|200027176416750&quot; data-ehref=&quot;https://www.facebook.com/tnihal.tasin&quot; href=&quot;https://www.facebook.com/tnihal.tasin&quot; target=&quot;_blank&quot;&gt;https://www.facebook.com/tnihal.tasin&lt;/a&gt;&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n2. Roni Molla&lt;br&gt;\r\n&lt;br&gt;\r\nAssistant General Secretary,&lt;br&gt;\r\n&lt;br&gt;\r\nEnvironment Watch: BUET&lt;br&gt;\r\n&lt;br&gt;\r\nContact : 01721221948&lt;br&gt;\r\n&lt;br&gt;\r\nfacebook Id :  &lt;a rel=&quot;nofollow noopener noreferrer&quot; class=&quot;extl track&quot; data-track=&quot;EventPage|clicks-external|200027176416750&quot; data-ehref=&quot;https://www.facebook.com/share/JUjeiU6tW6nViRLa/?mibextid=LQQJ4d&quot; href=&quot;https://www.facebook.com/share/JUjeiU6tW6nViRLa/?mibextid=LQQJ4d&quot; target=&quot;_blank&quot;&gt;https://www.facebook.com/share/JUjeiU6tW6nViRLa/?mibextid=LQQJ4d&lt;/a&gt;&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n3. Abdullah Al Mohtasim&lt;br&gt;\r\n&lt;br&gt;\r\nVice President,&lt;br&gt;\r\n&lt;br&gt;\r\nEnvironment Watch: BUET&lt;br&gt;\r\n&lt;br&gt;\r\nContact : 01760009278&lt;br&gt;\r\n&lt;br&gt;\r\nfacebook Id :  &lt;a rel=&quot;nofollow noopener noreferrer&quot; class=&quot;extl track&quot; data-track=&quot;EventPage|clicks-external|200027176416750&quot; data-ehref=&quot;https://www.facebook.com/share/j5vZn3HBNduv4F4C/?mibextid=LQQJ4d&quot; href=&quot;https://www.facebook.com/share/j5vZn3HBNduv4F4C/?mibextid=LQQJ4d&quot; target=&quot;_blank&quot;&gt;https://www.facebook.com/share/j5vZn3HBNduv4F4C/?mibextid=LQQJ4d&lt;/a&gt;&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nOur social media:&lt;br&gt;\r\n&lt;br&gt;\r\n&lt;br&gt;\r\nFacebook Page: &lt;br&gt;\r\n &lt;a rel=&quot;nofollow noopener noreferrer&quot; class=&quot;extl track&quot; data-track=&quot;EventPage|clicks-external|200027176416750&quot; data-ehref=&quot;https://www.facebook.com/globalyouthchangemaker&quot; href=&quot;https://www.facebook.com/globalyouthchangemaker&quot; target=&quot;_blank&quot;&gt;https://www.facebook.com/globalyouthchangemaker&lt;/a&gt;&lt;br&gt;\r\n&lt;br&gt;\r\nWebsite:  &lt;a rel=&quot;nofollow noopener noreferrer&quot; class=&quot;extl track&quot; data-track=&quot;EventPage|clicks-external|200027176416750&quot; data-ehref=&quot;https://www.globalyouthchangemaker.org&quot; href=&quot;https://www.globalyouthchangemaker.org&quot; target=&quot;_blank&quot;&gt;https://www.globalyouthchangemaker.org&lt;/a&gt; &lt;br&gt;\r\n&lt;br&gt;\r\nOfficial E-mail: &lt;span class=&quot;&quot;&gt;&lt;a href=&quot;https://allevents.in/dhaka/climate-hope-bangladesh-2024/200027176416750#&quot;&gt;globalyouthchangemaker@gmail.com&lt;/a&gt;&lt;/span&gt;						&lt;/div&gt;\r\n\r\n						&lt;p&gt;\r\n												&lt;/p&gt;\r\n													&lt;p&gt;\r\n								&lt;br&gt;&lt;br&gt;Also check out other &lt;a style=&quot;color:#565c68&quot; href=&quot;https://allevents.in/dhaka/workshops?ref=ep_desc_also&quot; title=&quot;Dhaka Seminars &amp;amp; Workshops | Motivational, Business &amp;amp; Training Workshops in Dhaka&quot;&gt;Workshops in Dhaka&lt;/a&gt;, &lt;a style=&quot;color:#565c68&quot; href=&quot;https://allevents.in/dhaka/business?ref=ep_desc_also&quot; title=&quot;Business &amp;amp; Networking Events Dhaka, Upcoming Startup &amp;amp; Corporate Events Dhaka&quot;&gt;Business events in Dhaka&lt;/a&gt;, &lt;a style=&quot;color:#565c68&quot; href=&quot;https://allevents.in/dhaka/conferences?ref=ep_desc_also&quot; title=&quot;Conferences in Dhaka [YEAR] | Summits in Dhaka&quot;&gt;Conferences in Dhaka&lt;/a&gt;.							&lt;/p&gt;', '2025-02-11 10:00:00', '2025-02-13 17:00:00', 500, 500, 500, 1, 12, '2025-01-29 20:14:59', '2025-01-29 20:15:20'),
(2, 'Bangladesh International Marathon 2025', 'Hatirjheel, Dhaka, Bangladesh', '&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.396547038646!2d90.41777418693145!3d23.768889433051076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c78f4daff4a5%3A0xa5174fef19148a25!2sHatirjheel%20Bridge%2C%20Hatir%20Jheel%20Link%20Rd%2C%20Dhaka%201212!5e0!3m2!1sen!2sbd!4v1738203492262!5m2!1sen!2sbd&quot; width=&quot;600&quot; height=&quot;450&quot; style=&quot;border:0;&quot; allowfullscreen=&quot;&quot; loading=&quot;lazy&quot; referrerpolicy=&quot;no-referrer-when-downgrade&quot;&gt;&lt;/iframe&gt;', '&lt;p&gt;International marathon run event at Bangladesh, organised by &quot;LIMELIGHT SPORTS&quot;.&lt;br&gt;\r\nRun for a good health &amp;amp; enjoy the beauty of Bangladesh by joining this mega event.&lt;br&gt;\r\nAny male &amp;amp; female person from around the world can participate in this mega event.&lt;/p&gt;', '2025-03-05 08:00:00', NULL, 0, 0, 0, 1, 13, '2025-01-29 20:20:04', '2025-01-29 20:20:04'),
(3, 'BYLC Running with Purpose 2025', 'Hatirjheel - হাতিরঝিল, Dhaka, Bangladesh', '&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.396547038646!2d90.41777418693145!3d23.768889433051076!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c78f4daff4a5%3A0xa5174fef19148a25!2sHatirjheel%20Bridge%2C%20Hatir%20Jheel%20Link%20Rd%2C%20Dhaka%201212!5e0!3m2!1sen!2sbd!4v1738203492262!5m2!1sen!2sbd&quot; width=&quot;600&quot; height=&quot;450&quot; style=&quot;border:0;&quot; allowfullscreen=&quot;&quot; loading=&quot;lazy&quot; referrerpolicy=&quot;no-referrer-when-downgrade&quot;&gt;&lt;/iframe&gt;', '&lt;p&gt;\r\n							\r\n							      At BYLC, we believe that personal well-being is \r\nfoundational to impactful leadership. Beyond growing leadership skills \r\nand career readiness, we champion the pursuit of healthy living as a \r\ncornerstone of personal and collective transformation.&lt;br&gt;\r\n&lt;br&gt;\r\nSince its inception in 2018, the BYLC Run has been a platform for youth \r\nand communities to unite for meaningful causes. This year, we are \r\nexcited to introduce the 7.5K 𝐁𝐘𝐋𝐂 𝐑𝐮𝐧𝐧𝐢𝐧𝐠 𝐰𝐢𝐭𝐡 \r\n𝐏𝐮𝐫𝐩𝐨𝐬𝐞 𝟐𝟎𝟐𝟓, centered around the theme &quot;𝐓𝐫𝐚𝐧𝐬𝐟𝐨𝐫𝐦 \r\n𝐘𝐨𝐮𝐫 𝐇𝐞𝐚𝐥𝐭𝐡, 𝐓𝐫𝐚𝐧𝐬𝐟𝐨𝐫𝐦 𝐁𝐚𝐧𝐠𝐥𝐚𝐝𝐞𝐬𝐡.&quot;&lt;br&gt;\r\n&lt;br&gt;\r\nBangladesh is on a journey of remarkable progress, but the growing \r\nprevalence of lifestyle-related health issues threatens to undermine its\r\n potential. By addressing these challenges, we can unlock a healthier, \r\nmore resilient nation. With a focus on Sustainable Development Goal \r\n(SDG) 3—Good Health and Well-being—this year’s event emphasizes the \r\nconnection between individual health and the nation’s prosperity.&lt;br&gt;\r\n&lt;br&gt;\r\nThrough this initiative, we aim to inspire citizens to prioritize \r\nfitness, adopt healthier habits, and recognize their role in building a \r\nhealthier Bangladesh. Together, let’s take strides toward a healthier \r\nfuture—because when we transform our health, we transform our nation.&lt;br&gt;\r\n&lt;br&gt;\r\nJoin us on this purposeful journey as we run for a healthier you and a healthier Bangladesh!&lt;br&gt;\r\n__________________________________&lt;br&gt;\r\n&lt;br&gt;\r\n𝐕𝐞𝐧𝐮𝐞: 𝐇𝐚𝐭𝐢𝐫𝐣𝐡𝐞𝐞𝐥, 𝐃𝐡𝐚𝐤𝐚&lt;br&gt;\r\n&lt;br&gt;\r\n𝐃𝐚𝐭𝐞: 𝐒𝐚𝐭𝐮𝐫𝐝𝐚𝐲, 𝐅𝐞𝐛𝐫𝐮𝐚𝐫𝐲 𝟖, 𝟐𝟎𝟐𝟓&lt;br&gt;\r\n&lt;br&gt;\r\n𝐓𝐢𝐦𝐞: 𝟓:𝟑𝟎 𝐚𝐦 – 𝟕:𝟒𝟓 𝐚𝐦&lt;br&gt;\r\n&lt;br&gt;\r\n𝐃𝐢𝐬𝐭𝐚𝐧𝐜𝐞: 𝟕.𝟓𝐊&lt;br&gt;\r\n__________________________________&lt;br&gt;\r\n&lt;br&gt;\r\n𝐑𝐞𝐠𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧 𝐨𝐩𝐞𝐧𝐬 𝐚𝐭 𝟗 𝐩𝐦 𝐨𝐧 𝐓𝐮𝐞𝐬𝐝𝐚𝐲, 𝐃𝐞𝐜𝐞𝐦𝐛𝐞𝐫 𝟐𝟒, 𝟐𝟎𝟐𝟒  &lt;br&gt;\r\n&lt;br&gt;\r\n𝐑𝐞𝐠𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧 𝐟𝐞𝐞: 𝐁𝐃𝐓 𝟔𝟎𝟎&lt;br&gt;\r\n&lt;br&gt;\r\n𝐑𝐞𝐠𝐢𝐬𝐭𝐫𝐚𝐭𝐢𝐨𝐧 𝐝𝐞𝐚𝐝𝐥𝐢𝐧𝐞: Please note that we will \r\nclose registration once the first 600 runners have registered, so we \r\nencourage early registration&lt;br&gt;\r\n__________________________________&lt;br&gt;\r\n&lt;br&gt;\r\n𝐀𝐰𝐚𝐫𝐝𝐬&lt;br&gt;\r\n&lt;br&gt;\r\n• Medal&lt;br&gt;\r\n&lt;br&gt;\r\n• Certificate of Participation&lt;br&gt;\r\n&lt;br&gt;\r\nIn addition, awards in the following categories will be presented:&lt;br&gt;\r\n&lt;br&gt;\r\n𝐅𝐚𝐬𝐭𝐞𝐬𝐭 𝐑𝐮𝐧𝐧𝐞𝐫: 1st prize, 2nd prize, and 3rd prize&lt;br&gt;\r\n&lt;br&gt;\r\n𝐔𝐧𝐝𝐞𝐫 𝟏𝟓: 1st prize&lt;br&gt;\r\n&lt;br&gt;\r\n𝐎𝐯𝐞𝐫 𝟓𝟎: 1st prize&lt;br&gt;\r\n__________________________________&lt;br&gt;\r\n&lt;br&gt;\r\n𝐑𝐮𝐥𝐞𝐬 𝐚𝐧𝐝 𝐫𝐞𝐠𝐮𝐥𝐚𝐭𝐢𝐨𝐧𝐬&lt;br&gt;\r\n&lt;br&gt;\r\n• Only the registered runners will be allowed to participate in the run on February 8, 2025&lt;br&gt;\r\n&lt;br&gt;\r\n• Anyone physically fit and able to run 7.5 kilometers, regardless of age, gender, or nationality, can register for the run&lt;br&gt;\r\n&lt;br&gt;\r\n• Runners must report at the venue by 5 am&lt;br&gt;\r\n&lt;br&gt;\r\n• The cut-off time to complete the run is 75 minutes&lt;br&gt;\r\n&lt;br&gt;\r\n• Only those runners who complete the run within 75 minutes will get a medal along with the e-certificate&lt;br&gt;\r\n&lt;br&gt;\r\nWhether you&#039;re a seasoned runner or a casual walker, join BYLC&#039;s annual \r\nRun with Purpose and make a difference! Enjoy a city filled with life, \r\ngreenery, and fresh air, embrace a healthier lifestyle, and advocate for\r\n a prosperous future&lt;/p&gt;', '2025-02-20 07:30:00', NULL, 0, 600, 0, 1, 14, '2025-01-29 20:27:57', '2025-01-29 20:28:06'),
(4, 'DHAKA INTERNATIONAL MARATHON 2025', '300 Feet, Purbachal, Dhaka, Bangladesh', '&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3649.1739946151033!2d90.47877277610152!3d23.847954485022697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c980ba2ef0bf%3A0x6bc8aa8f3fe01802!2sThe%20Pizza%20Studio%20-%20Purbachal%2C%20300%20feet!5e0!3m2!1sen!2sbd!4v1738204260609!5m2!1sen!2sbd&quot; width=&quot;600&quot; height=&quot;450&quot; style=&quot;border:0;&quot; allowfullscreen=&quot;&quot; loading=&quot;lazy&quot; referrerpolicy=&quot;no-referrer-when-downgrade&quot;&gt;&lt;/iframe&gt;', '&lt;p&gt;DHAKA INTERNATIONAL MARATHON 2025 is an inaugural Marathon Race by \r\nBangladesh Army  with a view to engage students, youths, veterans and \r\nall classes of people in active and healthy lifestyle! Bangladesh Army \r\nhas been organizing large scale Marathon races since 2021. Over the \r\nyears, the races organized by this prestigious institution has \r\nsignificantly impacted the society and thousand lives to remain active, \r\npositive and agile to drive the society to a sustainable future. \r\nBangladesh Army is organizing the DHAKA INTERNATIONAL MARATHON for the \r\nfirst time- exploiting it’s years long expertise, skill and experience. \r\n Your running track will be consisting of well-connected road network \r\nwith the variation of multiple bridges at Purbachal 300 ft Highway. &lt;br&gt;\r\n&lt;br&gt;\r\nThis is an AIMS (Association of International Marathons and Distance Races) certified race. &lt;br&gt;\r\n&lt;br&gt;\r\nMarathon (42.2 KM)&lt;br&gt;\r\n&lt;br&gt;\r\nHalf Marathon (21.1 KM)&lt;br&gt;\r\n&lt;br&gt;\r\n10 KM Run&lt;br&gt;\r\n&lt;br&gt;\r\n10K Veteran Category (50 yrs and above)&lt;br&gt;\r\n&lt;br&gt;\r\n10K First Timers&lt;/p&gt;', '2025-04-02 06:30:00', NULL, 0, 1000, 0, 1, 15, '2025-01-29 20:31:59', '2025-01-29 20:32:04'),
(5, 'Zero Olympiad with Faatiha Aayat - Grand Finale', 'BIAM Foundation, Dhaka, Bangladesh', '&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.96490731626!2d90.3940795760995!3d23.748630788842906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8971a7ecbb1%3A0x58a9fd3f6a32672c!2sBIAM%20Foundation!5e0!3m2!1sen!2sbd!4v1738204454915!5m2!1sen!2sbd&quot; width=&quot;600&quot; height=&quot;450&quot; style=&quot;border:0;&quot; allowfullscreen=&quot;&quot; loading=&quot;lazy&quot; referrerpolicy=&quot;no-referrer-when-downgrade&quot;&gt;&lt;/iframe&gt;', '&lt;div class=&quot;event-description-html&quot; id=&quot;event_description&quot;&gt;\r\n							\r\n							      জিরো অলিম্পিয়াড: একটি নতুন দিগন্তের সূচনা&lt;br&gt;\r\n&lt;br&gt;\r\nবিশ্বব্যাপী সমস্যা মোকাবিলায় তরুণ প্রজন্মকে অনুপ্রাণিত ও সক্রিয় করার \r\nলক্ষ্যে শুরু হওয়া জিরো অলিম্পিয়াড একটি যুগান্তকারী উদ্যোগ। ফাতিহা আয়াতের\r\n নেতৃত্বে এই অলিম্পিয়াড তরুণদের মধ্যে সচেতনতা বৃদ্ধি, নেতৃত্বের দক্ষতা \r\nবিকাশ এবং জাতিসংঘের টেকসই উন্নয়ন লক্ষ্যমাত্রা (SDG) অর্জনে তাদের \r\nসম্পৃক্ত করতে কাজ করছে। জিরো অলিম্পিয়াড একটি প্ল্যাটফর্ম যেখানে \r\nঅংশগ্রহণকারীরা নিজ নিজ চিন্তাভাবনা ও সমাধানের মাধ্যমে সমাজের বিভিন্ন \r\nসমস্যার কার্যকর সমাধান খুঁজে বের করতে উদ্বুদ্ধ হয়।&lt;br&gt;\r\n&lt;br&gt;\r\nজিরো অলিম্পিয়াড কী?&lt;br&gt;\r\n&lt;br&gt;\r\nজিরো অলিম্পিয়াড হল একটি বৈশ্বিক প্রতিযোগিতা, যার উদ্দেশ্য হল এমন একটি \r\nপৃথিবী গড়া যেখানে শূন্য দারিদ্র্য, শূন্য ক্ষুধা, শূন্য বৈষম্য, শূন্য \r\nকার্বন নিঃসরণ এভাবে জাতিসংঘের ১৭টি টেকসই উন্নয়ন লক্ষ্যমাত্রাকে (SDGs) \r\nঅর্জনের জন্য এর সাথে সম্পর্কিত ঋণাত্বক বিষয়গুলোকে পৃথিবী থেকে  নির্মূল \r\nকরার জন্য তরুণ প্রজন্মকে উদ্বুদ্ধ করা হয়।&lt;br&gt;\r\n&lt;br&gt;\r\nএই অলিম্পিয়াডে অংশগ্রহণকারীরা বিভিন্ন কার্যক্রমের মাধ্যমে সামাজিক, \r\nঅর্থনৈতিক এবং পরিবেশগত সমস্যার সমাধানে তাদের ধারণা ও পরিকল্পনা উপস্থাপন \r\nকরে। এটি তরুণদের মধ্যে দলগত কাজের দক্ষতা, সমস্যা সমাধানের ক্ষমতা এবং \r\nনেতৃত্বের গুণাবলি বিকাশে সহায়তা করে।&lt;br&gt;\r\n&lt;br&gt;\r\nজিরো অলিম্পিয়াডের প্রয়োজনীয়তা:&lt;br&gt;\r\n&lt;br&gt;\r\nবিশ্বব্যাপী বিভিন্ন সমস্যা, যেমন দারিদ্র্য, ক্ষুধা, বৈষম্য, এবং পরিবেশ \r\nদূষণ মোকাবিলায় তরুণদের সক্রিয় অংশগ্রহণ অত্যন্ত গুরুত্বপূর্ণ। কিন্তু \r\nপ্রথাগত শিক্ষা ব্যবস্থা তরুণদের এই ধরনের দক্ষতা ও জ্ঞান সরবরাহে অনেক \r\nসময়ই ব্যর্থ হয়।&lt;br&gt;\r\n&lt;br&gt;\r\nতরুণরা যদি ছোট বয়স থেকেই সচেতন হয় এবং সমাধানমুখী চিন্তাভাবনার সাথে বড় \r\nহয়, তবে তারা ভবিষ্যতে বিশ্ব পরিবর্তনের গুরুত্বপূর্ণ অংশ হয়ে উঠতে পারে। \r\nজিরো অলিম্পিয়াড এমন একটি মঞ্চ যেখানে এই শিক্ষা এবং প্রেরণা দেওয়া হয়।&lt;br&gt;\r\n&lt;br&gt;\r\nজিরো অলিম্পিয়াডের লক্ষ্য ও উদ্দেশ্য:&lt;br&gt;\r\n&lt;br&gt;\r\n১. টেকসই উন্নয়ন লক্ষ্যমাত্রার প্রচার: জাতিসংঘের SDG-এর গুরুত্ব সম্পর্কে \r\nতরুণদের অবগত করা এবং তাদের নিজস্ব উদ্যোগে এই লক্ষ্য অর্জনের পথে কাজ করতে\r\n উদ্বুদ্ধ করা।&lt;br&gt;\r\n২. নেতৃত্বের বিকাশ: তরুণদের মধ্যে নেতৃত্বের গুণাবলি তৈরি করা, যা তাদের ভবিষ্যতের সমস্যাগুলো সমাধানে সক্ষম করে তুলবে।&lt;br&gt;\r\n৩. সামাজিক দায়িত্ববোধ বৃদ্ধি: তরুণ প্রজন্মের মধ্যে সমাজের প্রতি \r\nদায়িত্বশীলতা এবং সবার জন্য একটি সুন্দর পৃথিবী গড়ার ইচ্ছা সৃষ্টি করা।&lt;br&gt;\r\n৪. সমস্যা সমাধানে দক্ষতা বৃদ্ধি: দলগত কার্যক্রমের মাধ্যমে সমস্যা সমাধানের দক্ষতা শেখানো।&lt;br&gt;\r\n&lt;br&gt;\r\n১৭ জন ফাইনালিস্ট যেসকল পুরষ্কার পাবেন:&lt;br&gt;\r\n&lt;br&gt;\r\nOverseas Universities গুলোতে ভর্তির সময় SDG Fellowship এর জন্য আবেদনের ক্ষেত্রে সার্বিক সহায়তা।&lt;br&gt;\r\n&lt;br&gt;\r\nপ্রতিবছর জাতিসংঘে অনুষ্ঠিত SDG Summit এ অংশ গ্রহণের জন্য রিকমেন্ডেশন।&lt;br&gt;\r\n &lt;br&gt;\r\nদেশ ব্যাপী সকল শিক্ষা প্রতিষ্ঠানে গঠিত Zero Olympiad ক্লাবে বছরব্যাপী \r\nপরিচালিত নানান কর্মকান্ডের মাধ্যমে নির্বাচিতদের National Zero Olympiad \r\nEnvoy তে অন্তর্ভুক্তি।&lt;br&gt;\r\n&lt;br&gt;\r\nDaffodil International Professional Training Institute এর তরফ থেকে থাকবে\r\n ৮টি মডিউল ও ২৪টি সেশনে সাজানো “Empowering Future Leaders: A \r\nComprehensive Program on Entrepreneurship, Sustainable Development, and \r\n21st-Century Skills” শীর্ষক অনলাইন কোর্সে এনরোল করার জন্য ফুল স্কলারশিপ।\r\n &lt;br&gt;\r\n&lt;br&gt;\r\nS@ifur’s থেকে ২৭টি ক্লাশ ও ৩৯টি লেসনে সাজানো অনলাইন IELTS কোর্সে এনরোল করার জন্য ফুল স্কলারশিপ। &lt;br&gt;\r\n&lt;br&gt;\r\n10 Minute School থেকে কাস্টমাইজড কোর্স স্কলারশিপ।&lt;br&gt;\r\n&lt;br&gt;\r\nMana Bay Water Park এর তরফ থেকে থাকছে 60,000 বর্গফুট জায়গা জুড়ে ১৭টি \r\nথ্রিলিং রাইড এ Unlimited Aquatic Adventure উপভোগ করার জন্য Day Long \r\nPass.  &lt;br&gt;\r\n&lt;br&gt;\r\nAd Din Foundation এর তরফ থেকে থাকছে জিরো ফি মেডিক্যাল ভাউচার। &lt;br&gt;\r\n&lt;br&gt;\r\nBangladesh Sports Development Foundation এর তরফ থেকে Professional Coach \r\nএর কাছে তোমার পছন্দের Sports শেখার জন্য থাকছে ফুল স্কলারশিপ।&lt;br&gt;\r\n&lt;br&gt;\r\nজাতিসংঘের সার্টিফিকেট কোর্স: &lt;br&gt;\r\n&lt;br&gt;\r\nযারা Zero Olympiad এ রেজিস্ট্রেশন করবে তাদেরকে রেজিস্ট্রেশন করার সাথে \r\nসাথেই ইমেইলের মাধ্যমে United Nations Institute for Training and Research\r\n (UNITAR) এবং UN Climate Change Learning Partnership (UNCC ELearn) থেকে \r\nজাতিসংঘ স্বীকৃত একাধিক কোর্স করার লিংক পাঠানো হবে। &lt;br&gt;\r\n&lt;br&gt;\r\nকোর্সগুলো অনলাইনে বিনামুল্যে নিজের সুবিধামত সময়ে করা যাবে। প্রতিটা কোর্স\r\n সম্পন্ন করার সাথে সাথে জাতিসংঘের এই প্রতিষ্ঠান থেকেই সার্টীফিকেট প্রদান\r\n করা হবে ইমেইলের মাধ্যমে।&lt;br&gt;\r\n&lt;br&gt;\r\nফাতিহা আয়াত ২০২৩ সালে এই কোর্স করেছিল যা তাকে জাতিসংঘে বিভিন্ন বিষয়ে বক্তব্য রাখার সুযোগ পেতে দারুণ সাহায্য করে। &lt;br&gt;\r\n&lt;br&gt;\r\nআরেকটা খুশীর খবর হল, এই কোর্স থেকেই থাকবে ১০ জানুয়ারি অনুষ্ঠিতব্য  Zero Olympiad এর ১ম রাউন্ডের ২০টি MCQ প্রশ্ন।&lt;br&gt;\r\n&lt;br&gt;\r\nপ্রফেশনাল লাইফে বায়োডাটা/সিভি/রিজিউম/প্রোফাইল/পোর্টফলিওতে এই কোর্স \r\nসম্পন্ন করার তথ্য উল্লেখ করলে প্রাপ্ত সার্টিফিকেট প্রেজেন্ট করলে \r\nনিঃসন্দেহে তা তোমাকে অন্যদের থেকে এগিয়ে রাখবে। &lt;br&gt;\r\n&lt;br&gt;\r\nএছাড়াও থাকছে – &lt;br&gt;\r\n&lt;br&gt;\r\n•	কেস স্টাডি প্রতিযোগিতা: যেখানে দলগুলো বিভিন্ন সামাজিক সমস্যার সমাধান খুঁজে বের করবে।&lt;br&gt;\r\n•	ডিবেট এবং পাবলিক স্পিকিং: অংশগ্রহণকারীরা তাদের ধারণাগুলো উপস্থাপন করবে এবং নিজেদের যুক্তি তুলে ধরবে।&lt;br&gt;\r\n•	ওয়ার্কশপ ও সেমিনার: দক্ষতা উন্নয়নের জন্য বিশেষ প্রশিক্ষণ প্রাপ্ত হবে।&lt;br&gt;\r\n•	প্রকল্প বাস্তবায়ন: অর্থায়নের মাধ্যমে অংশগ্রহণকারীদের উদ্ভাবনী ধারণাগুলো বাস্তবায়নের সুযোগ প্রদান করা হবে।&lt;br&gt;\r\n&lt;br&gt;\r\nপ্রথম রাউন্ড | MCQ Contest:&lt;br&gt;\r\n&lt;br&gt;\r\n২০২৫ সালের জানুয়ারি মাসে তুমি কোন ক্লাসে পড় সেই অনুযায়ী নির্ধারিত ক্যাটাগরিতে রেজিস্ট্রেশন কর। &lt;br&gt;\r\n&lt;br&gt;\r\nরেজিস্ট্রেশনের পরে তুমি যেই ইমেইল পেয়েছ সেখানে জাতিসংঘ স্বীকৃত যে কোর্স \r\nএর তালিকা দেয়া আছে সেখান থেকেই প্রথম রাউন্ডের MCQ পরীক্ষা অনুষ্ঠিত হবে \r\n১০ জানুয়ারী।  &lt;br&gt;\r\n&lt;br&gt;\r\nপ্রথম রাউণ্ডের MCQ থেকে নির্বাচিত বিজয়ীদের দ্বিতীয় রাউন্ডে অংশ গ্রহণের জন্য ইমেইল করা হবে। &lt;br&gt;\r\n&lt;br&gt;\r\nরেজিস্ট্রেশন লিংক | Registration Link&lt;br&gt;\r\n &lt;br&gt;\r\n&lt;br&gt;\r\nদ্বিতীয় রাউন্ড | Three Minute Thrill:&lt;br&gt;\r\n&lt;br&gt;\r\nপ্রথম রাউন্ডের MCQ পরীক্ষায় সর্বোচ্চ নম্বর প্রাপ্তির ভিত্তিতে দ্বিতীয় রাউন্ডে অংশ গ্রহণের জন্য ইমেইল করা হবে।&lt;br&gt;\r\n&lt;br&gt;\r\nইমেইলে উল্লেখিত এসডিজি সংক্রান্ত বিষয়ের উপর একটা তিন মিনিটের ভিডিও তৈরি \r\nকরে নিজের/পরিবারের/বন্ধুর সোশ্যাল মিডিয়ায় #ZeroOlympiad সহ পোস্ট করতে \r\nহবে। &lt;br&gt;\r\n&lt;br&gt;\r\nসেই পোস্টের লিংক আমাদেরকে পাঠাতে হবে নীচের ফর্মে। ভিডিওর লিংক জমা দেয়ার শেষ তারিখ ৩১ জানুয়ারী&lt;br&gt;\r\n&lt;br&gt;\r\nঢাকায় গ্র্যান্ড ফিনালে অনুষ্ঠানে কোন ৫১ জন: &lt;br&gt;\r\n&lt;br&gt;\r\nদ্বিতীয় রাউন্ডের তিন মিনিটের ভিডিও দেখে সম্মানিত জুরি বোর্ডের \r\nসিদ্ধান্তের ভিত্তিতে প্রতিটি এসডিজি’র জন্য তিনজন করে মোট ৫১ জনকে ঢাকায় \r\nগ্র্যান্ড ফিনালে অনুষ্ঠানে আমন্ত্রণ জানানো হবে দুইজন ফ্রেন্ডস বা \r\nফ্যামিলি সহ। এই ৫১ জন থেকে সতের জনকে মঞ্চে ডাকা হবে নির্ধারিত এসডিজি \r\nঅর্জনের জন্য রিলেটেড নেগেটিভ ইস্যুটা তারা কীভাবে Zero করতে চায় সেই বিষয়ে\r\n পাওয়ার পয়েন্ট প্রেজেন্টেশন দেয়ার জন্য। &lt;br&gt;\r\n&lt;br&gt;\r\nSDG Defender, SDG Leader, SDG Pioneer Award:&lt;br&gt;\r\n&lt;br&gt;\r\nপঞ্চম শ্রেণী/Grade 5/PYP 5/তাইসির/সমমান থেকে অষ্টম শ্রেণী/Grade 8/MYP \r\n3/হেদায়েতুন্নাহু পর্যন্ত যারা অংশ নিবে তাদেরকে SDG Activist বলা হবে। \r\nপ্রথম ও দ্বিতীয় রাউন্ডে বিজয়ী হয়ে গ্র্যান্ড ফিনালে অনুষ্ঠানে জুরি \r\nবোর্ডের সামনে চারটি ক্লাশ (পঞ্চম, ষষ্ঠ, সপ্তম ও অষ্টম) থেকে চারজন SDG \r\nActivist প্রেজেন্টেশন দেবেন। সর্বোচ্চ নম্বর প্রাপ্ত কে SDG Defender \r\nঅ্যাওয়ার্ড দেয়া হবে।&lt;br&gt;\r\n&lt;br&gt;\r\nনবম শ্রেণী/Grade 9/MYP 4/কাফিয়া ও বেকায়া/সমমান থেকে এইচএসসি \r\nপরিক্ষার্থী/A Level Candidate/জালালাইন/সমমান পর্যন্ত যারা অংশ নিবে \r\nতাদেরকে SDG Ambassador বলা হবে। নবম, দশম, এসএসসি পরিক্ষার্থী, একাদশ, \r\nদ্বাদশ, এইচএসসি পরিক্ষার্থী – এই ছয়টি ক্লাসের ছয়জন SDG Ambassador \r\nগ্র্যান্ড ফিনালে অনুষ্ঠানে জুরি বোর্ডের সামনে প্রেজেন্টেশন দেবেন। \r\nসর্বোচ্চ নম্বর প্রাপ্ত কে SDG Leader অ্যাওয়ার্ড দেয়া হবে।&lt;br&gt;\r\n&lt;br&gt;\r\n১ম বর্ষ/ফাজিল/মেশকাত থেকে স্নাতকোত্তর/কামিল/দাওরা পর্যন্ত ডিগ্রি পাস, \r\nস্নাতক, সম্মান, স্নাতকোত্তর, মেডিক্যাল, ইঞ্জিনিয়ারিং, মেরিন, মেরিন \r\nফিশারিজ, ডিপ্লোমা, কাওমি ও আলিয়া মাদ্রাসার সাতজন SDG Achiever গ্র্যান্ড \r\nফিনালে অনুষ্ঠানে জুরি বোর্ডের সামনে প্রেজেন্টেশন দেবেন। সর্বোচ্চ নম্বর \r\nপ্রাপ্ত কে SDG Pioneer অ্যাওয়ার্ড দেয়া হবে।&lt;br&gt;\r\n&lt;br&gt;\r\nটাইমলাইন&lt;br&gt;\r\n&lt;br&gt;\r\n•	রেজিস্ট্রেশন চলবে ৬ জানুয়ারি পর্যন্ত&lt;br&gt;\r\n&lt;br&gt;\r\n•	প্রথম রাউন্ডের MCQ পরীক্ষা অনুষ্ঠিত হবে ১০ জানুয়ারী&lt;br&gt;\r\n&lt;br&gt;\r\n•	দ্বিতীয় রাউন্ডের জন্য সোশ্যাল মিডিয়ায় আপলোড করা ভিডিওর লিংক জমা দেয়ার শেষ তারিখ ৩১ জানুয়ারী&lt;br&gt;\r\n&lt;br&gt;\r\n•	ঢাকায় গ্র্যান্ড ফিনালে অনুষ্ঠিত হবে ৮ ফেব্রুয়ারি &lt;br&gt;\r\n&lt;br&gt;\r\nফাতিহা আয়াত এবং জিরো অলিম্পিয়াড&lt;br&gt;\r\n&lt;br&gt;\r\n১৩ বছর বয়সী ফাতিহা আয়াতের স্বপ্ন এবং নেতৃত্বেই জিরো অলিম্পিয়াডের সূচনা। \r\nতিনি কেবল একজন আন্তর্জাতিক ব্যক্তিত্ব নন, বরং শিশু অধিকার, জলবায়ু \r\nপরিবর্তন, এবং টেকসই উন্নয়নের একজন সক্রিয় কর্মী। তিনি জাতিসংঘ এবং বিভিন্ন\r\n আন্তর্জাতিক প্ল্যাটফর্মে তার দৃষ্টিভঙ্গি উপস্থাপন করেছেন। তার লক্ষ্য \r\nতরুণ প্রজন্মকে এমনভাবে প্রস্তুত করা, যাতে তারা ভবিষ্যতে বিশ্বে ইতিবাচক \r\nপরিবর্তন আনতে পারে। ফাতিহা বিশ্বাস করেন, &quot;যদি তরুণরা তাদের ক্ষমতার \r\nসর্বোচ্চ ব্যবহার করে কাজ করে, তবে তারা পৃথিবীকে শূন্য সমস্যার পৃথিবীতে \r\nরূপান্তর করতে পারবে।&quot;&lt;br&gt;\r\n&lt;br&gt;\r\nউপসংহার&lt;br&gt;\r\n&lt;br&gt;\r\nজিরো অলিম্পিয়াড কেবল একটি প্রতিযোগিতা নয়, এটি একটি আন্দোলন। এটি তরুণ \r\nপ্রজন্মকে নতুন পথ দেখায় এবং তাদের মধ্যে এমন একটি বিশ্বাস সৃষ্টি করে যে, \r\nতারা চাইলেই পৃথিবীর সমস্যা সমাধানে ভূমিকা রাখতে পারে।&lt;br&gt;\r\n&lt;br&gt;\r\nফাতিহা আয়াতের এই উদ্যোগ প্রমাণ করে যে, তরুণদের ক্ষমতা এবং সঠিক \r\nদিকনির্দেশনা পৃথিবীকে একটি সুন্দর, টেকসই এবং শূন্য সমস্যার পৃথিবীতে \r\nরূপান্তর করতে পারে। জিরো অলিম্পিয়াডের মাধ্যমে ফাতিহা কেবল ভবিষ্যৎ \r\nনেতৃত্ব তৈরি করছেন না, বরং আমাদের প্রজন্মের জন্য একটি নতুন দৃষ্টান্ত \r\nস্থাপন করছেন।						&lt;/div&gt;\r\n\r\n						&lt;p&gt;\r\n												&lt;/p&gt;\r\n													\r\n								&lt;p&gt;&lt;/p&gt;', '2025-02-20 10:30:00', NULL, 0, 0, 0, 1, 16, '2025-01-29 20:35:13', '2025-01-29 20:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` bigint UNSIGNED NOT NULL,
  `operation_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL COMMENT 'id of operations table',
  `filepath` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fileinfo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `operation_name`, `table_id`, `filepath`, `filename`, `fileinfo`, `created_by`, `deleted_by`, `created_at`, `deleted_at`) VALUES
(7, 'users', 1, 'users', '1_1737907625.jpg', 'profile_picture', 1, NULL, '2025-01-26 10:07:05', NULL),
(12, 'events', 1, 'events', '1_1738203299.jpg', 'banner_image', 12, NULL, '2025-01-29 20:14:59', NULL),
(13, 'events', 2, 'events', '2_1738203604.jpg', 'banner_image', 13, NULL, '2025-01-29 20:20:04', NULL),
(14, 'users', 14, 'users', '14_1738203876.jpg', 'profile_picture', 14, NULL, '2025-01-29 20:24:36', NULL),
(15, 'events', 3, 'events', '3_1738204077.jpg', 'banner_image', 14, NULL, '2025-01-29 20:27:57', NULL),
(16, 'events', 4, 'events', '4_1738204319.jpg', 'banner_image', 15, NULL, '2025-01-29 20:31:59', NULL),
(17, 'events', 5, 'events', '5_1738204513.jpg', 'banner_image', 16, NULL, '2025-01-29 20:35:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `host_details`
--

CREATE TABLE `host_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `host_details`
--

INSERT INTO `host_details` (`id`, `user_id`, `description`, `location`) VALUES
(1, 14, '&lt;p&gt;BYLC \r\nis a registered non-profit and non-partisan youth leadership training \r\ninstitute in Bangladesh. For details, visit http://www.bylc.org/&lt;/p&gt;&lt;div class=&quot;mt10&quot; style=&quot;overflow-wrap:break-word&quot;&gt;&lt;span style=&quot;font-weight: 600;&quot;&gt;Website Link:&lt;/span&gt; http://www.bylc.org&lt;/div&gt;', 'http://www.bylc.org');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=>inactive, 1=>active',
  `type` tinyint NOT NULL DEFAULT '3' COMMENT '1=>superuser, 2=>host, 3=>general_user',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint NOT NULL DEFAULT '0',
  `updated_by` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `mobile`, `email_verified_at`, `status`, `type`, `password`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Naymur Rahman', 'naymur92@gmail.com', '01737036324', NULL, 1, 1, '$2y$10$.HRiuajTuUBzB6QcgjoXcu0jMasD5XZZSymxn0jZkNZ12rdI0qVva', 0, 1, '2025-01-23 01:51:37', '2025-01-26 12:46:40'),
(3, 'Md. Kamrul Hasan', 'kamrul@gmail.com', '01558981652', NULL, 0, 2, '$2y$10$qQji/ujnkB6upiQXyENnR.UHy.XkqIx1YGiSpDbCv/F0616FvnLiG', 0, 1, '2025-01-24 09:27:53', '2025-01-26 12:03:58'),
(4, 'Abdur Rahman', 'abdrahman@gmail.com', '01737036324', NULL, 0, 3, '$2y$10$6ZHQFuUJDRq5mdYCmsJ5lu/cli9URQ7fG4aH5mto3HEjmmeeIOPuC', 1, 1, '2025-01-25 05:35:22', '2025-01-25 08:35:39'),
(12, 'GYCM - Global Youth Change Maker', 'admin@gycm.com', '', NULL, 1, 2, '$2y$10$I4WSau95kQMVYC1Bb3HHq.EUZnkLndXUAhKh7UZy0U7MP2cLSYm9C', 0, 0, '2025-01-29 20:07:38', '2025-01-29 20:07:38'),
(13, 'LimeLight Sports', 'admin@limelight.com', '', NULL, 1, 2, '$2y$10$kppvtTdntOu3NhHCJVpcje5qA/N2q8EFGggXUvKkL39ogBNX.tCT2', 0, 0, '2025-01-29 20:16:59', '2025-01-29 20:16:59'),
(14, 'Bangladesh Youth Leadership Center (BYLC)', 'admin@bylc.com', '', NULL, 1, 2, '$2y$10$6pi3sPVFhwsnohqUxGK5N.Guxv5.F3SBDHNLdo.1hRSTboDwXlxOS', 0, 14, '2025-01-29 20:23:54', '2025-01-29 20:25:21'),
(15, 'Dhaka International Marathon', 'admin@dim.com', '', NULL, 1, 2, '$2y$10$kg4G5eeNEsLzVB6/Jn1lUudirDmxtY3TUQnWaUIW1EGaLNH.WUO76', 0, 0, '2025-01-29 20:29:18', '2025-01-29 20:29:18'),
(16, 'Zero Olympiad', 'admin@zo.com', '', NULL, 1, 2, '$2y$10$/jXqGv0iY/G.Obz57KTEMuVkNVpxAkVegRcIkWttZR990NIME7i0q', 0, 0, '2025-01-29 20:33:04', '2025-01-29 20:33:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendees`
--
ALTER TABLE `attendees`
  ADD PRIMARY KEY (`attendee_id`),
  ADD KEY `attendees_user_id_foreign` (`user_id`),
  ADD KEY `attendees_event_id_foreign` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `events_user_id_foreign` (`user_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `files_created_by_foreign` (`created_by`),
  ADD KEY `files_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `host_details`
--
ALTER TABLE `host_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendees`
--
ALTER TABLE `attendees`
  MODIFY `attendee_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `host_details`
--
ALTER TABLE `host_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendees`
--
ALTER TABLE `attendees`
  ADD CONSTRAINT `attendees_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `files_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `host_details`
--
ALTER TABLE `host_details`
  ADD CONSTRAINT `host_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
