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


-- INSERT DUMMY DATA  --

INSERT INTO users (username, password, role) VALUES
('asd', '$2y$10$PV6hUja7e1DzegDIwJ81PukpPktanJyUQXXfXliZkbk9hpSC/Zn8y', 'user'),
('admin', '$2y$10$nsylnIou1X6sQKfzTH7/SOBFTGrbLvrMjAfs/iYrUUwu2fsqXe2jS', 'admin');


INSERT INTO devices (name, brand, os, year, price, image) VALUES
('iPhone 15', 'Apple', 'iOS', 2023, 999.99, 'iphone15.png'),
('iPhone 15 Plus', 'Apple', 'iOS', 2023, 1099.99, 'iphone15plus.png'),
('iPhone 16 Pro', 'Apple', 'iOS', 2024, 1499.99, 'iphone16pro.png'),
('iPhone 16 Plus', 'Apple', 'iOS', 2024, 1299.99, 'iphone16plus.png'),
('Samsung Galaxy S25 Ultra', 'Samsung', 'Android', 2025, 1999.99, 'samsunggalaxyS25ultra.png'),
('Samsung Galaxy S25', 'Samsung', 'Android', 2025, 1499.99, 'samsunggalaxyS25.png'),
('Samsung Galaxy S24 Ultra', 'Samsung', 'Android', 2024, 1499.99, 'samsunggalaxyS24ultra.png'),
('Samsung Galaxy S24', 'Samsung', 'Android', 2024, 899.99, 'samsunggalaxyS24.png'),
('Samsung Galaxy S24 FE', 'Samsung', 'Android', 2024, 799.99, 'samsunggalaxyS24fe.png'),
('Xiaomi Redmi Note 14S', 'Xiaomi', 'Android', 2025, 349.99, 'xiaomiredminote14s.png'),
('Xiaomi Redmi Note 13 Pro+', 'Xiaomi', 'Android', 2024, 399.99, 'xiaomiredminote13proplus.png'),
('Xiaomi Redmi Note 14 Pro', 'Xiaomi', 'Android', 2025, 399.99, 'xiaomiredminote14pro.png'),
('Samsung Galaxy Z Fold7', 'Samsung', 'Android', 2025, 2999.99, 'samsunggalaxyzfold7.png'),
('Huawei Mate X6', 'Huawei', 'Android', 2025, 2299.99, 'huaweimatex6.png'),
('Huawei Nova 13 Pro', 'Huawei', 'Android', 2024, 499.99, 'huaweinova13pro.png'),
('Huawei Nova 13', 'Huawei', 'Android', 2024, 349.99, 'huaweinova13.png');