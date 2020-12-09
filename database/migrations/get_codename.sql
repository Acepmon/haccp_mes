SET GLOBAL log_bin_trust_function_creators = 1;

DROP function IF EXISTS haccp_mes.get_codename;
DELIMITER $$
CREATE function 
  haccp_mes.get_codename(cd1 VARCHAR(20), 
               cd2 VARCHAR(20)) returns VARCHAR(100) 
BEGIN 
  DECLARE getname VARCHAR(100);
  SET getname = 'Code Err';
  SELECT comm2_nm into getname
  FROM   comm_cd 
  WHERE  comm1_cd = cd1 
  AND    comm2_cd = cd2;
  RETURN getname;
END $$
DELIMITER ;