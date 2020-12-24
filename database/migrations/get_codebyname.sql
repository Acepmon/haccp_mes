SET GLOBAL log_bin_trust_function_creators = 1;

DROP function IF EXISTS get_codebyname;
DELIMITER $$
CREATE function 
  get_codebyname(cd1 VARCHAR(20), 
               cdnm VARCHAR(100)) returns VARCHAR(20) 
BEGIN 
  DECLARE getcode VARCHAR(20);
  SET getcode = 'Code Err';
  SELECT comm2_cd into getcode
  FROM   COMM_CD 
  WHERE  comm1_cd = cd1 
  AND    comm2_nm = cdnm;
  RETURN getcode;
END $$
DELIMITER ;