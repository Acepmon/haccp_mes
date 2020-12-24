SET GLOBAL log_bin_trust_function_creators = 1;

DROP function IF EXISTS get_codebyname;
DELIMITER $$
CREATE function 
  get_codebyname(cd1 VARCHAR(20), 
               cdnm VARCHAR(100)) returns VARCHAR(20) 
BEGIN 
  DECLARE getcode VARCHAR(20);
  SET getcode = 'Code Err';
  SELECT COMM2_CD into getcode
  FROM   COMM_CD 
  WHERE  COMM1_CD = cd1 
  AND    COMM2_NM = cdnm;
  RETURN getcode;
END $$
DELIMITER ;