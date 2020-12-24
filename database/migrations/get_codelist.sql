SET GLOBAL log_bin_trust_function_creators = 1;

DROP PROCEDURE IF EXISTS get_codelist;
DELIMITER $$ 
CREATE PROCEDURE get_codelist(IN cd1 VARCHAR(20)) 
BEGIN 
    SELECT COMM2_CD, COMM2_NM 
    FROM  COMM_CD 
    WHERE COMM1_CD = cd1 
    AND    COMM2_CD NOT IN ('$$');  
END $$
DELIMITER ;
