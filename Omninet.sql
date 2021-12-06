-- Creating the Database
CREATE DATABASE Omninet;
-- Craeting the User table
CREATE TABLE Omninet.User (
    UserMailAddress VARCHAR(64) NOT NULL PRIMARY KEY,
    UserPassword VARCHAR(256) NOT NULL,
    UserFirstName VARCHAR(64) NOT NULL,
    UserLastName VARCHAR(64) NOT NULL,
    UserType VARCHAR(8) NOT NULL
);
-- Creating Login table
CREATE TABLE Omninet.Login (
    LoginId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    LoginUser VARCHAR(64) NOT NULL,
    LoginDate VARCHAR(32) NOT NULL,
    CONSTRAINT fkLoginUserUserMailAddress FOREIGN KEY (LoginUser) REFERENCES Omninet.User (UserMailAddress)
);
-- Creating Item table
CREATE TABLE Omninet.Item (
    ItemId INT NOT NULL PRIMARY KEY,
    ItemName VARCHAR(128) NOT NULL,
    ItemPrice DOUBLE NOT NULL UNIQUE,
    ItemImage VARCHAR(256),
    ItemQuantity INT DEFAULT 99
);
-- Creating Cart table
CREATE TABLE Omninet.Cart (
    CartId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    CartUser VARCHAR(64) NOT NULL,
    CONSTRAINT fkCartUserUserMailAddress FOREIGN KEY (CartUser) REFERENCES Omninet.User (UserMailAddress),
    CartItem INT NOT NULL,
    CONSTRAINT fkCartItemItemId FOREIGN KEY (CartItem) REFERENCES Omninet.Item (ItemId),
    CartAmount INT NOT NULL,
    CartPrice DOUBLE NOT NULL
);
-- Updating the Image of the item
UPDATE Omninet.Item SET ItemImage = "http://stormysystem.ddns.net/Omninet/public/Images/Items/(1135).jpg" WHERE ItemId = 62319;
UPDATE Omninet.Item SET ItemImage = "http://stormysystem.ddns.net/Omninet/public/Images/Items/(11).jpeg" WHERE ItemId = 63121;
UPDATE Omninet.Item SET ItemImage = "http://stormysystem.ddns.net/Omninet/public/Images/Items/(1137).jpg" WHERE ItemId = 14585;
UPDATE Omninet.Item SET ItemImage = "http://stormysystem.ddns.net/Omninet/public/Images/Items/(1138).jpg" WHERE ItemId = 96846;
UPDATE Omninet.Item SET ItemImage = "http://stormysystem.ddns.net/Omninet/public/Images/Items/(1139).jpg" WHERE ItemId = 36752;
UPDATE Omninet.Item SET ItemImage = "http://stormysystem.ddns.net/Omninet/public/Images/Items/(12).jpeg" WHERE ItemId = 62877;
UPDATE Omninet.Item SET ItemImage = "http://stormysystem.ddns.net/Omninet/public/Images/Items/(12).webp" WHERE ItemId = 89487;