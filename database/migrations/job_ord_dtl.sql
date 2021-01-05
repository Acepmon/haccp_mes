CREATE TABLE `JOB_ORD_DTL` (
`JOB_DT`      VARCHAR(8)   NOT NULL COMMENT '작업일자', -- JOB_DT
`SEQ_NO`      INT(3)       NOT NULL COMMENT '전표순번', -- SEQ_NO
`ITEM_ID`     VARCHAR(20)  NOT NULL COMMENT '자재 ID', -- ITEM_ID
`PROC_SEQ_NO` INT(3)       NOT NULL COMMENT 'PROC순번', -- PROC_SEQ_NO
`SRT_DTM`     VARCHAR(14)  NULL     COMMENT '시작시간', -- SRT_DTM
`END_DTM`     VARCHAR(14)  NULL     COMMENT '종료시간', -- END_DTM
`HACCP_CD`    VARCHAR(20)  NULL     COMMENT 'HACCP 품목코드', -- HACCP_CD
`HACCP_YN`    CHAR(1)      NULL     COMMENT 'HACCP YN', -- HACCP_YN
`REMARK`      VARCHAR(100) NULL     COMMENT '비고', -- REMARK
`REG_ID`      VARCHAR(15)  NULL     COMMENT '등록자ID', -- REG_ID
`REG_DTM`     VARCHAR(14)  NULL     COMMENT '등록일시', -- REG_DTM
PRIMARY KEY(JOB_DT, SEQ_NO, ITEM_ID, PROC_SEQ_NO)
)
COMMENT 'Job Order Detail';
