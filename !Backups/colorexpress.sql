-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 14 2017 г., 14:17
-- Версия сервера: 5.6.33-0ubuntu0.14.04.1
-- Версия PHP: 5.6.30-7+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `colorexpress`
--

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction`
--

CREATE TABLE IF NOT EXISTS `advertising_construction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nearest_locations` text,
  `traffic_info` text,
  `has_traffic_lights` tinyint(1) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `size_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `type_id` int(11) NOT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT '0',
  `requirements_document_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-advertising_construction_size` (`size_id`),
  KEY `idx-advertising_construction_type` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Дамп данных таблицы `advertising_construction`
--

INSERT INTO `advertising_construction` (`id`, `name`, `nearest_locations`, `traffic_info`, `has_traffic_lights`, `address`, `size_id`, `price`, `type_id`, `latitude`, `longitude`, `is_published`, `requirements_document_path`) VALUES
(2, '16,05х6', 'Ботанический сад, Парк Челюскинцев, Площадь Калинина, Академия Искусств\r\n', 'Сильный', 1, 'Независимости пр.,80', 9, '81', 2, '53.9223958', '27.6078567', 1, 'uploads/Construction/Documents/CF9gOF678b0jPVUdw2eNyCOHeHn0SPKF.doc'),
(3, '13,5х5,15', 'Белагропромбанк, Белинвестбанк, ст.м Пушкинская, БЦ "Стильсервис"\r\n', 'Сильный', 1, 'Пушкина пр., 81', 10, '64', 2, '53.9210863', '27.4985325', 1, 'uploads/Construction/Documents/Ft5BdHB2dkuwXHr-Lj9gO8B9JziD0lov.doc'),
(4, '16,2х6,5', 'ст.м. Академия наук, Национальная академия наук Беларуси, БГУИР, Академическая книга, кинотеатр "Октябрь", Дворец водного спорта, м-н "Оранжевый верблюд"\r\n', 'Сильный', 1, 'Независимости пр.,72', 9, '355', 2, '53.9219961', '27.6016796', 1, 'uploads/Construction/Documents/TnJNyN3wFqnrC2feNUQlojLLJh3yz6rh.doc'),
(5, '3х6', 'McDonalds (макдрайв), Чиннабон, Торговый дом "На Немиге", ТРЦ "Немига", офисные здания, Лукоил, кинотеатр «Беларусь»,  улицы  Интернациональная  и Революционная с обилием кафе и бутиков', 'Сильный', 1, 'ул. Городской Вал. 8', 7, '42', 5, '53.9002326', '27.5518495', 1, 'uploads/Construction/Documents/akfjfhv0zYbYYhV9E3TSeLbPt_Fx_7KY.doc'),
(6, '3х6', 'Национальный Банк Республики Беларусь, БГУ, Национальный художественный музей', 'низкий', 1, 'ул. К.Маркса, 30', 7, '132', 5, '53.517385', '49.406843', 1, 'uploads/Construction/Documents/avQVW4t_3LovpPiKqJOYQxnLutYtaLgQ.doc'),
(7, '2,45х4,9', '«Планета Суши», фирменный магазин «Луч», магазин звезда', 'Сильный', 1, 'пр.Независимости, 18', 7, '31', 3, '53.8994504', '27.5574902', 1, 'uploads/Construction/Documents/UK62frzYoF-Y83S23wWZQ7R8rEfAMwnz.doc'),
(8, '3х6', 'магазин "Лакомка", Центральная книгарня, ГУМ\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 19', 7, '33', 3, '53.8998944', '27.5568679', 1, 'uploads/Construction/Documents/9upmMFxM17pGPqEX6D-aIzcVKZfcQ2im.doc'),
(9, '3х6', 'магазин "Лакомка", Центральная книгарня, ГУМ\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 19 ', 7, '33', 3, '53.8998944', '27.5568679', 1, 'uploads/Construction/Documents/l0de9i7fIrHq7z_LyD5JyEOfvnzuPZCt.doc'),
(10, '3х6', 'магазин "Лакомка", Центральная книгарня, ГУМ', 'Сильный', 1, 'пр.Независимости, 21 ', 7, '41', 3, '53.9004887', '27.5579783', 1, 'uploads/Construction/Documents/bgp9QAeo2QgsWTC2ZzEQhWt6HU1GFBGF.doc'),
(11, '3х4,5', 'городская ратуша, 5* г-ца "Европа", главный офис компании "Белтелеком", консерватория, Посольство Франции\r\n\r\n', 'Средний', 1, 'Ленина, 2 ', 6, '37', 3, '58.6165399', '49.6800408', 1, 'uploads/Construction/Documents/xDMoqo-R_u0tnKNB8e8mtpzUKA-KcY6L.doc'),
(12, '3х4,5', 'городская ратуша, 5* г-ца "Европа", главный офис компании "Белтелеком", консерватория, Посольство Франции', 'Средний', 1, 'Ленина, 2 ', 6, '37', 3, '58.6165399', '49.6800408', 1, 'uploads/Construction/Documents/AiO8gO9dTr-6J_BHPOeP8beHhGnAdKl0.doc'),
(14, '3х4,5', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds\r\n\r\n\r\n\r\n', 'Средний', 1, 'Ленина,8 ', 6, '29', 3, '58.6146831', '49.6808926', 1, 'uploads/Construction/Documents/hNmLECrdwlTNAyDBizMgVyygl7BlspBl.doc'),
(15, '3х4,5', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds\r\n\r\n', 'Средний', 1, 'Ленина,8 ', 6, '29', 3, '58.6146831', '49.6808926', 1, 'uploads/Construction/Documents/rbSbrzX-y9_nJtegW5gHPQOVU86DVu3w.doc'),
(16, '3х4,5', 'пл. Я.Коласа, Суши-бар «Манга», гимназия №23, ЗАГС Советского района, Электросила', 'Сильный', 1, 'Независимости, 46', 6, '29', 3, '53.9132898', '27.5811282', 1, NULL),
(17, '3х4,5', 'ст.м. площадь Победы, пл. Победы, парк им Горького, Fresh cafe и др. кафе\r\n', 'Сильный', 1, 'пр.Независимости, 42', 6, '29', 3, '53.909791', '27.5773036', 1, 'uploads/Construction/Documents/egh1ZUI-ULom4uQ-TDOMOy6kyLdnlu8J.doc'),
(18, '3х4,5', 'ст.м. площадь Победы, пл. Победы, парк им Горького, Fresh cafe и др. кафе\r\n', 'Сильный', 1, 'пр.Независимости, 42 ', 6, '29', 3, '53.909791', '27.5773036', 1, 'uploads/Construction/Documents/znyRCvFCQ3PxahZCobajG1U2-PCNaV11.doc'),
(19, '3х4,5', 'ст.м. площадь Победы, магазин "Океан", Fresh cafe, ул. Козлова\r\n', 'Средний', 1, 'ул.Козлова, 2', 6, '29', 3, '53.9096725', '27.5788164', 1, 'uploads/Construction/Documents/jOFLrLwdXmmUF8yc9aidXlSnoaCU06_-.doc'),
(20, '3х4,5', 'кафе «Проспект 44», Беларусбанк, м-н «Марко», салон красоты «ЭтуальSPA»\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 44 ', 6, '29', 3, '53.9116444', '27.5794637', 1, 'uploads/Construction/Documents/zUa3eyHZOL9voDN9s05SoZv6pGeVv4nO.doc'),
(21, '3х4,5', 'кафе «Проспект 44», Беларусбанк, м-н «Марко», салон красоты «ЭтуальSPA»\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 44 ', 6, '29', 3, '53.9116444', '27.5794637', 1, 'uploads/Construction/Documents/2ovvZ3R1L4AM44L0sFMADHeqAWsZOW8s.doc'),
(22, '3х4,5', 'ЦУМ, магазин "Столичный", Белорусская государственная филармония, ст.м.Я.Колоса.\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 52', 6, '40', 3, '53.9157755', '27.5846422', 1, 'uploads/Construction/Documents/Rzuunr9SdAw6gETn1yf15sld_HURRxGn.doc'),
(23, '3х4,5', 'ЦУМ, магазин "Столичный", Белорусская государственная филармония, ст.м.Я.Колоса.', 'Сильный', 1, 'пр.Независимости, 52 ', 6, '40', 3, '53.9157755', '27.5846422', 1, 'uploads/Construction/Documents/BBZe8IUNBSBcI_rte-1La5NR6Lf_xkgT.doc'),
(24, '3х4,5', 'сквер, торговый дом "На Немиге", ТЦ «Немига», McDonalds, магазин Адмдас, кафе Чинабон, кафе Бистро Де Люкс\r\n', 'Средний', 1, 'Городской вал, 12', 6, '29', 3, '57.621217', '39.849601', 1, 'uploads/Construction/Documents/tUKH3dJpyIVnSu4f6SULHtE-C4yyscLN.doc'),
(25, '3х4,5', 'городская ратуша, 5* г-ца "Европа", главный офис компании "Белтелеком", консерватория, Посольство Франции\r\n\r\n', 'Средний', 1, 'пл.Свободы, 5 верхний', 6, '37', 3, '53.9027263', '27.5555509', 1, 'uploads/Construction/Documents/E4ZRAVj6VlXSiDNh_77cMVE7Pj9PFh1E.doc'),
(26, '3х4,5', 'городская ратуша, 5* г-ца "Европа", главный офис компании "Белтелеком", консерватория, Посольство Франции\r\n\r\n', 'Средний', 1, 'пл.Свободы, 5, нижний', 6, '37', 3, '56.3183956', '44.0152578', 1, 'uploads/Construction/Documents/lJRe-p3w36MOXx6gXm9XJwPXxIpVqnWd.doc'),
(27, '3х4,5', 'ст.м. Московская, БГАТУ, Аптека №2, мед центр Роден, ул. Макаенка, Белтелерадиокомпания\r\n', 'Сильный', 1, 'пр.Независимости,92', 6, '29', 3, '53.9275091', '27.6273953', 1, 'uploads/Construction/Documents/j0HNKFYtF1HIcwrAdDpUmtsSvzWY9S1z.doc'),
(28, '3х4,5', 'Центральная книгарня, \r\nк-р Центральный, ресторан Васильки, Юридический колледж БГУ, пл. Независимости, ТЦ Столица\r\n\r\n', 'Сильный', 1, 'пр.Независимости,16 ', 6, '29', 3, '53.8982508', '27.5550923', 1, 'uploads/Construction/Documents/awBcE3HuFI07U7uvLx4GcEjqid1v6FI8.doc'),
(29, '3х4,5', 'Центральная книгарня, \r\nк-р Центральный, ресторан Васильки, Юридический колледж БГУ, пл. Независимости, ТЦ Столица\r\n\r\n', 'Сильный', 1, 'пр.Независимости,16', 6, '29', 3, '53.8982508', '27.5550923', 1, 'uploads/Construction/Documents/bIJqg4Mr3khODp3fH2LQ1y_7xZwzY7eH.doc'),
(30, '3х4,5', 'м-н "Техника в быту", кинотеатр "Беларусь", ст.м. Фрунзенская. МонКафе, нацилнальная школа красоты\r\n\r\n', 'Сильный', 1, 'ул.Кальварийская, 2 ', 6, '29', 3, '53.9057777', '27.5402275', 1, 'uploads/Construction/Documents/XdXhBOTGJX7ZHr0fYSuQwwl7kyCf9rKN.doc'),
(31, '3х4,5', 'м-н "Техника в быту", кинотеатр "Беларусь", ст.м. Фрунзенская. МонКафе, нацилнальная школа красоты\r\n\r\n', 'Сильный', 1, 'ул.Кальварийская, 2 ', 6, '29', 3, '53.9057777', '27.5402275', 1, 'uploads/Construction/Documents/5ae_aN5GPqmQ_27scU8-ZZQlbyfN63wG.doc'),
(32, '3х4,5', 'Центральная книгарня, \r\nк-р Центральный, ресторан Васильки, Юридический колледж БГУ, пл. Независимости, ТЦ Столица\r\n', 'Сильный', 1, 'ул.Кальварийская, 5 ', 6, '29', 3, '53.90537', '27.5367728', 1, 'uploads/Construction/Documents/Jv6tvQRyf7qMkzV3lN1Gakc0srVJFvzU.doc'),
(33, '3х4,5', 'м-н «Спортмастер», м-н «Спорттовары»,м-н «Музыка», ночной клуб «НЛО»\r\n\r\n', 'Сильный', 1, 'ул.Я.Коласа,30 верхний', 6, '32', 3, '53.9263364', '27.594738', 1, 'uploads/Construction/Documents/O4fplJGCPDwqTsULIAbNvzcgJn9ubZgG.doc'),
(34, '3х4,5', 'м-н «Спортмастер», м-н «Спорттовары»,м-н «Музыка», ночной клуб «НЛО»\r\n\r\n', 'Сильный', 1, 'ул.Я.Коласа, 30 нижний', 6, '32', 3, NULL, NULL, 1, 'uploads/Construction/Documents/paF-fFKY_6zcKyJMEJs4m1mKqJcMnGad.doc'),
(35, '3х4,5', 'пл. Бангалор, парк Дружбы народов\r\n\r\n', 'Сильный', 1, 'ул.Орловская, 4', 6, '29', 3, '58.596223', '49.690738', 1, 'uploads/Construction/Documents/FtGx8SFgoI02NWbflDdE8YXbTmQ0445B.doc'),
(36, '3х4,5', 'пл. Бангалор, парк Дружбы народов', 'Сильный', 1, 'ул.Орловская, 3', 6, '29', 3, '53.9318859', '27.5648421', 1, 'uploads/Construction/Documents/rLdhj8mnZ6it1dsB3khMjxl2FmWm0A9O.doc'),
(37, '3х4,5', 'парк Я.Купалы, гостиница «Журавинка», Белгосцирк, Турецкие авиалинии,  Большой театр Оперы и балета.\r\n\r\n', 'Средний', 1, 'ул.Я.Купалы, 23 ', 6, '32', 3, '53.9061027', '27.5661029', 1, 'uploads/Construction/Documents/QSuHE3bij5dm1kSi_j0YfNYahmbNrQmE.doc'),
(38, '3х4,5', 'парк Я.Купалы, гостиница «Журавинка», Белгосцирк, Турецкие авиалинии,  Большой театр Оперы и балета.\r\n\r\n', 'Средний', 1, 'ул.Я.Купалы, 23 ', 6, '32', 3, '53.9061027', '27.5661029', 1, 'uploads/Construction/Documents/c2aWD79vCrFc7_yVGKcitP9hpAEktSFK.doc'),
(39, '3х4,5', 'Ювелирный магазин «Магия Золота», туристическая компания «Гулливер», магазин «Санта Фиш», кафе "Gurmans", оптика «Золушка»\r\n', 'Средний', 1, 'ул.К. Маркса, 23 ', 6, '29', 3, '56.8238706', '53.2073937', 1, 'uploads/Construction/Documents/vosvMx90ssXDzWc4j5FZO6FiKGyfVCE5.doc'),
(40, '3х4,5', 'ресторан «McDonalds», Корпус БГУ, ж/д вокзал., ст.м. «Площадь Ленина».\r\n', 'Высокий', 1, 'ул.Ленинградская, 7 ', 6, '40', 3, '48.480222', '135.0971632', 1, 'uploads/Construction/Documents/1VxYGzgI66bZZLiFuGXNd_xxkfvh4Mcr.doc'),
(41, '8х4', 'пл.Я.Коласа, суши-бар "Манга", гимназия №23, Керамин', 'Сильный', 1, 'пр.Независимости, 47', 2, '61', 3, '53.9139288', '27.5805867', 1, 'uploads/Construction/Documents/jNaRBSbJwsN6zSqmix6NtjmJR4lET7kF.doc'),
(42, '8х4', 'пл.Я.Коласа, суши-бар "Манга", гимназия №23, Керамин', 'Высокий', 1, 'пр.Независимости, 47 ', 2, '61', 3, '53.9139288', '27.5805867', 1, 'uploads/Construction/Documents/vk6Jb1h7g5ir8q7R0jN23HF834vZnYGV.doc'),
(43, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Высокий', 1, 'пр.Независимости-ул. Ленина, №1', 8, '7', 6, NULL, NULL, 1, 'uploads/Construction/Documents/XsZkp2IYwB_MjrzNkK0aFlwKFX8u7yuQ.doc'),
(44, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds\r\n', 'Сильный', 1, 'пр.Независимости-ул. Ленина, №2', 8, '7', 6, NULL, NULL, 1, 'uploads/Construction/Documents/GY1EUXH9Nk6nosF970Di5PvZHQ7Sajuu.doc'),
(45, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Сильный', 1, 'пр.Независимости-ул. Ленина, №3', 8, '11', 6, NULL, NULL, 1, NULL),
(47, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Сильный', 0, 'пр.Независимости-ул. Ленина, №4', 8, '7', 6, NULL, NULL, 1, NULL),
(48, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Сильный', 0, 'пр.Независимости-ул. Ленина, №5', 8, '8', 6, NULL, NULL, 1, NULL),
(49, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Сильный', 0, 'пр.Независимости-ул. Ленина, №6', 8, '7', 6, '53.8947453', '27.5482392', 1, NULL),
(50, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Сильный', 0, 'пр.Независимости-ул. Ленина, №7', 8, '7', 6, NULL, NULL, 1, NULL),
(51, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Сильный', 0, 'пр.Независимости-ул. Ленина, №8', 8, '13', 6, NULL, NULL, 1, NULL),
(52, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Сильный', 0, 'пр.Независимости-ул. Ленина, №9', 8, '7', 6, '53.8957474', '27.5489956', 1, NULL),
(53, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Сильный', 0, 'пр.Независимости-ул. Ленина, №10', 8, '7', 6, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_image`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `advertising_construction_id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-advertising_construction_image_construction` (`advertising_construction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Дамп данных таблицы `advertising_construction_image`
--

INSERT INTO `advertising_construction_image` (`id`, `advertising_construction_id`, `path`) VALUES
(2, 2, 'uploads/Construction/Nc58LDcMtQVf_K9NMms2LOU-N4oun6e3.jpg'),
(3, 3, 'uploads/Construction/pGfh6q4E1MyRzuw3DNbNGnLQvdYf3Bek.jpg'),
(4, 4, 'uploads/Construction/0vfeSYrtKtDgxZkFyu71TobqqiHJdJy3.jpg'),
(5, 5, 'uploads/Construction/6wX2l13CrAVhLNfe96uxHh8LTKoYpqr8.jpg'),
(6, 6, 'uploads/Construction/NFdCe8EGcaFoSkIManxwvCB2ov-KZ8Wn.jpg'),
(7, 7, 'uploads/Construction/LMEoMSa_BEiowHXQe0wF4HvF2KlUoK3u.jpg'),
(8, 8, 'uploads/Construction/tVZp5a0eyxwGPt4bbZ3J-ppLyan0HUN2.jpg'),
(9, 9, 'uploads/Construction/WfJFu0eNBEblWJTlVJKDmKkkW0LZkNUj.jpg'),
(10, 10, 'uploads/Construction/M1tK7X7YvRtxOZ9bufsQkCdBOcZlzk9L.jpg'),
(11, 11, 'uploads/Construction/zZo8ZgznQBhB8Q5E3eYXKteouEk70En9.jpg'),
(12, 12, 'uploads/Construction/ppURuEwQl9Ovwc0pwMa7Nkw8jHQqNCBR.jpg'),
(13, 14, 'uploads/Construction/GJgMp_iNdJ9Xpd5GOyAI_EmGJOkKdt64.jpg'),
(14, 15, 'uploads/Construction/Vw1E4k8vyVxRgWbO5ZyE-JRT6NpPB3L6.jpg'),
(15, 16, 'uploads/Construction/LUmE1qxDcuaC1Ox_CedV9u6FAauslYQN.jpg'),
(16, 17, 'uploads/Construction/3E3dtw6nyUN0ijML4R_lzAB24BELag_B.jpg'),
(17, 18, 'uploads/Construction/CjpeSPueQy-fY9qx1DB0WwkjR1NHPCSm.jpg'),
(18, 19, 'uploads/Construction/N03rXt9cyDVNuHisV2sYAtXYxfjn5z8U.jpg'),
(19, 20, 'uploads/Construction/OavxaXipSJIbYVltXm9ecwDnZPsKr4aO.jpg'),
(20, 21, 'uploads/Construction/XEsuV64n6V-WtjegFgPVijnkRsgP8HpA.jpg'),
(21, 22, 'uploads/Construction/qR9BHmaoHWJ1yxQMm1YwO2xyvHmlW82V.jpg'),
(22, 23, 'uploads/Construction/otIA69knNA4FVooLZb8cvs3ByE8ejHeC.jpg'),
(23, 24, 'uploads/Construction/VJwveuQg-mun03ryG3FfDDVLZka5rnGC.jpg'),
(24, 25, 'uploads/Construction/9S6ZXKTfg2h0zulnT-APFFVp4fpT47H2.jpg'),
(25, 26, 'uploads/Construction/NyWmOiOsFcbpack3E94LVQF0vvjy1dxT.jpg'),
(26, 27, 'uploads/Construction/RvehJiL9i_y7rLhkMXnYRdQW8-e9SReV.jpg'),
(27, 28, 'uploads/Construction/dLYXMzDaSMxbtZqVe2tm41ZZon615GZm.jpg'),
(28, 29, 'uploads/Construction/iEy49Jvo28hKR2ugrd4wnwqyMK7b3-Sv.jpg'),
(29, 30, 'uploads/Construction/Qhfa1PQdxCP9M-rfi3uOuWLzEqU7SatL.jpg'),
(30, 31, 'uploads/Construction/Sh9Zpg9CKh5JADVDzWwhS82jN6MGekF0.jpg'),
(31, 32, 'uploads/Construction/HEDKTpVT4LpG_GkcsmChMZ3itLGZShNI.jpg'),
(32, 33, 'uploads/Construction/sgrXytkIZBofAypzO-PyQajSuYg69uA5.jpg'),
(33, 34, 'uploads/Construction/WMWdG4EYJvMnfGIoNOjQPuSgBYa2BjEK.jpg'),
(34, 35, 'uploads/Construction/7jE67D6aXZt1q1Zqul48i1uxdG5jzzru.jpg'),
(35, 36, 'uploads/Construction/uXLIOGoGA45UepkEXONS9_jX1Oqfzidk.jpg'),
(36, 37, 'uploads/Construction/sAEooiLTqun4cnB7Qi2_NsCW2Rb_18EK.jpg'),
(37, 38, 'uploads/Construction/fCkFiypBXNIbuAPabF_nsCVe0G0VPJ-d.jpg'),
(38, 39, 'uploads/Construction/B7AXU6t798du1s9u-Kcw8407UBZj6MPv.jpg'),
(39, 40, 'uploads/Construction/L7TkNHttIH_19krL0LkCmvvlbF149qlt.jpg'),
(40, 41, 'uploads/Construction/LesXpfrExs6pR9WKGykAR1yIHc6KQt5F.jpg'),
(41, 42, 'uploads/Construction/NdDm86V3sFytH57oe5vyaD_4HnSimZIB.jpg'),
(44, 45, 'uploads/Construction/22CUqfE-XgCtAsWGJohRbDMRa8UX0snd.jpg'),
(46, 47, 'uploads/Construction/3W2Do4BoI2ORGPNipdVuk5RIqFta4R_x.png'),
(47, 48, 'uploads/Construction/2p-GOap46oKT9hnPgZG2_STZG7gwMRbO.png'),
(48, 49, 'uploads/Construction/7-timaHF-b3NOS8NLE8D0zoFRpw4si3E.png'),
(49, 50, 'uploads/Construction/2K72drEHk8NwkoBSxbi-pIrW2eq0fPYh.jpg'),
(50, 51, 'uploads/Construction/gcWkTFeyq_Iu-ty6GCzHQsR_AsHfXBYX.jpg'),
(51, 52, 'uploads/Construction/qWOJFIFLm8ly5c9K15bX-biGFwtAceN2.png'),
(52, 53, 'uploads/Construction/_-k-q3y5t7WqIuD82FcWIpx1pcbw2sR9.jpg'),
(55, 2, 'uploads/Construction/BWOgWcLF5EvqeZ6v-Czk9i-7g5BkJTdm.jpg'),
(56, 3, 'uploads/Construction/Cx2W8JVUVX8chGWjNiQVmtRlNRuVozHX.jpg'),
(57, 4, 'uploads/Construction/qc48-2kxYYHMMzLkTyYdV5BiVrRM0LfJ.jpg'),
(58, 5, 'uploads/Construction/vx56g7-2bqBwD3FaZdFwoUAVxmAo0sHe.jpg'),
(59, 6, 'uploads/Construction/kdclP2o3QgsDzmbJQhfwUQOrzC-H0NBy.jpg'),
(60, 7, 'uploads/Construction/MFKOtzidAb8Y98Xaq747msNaqZFMtvmC.jpg'),
(61, 8, 'uploads/Construction/FnPD_RxJy6IvuB7fn7EdbmrXxHq1jNny.jpg'),
(62, 9, 'uploads/Construction/bfAbfUIW2Eny0Hfr_DXTNADnc7A7lwK4.jpg'),
(63, 10, 'uploads/Construction/8s1ylmaQNmJT4bVQhf8J0_tVxWAuQdgs.jpg'),
(64, 11, 'uploads/Construction/f6aCyXPAsntthf6Jnvbtk-IXgz0MNu1j.jpg'),
(65, 12, 'uploads/Construction/Jt_Ii4h7t2xT4DcnH5hPiIk_ARYE-RnT.jpg'),
(67, 14, 'uploads/Construction/-neQ32jdEPgep920UVAa8FIZFQAIMSxd.jpg'),
(68, 15, 'uploads/Construction/iLlxMwhFELCnOUrHZ62AGlDj-GiJI_VF.jpg'),
(69, 17, 'uploads/Construction/bY0dP4TTJMRcejFXWCRiCKxE3rgkqEBG.jpg'),
(70, 18, 'uploads/Construction/HO5doE80oqEZ2Z1z-vzWsvfi3Je9fePr.jpg'),
(71, 19, 'uploads/Construction/kbKAH3XWKerUY0kY2U_hqikyWpBcG3Xv.jpg'),
(72, 20, 'uploads/Construction/kp81a3nGl46GU5Czb4cOn4v7DdcU8dbf.jpg'),
(73, 21, 'uploads/Construction/Fx2IVAeR8A8A4V-qLOkGJue2pHGDVb1N.jpg'),
(74, 22, 'uploads/Construction/ht7FHudiMLDCtEYefMxcqLT-jDA8YZiQ.jpg'),
(75, 23, 'uploads/Construction/WnQ9iW5wShKRUXu6A8TlDfCXUZ1FUlMS.jpg'),
(76, 24, 'uploads/Construction/oqZYIR7j3ty2e3XeE6G67pGdrijFotGY.jpg'),
(77, 25, 'uploads/Construction/j_mikGZTA6I7yAp4ZUduiq9ea-rtKlqv.jpg'),
(78, 26, 'uploads/Construction/D-yYjtPCwc1p9wpBYW25ymPzHPkJ3yDG.jpg'),
(79, 27, 'uploads/Construction/fb7LLEdxI3ZktP6njajuN5fj4uydv8gy.jpg'),
(80, 28, 'uploads/Construction/7-YiviK8Wx3NmxisDU0_rEg9A4nideKo.jpg'),
(81, 29, 'uploads/Construction/fmFtXBQB8ksc039TVFkhjcAJ3Wqw0osw.jpg'),
(82, 30, 'uploads/Construction/3Q5tnCcA0xORtdR95K9h3FZHNZpKweIb.jpg'),
(83, 31, 'uploads/Construction/xB6PUqf5peOkZbLEvS-gY4w4KB1xQXNv.jpg'),
(84, 32, 'uploads/Construction/UN1DFnkzGprRu2BFkJ10Bl7Eq52C94Xg.jpg'),
(85, 33, 'uploads/Construction/IwVUIcdHboShowQiv4J4cXNegAGbw83_.jpg'),
(86, 34, 'uploads/Construction/GeWnbJN7Krw9oVI_nBu-9IdNvYzq4Uoc.jpg'),
(87, 35, 'uploads/Construction/ZB7RBzzjfPRVF0CGWRU4J2_POTyX42U3.jpg'),
(88, 36, 'uploads/Construction/lmMxUnMcG7U4dEZqFcSN6LzEX4FSOt9P.jpg'),
(89, 37, 'uploads/Construction/mqPLH1ZeeLMJHfsMB2YsnX8_PfX3Z_rR.jpg'),
(90, 38, 'uploads/Construction/QpGjeW5UiDJx8Y5i0Up185lWG0TZW7ll.jpg'),
(91, 39, 'uploads/Construction/epLFNcR5PXmFvgID_MKamLxDWDpynrYH.jpg'),
(92, 40, 'uploads/Construction/2-05Nc_I0yTb88-V6qKn60VD0zvBEP7x.jpg'),
(93, 41, 'uploads/Construction/vj7FSyMwkcCJmPHfnhh3OBhC2mX8cXlU.jpg'),
(94, 42, 'uploads/Construction/fWZSqJPs1lwAj7kAiCnlEclZMBVDhqJY.jpg'),
(96, 43, 'uploads/Construction/ITNBB-wI-7RmQu7iuvsXILqMQXLSMdfa.jpg'),
(97, 43, 'uploads/Construction/g8ReVV7eeOANOzUdSLuVme0LJvD-Rcs-.jpg'),
(98, 44, 'uploads/Construction/hmhUpVTK5H_vyupakXYD7na-9HFY-DHF.png'),
(99, 44, 'uploads/Construction/MaSCoCTq306PudDViLkPWwV9fdt1i4sM.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_reservation`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advertising_construction_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `cost` decimal(10,0) DEFAULT NULL,
  `marketing_type_id` int(11) DEFAULT NULL,
  `thematic` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `employee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-advertising_construction_reservation_construction` (`advertising_construction_id`),
  KEY `idx-advertising_construction_reservation_user` (`user_id`),
  KEY `idx-advertising_construction_reservation_status` (`status_id`),
  KEY `fk_advertising_construction_reservation_marketing_type` (`marketing_type_id`),
  KEY `fk_advertising_construction_reservation_employee` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `advertising_construction_reservation`
--

INSERT INTO `advertising_construction_reservation` (`id`, `advertising_construction_id`, `status_id`, `user_id`, `from`, `to`, `cost`, `marketing_type_id`, `thematic`, `created_at`, `employee_id`) VALUES
(1, 2, 50, 13, '2017-05-11', '2017-05-13', '81', 1, 'тематика', '2017-05-11 11:34:29', NULL),
(2, 3, 50, 13, '2017-05-11', '2017-05-12', '64', 1, 'тематика', '2017-05-11 11:35:09', NULL),
(3, 2, 255, 13, '2017-05-11', '2017-07-03', '85', 2, 'навигатор', '2017-05-11 12:44:06', NULL),
(4, 2, 255, 13, '2017-08-01', '2017-08-31', '81', 1, 'гаджеты', '2017-05-11 12:46:18', NULL),
(5, 9, 255, 13, '2017-05-11', '2017-05-11', '33', 1, 'te', '2017-05-11 12:55:31', NULL),
(6, 10, 10, 13, '2017-05-11', '2017-05-11', '41', NULL, NULL, '2017-05-11 13:06:17', 3),
(7, 11, 10, 13, '2017-05-11', '2017-05-11', '37', NULL, NULL, '2017-05-11 13:06:50', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_reservation_status`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_reservation_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=256 ;

--
-- Дамп данных таблицы `advertising_construction_reservation_status`
--

INSERT INTO `advertising_construction_reservation_status` (`id`, `name`) VALUES
(10, 'В корзине (заказ)'),
(11, 'В корзине (резерв)'),
(20, 'В обработке'),
(31, 'Резерв до'),
(40, 'Подтверждено'),
(50, 'Отклонено'),
(255, 'Отменено');

-- --------------------------------------------------------

--
-- Структура таблицы `advertising_construction_size`
--

CREATE TABLE IF NOT EXISTS `advertising_construction_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `advertising_construction_type`
--

INSERT INTO `advertising_construction_type` (`id`, `name`) VALUES
(1, 'Щитовые рекламные конструкции'),
(2, 'Брандмауэры'),
(3, 'Настенные световые короба'),
(4, 'Рекламные конструкции на путепроводах'),
(5, 'Надкрышные световые короба'),
(6, 'Рекламные конструкции в переходе');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1493850776),
('client', '10', 1494410309),
('client', '11', 1494410904),
('client', '12', 1494411203),
('client', '13', 1494491536),
('client', '14', 1494576144),
('client', '15', 1494576233),
('client', '16', 1494576344),
('client', '17', 1494576569),
('client', '18', 1494576831),
('client', '19', 1494577024),
('client', '20', 1494577256),
('client', '21', 1494759643),
('client', '4', 1494062431),
('client', '5', 1494062488),
('client', '6', 1494063164),
('client', '7', 1494068152),
('client', '8', 1494068235),
('client', '9', 1494410052),
('employee', '2', 1493882824),
('employee', '3', 1493884505);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Админ', NULL, NULL, 1493850738, 1493850738),
('client', 1, 'Клиент', NULL, NULL, 1493850739, 1493850739),
('employee', 1, 'Сотрудник', NULL, NULL, 1493850739, 1493850739),
('guest', 1, 'Не авторизированный пользователь', NULL, NULL, 1493850739, 1493850739);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'client'),
('admin', 'employee'),
('admin', 'guest');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `contact_us_submission`
--

CREATE TABLE IF NOT EXISTS `contact_us_submission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cv_id` int(11) DEFAULT NULL,
  `message` text,
  `submitted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-contact_us_submission_file` (`cv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `subclient_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-user_document` (`user_id`),
  KEY `fk-subclient_document` (`subclient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `uploaded_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `marketing_type`
--

CREATE TABLE IF NOT EXISTS `marketing_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `charge` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `marketing_type`
--

INSERT INTO `marketing_type` (`id`, `name`, `charge`) VALUES
(1, 'Белорусская реклама', 0),
(2, 'Иностранная реклама', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1493850727),
('m140506_102106_rbac_init', 1493850730),
('m170213_121426_initial_migration', 1493850750),
('m170213_135848_initial_database_structure', 1493850758),
('m170301_121052_add_our_clients', 1493850759),
('m170310_155514_add_vacancies', 1493850759),
('m170311_111112_fill_database_with_default_data', 1493850759),
('m170311_112511_create_user', 1493850760),
('m170311_130630_add_latitude_longitude_to_advertising_construction', 1493850761),
('m170325_092450_change_advertising_construction_images_relation', 1493850762),
('m170326_104925_add_is_available_on_external_pages_for_advertising_construction', 1493850763),
('m170326_125050_advertising_construction_statuses_seed', 1493850763),
('m170326_133442_add_cost_to_reservation_model', 1493850763),
('m170326_135450_add_marketing_type_table', 1493850765),
('m170329_192616_add_document_to_advertising_construction', 1493850765),
('m170329_202021_add_thematic_field_to_advertising_construction_reservation', 1493850766),
('m170330_235732_add_cancelled_status_to_advertising_construction_reservation', 1493850766),
('m170331_004032_add_creation_date_to_advertising_construction_reservation', 1493850766),
('m170403_200901_alterUserLengthUsername', 1493850767),
('m170405_184352_add_documents', 1493850768),
('m170405_185138_add_user_create_at', 1493850769),
('m170417_180832_add_month_and_year_to_document', 1493850770),
('m170417_190202_add_subclients', 1493850772),
('m170428_131909_add_name_to_site_settings', 1493850772),
('m170428_133106_set_site_settings', 1493850772),
('m170430_133826_add_primary_key_to_advertising_construction_image', 1493850773),
('m170501_135252_add_is_created_by_manager_field_to_reservation', 1493850774),
('m170501_154544_added_user_lastname', 1493850775),
('m170502_143904_photo_more_length', 1493850775),
('m170503_183141_create_admin', 1493850776),
('m170503_205639_add_filename_to_document', 1493850777),
('m170511_063613_change_size_of_checking_account', 1494486100),
('m170512_083830_extend_bank_field_length', 1494580534);

-- --------------------------------------------------------

--
-- Структура таблицы `our_client`
--

CREATE TABLE IF NOT EXISTS `our_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `site_settings`
--

CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  `name` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `site_settings`
--

INSERT INTO `site_settings` (`id`, `value`, `name`) VALUES
(1, 'http://colorexpo.by/', 'Ссылка на скачивание презентации (внешняя)'),
(2, 'outdoor@colorexpress.by', 'Email для связи'),
(3, '+375 (17) 399-10-95/96/97;+375 (29) 199-27-89;', 'Номер телефонов для связи через ;'),
(4, 'г. Минск, ул. Железнодорожная, 44', 'Адрес'),
(5, '53.8805047', 'Адрес - координата (Latitude)'),
(6, '27.5192012', 'Адрес - координата (Longitude)'),
(7, '86400', 'Частота показа всплывающего окна "Акции" (в секундах)'),
(8, '0', 'Содержимое блока "Акции" (формат HTML; если 0 - блок не показывается)');

-- --------------------------------------------------------

--
-- Структура таблицы `subclient`
--

CREATE TABLE IF NOT EXISTS `subclient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-user_subclient` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `is_agency` tinyint(1) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pan` varchar(15) DEFAULT NULL,
  `okpo` varchar(15) DEFAULT NULL,
  `checking_account` varchar(28) DEFAULT NULL,
  `bank` varchar(1000) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `manage_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_2` (`username`),
  KEY `fk_manage_id` (`manage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `name`, `surname`, `email`, `number`, `is_agency`, `company`, `address`, `pan`, `okpo`, `checking_account`, `bank`, `photo`, `manage_id`, `created_at`, `lastname`) VALUES
(1, 'color_admin@gmail.com', '$2y$13$QWV6ToJ56.RE1lDBB6.z.OGyV9AsCXIjCEG/5nqDofvWiTRAdy16q', 'dnUJSHXWK849sxpRr1ZD_Bt1gyLaBx6P', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-04 01:32:56', NULL),
(2, 'siamashka@colorexpress.by', '$2y$13$qlFfqmk5OSO.Slg/rPo/MeRhNAPr63WOH7zp.eut5ezwSbI2NTyK6', 'Xq5y22NeOxtW_rbN_bhVKJhLc9bfMbIS', 'Виктория', 'Семашко ', NULL, '+375291992789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/employee/bDb_svSp3gkx5aENlsknYuTqIdzAtCR2.jpg', NULL, '2017-05-04 10:27:04', 'Викторовна'),
(3, 'karpuk@colorexpress.by', '$2y$13$dtB/zx.mEmMXoMz2hgXT7.E8P7z.RpFfwAUsahAtgw/MQHv/OvGVG', 'QY06O7zk_dqY_RssWHye0ocKuKtR26ld', 'Мария', 'Карпук  ', NULL, '+375291992789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/employee/uCsE9lDULA0EcH5lReBAU3OR0RMuOrLF.jpg', NULL, '2017-05-04 10:55:05', 'Юрьевна'),
(13, 'login@gmail.com', '$2y$13$A7YmBcdLZEJ8RM63MNQ5De0UJ51rLhmb6tmZe/X1wg6ITuAf/uuN.', 'diX6mGTW395Znygj3S6ggwhDiXbeW0zG', 'Vlad', NULL, NULL, '+375336683035', 0, 'Haishuncorp', 'Minsk', '123123132', '12312312', '123123123123123123', 'Bank_name', NULL, 3, '2017-05-11 11:32:16', NULL),
(18, '5066663@gmail.com', '$2y$13$b6xc4cA50WHlJD1CrcOl1OrdV.UjDt4239zOshB13fQ45KxBNiuoa', 'Kg7l9FdAWw3OG7xIcAOeUY0ZR1OkYhU2', 'Дарья Долматова', NULL, NULL, '+375295066663', 1, 'ООО "АТЕНАИС"', 'г. Минск, ул. Кирова, 8/3-3, комн. 102', '190806910', '37713918', '3012015313012', 'ОАО "Приорбанк", код 749, 1233121', NULL, 3, '2017-05-12 11:13:51', NULL),
(19, 'dolmatova@shangri-la.by', '$2y$13$7wT3BHhn1J0.acHVwdqQ7.vbOPp5CBBCa5yPLE2b035gLsLgv5J/a', 'd2g8ZR95qgTeYciKMF0KB_ie4YsndnzJ', 'Дарья Долматова', NULL, NULL, '+375295066663', 1, 'ООО "АТЕНАИС"', 'г. Минск, ул. Кирова, 8/3-3, комн. 102', '190806910', '37713918', '3012015313012', 'ОАО "Приорбанк", код 749,', NULL, 3, '2017-05-12 11:17:04', NULL),
(20, '123123123@gmail.com', '$2y$13$i4zkjbElBh1Svl1cPF6OOu3S6pq0E31Xe1/yvMJVOji3dluEBB/1u', 'M1k7uBBmlyIp8APRcUdGxM6FTo1gcIv-', '13', NULL, NULL, '123123', 0, '123', '123123', '123123123', '12312323', '123212312312', '1111111111111111111111111111111111111111111111', NULL, 3, '2017-05-12 11:20:56', NULL),
(21, 'a1media@telecom.by', '$2y$13$ZFGtNbT/cSpN6u0CuSRnBONGbBvxfnzUyVICf99egLAwdQx77hboK', 'lE4vuwKYpfKtvQGspJuoiy6Z_8CoSY4q', 'Александр Суходольский', NULL, NULL, '+375296313818', 0, 'ЧРУП "А1-медиа"', '"Юридический адрес: 220035, г. Минск, ул. Тимирязева, 65 А – 229  Почтовый адрес: 220020, г. Минск, Л.Украинки, 14-7"', '191002921', '00000000', '3012115360001', 'ОАО "Технобанк", код 182, г. Минск, Кропоткина, 44', NULL, NULL, '2017-05-14 14:00:43', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_document`
--

CREATE TABLE IF NOT EXISTS `user_document` (
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  KEY `fk-user_document_file` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `vacancy`
--

CREATE TABLE IF NOT EXISTS `vacancy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `vacancy`
--

INSERT INTO `vacancy` (`id`, `title`, `content`) VALUES
(1, 'В данный момент открытые вакансии отсутствуют.', 'Но, если Вы:\r\n\r\n- знаете толк в продажах; <br />\r\n\r\n- нацелены на результат; <br />\r\n\r\n- готовы работать в команде; <br />\r\n\r\n- брать на себя ответственность;<br />\r\n\r\n- полны энергии, знаний и хотите стать участником команды профессионалов, то <br />\r\n\r\nзаполните форму и прикрепите свое резюме.\r\nМы обязательно рассмотрим вашу кандидатуру при наличии открытой вакансии.');

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
  ADD CONSTRAINT `fk-advertising_construction_image_construction` FOREIGN KEY (`advertising_construction_id`) REFERENCES `advertising_construction` (`id`);

--
-- Ограничения внешнего ключа таблицы `advertising_construction_reservation`
--
ALTER TABLE `advertising_construction_reservation`
  ADD CONSTRAINT `fk-advertising_construction_reservation_construction` FOREIGN KEY (`advertising_construction_id`) REFERENCES `advertising_construction` (`id`),
  ADD CONSTRAINT `fk-advertising_construction_reservation_status` FOREIGN KEY (`status_id`) REFERENCES `advertising_construction_reservation_status` (`id`),
  ADD CONSTRAINT `fk_advertising_construction_reservation_employee` FOREIGN KEY (`employee_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `fk_advertising_construction_reservation_marketing_type` FOREIGN KEY (`marketing_type_id`) REFERENCES `marketing_type` (`id`);

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `contact_us_submission`
--
ALTER TABLE `contact_us_submission`
  ADD CONSTRAINT `fk-contact_us_submission_file` FOREIGN KEY (`cv_id`) REFERENCES `file` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `fk-subclient_document` FOREIGN KEY (`subclient_id`) REFERENCES `subclient` (`id`),
  ADD CONSTRAINT `fk-user_document` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `subclient`
--
ALTER TABLE `subclient`
  ADD CONSTRAINT `fk-user_subclient` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_manage_id` FOREIGN KEY (`manage_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_document`
--
ALTER TABLE `user_document`
  ADD CONSTRAINT `fk-user_document_file` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
