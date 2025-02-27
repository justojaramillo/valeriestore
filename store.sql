-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS online_store;
USE online_store;

-- Tabla de usuario
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de rol
CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de permiso
CREATE TABLE permission (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Relación entre roles y permisos
CREATE TABLE role_permission (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT,
    permission_id INT,
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permission(id) ON DELETE CASCADE
);

-- Relación entre usuarios y roles
CREATE TABLE user_role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    role_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE
);

-- Tabla de categoría de producto
CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT
);

-- Tabla de producto
CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    category_id INT,
    image VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE SET NULL
);

-- Tabla de pedido
CREATE TABLE order_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'canceled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Tabla de detalle del pedido
CREATE TABLE order_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES order_table(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Inserción de roles
INSERT INTO role (name) VALUES ('Admin'), ('Seller'), ('Customer');

-- Inserción de permisos
INSERT INTO permission (name, description) VALUES
    ('add_product', 'Can add new products'),
    ('edit_product', 'Can edit existing products'),
    ('delete_product', 'Can delete products'),
    ('view_product', 'Can view products'),
    ('add_category', 'Can add new categories'),
    ('edit_category', 'Can edit categories'),
    ('delete_category', 'Can delete categories'),
    ('view_category', 'Can view categories'),
    ('add_order', 'Can create new orders'),
    ('edit_order', 'Can edit existing orders'),
    ('delete_order', 'Can delete orders'),
    ('view_order', 'Can view orders'),
    ('add_user', 'Can add new users'),
    ('edit_user', 'Can edit users'),
    ('delete_user', 'Can delete users'),
    ('view_user', 'Can view users'),
    ('add_role', 'Can add new roles'),
    ('edit_role', 'Can edit roles'),
    ('delete_role', 'Can delete roles'),
    ('view_role', 'Can view roles');

-- Asignación de permisos a roles
INSERT INTO role_permission (role_id, permission_id) VALUES
    (1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10), (1, 11), (1, 12), (1, 13), (1, 14), (1, 15), (1, 16), (1, 17), (1, 18), (1, 19), (1, 20), -- Admin has all permissions
    (2, 1), (2, 2), (2, 4), (2, 5), (2, 6), (2, 8), (2, 9), (2, 10), (2, 12), (2, 14), (2, 16), (2, 18), -- Seller can manage products, categories, orders, and view users and roles
    (3, 4), (3, 8), (3, 12); -- Customer can only view products, categories, and orders

-- Inserción de usuarios
INSERT INTO user (username, password) VALUES
    ('admin', '$2y$12$EDrLQHs6jmq9K6tU4Rjra.rC8LAEglzzZ7.6alAgfg1Dh7csz9q5a'),
    ('seller', '$2y$12$EDrLQHs6jmq9K6tU4Rjra.rC8LAEglzzZ7.6alAgfg1Dh7csz9q5a'),
    ('customer', '$2y$12$EDrLQHs6jmq9K6tU4Rjra.rC8LAEglzzZ7.6alAgfg1Dh7csz9q5a');

-- Asignación de roles a usuarios
INSERT INTO user_role (user_id, role_id) VALUES
    (1, 1), -- Admin User
    (2, 2), -- Seller User
    (3, 3); -- Customer User
