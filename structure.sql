/*
  SQL database structure
*/

DROP TABLE IF EXISTS EORDERLINE;
DROP TABLE IF EXISTS ESTOCK;
DROP TABLE IF EXISTS EORDER;
DROP TABLE IF EXISTS EMEMBER;
DROP TABLE IF EXISTS ECATEGORY;

CREATE TABLE ECATEGORY (
  category ENUM("gold","silver","bronze"),
  imagePath VARCHAR(20),
  discount INT(2),
  PRIMARY KEY (category)
);

CREATE TABLE EMEMBER (
  memberNo INT(6) AUTO_INCREMENT,
  forename VARCHAR(20),
  surname VARCHAR(20),
  street VARCHAR(40),
  town VARCHAR(20),
  postcode VARCHAR(10),
  email VARCHAR(40),
  category ENUM("gold","silver","bronze"),
  passwordHash CHAR(60),
  FOREIGN KEY (category) REFERENCES ECATEGORY(category),
  PRIMARY KEY (memberNo)
);

CREATE TABLE EORDER (
  orderNo INT(6) AUTO_INCREMENT,
  memberNo INT(6),
  PRIMARY KEY (orderNo),
  FOREIGN KEY (memberNo) REFERENCES EMEMBER(memberNo)
);

CREATE TABLE ESTOCK (
  stockNo CHAR(5),
  description VARCHAR(30),
  price DECIMAL(5,2),
  qtyInStock INT(3),
  PRIMARY KEY (stockNo)
);

CREATE TABLE EORDERLINE (
  orderNo INT(6),
  stockNo CHAR(5),
  quantity INT(2),
  PRIMARY KEY (orderNo,stockNo),
  FOREIGN KEY (stockNo) REFERENCES ESTOCK(stockNo),
  FOREIGN KEY (orderNo) REFERENCES EORDER(orderNo)
);

INSERT INTO ECATEGORY
  (category, imagePath, discount)
VALUES
  ("gold", "gold.png", 10),
  ("silver", "silver.png", 10),
  ("bronze", "bronze.png", 10);

INSERT INTO EMEMBER 
  (memberNo, forename, surname, street, town, postcode, email, category) 
VALUES
  (123980, "Chrispoher", "Brown", "12 High Street", "Perth", "PH3 WE4", "c.brown@hotmail.com", "gold"),
  (445637, "Anne", "Greenfield", "7 George Street", "Perth", "PH1 4ER", "anne.greenfield@yahoo.co.uk", "silver"),
  (456389, "Gillian", "Higgins", "8A Princess Rd", "Dundee", "DD7 2WE", "g.higgins@hotmail.com", "bronze"),
  (659000, "Hannah", "Bluefish", "101 Queens Rd", "Perth", "PH2 3ZX", "blue.hannah@goal.com", "gold"),
  (231901, "Teresa", "Edwards", "4 St Johns Rd", "Dundee", "DD1 RT5", "t.eddy@yahoo.co.uk", "bronze");

INSERT INTO ESTOCK
  (stockNo, description, price, qtyInStock)
VALUES
  ("EG334", "Firefox Twin Turbo", 600, 20),
  ("HG602", "Life JAckets Mk4", 200, 50),
  ("SH990", "Waterproof Shoes", 35, 100),
  ("SP120", "Galaxy Open Topped", 500, 3),
  ("WS980", "5mm Long Sleeved Nordic", 350, 40),
  ("GD500", "Ladies MonoSki", 250, 40),
  ("GD550", "Ladies MonoSki II", 300, 40);

