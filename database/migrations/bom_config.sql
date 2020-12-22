CREATE TABLE `BOM_CONFIG` (
`ITEM1_ID` VARCHAR(20)  NOT NULL COMMENT '자재ID1', -- ITEM1_ID
`ITEM2_ID` VARCHAR(20)  NOT NULL COMMENT '자재ID2', -- ITEM2_ID
`BOM_VER`  VARCHAR(100) NULL     COMMENT 'BOM 버젼', -- BOM_VER
`PROD_QTY` DECIMAL(10)  NULL     COMMENT '생산수량', -- PROD_QTY
`USE_QTY`  DECIMAL(10)  NULL     COMMENT '소모량', -- USE_QTY
`REG_ID`   VARCHAR(15)  NULL     COMMENT '등록자ID', -- REG_ID 
`REG_DTM`  VARCHAR(14)  NULL     COMMENT '등록일시', -- REG_DTM
PRIMARY KEY(ITEM1_ID, ITEM2_ID)
)
COMMENT 'BOM Configuration';