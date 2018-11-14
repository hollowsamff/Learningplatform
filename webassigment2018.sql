-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2018 at 09:52 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webassigment2018`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_post_id` int(11) NOT NULL,
  `comment_author` varchar(50) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(10) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `indivigual_page_content`
--

CREATE TABLE `indivigual_page_content` (
  `indivigual_page_content_id` int(11) NOT NULL,
  `indivigual_page_content_text` text NOT NULL,
  `indivigual_page_content_image_one` varchar(50) NOT NULL,
  `indivigual_page_content_image_two` varchar(50) NOT NULL,
  `indivigual_page_content_page_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `indivigual_page_content`
--

INSERT INTO `indivigual_page_content` (`indivigual_page_content_id`, `indivigual_page_content_text`, `indivigual_page_content_image_one`, `indivigual_page_content_image_two`, `indivigual_page_content_page_name`) VALUES
(21, 'Sam Francis personal portfolio portfolio site~Sam Francis student at Bath College portfolio site~~Website contains:~<p><span style=\"font-family: Arial, sans-serif; font-size: 12pt;\">.The functionality to track when twitch streamers are online.</span><span style=\"font-family: Arial, sans-serif; font-size: 12pt;\">The functionalityo generate famous quotes.T</span><span style=\"font-family: Arial, sans-serif; font-size: 12pt;\">o </span><span style=\"mso-bidi-font-size: 12.0pt; mso-fareast-font-family: æ¸¸æ˜Žæœ; mso-bidi-font-family: Arial;\">display a map and the weather of the location you are using the website.A p</span><span style=\"font-family: Arial, sans-serif; font-size: 12pt;\">omodoro clock.</span><span style=\"font-family: Arial, sans-serif; font-size: 12pt;\">The functionality to search for and display Wikipedia articles</span></p>~<p>The website also contains a blog.</p><p>However, you need to <a href=\"registration.php\"> register </a>to access the blog.</p>~', 'cloud.jpg', 'cloud.jpg', 'healthandsafetyservices.php'),
(22, 'Sam Francis personal portfolio portfolio site~Sam Francis student at Bath College portfolio site~<p>Sam Francis was born in London in 1993 and is currenly study in his last year of an honers degree in computing.</p>~Key skills:~<p><span style=\"font-family: Arial, sans-serif; font-size: 12pt;\">.Good time managent.Javascript.PHP.jQuery</span></p>~~', 'cloud.jpg', 'cloud.jpg', 'whoweare.php');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` int(11) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_image` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_view_count` int(11) NOT NULL,
  `has_video` tinyint(1) NOT NULL,
  `has_podcast` tinyint(1) NOT NULL,
  `post_status` varchar(255) NOT NULL,
  `post_tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_comment_count`, `post_view_count`, `has_video`, `has_podcast`, `post_status`, `post_tags`) VALUES
(618, 2, 'Post one', 5, '2018-04-13 18:03:14', 'cloud.jpg', '<p>Post Content - blog post has a quiz</p>', 0, 82, 0, 0, 'published', '');

-- --------------------------------------------------------

--
-- Table structure for table `posts_download_links`
--

CREATE TABLE `posts_download_links` (
  `posts_download_links_id` int(11) NOT NULL,
  `posts_id` int(11) NOT NULL,
  `link_name` text NOT NULL,
  `link_href` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts_external_links`
--

CREATE TABLE `posts_external_links` (
  `posts_external_links_id` int(11) NOT NULL,
  `posts_id` int(11) NOT NULL,
  `link_href` text NOT NULL,
  `link_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts_podcasts`
--

CREATE TABLE `posts_podcasts` (
  `posts_podcasts_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `podcast_href` varchar(255) NOT NULL,
  `podcast_name` varchar(255) NOT NULL,
  `podcast_length` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts_podcasts`
--

INSERT INTO `posts_podcasts` (`posts_podcasts_id`, `post_id`, `podcast_href`, `podcast_name`, `podcast_length`) VALUES
(1, 507, '.mp3', 'Indigo Star', 264);

-- --------------------------------------------------------

--
-- Table structure for table `posts_videos`
--

CREATE TABLE `posts_videos` (
  `posts_video_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `video_name` varchar(255) NOT NULL,
  `video_href` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`cat_id`, `cat_title`) VALUES
(1, 'Anatomy and Physiology'),
(2, ' Quizzes');

-- --------------------------------------------------------

--
-- Table structure for table `post_study_questionnaire_results`
--

CREATE TABLE `post_study_questionnaire_results` (
  `post_study_questionnaire_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `preferred_teaching_method` varchar(255) NOT NULL,
  `easy_to_use` varchar(30) NOT NULL,
  `organized` varchar(30) NOT NULL,
  `helpful` varchar(30) NOT NULL,
  `complements_teaching` varchar(30) NOT NULL,
  `recommend_other_students` tinyint(1) NOT NULL,
  `hours_studying_week` int(255) NOT NULL,
  `other_comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `post_study_questionnaire_results`
--

INSERT INTO `post_study_questionnaire_results` (`post_study_questionnaire_id`, `user_id`, `preferred_teaching_method`, `easy_to_use`, `organized`, `helpful`, `complements_teaching`, `recommend_other_students`, `hours_studying_week`, `other_comments`) VALUES
(17, 12, 'blended', 'Agree', 'Neither agree nor disagree', 'Neither agree nor disagree', 'Agree', 0, 10, ''),
(18, 13, 'Classroom', 'Neither agree nor disagree', 'Disagree', 'Disagree', 'Disagree', 0, 2, ''),
(19, 10, 'Classroom', 'Neither agree nor disagree', 'Disagree', 'Disagree', 'Disagree', 0, 2, ''),
(20, 8, 'Classroom', 'Disagree', 'Strongly disagree', 'Disagree', 'Neither agree nor disagree', 0, 5, ''),
(21, 14, 'blended', 'Strongly disagree', 'Strongly disagree', 'Disagree', 'Strongly agree', 1, 2, 'My test didn\\\'t come up at the end.'),
(22, 9, 'Classroom', 'Strongly disagree', 'Strongly disagree', 'Strongly disagree', 'Strongly disagree', 0, 2, 'I am afraid I did not enjoy this or find it particularly useful'),
(23, 11, 'Classroom', 'Agree', 'Agree', 'Disagree', 'Neither agree nor disagree', 0, 2, 'I think it\\\'s a good revision aid for others, but not quite for me.');

-- --------------------------------------------------------

--
-- Table structure for table `pre_study_questionnaire_results`
--

CREATE TABLE `pre_study_questionnaire_results` (
  `pre_study_questionnaire_results_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_online_material_easy_to_use` varchar(30) NOT NULL,
  `current_online_material_easy_organized` varchar(30) NOT NULL,
  `current_online_material_easy_helpful` varchar(30) NOT NULL,
  `current_online_material_complements_teaching` varchar(30) NOT NULL,
  `preferred_teaching_method` varchar(255) NOT NULL,
  `hours_studying_week` int(11) NOT NULL,
  `pre_online_course_experience` tinyint(1) NOT NULL,
  `pre_online_course_experience_frequency` int(11) NOT NULL,
  `student_requests_for_website` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pre_study_questionnaire_results`
--

INSERT INTO `pre_study_questionnaire_results` (`pre_study_questionnaire_results_id`, `user_id`, `current_online_material_easy_to_use`, `current_online_material_easy_organized`, `current_online_material_easy_helpful`, `current_online_material_complements_teaching`, `preferred_teaching_method`, `hours_studying_week`, `pre_online_course_experience`, `pre_online_course_experience_frequency`, `student_requests_for_website`) VALUES
(65, 5, 'Strongly agree', 'Strongly agree', 'Strongly agree', 'Strongly agree', 'Classroom', 2, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `quiz_name` varchar(255) NOT NULL,
  `posts_id` int(11) NOT NULL,
  `quiz_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `quiz_name`, `posts_id`, `quiz_image`) VALUES
(194, 'Quiz one', 618, '');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_finished_classroom_students`
--

CREATE TABLE `quiz_finished_classroom_students` (
  `quiz_finished_classroom_students_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `complete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_question`
--

CREATE TABLE `quiz_question` (
  `quiz_question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `quiz_question` varchar(255) NOT NULL,
  `quiz_question_image` varchar(255) NOT NULL,
  `answer_one_correct_answer` varchar(255) NOT NULL,
  `answer_two` varchar(255) NOT NULL,
  `answer_three` varchar(255) NOT NULL,
  `answer_four` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_question`
--

INSERT INTO `quiz_question` (`quiz_question_id`, `quiz_id`, `quiz_question`, `quiz_question_image`, `answer_one_correct_answer`, `answer_two`, `answer_three`, `answer_four`) VALUES
(238, 194, 'What is five + five', '', '10', '5', '20', '5'),
(239, 194, 'What is green', '', 'Grass', 'Blue', 'Sky', 'Sand'),
(240, 194, 'What is a zebra', '', 'a animal', 'a car', 'a table', 'a pen');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `completed_pre_test` tinyint(1) NOT NULL,
  `score` int(11) NOT NULL,
  `user_first_name` varchar(255) NOT NULL,
  `user_last_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_DOB` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_password`, `reset_token`, `user_name`, `user_role`, `completed_pre_test`, `score`, `user_first_name`, `user_last_name`, `user_email`, `user_DOB`) VALUES
(5, '$2y$10$Oi27.CgoM3YQUp4icWyFP.sxQTEXUBY71YLW91UrOFYmeEHREtxI.', '', 'sam', 'admin', 1, 19, 'samf', 'francis', 'test@aol.com', '1993-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `users_online_time`
--

CREATE TABLE `users_online_time` (
  `users_online_time_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_downloaded_files`
--

CREATE TABLE `user_downloaded_files` (
  `user_downloaded_files_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `download_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_length_listen_to_podcasts`
--

CREATE TABLE `user_length_listen_to_podcasts` (
  `user_length_listen_to_podcasts_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `podcast_id` int(11) NOT NULL,
  `length_listen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_quiz_score`
--

CREATE TABLE `user_quiz_score` (
  `user_quiz_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_score` int(11) NOT NULL,
  `max_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_video_watched`
--

CREATE TABLE `user_video_watched` (
  `user_video_id` int(11) NOT NULL,
  `post_video_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `number_times_watched` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_websites_visited`
--

CREATE TABLE `user_websites_visited` (
  `user_websites_visited_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `visited_number` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `website_errors`
--

CREATE TABLE `website_errors` (
  `website_error_id` int(11) NOT NULL,
  `error_location` varchar(100) NOT NULL,
  `error_description` text NOT NULL,
  `error_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_post_id` (`comment_post_id`);

--
-- Indexes for table `indivigual_page_content`
--
ALTER TABLE `indivigual_page_content`
  ADD PRIMARY KEY (`indivigual_page_content_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_category_id` (`post_category_id`),
  ADD KEY `post_author` (`post_author`);

--
-- Indexes for table `posts_download_links`
--
ALTER TABLE `posts_download_links`
  ADD PRIMARY KEY (`posts_download_links_id`),
  ADD KEY `posts_id` (`posts_id`);

--
-- Indexes for table `posts_external_links`
--
ALTER TABLE `posts_external_links`
  ADD PRIMARY KEY (`posts_external_links_id`),
  ADD KEY `posts_id` (`posts_id`);

--
-- Indexes for table `posts_videos`
--
ALTER TABLE `posts_videos`
  ADD PRIMARY KEY (`posts_video_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `pre_study_questionnaire_results`
--
ALTER TABLE `pre_study_questionnaire_results`
  ADD PRIMARY KEY (`pre_study_questionnaire_results_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`),
  ADD KEY `posts_id` (`posts_id`);

--
-- Indexes for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD PRIMARY KEY (`quiz_question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_online_time`
--
ALTER TABLE `users_online_time`
  ADD PRIMARY KEY (`users_online_time_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_quiz_score`
--
ALTER TABLE `user_quiz_score`
  ADD PRIMARY KEY (`user_quiz_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `user_video_watched`
--
ALTER TABLE `user_video_watched`
  ADD PRIMARY KEY (`user_video_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_video_id` (`post_video_id`);

--
-- Indexes for table `user_websites_visited`
--
ALTER TABLE `user_websites_visited`
  ADD PRIMARY KEY (`user_websites_visited_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `link_id` (`link_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `indivigual_page_content`
--
ALTER TABLE `indivigual_page_content`
  MODIFY `indivigual_page_content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=622;

--
-- AUTO_INCREMENT for table `posts_external_links`
--
ALTER TABLE `posts_external_links`
  MODIFY `posts_external_links_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `posts_videos`
--
ALTER TABLE `posts_videos`
  MODIFY `posts_video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pre_study_questionnaire_results`
--
ALTER TABLE `pre_study_questionnaire_results`
  MODIFY `pre_study_questionnaire_results_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `quiz_question`
--
ALTER TABLE `quiz_question`
  MODIFY `quiz_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_online_time`
--
ALTER TABLE `users_online_time`
  MODIFY `users_online_time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=542;

--
-- AUTO_INCREMENT for table `user_quiz_score`
--
ALTER TABLE `user_quiz_score`
  MODIFY `user_quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=847;

--
-- AUTO_INCREMENT for table `user_video_watched`
--
ALTER TABLE `user_video_watched`
  MODIFY `user_video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_websites_visited`
--
ALTER TABLE `user_websites_visited`
  MODIFY `user_websites_visited_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`comment_post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts_external_links`
--
ALTER TABLE `posts_external_links`
  ADD CONSTRAINT `posts_external_links_ibfk_1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts_videos`
--
ALTER TABLE `posts_videos`
  ADD CONSTRAINT `posts_videos_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `pre_study_questionnaire_results`
--
ALTER TABLE `pre_study_questionnaire_results`
  ADD CONSTRAINT `pre_study_questionnaire_results_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `quiz_question`
--
ALTER TABLE `quiz_question`
  ADD CONSTRAINT `quiz_question_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `users_online_time`
--
ALTER TABLE `users_online_time`
  ADD CONSTRAINT `users_online_time_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_quiz_score`
--
ALTER TABLE `user_quiz_score`
  ADD CONSTRAINT `user_quiz_score_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_quiz_score_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Constraints for table `user_video_watched`
--
ALTER TABLE `user_video_watched`
  ADD CONSTRAINT `user_video_watched_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_video_watched_ibfk_2` FOREIGN KEY (`post_video_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_websites_visited`
--
ALTER TABLE `user_websites_visited`
  ADD CONSTRAINT `user_websites_visited_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_websites_visited_ibfk_2` FOREIGN KEY (`link_id`) REFERENCES `posts_external_links` (`posts_external_links_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
