# php-mysql-CRUD

Project to build CRUD application for login logout on auto website
Used stack: LAMP

Used sql:
    CREATE TABLE autos (
        autos_id INTEGER NOT NULL KEY AUTO_INCREMENT,
        make VARCHAR(255),
        model VARCHAR(255),
        year INTEGER,
        mileage INTEGER
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
