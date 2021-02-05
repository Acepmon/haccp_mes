-- eDoc File having HACCP
CREATE TABLE `EDOC_FILE_HACCP` (
`HACCP_SEQ` INT          NOT NULL AUTO_INCREMENT COMMENT 'HACCP순서', -- TYPE_CD
`DOC_ID`    INT          NULL     COMMENT '문서 ID', -- DOC_ID
`DOC_NM`    VARCHAR(100) NULL     COMMENT '문서이름', -- DOC_NM
`APR_CD`    VARCHAR(20)  NULL     COMMENT '승인코드', -- APR_CD  C10 TEMP > 10 -ing  > 20 finish, TEMP tempeary status
`DOC_HTML`  TEXT         NULL     COMMENT '문서형식', -- DOC_HTML
`APP_DATA`  TEXT         NULL     COMMENT 'APP 자료', -- APP_DATA
`REMARK`    VARCHAR(100) NULL     COMMENT '비고', -- REMARK
`USE_YN`    CHAR(1)      NULL     COMMENT '사용유무', -- USE_YN
`WORK_ID`   VARCHAR(15)  NULL     COMMENT '작업자ID', -- WORK_ID
`ATT_DTM`   VARCHAR(14)  NULL     COMMENT '첨부화일', -- ATT_DTM
`WORK_DTM`  VARCHAR(14)  NULL     COMMENT '작업일시', -- WORK_DTM
`APP_ID`    VARCHAR(15)  NULL     COMMENT '승인자ID', -- APP_ID
`APP_DTM`   VARCHAR(14)  NULL     COMMENT '승인일시', -- APP_DTM
PRIMARY KEY(HACCP_SEQ)
)
COMMENT 'eDoc File having HACCP';
