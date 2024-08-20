CREATE TABLE comments (
    id INT NOT NULL AUTO_INCREMENT,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    username varchar(255) NOT NULL,
    text VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    date date NOT NULL,
    PRIMARY KEY (id)
);