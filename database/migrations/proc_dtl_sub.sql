-- Process detail sub
CREATE TABLE `PROC_DTL_SUB` (
`ITEM_ID`    VARCHAR(20)  NOT NULL COMMENT '자재 ID', -- ITEM_ID
`SEQ_NO`     INT(3)       NOT NULL COMMENT '작업순서', -- SEQ_NO
`SUB_SEQ_NO` INT(3)       NOT NULL COMMENT '동시작업순서', -- SUB_SEQ_NO
`SEQ_NM`     VARCHAR(20)  NULL     COMMENT '순서이름', -- SEQ_NM
`PROC_CD`    VARCHAR(20)  NULL     COMMENT '공정코드', -- PROC_CD > B80
`PROC_NM`    VARCHAR(40)  NULL     COMMENT '공정이름', -- PROC_NM
`PROC_DTL`   VARCHAR(100) NULL     COMMENT '설명', -- PROC_DTL
`REG_ID`     VARCHAR(15)  NULL     COMMENT '등록자ID', -- REG_ID 
`REG_DTM`    VARCHAR(14)  NULL     COMMENT '등록일시', -- REG_DTM
PRIMARY KEY(ITEM_ID, SEQ_NO, SUB_SEQ_NO)
)
COMMENT 'Process detail sub';
