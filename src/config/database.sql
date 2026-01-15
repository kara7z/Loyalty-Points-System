-- Users table
create DATABASE LPS;
USE LPS;
CREATE TABLE users (
id INT PRIMARY KEY AUTO_INCREMENT,
email VARCHAR(100) UNIQUE NOT NULL,
password_hash VARCHAR(255) NOT NULL,
name VARCHAR(100),
total_points INT DEFAULT 0,
createdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Points transactions

CREATE TABLE points_transactions (
id INT PRIMARY KEY AUTO_INCREMENT,
user_id INT NOT NULL,
type ENUM('earned', 'redeemed', 'expired') NOT NULL,
amount INT NOT NULL,
description VARCHAR(255),
balance_after INT NOT NULL,
createdat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Rewards catalog

CREATE TABLE rewards (
id INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(100) NOT NULL,
points_required INT NOT NULL,
description TEXT,
stock INT DEFAULT -1 -- -1 = unlimited
);
