CREATE TABLE user_wallets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    remaining_amount DECIMAL(10,2) NOT NULL,
    used_amount DECIMAL(10,2) NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO user_wallets (user_name, total_amount, remaining_amount, used_amount)
VALUES 
('Manish9322', 1000, 700, 300),
('Tejas Khairnar', 2000, 1500, 500);
INSERT INTO user_wallets (user_name, total_amount, remaining_amount, used_amount,last_updated) VALUES ('Manish9322', 1000, 700, 300,"2025-02-15"), ('Tejas Khairnar', 2000, 1500, 500,"2025-03-30");



CREATE TABLE wallet_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    passenger_name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    payment_id VARCHAR(50) NOT NULL UNIQUE,
    payment_mode VARCHAR(50) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    paid_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO wallet_payments (passenger_name, title, payment_id, payment_mode, total_amount, paid_at) VALUES
('Manish Sonawane', 'Flight Payment', 'GRTGB123', 'Credit Card', 500, '2025-01-22 00:00:00'),
('Jayesh Chaudhari', 'Train Payment', 'HGHJT456', 'Debit Card', 300, '2025-01-21 00:00:00');


CREATE TABLE custom_push (
    id INT AUTO_INCREMENT PRIMARY KEY,
    notification_type ENUM('Notification', 'SMS', 'WhatsApp') NOT NULL,
    send_by ENUM('Admin', 'User', 'Partner') NOT NULL,
    message TEXT NOT NULL,
    recipients TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE notification_management (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    partner_id INT NOT NULL,
    status ENUM('pending', 'sent', 'failed') NOT NULL DEFAULT 'pending',
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    delivered_at TIMESTAMP NULL DEFAULT NULL
);

INSERT INTO notification_management (user_id, partner_id, status, message, created_at, delivered_at) VALUES
(1, 101, 'sent', 'Your parcel has been shipped.', NOW(), NOW()),
(2, 102, 'pending', 'Your parcel is ready for pickup.', NOW(), NULL);
