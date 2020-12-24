SET GLOBAL log_bin_trust_function_creators = 1;

DROP function IF EXISTS get_codename;
DELIMITER $$
CREATE function 
  get_codename(cd1 VARCHAR(20), 
               cd2 VARCHAR(20)) returns VARCHAR(100) 
BEGIN 
  DECLARE getname VARCHAR(100);
  SET getname = 'Code Err';
  SELECT COMM2_NM into getname
  FROM   COMM_CD 
  WHERE  COMM1_CD = cd1 
  AND    COMM2_CD = cd2;
  RETURN getname;
END $$
DELIMITER ;