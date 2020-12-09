SET GLOBAL log_bin_trust_function_creators = 1;

DROP PROCEDURE IF EXISTS haccp_mes.get_codelist;
DELIMITER $$ 
CREATE PROCEDURE haccp_mes.get_codelist(IN cd1 VARCHAR(20)) 
BEGIN 
    SELECT comm2_cd, comm2_nm 
    FROM  comm_cd 
    WHERE comm1_cd = cd1 
    AND    comm2_cd NOT IN ('$$');  
END $$
DELIMITER ;
