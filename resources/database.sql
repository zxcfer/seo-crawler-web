SELECT * FROM users;
SELECT * FROM posts;

USE seospider_web;
CREATE TABLE website (
    id BIGINT unsigned NOT NULL AUTO_INCREMENT,
    name VARCHAR(250) NOT NULL,
    root_url VARCHAR(250),
    description TEXT,
    status INTEGER, -- 0 Inactive, 1 Active, 2 Blocked
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    PRIMARY KEY (id)
)
ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE website_availability (
        id BIGINT unsigned NOT NULL AUTO_INCREMENT,
        availability INTEGER, -- 0 on, 1 off
        average DECIMAL(3,2),
        average_date DATE, 
        atype INTEGER, -- 0 Exact time Status, 1 Daily Average
        checked_on DATETIME, 
        website BIGINT,
        PRIMARY KEY (id)
)

CREATE TABLE website_status (
        id bigint unsigned NOT NULL AUTO_INCREMENT,
        risk_level INTEGER, -- (0 GREEN, 1 YELLOW,  2 ORANGE, 3 RED )
        status_date TIMESTAMP,
        status_type INTEGER, -- (0 daily, 1 weekly)
        website bigint,
        PRIMARY KEY (id)
)

CREATE TABLE url (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        url VARCHAR(255) NOT NULL,
        urltype INTEGER NOT NULL,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        website_id INT NOT NULL,
        PRIMARY KEY (id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1;
    
CREATE TABLE url_status (
        id BIGINT NOT NULL AUTO_INCREMENT,
        h1 TEXT,
        h2 TEXT,
        h3 TEXT,
        h4 TEXT,
        h5 TEXT,
        h6 TEXT,
        title TEXT,
        description TEXT,
        url_id INT NOT NULL,
        reported_on DATE,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (id)
    )
    ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE alert (
        id bigint unsigned NOT NULL AUTO_INCREMENT,
        severety INTEGER, -- (0 GREEN, 1 YELLOW,  2 ORANGE, 3 RED )
        description TEXT,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (id)
);

CREATE TABLE url_alert (
        id bigint unsigned NOT NULL AUTO_INCREMENT,
        url_id BIGINT,
        reported_on DATE,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        PRIMARY KEY (id)
);


