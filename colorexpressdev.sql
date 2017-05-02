-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 17 2017 г., 02:57
-- Версия сервера: 5.7.13
-- Версия PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `colorexpressdev`
--

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction`
--

CREATE TABLE IF NOT EXISTS `advertising_construction` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `nearest_locations` text,
  `traffic_info` text,
  `has_traffic_lights` tinyint(1) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `size_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `type_id` int(11) NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `advertising_construction`
--

INSERT INTO `advertising_construction` (`id`, `name`, `nearest_locations`, `traffic_info`, `has_traffic_lights`, `address`, `size_id`, `price`, `type_id`, `latitude`, `longitude`) VALUES
(1, 'РК_3х5_1551', 'Ун-сам Невель, велодорожка', '1000 машин в час в "час-пик"', 0, 'ул. Якубова 48/1', 1, '1000', 2, '53.8555531', '27.59451'),
(2, 'РК_12х3_4234', 'Парк Высоких Технологий, МКАД', '2000 машин в час в "час-пик"', 1, 'ул. Купревича д. 3', 3, '1500', 4, '53.9281511', '27.6814807'),
(3, 'РК_9х3_4234', 'Ботанический сад, Академия Наук, БГУИР, БНТУ', '2500 машин в час в "час-пик"', 1, 'ул. Ботаническая 10', 5, '2500', 5, '53.9083611', '27.6078137'),
(4, 'РК_36х1_8_324939', 'Центр "Матери и ребенка", трамвайное кольцо', '1500 машин в час в "час-пик"', 1, 'ул. Орловская д.18', 5, '3500', 6, '53.9323967', '27.5604594'),
(5, 'РК_8х4_5435', 'Торговый центр "Магнит"', '2500 машин в час в "час-пик"', 1, 'ул. Шаранговича 13', 2, '2700', 1, '53.8869725', '27.4516378'),
(6, 'РК_4х3_34252', 'ТЦ Простор', '2500 машин в час в "час-пик"', 0, 'ул. Каменногорская 2', 6, '5999', 3, '53.9110376', '27.4154618');

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_image`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_image` (
  `advertising_construction_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_reservation`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_reservation` (
  `id` int(11) NOT NULL,
  `advertising_construction_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_reservation_status`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_reservation_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_size`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_size` (
  `id` int(11) NOT NULL,
  `size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `advertising_construction_size`
--

INSERT INTO `advertising_construction_size` (`id`, `size`) VALUES
(1, '9x3'),
(2, '8x4'),
(3, '12x3'),
(4, '12x1,8'),
(5, '36x1,8'),
(6, '4,5x3'),
(7, '6x3'),
(8, '2x1,3'),
(9, '16x6'),
(10, '13,5x5');

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_type`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `advertising_construction_type`
--

INSERT INTO `advertising_construction_type` (`id`, `name`) VALUES
(1, 'Щитовые рекламные конструкции'),
(2, 'Брандмауэры'),
(3, 'Настенные световые короба'),
(4, 'Рекламные конструкции на путепроводах'),
(5, 'Надкрышные световые короба'),
(6, 'Рекламные конструкции в метро, переходе');

-- --------------------------------------------------------

--
-- Структура таблицы `contact_us_submission`
--

CREATE TABLE IF NOT EXISTS `contact_us_submission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cv_id` int(11) DEFAULT NULL,
  `message` text,
  `submitted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1489707782),
('m170213_121426_initial_migration', 1489707784),
('m170213_135848_initial_database_structure', 1489707785),
('m170301_121052_add_our_clients', 1489707785),
('m170310_155514_add_vacancies', 1489707785),
('m170311_111112_fill_database_with_default_data', 1489707785),
('m170311_112511_create_user', 1489707785),
('m170311_130630_add_latitude_longitude_to_advertising_construction', 1489707785);

-- --------------------------------------------------------

--
-- Структура таблицы `our_client`
--

CREATE TABLE IF NOT EXISTS `our_client` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_url` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `our_client`
--

INSERT INTO `our_client` (`id`, `name`, `logo_url`) VALUES
(1, 'Coca-Cola', 'http://mixstuff.ru/wp-content/uploads/2013/03/3.png'),
(2, 'Burger King', 'https://upload.wikimedia.org/wikipedia/ru/thumb/3/3a/Burger_King_Logo.svg/1010px-Burger_King_Logo.svg.png'),
(3, 'Playstation', 'https://trashbox.ru/files/195471_78e4d9/713px-playstation_logo_colour.svg.png'),
(4, 'BBC', 'http://mixstuff.ru/wp-content/uploads/2013/03/10.png'),
(5, 'Триколор', 'http://antenna73.ru/picture2/logo-trikolor-tv.png'),
(6, 'Pepsi', 'http://ic.pics.livejournal.com/tragemata/25155229/2616189/2616189_original.png'),
(7, 'LEGO', 'http://lclub.ua/userfiles/images/lego_logo_rgb.JPG'),
(8, 'Mazda', 'https://upload.wikimedia.org/wikipedia/ru/archive/1/17/20090512213331%21Mazda_Logo.png'),
(9, 'Youtube', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQb3lmfAZ6Og_1Rm3z8ax0TSSxHrgBIgnHId4uBrsYlsuVY9xPXxA'),
(10, 'ВКонтакте', 'https://habrastorage.org/storage2/7ac/0d8/26a/7ac0d826a596f4388cb537f04617fcfd.png'),
(11, 'Ашан', 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQzGJWAr226nhuxoSw5VH9ovftpkhfEaFGEeyU-QVbSiq--ShUJ5w'),
(12, 'Kaspersky', 'http://toplogos.ru/images/logo-kaspersky.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `site_settings`
--

CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `is_agency` tinyint(1) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pan` varchar(15) DEFAULT NULL,
  `okpo` varchar(15) DEFAULT NULL,
  `checking_account` varchar(20) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `photo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_document`
--

CREATE TABLE IF NOT EXISTS `user_document` (
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `vacancy`
--

CREATE TABLE IF NOT EXISTS `vacancy` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vacancy`
--

INSERT INTO `vacancy` (`id`, `title`, `content`) VALUES
(1, 'Вакансия 1: Стажёр - тестировщик', '<ul> <li>приглашаются студенты и выпускники вузов IТ-специальностей для предварительного обучения за счет компании с перспективой трудоустройства;</li> <li>стабильность и надежность;</li> <li>разнообразие проектов и задач для быстрого и успешного развития;</li> <li>возможности для роста в нескольких профессиональных направлениях – аналитик, менеджер, тестировщик;</li> <li>конкурентная зарплата и оптимальные условия для построения карьеры;</li> <li>комфортные условия работы, гибкий рабочий график;</li> <li>молодая и активная команда сотрудников;</li> <li>престижная работа с крупными и известными заказчиками со всего мира;</li> <li>возможны командировки в Россию, европейские страны, США и др.;</li> <li>создана и активно развивается система бесплатного корпоративного обучения для кандидатов и сотрудников;</li> <li>социальный пакет;</li> <li>офис в центре Минска, недалеко от метро.</li> </ul>'),
(2, 'Вакансия 2: Менеджер интернет-проектов', '<div class="l-paddings b-vacancy-desc g-user-content"><div class="b-vacancy-desc-wrapper" itemprop="description"><p><strong>Должностные обязанности: </strong></p> <ul> <li>Коммуникация с клиентами, сбор потребностей, проведение встреч, анализ, планирование,</li> <li>Составление заданий для специалистов (frontend и backend разработчика, дизайнера, seo- специалиста).</li> <li>Полное сопровождение процесса разработки интернет-проектов на всех этапах: от брифинга до сдачи и поддержки.</li> </ul> <p> </p> <p><strong>Требования к кандидату:</strong></p> <ul> <li>Желательно опыт работы в сфере интернет-рекламы (создание и продвижение сайтов) от 1 года.</li> </ul></div></div>'),
(3, 'Вакансия 3: Интернет-маркетолог', '<div class="b-vacancy-desc-wrapper" itemprop="description"><p>Автомобильный центр "Байернкрафт" -- официальный дилер компании BMW в Республике Беларусь приглашает ИНТЕРНЕТ-МАРКЕТОЛОГА</p> <p> </p> <p><strong>Обязанности</strong>:</p> <ul> <li>Размещение и оформление информации на сайтах компании и в личном кабинете клиента;</li> <li>Контроль за постоянным обновлением контента;</li> <li>Обработка и размещение графических объектов;</li> <li>Создание и ведение рекламных кампаний в системах контекстной рекламы, оценка их эффективности;</li> <li>Работа с e-mail рассылками;</li> <li>Контроль за сроками действия сертификатов и оплат.</li> </ul> <p> </p> <p><strong>Требования</strong>:</p> <ul> <li>Знание и любовь к марке BMW;</li> <li>Знания систем: Яндекс Директ, Google AdWords, Facebook , Вконтакте, My.Target;</li> <li>Умение анализировать трафик, использование Google Analytics; Яндекс Метрика;</li> <li>Работа с Photoshop, базовый уровень, или любой другой графический редактор пригодный для создания рекламных креативов/ТГБ, знание EXCEL;</li> <li>Знание платформ IOS и Android для пользовательского использования;</li> <li>Логический склад ума, внимательность, ответственность, трудолюбие, обучаемость, стремление к знаниям и самообразованию;</li> <li>Ищем амбициозного</li> </ul> <p> </p> <p><strong>Условия</strong>:</p> <ul> <li>Официальное трудоустройство + социальный пакет;</li> <li>Работа в стабильной и развивающейся компании;</li> </ul></div>');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `advertising_construction`
--
ALTER TABLE `advertising_construction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-advertising_construction_size` (`size_id`),
  ADD KEY `idx-advertising_construction_type` (`type_id`);

--
-- Индексы таблицы `advertising_construction_image`
--
ALTER TABLE `advertising_construction_image`
  ADD KEY `fk-advertising_construction_image_construction` (`advertising_construction_id`),
  ADD KEY `fk-advertising_construction_image_file` (`file_id`);

--
-- Индексы таблицы `advertising_construction_reservation`
--
ALTER TABLE `advertising_construction_reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-advertising_construction_reservation_construction` (`advertising_construction_id`),
  ADD KEY `idx-advertising_construction_reservation_user` (`user_id`),
  ADD KEY `idx-advertising_construction_reservation_status` (`status_id`);

--
-- Индексы таблицы `advertising_construction_reservation_status`
--
ALTER TABLE `advertising_construction_reservation_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `advertising_construction_size`
--
ALTER TABLE `advertising_construction_size`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `advertising_construction_type`
--
ALTER TABLE `advertising_construction_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contact_us_submission`
--
ALTER TABLE `contact_us_submission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-contact_us_submission_file` (`cv_id`);

--
-- Индексы таблицы `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `our_client`
--
ALTER TABLE `our_client`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_document`
--
ALTER TABLE `user_document`
  ADD KEY `fk-user_document_file` (`file_id`);

--
-- Индексы таблицы `vacancy`
--
ALTER TABLE `vacancy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `advertising_construction`
--
ALTER TABLE `advertising_construction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `advertising_construction_reservation`
--
ALTER TABLE `advertising_construction_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `advertising_construction_reservation_status`
--
ALTER TABLE `advertising_construction_reservation_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `advertising_construction_size`
--
ALTER TABLE `advertising_construction_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `advertising_construction_type`
--
ALTER TABLE `advertising_construction_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `contact_us_submission`
--
ALTER TABLE `contact_us_submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `our_client`
--
ALTER TABLE `our_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `vacancy`
--
ALTER TABLE `vacancy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `advertising_construction`
--
ALTER TABLE `advertising_construction`
  ADD CONSTRAINT `fk-advertising_construction_size` FOREIGN KEY (`size_id`) REFERENCES `advertising_construction_size` (`id`),
  ADD CONSTRAINT `fk-advertising_construction_type` FOREIGN KEY (`type_id`) REFERENCES `advertising_construction_type` (`id`);

--
-- Ограничения внешнего ключа таблицы `advertising_construction_image`
--
ALTER TABLE `advertising_construction_image`
  ADD CONSTRAINT `fk-advertising_construction_image_construction` FOREIGN KEY (`advertising_construction_id`) REFERENCES `advertising_construction` (`id`),
  ADD CONSTRAINT `fk-advertising_construction_image_file` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`);

--
-- Ограничения внешнего ключа таблицы `advertising_construction_reservation`
--
ALTER TABLE `advertising_construction_reservation`
  ADD CONSTRAINT `fk-advertising_construction_reservation_construction` FOREIGN KEY (`advertising_construction_id`) REFERENCES `advertising_construction` (`id`),
  ADD CONSTRAINT `fk-advertising_construction_reservation_status` FOREIGN KEY (`status_id`) REFERENCES `advertising_construction_reservation_status` (`id`);

--
-- Ограничения внешнего ключа таблицы `contact_us_submission`
--
ALTER TABLE `contact_us_submission`
  ADD CONSTRAINT `fk-contact_us_submission_file` FOREIGN KEY (`cv_id`) REFERENCES `file` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_document`
--
ALTER TABLE `user_document`
  ADD CONSTRAINT `fk-user_document_file` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
