-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 10 2014 г., 17:02
-- Версия сервера: 5.6.16
-- Версия PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `itc_guestbook`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `anonim` tinyint(4) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `message_id`, `author`, `text`, `anonim`, `date`) VALUES
(1, 3, 'admin', 'Это сообщение от администрации!', 0, '2014-11-02 13:44:48'),
(2, 3, 'user', 'А это сообщение от обычного пользователя', 0, '2014-11-02 13:45:36'),
(3, 3, 'blocked', 'А я заблокирован :(', 0, '2014-11-02 13:46:28');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) CHARACTER SET utf8 NOT NULL,
  `theme` varchar(255) CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `anonim` tinyint(4) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `author`, `theme`, `text`, `anonim`, `date`) VALUES
(1, 'admin', 'Добро пожаловать в гостевую книгу!', 'Это гостевая книга! Оставляйте здесь свои сообщения, комментируйте их!', 0, '2014-11-02 13:41:41'),
(2, 'admin', '2 сообщение', 'Это второе сообщение для гостевой книги!', 0, '2014-11-02 13:43:38'),
(3, 'admin', 'Третье сообщение гостевой книги', 'Тут должны быть комментарии от других пользователей!', 0, '2014-11-02 13:44:09');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` text CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `blocked` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `login`, `password`, `email`, `avatar`, `admin`, `blocked`) VALUES
(1, 'Админ', 'Иванов', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@my.ru', 'admin.jpg', 1, 0),
(2, 'Пользователь', 'Иванов', 'user', '5cc32e366c87c4cb49e4309b75f57d64', 'user@my.ru', 'someone.jpg', 0, 0),
(3, 'БлокированныйПользователь', 'Иванов', 'blocked', '1faaaae288fc8ca4ed1751049aa2f84f', 'blocked@my.ru', 'someone.jpg', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
