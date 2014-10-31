<?php

class m141031_145412_main_DB extends CDbMigration
{
	public function up() {
    $this->createTables();
	}
  
  public function createTables() {
    $sql = <<<SQL
-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Окт 31 2014 г., 17:02
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `status_report`
--

-- --------------------------------------------------------

--
-- Структура таблицы `flat_sessions`
--

CREATE TABLE IF NOT EXISTS `flat_sessions` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `flat_sessions`
--

INSERT INTO `flat_sessions` (`id`, `expire`, `data`) VALUES
('c738inlt9kg6hfs134bs5rrp52', 1414703689, 'gii__returnUrl|s:10:"/gii/model";gii__id|s:5:"yiier";gii__name|s:5:"yiier";gii__states|a:0:{}'),
('np0bvga1kmk5pq305satr6rso0', 1414703657, 'gii__returnUrl|s:10:"/gii/model";');

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` int(11) NOT NULL,
  `mimetype` varchar(20) NOT NULL,
  `revision` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `image`
--


-- --------------------------------------------------------

--
-- Структура таблицы `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(250) NOT NULL,
  `created_at` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `report`
--

INSERT INTO `report` (`id`, `text`, `created_at`, `owner_id`) VALUES
(1, 'sadsadsa\nasd\nas\nфыцафыафы', 1414751425, 3),
(2, 'sadsadsa\nasd\nas\nфыцафыафы', 1414751679, 3),
(3, 'sadsadsa\nasd\nas\nфыцафыафы', 1414751704, 3),
(4, 'sadasdas', 1414751882, 3),
(5, 'asdsa', 1414751903, 3),
(6, 'asdsa', 1414751907, 3),
(7, 'asdsa', 1414751908, 3),
(8, 'sadasdas', 1414752024, 3),
(9, 'sadasd', 1414752044, 3),
(10, 'sadasda', 1414752569, 3),
(11, 'asdas', 1414752613, 3),
(12, 'asdsa', 1414752648, 3),
(13, 'sadas', 1414752686, 3),
(14, 'sadsa', 1414752723, 3),
(15, 'sadas', 1414752901, 3),
(16, 'asdas', 1414752966, 3),
(17, 'asdas', 1414752996, 3),
(18, 'asdas', 1414753007, 3),
(19, 'asdas', 1414753027, 3),
(20, 'asdas', 1414753040, 3),
(21, 'sadas', 1414753062, 3),
(22, 'asdas', 1414753101, 3),
(23, 'sadas', 1414753159, 3),
(24, 'asdad', 1414758313, 3),
(25, 'sadasdas', 1414762009, 3),
(26, 'привет', 1414759685, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `status_reporter_sessions`
--

CREATE TABLE IF NOT EXISTS `status_reporter_sessions` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `status_reporter_sessions`
--

INSERT INTO `status_reporter_sessions` (`id`, `expire`, `data`) VALUES
('9u9r5sm5vqg8vsqtk1sr596500', 1414764862, ''),
('bgc9l510ja1pjsldn4hindd022', 1414763470, ''),
('f6psq3fr2jtbbjs915b3maf794', 1414763104, ''),
('u0rctea78ed1lq1qbmkvn3vtp3', 1414764031, 'c5816056857be7fa962b9e7a7c4cbace__id|s:1:"3";c5816056857be7fa962b9e7a7c4cbace__name|s:5:"admin";c5816056857be7fa962b9e7a7c4cbacelogin|s:5:"admin";c5816056857be7fa962b9e7a7c4cbacerole|s:5:"admin";c5816056857be7fa962b9e7a7c4cbace__states|a:2:{s:5:"login";b:1;s:4:"role";b:1;}');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password_hash` varchar(32) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `role` varchar(20) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `avatar_id` int(11) NOT NULL,
  `auth_token` varchar(32) NOT NULL,
  `aut_token_expires` int(11) NOT NULL,
  `timezone` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `avatar_id` (`avatar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password_hash`, `first_name`, `last_name`, `role`, `created_at`, `updated_at`, `avatar_id`, `auth_token`, `aut_token_expires`, `timezone`) VALUES
(3, 'admin', '202cb962ac59075b964b07152d234b70', 'admin', 'admin', 'admin', 0, 0, 0, '', 0, -4),
(4, 'adsa', '698d51a19d8a121ce581499d7b701668', 'sdas', 'sadas', '', 0, 0, 0, '', 0, 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

SQL;
    $connection = Yii::app()->db; 	
    $command = $connection->createCommand($sql);
    $command->execute();   
  }
  
	public function down()
	{
		echo "m140625_110023_w333_dump does not support migration down.\n";
		//return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}