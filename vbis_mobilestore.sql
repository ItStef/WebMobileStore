CREATE DATABASE IF NOT EXISTS vbis_mobilestore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vbis_mobilestore;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin' , 'anon') DEFAULT 'anon'
);

CREATE TABLE devices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    os VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255)
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    device_id INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (device_id) REFERENCES devices(id)
);



INSERT INTO devices (name, brand, price, year, os, image) VALUES
('iPhone 15', 'Apple', 999.99, 2023, 'iOS', 'iphone15.png'),
('Galaxy S24', 'Samsung', 899.99, 2024, 'Android', 'galaxys24.png'),
('Pixel 9', 'Google', 799.99, 2024, 'Android', 'pixel9.png'),
('Poco F6', 'Xiaomi', 399.99, 2024, 'Android', 'pocof6.png');