-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 11 2017 г., 09:46
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Дамп данных таблицы `advertising_construction`
--

INSERT INTO `advertising_construction` (`id`, `name`, `nearest_locations`, `traffic_info`, `has_traffic_lights`, `address`, `size_id`, `price`, `type_id`, `latitude`, `longitude`, `is_published`, `requirements_document_path`) VALUES
(2, '16,05х6', 'Ботанический сад, Парк Челюскинцев, Площадь Калинина, Академия Искусств\r\n', 'Сильный', 1, 'Независимости пр.,80', 9, '81', 2, '53.9223958', '27.6078567', 1, NULL),
(3, '13,5х5,15', 'Белагропромбанк, Белинвестбанк, ст.м Пушкинская, БЦ "Стильсервис"\r\n', 'Сильный', 1, 'Пушкина пр., 81', 10, '64', 2, '53.9210863', '27.4985325', 1, NULL),
(4, '16,2х6,5', 'ст.м. Академия наук, Национальная академия наук Беларуси, БГУИР, Академическая книга, кинотеатр "Октябрь", Дворец водного спорта, м-н "Оранжевый верблюд"\r\n', 'Сильный', 1, 'Независимости пр.,72', 9, '355', 2, '53.9219961', '27.6016796', 1, NULL),
(5, '3х6', 'McDonalds (макдрайв), Чиннабон, Торговый дом "На Немиге", ТРЦ "Немига", офисные здания, Лукоил, кинотеатр «Беларусь»,  улицы  Интернациональная  и Революционная с обилием кафе и бутиков', 'Сильный', 1, 'ул. Городской Вал. 8', 7, '42', 5, '53.9002326', '27.5518495', 1, NULL),
(6, '3х6', 'Национальный Банк Республики Беларусь, БГУ, Национальный художественный музей', 'низкий', 1, 'ул. К.Маркса, 30', 7, '132', 5, '53.517385', '49.406843', 1, NULL),
(7, '2,45х4,9', '«Планета Суши», фирменный магазин «Луч», магазин звезда', 'Сильный', 1, 'пр.Независимости, 18', 7, '31', 3, '53.8994504', '27.5574902', 1, NULL),
(8, '3х6', 'магазин "Лакомка", Центральная книгарня, ГУМ\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 19', 7, '33', 3, '53.8998944', '27.5568679', 1, NULL),
(9, '3х6', 'магазин "Лакомка", Центральная книгарня, ГУМ\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 19 ', 7, '33', 3, '53.8998944', '27.5568679', 1, NULL),
(10, '3х6', 'магазин "Лакомка", Центральная книгарня, ГУМ', 'Сильный', 1, 'пр.Независимости, 21 ', 7, '41', 3, '53.9004887', '27.5579783', 1, NULL),
(11, '3х4,5', 'городская ратуша, 5* г-ца "Европа", главный офис компании "Белтелеком", консерватория, Посольство Франции\r\n\r\n', 'Средний', 1, 'Ленина, 2 ', 6, '37', 3, '58.6165399', '49.6800408', 1, NULL),
(12, '3х4,5', 'городская ратуша, 5* г-ца "Европа", главный офис компании "Белтелеком", консерватория, Посольство Франции', 'Средний', 1, 'Ленина, 2 ', 6, '37', 3, '58.6165399', '49.6800408', 1, NULL),
(13, '3х4,5', '', '', 0, 'Ленина,8 ', 6, '29', 3, '56.836228', '60.58609', 0, NULL),
(14, '3х4,5', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds\r\n\r\n\r\n\r\n', 'Средний', 1, 'Ленина,8 ', 6, '29', 3, '56.836228', '60.58609', 1, NULL),
(15, '3х4,5', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds\r\n\r\n', 'Средние', 1, 'Ленина,8 ', 6, '29', 3, '56.836228', '60.58609', 1, NULL),
(16, '3х4,5', 'пл. Я.Коласа, Суши-бар «Манга», гимназия №23, ЗАГС Советского района, Электросила', 'Сильный', 1, 'Независимости, 46', 6, '29', 3, '53.9132898', '27.5811282', 1, NULL),
(17, '3х4,5', 'ст.м. площадь Победы, пл. Победы, парк им Горького, Fresh cafe и др. кафе\r\n', 'Сильный', 1, 'пр.Независимости, 42', 6, '29', 3, '53.909791', '27.5773036', 1, NULL),
(18, '3х4,5', 'ст.м. площадь Победы, пл. Победы, парк им Горького, Fresh cafe и др. кафе\r\n', 'Сильный', 1, 'пр.Независимости, 42 ', 6, '29', 3, '53.909791', '27.5773036', 1, NULL),
(19, '3х4,5', 'ст.м. площадь Победы, магазин "Океан", Fresh cafe, ул. Козлова\r\n', 'Средний', 1, 'ул.Козлова, 2', 6, '29', 3, '53.9096725', '27.5788164', 1, NULL),
(20, '3х4,5', 'кафе «Проспект 44», Беларусбанк, м-н «Марко», салон красоты «ЭтуальSPA»\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 44 ', 6, '29', 3, '53.9116444', '27.5794637', 1, NULL),
(21, '3х4,5', 'кафе «Проспект 44», Беларусбанк, м-н «Марко», салон красоты «ЭтуальSPA»\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 44 ', 6, '29', 3, '53.9116444', '27.5794637', 1, NULL),
(22, '3х4,5', 'ЦУМ, магазин "Столичный", Белорусская государственная филармония, ст.м.Я.Колоса.\r\n\r\n', 'Сильный', 1, 'пр.Независимости, 52', 6, '40', 3, '53.9157755', '27.5846422', 1, NULL),
(23, '3х4,5', 'ЦУМ, магазин "Столичный", Белорусская государственная филармония, ст.м.Я.Колоса.', 'Сильный', 1, 'пр.Независимости, 52 ', 6, '40', 3, '53.9157755', '27.5846422', 1, NULL),
(24, '3х4,5', 'сквер, торговый дом "На Немиге", ТЦ «Немига», McDonalds, магазин Адмдас, кафе Чинабон, кафе Бистро Де Люкс\r\n', 'Средний', 1, 'Городской вал, 12', 6, '29', 3, '57.621217', '39.849601', 1, NULL),
(25, '3х4,5', 'городская ратуша, 5* г-ца "Европа", главный офис компании "Белтелеком", консерватория, Посольство Франции\r\n\r\n', 'Средний', 1, 'пл.Свободы, 5 верхний', 6, '37', 3, '53.9027263', '27.5555509', 1, NULL),
(26, '3х4,5', 'городская ратуша, 5* г-ца "Европа", главный офис компании "Белтелеком", консерватория, Посольство Франции\r\n\r\n', 'Средний', 1, 'пл.Свободы, 5, нижний', 6, '37', 3, '56.3183956', '44.0152578', 1, NULL),
(27, '3х4,5', 'ст.м. Московская, БГАТУ, Аптека №2, мед центр Роден, ул. Макаенка, Белтелерадиокомпания\r\n', 'Сильный', 1, 'пр.Независимости,92', 6, '29', 3, '53.9275091', '27.6273953', 1, NULL),
(28, '3х4,5', 'Центральная книгарня, \r\nк-р Центральный, ресторан Васильки, Юридический колледж БГУ, пл. Независимости, ТЦ Столица\r\n\r\n', 'Сильный', 1, 'пр.Независимости,16 ', 6, '29', 3, '53.8982508', '27.5550923', 1, NULL),
(29, '3х4,5', 'Центральная книгарня, \r\nк-р Центральный, ресторан Васильки, Юридический колледж БГУ, пл. Независимости, ТЦ Столица\r\n\r\n', 'Сильный', 1, 'пр.Независимости,16', 6, '29', 3, '53.8982508', '27.5550923', 1, NULL),
(30, '3х4,5', 'м-н "Техника в быту", кинотеатр "Беларусь", ст.м. Фрунзенская. МонКафе, нацилнальная школа красоты\r\n\r\n', 'Сильный', 1, 'ул.Кальварийская, 2 ', 6, '29', 3, '53.9057777', '27.5402275', 1, NULL),
(31, '3х4,5', 'м-н "Техника в быту", кинотеатр "Беларусь", ст.м. Фрунзенская. МонКафе, нацилнальная школа красоты\r\n\r\n', 'Сильный', 1, 'ул.Кальварийская, 2 ', 6, '29', 3, '53.9057777', '27.5402275', 1, NULL),
(32, '3х4,5', 'Центральная книгарня, \r\nк-р Центральный, ресторан Васильки, Юридический колледж БГУ, пл. Независимости, ТЦ Столица\r\n', 'Сильный', 1, 'ул.Кальварийская, 5 ', 6, '29', 3, '53.90537', '27.5367728', 1, NULL),
(33, '3х4,5', 'м-н «Спортмастер», м-н «Спорттовары»,м-н «Музыка», ночной клуб «НЛО»\r\n\r\n', 'Сильный', 1, 'ул.Я.Коласа,30 верхний', 6, '32', 3, '53.9263364', '27.594738', 1, NULL),
(34, '3х4,5', 'м-н «Спортмастер», м-н «Спорттовары»,м-н «Музыка», ночной клуб «НЛО»\r\n\r\n', 'Сильный', 1, 'ул.Я.Коласа, 30 нижний', 6, '32', 3, NULL, NULL, 1, NULL),
(35, '3х4,5', 'пл. Бангалор, парк Дружбы народов\r\n\r\n', 'Сильный', 1, 'ул.Орловская, 4', 6, '29', 3, '53.9323234', '27.5646946', 1, NULL),
(36, '3х4,5', 'пл. Бангалор, парк Дружбы народов', 'Сильный', 1, 'ул.Орловская, 3', 6, '29', 3, '53.9318859', '27.5648421', 1, NULL),
(37, '3х4,5', 'парк Я.Купалы, гостиница «Журавинка», Белгосцирк, Турецкие авиалинии,  Большой театр Оперы и балета.\r\n\r\n', 'Средний', 1, 'ул.Я.Купалы, 23 ', 6, '32', 3, '53.9061027', '27.5661029', 1, NULL),
(38, '3х4,5', 'парк Я.Купалы, гостиница «Журавинка», Белгосцирк, Турецкие авиалинии,  Большой театр Оперы и балета.\r\n\r\n', 'Средний', 1, 'ул.Я.Купалы, 23 ', 6, '32', 3, '53.9061027', '27.5661029', 1, NULL),
(39, '3х4,5', 'Ювелирный магазин «Магия Золота», туристическая компания «Гулливер», магазин «Санта Фиш», кафе "Gurmans", оптика «Золушка»\r\n', 'Средний', 1, 'ул.К. Маркса, 23 ', 6, '29', 3, '56.8238706', '53.2073937', 1, NULL),
(40, '3х4,5', 'ресторан «McDonalds», Корпус БГУ, ж/д вокзал., ст.м. «Площадь Ленина».\r\n', 'Высокий', 1, 'ул.Ленинградская, 7 ', 6, '40', 3, '48.480222', '135.0971632', 1, NULL),
(41, '8х4', 'пл.Я.Коласа, суши-бар "Манга", гимназия №23, Керамин', 'Сильный', 1, 'пр.Независимости, 47', 2, '61', 3, '53.9139288', '27.5805867', 1, NULL),
(42, '8х4', 'пл.Я.Коласа, суши-бар "Манга", гимназия №23, Керамин', 'Высокий', 1, 'пр.Независимости, 47 ', 2, '61', 3, '53.9139288', '27.5805867', 1, NULL),
(43, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds', 'Высокий', 1, 'пр.Независимости-ул. Ленина, №1', 8, '7', 6, NULL, NULL, 1, NULL),
(44, '2x1,3', 'ГУМ, 5* гостиница "Европа", пл.Свободы, ст.м. Октябрьская, McDonalds\r\n', 'Сильный', 1, 'пр.Независимости-ул. Ленина, №2', 8, '7', 6, NULL, NULL, 1, NULL),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

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
(42, 43, 'uploads/Construction/5dFmYtARm6sRexFbEWpDbcufyqtE6YGg.png'),
(43, 44, 'uploads/Construction/889z0JGlZWkaT3fPe22Fxjl4eI2vOoV6.png'),
(44, 45, 'uploads/Construction/22CUqfE-XgCtAsWGJohRbDMRa8UX0snd.jpg'),
(46, 47, 'uploads/Construction/3W2Do4BoI2ORGPNipdVuk5RIqFta4R_x.png'),
(47, 48, 'uploads/Construction/2p-GOap46oKT9hnPgZG2_STZG7gwMRbO.png'),
(48, 49, 'uploads/Construction/7-timaHF-b3NOS8NLE8D0zoFRpw4si3E.png'),
(49, 50, 'uploads/Construction/2K72drEHk8NwkoBSxbi-pIrW2eq0fPYh.jpg'),
(50, 51, 'uploads/Construction/gcWkTFeyq_Iu-ty6GCzHQsR_AsHfXBYX.jpg'),
(51, 52, 'uploads/Construction/qWOJFIFLm8ly5c9K15bX-biGFwtAceN2.png'),
(52, 53, 'uploads/Construction/_-k-q3y5t7WqIuD82FcWIpx1pcbw2sR9.jpg');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
('m170503_205639_add_filename_to_document', 1493850777);

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
  `email` varchar(20) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `is_agency` tinyint(1) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pan` varchar(15) DEFAULT NULL,
  `okpo` varchar(15) DEFAULT NULL,
  `checking_account` varchar(20) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `manage_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_2` (`username`),
  KEY `fk_manage_id` (`manage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `name`, `surname`, `email`, `number`, `is_agency`, `company`, `address`, `pan`, `okpo`, `checking_account`, `bank`, `photo`, `manage_id`, `created_at`, `lastname`) VALUES
(1, 'color_admin@gmail.com', '$2y$13$QWV6ToJ56.RE1lDBB6.z.OGyV9AsCXIjCEG/5nqDofvWiTRAdy16q', 'dnUJSHXWK849sxpRr1ZD_Bt1gyLaBx6P', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-04 01:32:56', NULL),
(2, 'siamashka@colorexpress.by', '$2y$13$qlFfqmk5OSO.Slg/rPo/MeRhNAPr63WOH7zp.eut5ezwSbI2NTyK6', 'Xq5y22NeOxtW_rbN_bhVKJhLc9bfMbIS', 'Виктория', 'Семашко ', NULL, '+375291992789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/employee/bDb_svSp3gkx5aENlsknYuTqIdzAtCR2.jpg', NULL, '2017-05-04 10:27:04', 'Викторовна'),
(3, 'karpuk@colorexpress.by', '$2y$13$dtB/zx.mEmMXoMz2hgXT7.E8P7z.RpFfwAUsahAtgw/MQHv/OvGVG', 'QY06O7zk_dqY_RssWHye0ocKuKtR26ld', 'Мария', 'Карпук  ', NULL, '+375291992789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'uploads/employee/uCsE9lDULA0EcH5lReBAU3OR0RMuOrLF.jpg', NULL, '2017-05-04 10:55:05', 'Юрьевна'),
(4, 'test@test.test', '$2y$13$VR6t0r9Va1kAM.nzqcQ8hegTQ8BWZFvf1UVOznl4Dlr7qw1L8Nc5a', '8V9LwjaR_fBc0mhnvG4cTuQOOZKTOXIr', 'Тест', NULL, NULL, '+375297698610', 0, 'Тестовая компания', 'машерова', '123123123', '12312312', '123123123123', 'куеуек', NULL, 3, '2017-05-06 12:20:31', NULL),
(5, 'login@gmai.com', '$2y$13$pf5aH3bHP3dBshFZ7rrrVe02JXOsTJD6taYGNCqoyS8q9JrVKrdtu', '6s2bT6v5jR4yS77xePUWhWQY906DTcx9', 'имя', NULL, NULL, '+375336683035', 0, 'название', 'flhtc', '123123123', '12312331', '123123123', '123123123', NULL, 3, '2017-05-06 12:21:28', NULL),
(6, 'JM@gmail.com', '$2y$13$I48IDe6whA3xdtq8orZ1yeRYNV63.VX1TnWi97vP9AhH9fV/Y0SZG', 'FrOvpxJzgFcj2_gXUwCLMTZGFJ34c8-z', 'тест 1', NULL, NULL, '+375336683035', 0, 'тест 1', 'qr', '111111111', '11111111', '123123', '123123', NULL, 3, '2017-05-06 12:32:44', NULL),
(7, 'tettuser_@gmail.com', '$2y$13$ORbLY3A6igc5.J8KZlQBhezh1z3qbf/6XPpFwwN4.cz8/xyP0eKC.', '0p0M7HYFWH78lZVv0zptoOxZRCpQswf9', 'Имя тестового клиента', NULL, NULL, '+375336683035', 0, 'тестовая компания', 'адрес тестовой компании', '123123123', '12312323', '132123123', 'банк', NULL, 3, '2017-05-06 13:55:52', NULL),
(8, 'test_user2@gmail.com', '$2y$13$Xp2vprWyAKCKp74ZZWHTYuboAnfmnD8wn774NsHhoURo0sr/IpRnW', 'OxLW1mRzBDSF_qU8medUbDSJFWyjqoNU', 'тест 2', NULL, NULL, '+375336683035', 1, 'тестовая компания 2', 'flhtc', '123456789', '12345678', '123456789', 'банк', NULL, 3, '2017-05-06 13:57:15', NULL),
(9, 'in@gmai.com', '$2y$13$scvMrKuqYbYpiJp1DmQ.GuP39iUEuUGlwdS1cSmXOVdpNsWjPuOEq', 'SUhhV8DbaqIeZRpAHqYrkXJdAv1T-MRF', 'Имя', NULL, NULL, '+375336683035', 0, 'тестовая компания 3', 'адрес', '123123123', '12312312', '123123123', 'банк', NULL, NULL, '2017-05-10 12:54:12', NULL),
(10, 'layreniya@mail.ru', '$2y$13$SODiz3xXYUEclOQsVEd.beeV2DIzj.C1Fiv7766L5GoKE5E6oQH0O', 'j69a3nig-IwNXVPBjLPYHprCBVQAogqi', 'Ирина', NULL, NULL, '+375291666263', 1, 'Лимпопо', 'Московская ул. ', '236589756', '96325698', '32123123123123123', 'беларусбанк', NULL, NULL, '2017-05-10 12:58:29', NULL),
(11, 'l@gmail.com', '$2y$13$mfZRpMxRY3fKVm.xFBXHuuA0KG02DfLBUpfO0XvaRbKppXaKLZNXO', 'Tzw4XthnLFJPJirdFL4BOckq0rywnMPU', '123', NULL, NULL, '+375336683035', 0, '123', 'адрес', '123123123', '12312312', '123123123', '123123123', NULL, NULL, '2017-05-10 13:08:24', NULL),
(12, '13oops13@gmail.com', '$2y$13$unFybG2zgTuGOmnslxWaw.4mmxA20KvL9dIdEqJEo.FImI6mrhdiS', 'SukrExPGoj6djdlEy3LcVY3xG5ZGrIoS', 'ert', NULL, NULL, '+375445828295', 0, 'ert', 'wer', '123123123', '12312312', '123123213', '123132', NULL, NULL, '2017-05-10 13:13:23', NULL);

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
