-- Process source
CREATE TABLE `PROC_SRC` (
`ITEM_ID` VARCHAR(20)  NOT NULL COMMENT '자재 ID', -- ITEM_ID
`SEQ_NO`  INT(3)       NOT NULL COMMENT '재료순서', -- SEQ_NO
`SRC_NM`  VARCHAR(100) NULL     COMMENT '소스이름', -- SRC_NM
`REG_ID`  VARCHAR(15)  NULL     COMMENT '등록자ID', -- REG_ID 
`REG_DTM` VARCHAR(14)  NULL     COMMENT '등록일시', -- REG_DTM
PRIMARY KEY(ITEM_ID, SEQ_NO)
)
COMMENT 'Process source';