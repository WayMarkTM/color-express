DELIMITER $$
CREATE PROCEDURE splitReservationToPeriods(in _advertising_construction_reservation_id INTEGER, in _from DATE, in _to DATE, in _price DECIMAL(10, 2))
BEGIN
	DECLARE counter INTEGER DEFAULT 0;
    DECLARE temp_date DATE DEFAULT CURDATE();
    SET temp_date = _from;
    SET counter = PERIOD_DIFF(DATE_FORMAT(_to, '%Y%m'), DATE_FORMAT(_from, '%Y%m'));
    
    WHILE counter >= 0 DO
		IF counter = 0 THEN
			INSERT INTO `advertising_construction_reservation_period`(advertising_construction_reservation_id, `from`, `to`, price)
            VALUES (_advertising_construction_reservation_id, temp_date, _to, _price);
		ELSE 
			INSERT INTO `advertising_construction_reservation_period`(advertising_construction_reservation_id, `from`, `to`, price)
            VALUES (_advertising_construction_reservation_id, temp_date, DATE_ADD(DATE_ADD(DATE_ADD(temp_date, INTERVAL - DAY(temp_date) + 1 DAY), INTERVAL 1 MONTH), INTERVAL - 1 DAY), _price);
        END IF;
        
		SET temp_date = DATE_ADD(DATE_ADD(temp_date, INTERVAL - DAY(temp_date) + 1 DAY), INTERVAL 1 MONTH);
		SET counter = counter - 1;
    END WHILE;
END;$$

CREATE PROCEDURE splitReservationsToPeriods ()
BEGIN
	DECLARE finished INTEGER DEFAULT 0;
    DECLARE _id INTEGER DEFAULT 0;
    DECLARE _from DATE DEFAULT CURDATE();
    DECLARE _to DATE DEFAULT CURDATE();
    DECLARE _cost DECIMAL(10, 2) DEFAULT 0.0;
    DECLARE _price DECIMAL(10, 2) DEFAULT 0.0;

	DECLARE reservationsCursor CURSOR FOR
    SELECT id, `from`, `to`, cost FROM `advertising_construction_reservation`;
    
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET finished = 1;

	OPEN reservationsCursor;
    REPEAT
		FETCH reservationsCursor INTO _id, _from, _to, _cost;
        SET _price = ROUND(_cost / (DATEDIFF(_to, _from) + 1), 2);

        CALL splitReservationToPeriods(_id, _from, _to, _price);
	UNTIL finished END REPEAT;
    CLOSE reservationsCursor;
END;$$
 
DELIMITER ;

DROP PROCEDURE splitReservationsToPeriods;

DROP PROCEDURE splitReservationToPeriods;

CALL splitReservationToPeriods(
	(SELECT id FROM `advertising_construction_reservation` LIMIT 1),
    (SELECT `from` FROM `advertising_construction_reservation` LIMIT 1),
    (SELECT `to` FROM `advertising_construction_reservation` LIMIT 1),
    (SELECT `cost` FROM `advertising_construction_reservation` LIMIT 1)
);


CALL splitReservationsToPeriods();
select * from `temp_table`;
select * from `advertising_construction_reservation`;
select * from `advertising_construction_reservation_period` where advertising_construction_reservation_id = 3482;

delete from `advertising_construction_reservation_period` where id > 0;

SELECT ROUND(13054.00 / DATEDIFF('2017-12-31', '2017-06-01'), 2);

SELECT DATE_ADD(DATE_ADD('2018-02-28', INTERVAL - DAY('2018-02-28') + 1 DAY), INTERVAL 1 MONTH);

select count(*) from `advertising_construction_reservation_period`;
SELECT SUM(monthCount) FROM (select id, PERIOD_DIFF(DATE_FORMAT(`to`, '%Y%m'), DATE_FORMAT(`from`, '%Y%m')) + 1 AS monthCount
FROM `advertising_construction_reservation`) tempt