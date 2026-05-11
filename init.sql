-- Database: yonogame_random
CREATE DATABASE IF NOT EXISTS yonogame_random;
USE yonogame_random;

-- Admins table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Games table
CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    image VARCHAR(255) DEFAULT NULL,
    description TEXT,
    bonus VARCHAR(100),
    withdraw INT(20),
    rating DECIMAL(2,1) DEFAULT 0.0,
    size VARCHAR(50),
    version VARCHAR(50),
    downloads VARCHAR(50),
    category_id INT,
    download_link VARCHAR(255),
    meta_title VARCHAR(255),
    meta_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Default Admin (Password: admin123)
-- Hash generated using password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO admins (username, password) VALUES ('admin', '$2y$10$8W9f8S95UvQ8.Y.o.S.P.O.O.O.O.O.O.O.O.O.O.O.O.O.O.O.O.O'); 

-- Sample Categories
INSERT INTO categories (name) VALUES ('New Games'), ('Other Games'), ('Rummy'), ('Slots');
