CREATE DATABASE IF NOT EXISTS GardeningStore;
USE GardeningStore;

-- Customers Table
CREATE TABLE Customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone_no VARCHAR(20),
    address TEXT,
    password_hash VARCHAR(255) NOT NULL  -- Securely store hashed passwords
);

-- Gardeners Table
CREATE TABLE Gardeners (
    gardener_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone_no VARCHAR(20),
    charges DECIMAL(10,2),
    password_hash VARCHAR(255) NOT NULL  -- Securely store hashed passwords
);

-- Sellers Table (Those who sell to the nursery)
CREATE TABLE Sellers (
    seller_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_no VARCHAR(20),
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL  -- Securely store hashed passwords
);

-- Unified Products Table (Plants, Seeds, Accessories, etc.)
CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category ENUM('Plant', 'Seed', 'Bulb', 'Soil & Fertilizer', 'Gardening Tool', 'Gift', 'Pebble', 'Accessory') NOT NULL,
    subcategory VARCHAR(255) NOT NULL, -- Example: Indoor Plants, Herb Seeds, Decorative Pebbles
    description TEXT,
    price DECIMAL(10,2),
    quantity INT DEFAULT 0,
    image BLOB,
    seller_id INT,
    FOREIGN KEY (seller_id) REFERENCES Sellers(seller_id) ON DELETE SET NULL
);

-- Inventory Table (Storage management for bulk products)
CREATE TABLE Inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    quantity INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
);

-- Orders Table
CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_date DATE,
    total_amount DECIMAL(10,2),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE
);

-- Order Details Table (To store multiple items in an order)
CREATE TABLE OrderDetails (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
);

-- Sales Table (Tracking sales from sellers to the nursery)
CREATE TABLE Sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT,
    product_id INT,
    quantity INT,
    amount DECIMAL(10,2),
    sale_date DATE,
    FOREIGN KEY (seller_id) REFERENCES Sellers(seller_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
);

-- Hiring Table (Customers hiring Gardeners)
CREATE TABLE Hiring (
    hiring_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    gardener_id INT,
    hire_date DATE,
    duration_days INT,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (gardener_id) REFERENCES Gardeners(gardener_id) ON DELETE CASCADE
);
