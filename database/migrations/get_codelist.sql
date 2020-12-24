SET GLOBAL log_bin_trust_function_creators = 1;

DROP PROCEDURE IF EXISTS get_codelist;
DELIMITER $$ 
CREATE PROCEDURE get_codelist(IN cd1 VARCHAR(20)) 
BEGIN 
    SELECT comm2_cd, comm2_nm 
    FROM  COMM_CD 
    WHERE comm1_cd = cd1 
    AND    comm2_cd NOT IN ('$$');  
END $$
DELIMITER ;
