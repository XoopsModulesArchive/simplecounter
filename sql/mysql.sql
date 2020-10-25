#
# Table structure for table `simplecounter`
#

CREATE TABLE simplecounter (
    uri       VARCHAR(254) BINARY PRIMARY KEY,
    cur_date  DATE   NOT NULL,
    today     INT    NOT NULL DEFAULT 0,
    yesterday INT    NOT NULL DEFAULT 0,
    total     BIGINT NOT NULL DEFAULT 0
)
    ENGINE = ISAM;

CREATE TABLE simplecounter_total (
    cur_date DATE   NOT NULL PRIMARY KEY,
    today    BIGINT NOT NULL DEFAULT 0,
    total    BIGINT NOT NULL DEFAULT 0
)
    ENGINE = ISAM;
