-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Фев 01 2018 г., 15:55
-- Версия сервера: 5.7.20-0ubuntu0.16.04.1
-- Версия PHP: 7.2.0-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `chatty`
--

-- --------------------------------------------------------

--
-- Структура таблицы `conversations`
--

CREATE TABLE `conversations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `conversations`
--

INSERT INTO `conversations` (`id`, `user_one`, `user_two`, `created_at`, `updated_at`) VALUES
(5, 4, 5, '2018-01-12 09:00:29', '2018-01-12 09:00:29'),
(6, 7, 4, '2018-01-12 09:45:23', '2018-01-12 09:45:23'),
(7, 4, 6, '2018-01-12 12:16:15', '2018-01-12 12:16:15');

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `friend_id` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `accepted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `accepted`, `created_at`, `updated_at`) VALUES
(7, 4, 5, 1, NULL, NULL),
(10, 4, 6, 1, NULL, NULL),
(11, 5, 6, 0, NULL, NULL),
(12, 4, 7, 1, NULL, NULL),
(13, 5, 7, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `likeable`
--

CREATE TABLE `likeable` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `likeable_id` int(11) NOT NULL,
  `likeable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `likeable`
--

INSERT INTO `likeable` (`id`, `user_id`, `likeable_id`, `likeable_type`, `created_at`, `updated_at`) VALUES
(16, 4, 6, 'Chatty\\Status', '2018-01-11 12:19:41', '2018-01-11 12:19:41');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `from_user_id` int(10) UNSIGNED NOT NULL,
  `to_user_id` int(10) UNSIGNED NOT NULL,
  `conversation_id` int(10) UNSIGNED DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `readed` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `from_user_id`, `to_user_id`, `conversation_id`, `text`, `readed`, `created_at`, `updated_at`) VALUES
(9, 4, 5, 5, 'hi', 1, '2018-01-12 09:00:29', '2018-01-12 12:10:39'),
(10, 5, 4, 5, 'hello!', 1, '2018-01-12 09:35:53', '2018-01-12 12:14:22'),
(11, 7, 4, 6, 'hi! it\'s JOHN!', 1, '2018-01-12 09:45:23', '2018-01-12 12:18:24'),
(12, 4, 7, 6, 'Hello! i glad to see you! how\'re you?', 1, '2018-01-12 09:46:17', '2018-01-12 12:18:07'),
(13, 7, 4, 6, 'i\'m fine! And you? Where are you now, bro?', 1, '2018-01-12 09:47:05', '2018-01-12 12:18:24'),
(14, 4, 7, 6, 'Около 1,5 тыс. иностранным гражданам запрещен въезд в Украину из-за незаконного посещения оккупированной территории АР Крым, в том числе более 100 артистов и деятелей культуры, сообщает Государственная пограничная служба Украины.\r\n\r\nПо информации пресс-службы Госпогранслужбы, только с начала 2018 года уже выявлено более 30 лиц, посещавших оккупированный Крым вопреки установленному порядку.\r\n\r\nТакже в настоящее время по результатам мониторинга выделены более 810 человек, которые, возможно, находились на временно оккупированной территории АР Крым.\r\n\r\n\"Отметим, что в течение 2017 года составлено почти 2,3 тыс. админпротоколов по ст.204-2 КУоАП (Кодекс Украины об административных правонарушениях - ИФ) за нарушение порядка въезда на временно оккупированную территорию Украины и выезда из нее\", - сказано в сообщении.', 1, '2018-01-12 11:53:40', '2018-01-12 12:18:07'),
(15, 7, 4, 6, 'fine!', 1, '2018-01-12 11:55:56', '2018-01-12 12:18:24'),
(16, 4, 5, 5, 'love you!', 1, '2018-01-12 11:59:24', '2018-01-12 12:10:39'),
(17, 4, 7, 6, ')))', 1, '2018-01-12 12:11:09', '2018-01-12 12:18:07'),
(18, 4, 6, 7, ')))hello sister!!!', 1, '2018-01-12 12:16:15', '2018-01-12 12:17:05'),
(19, 6, 4, 7, 'hi!', 1, '2018-01-12 12:17:05', '2018-01-12 12:17:22'),
(20, 7, 4, 6, 'nice day!', 1, '2018-01-12 12:18:06', '2018-01-12 12:18:24');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_01_08_140415_CreateUsersTable', 1),
(2, '2018_01_10_143058_createFriendsTable', 2),
(3, '2018_01_11_130823_createStatusesTable', 3),
(4, '2018_01_11_142524_EditStatusesTable', 4),
(5, '2018_01_12_120113_CreateLikeableTable', 5),
(6, '2018_01_12_163334_CreateMessagesTable', 6),
(7, '2018_01_13_185408_ConversationTable', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `user_id`, `parent_id`, `body`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 'hi everyone', '2018-01-10 08:44:39', NULL),
(2, 4, NULL, 'lol', '2018-01-11 05:31:59', '2018-01-11 05:31:59'),
(3, 4, NULL, 'qwerty', '2018-01-11 05:34:09', '2018-01-11 05:34:09'),
(4, 4, 3, 'what\'s funy?', '2018-01-11 07:53:21', '2018-01-11 07:53:21'),
(5, 4, 3, 'xaxa', '2018-01-11 08:22:15', '2018-01-11 08:22:15'),
(6, 5, NULL, 'i\'m here too', '2018-01-11 09:13:05', '2018-01-11 09:13:05'),
(7, 5, 2, '???', '2018-01-11 09:13:18', '2018-01-11 09:13:18'),
(8, 4, 2, 'you!', '2018-01-11 09:13:44', '2018-01-11 09:13:44'),
(9, 4, 6, 'welcome', '2018-01-11 09:44:33', '2018-01-11 09:44:33'),
(10, 4, 6, 'great!', '2018-01-11 09:48:57', '2018-01-11 09:48:57');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `location`, `remember_token`, `created_at`, `updated_at`) VALUES
(4, 'kostik', '777koc@gmail.com', '$2y$10$iURP9wThoMn5r0101Ti0mepnMlhtrKs26IO.u5SOTJhalEaMWZfHy', 'Kostiantyn', 'Logunov', 'Vinnitsia', 'HsFjg3oNDipORRhX0vCJFKXvumZNvxbBmlqILEy9MiCcAHPEpma3Y1fTUXq3', '2018-01-10 16:06:47', '2018-01-12 12:00:38'),
(5, 'Ilonka', 'xa.13@i.ua', '$2y$10$YkHfSjLG45cWo8Ev0FxX5OO04v197fOqsvnI0Q8vP2r4Z72QlhW3e', 'Ilona', 'Pavlyk', NULL, 'jVrdzHNu404UKl8OZizbXF9wkxsRp64wvIz1cwsOJb1vH54bwuSBhf89oiGJ', '2018-01-10 16:07:14', '2018-01-10 16:07:14'),
(6, 'July', 'laravel777@gmail.com', '$2y$10$qgisRubWF8gRmyMcVMr3zugPIjHVaU8s3qZLO/cROEqG2V7FfkGC.', 'Julia', 'Logunova', NULL, 'IRCvcHl8KFs2YPVFFOFoYw2Yj1gDrJ1q6wKgxk4qgKWq65DqTsOoXq0psSDT', '2018-01-10 16:07:33', '2018-01-10 16:07:33'),
(7, 'john', 'john@gmail.com', '$2y$10$o/FQsMWKxOf5qecvWpO9gOiorARl/g4pg7VIklS7N4n35ZkmfOIOK', NULL, NULL, NULL, 'VtLVz3vTO9IBK7K3X3pdRNX454ShKqqC5GFsCqrGFSNbmbTeCghP7kqoYIyF', '2018-01-12 09:44:09', '2018-01-12 09:44:09');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `likeable`
--
ALTER TABLE `likeable`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `likeable`
--
ALTER TABLE `likeable`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
