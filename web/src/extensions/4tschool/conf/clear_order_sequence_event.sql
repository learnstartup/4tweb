delimiter |

CREATE EVENT IF NOT EXISTS clear_order_sequence
ON SCHEDULE EVERY 1 DAY
DO 
BEGIN
	DROP TABLE IF EXISTS `pw_4t_order_sequence`;
	CREATE TABLE  `pw_4t_order_sequence` (
	  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	  `orderid` INT NOT NULL ,
	  `createdat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	  UNIQUE (
	    `orderid`
	  )
	) ENGINE = INNODB;
END |

delimiter ;