INSERT INTO users (email, password_hash, name, total_points) VALUES
('kara@gmail.com', '$2y$10$abc123kara', 'Kara Ossama', 1200),
('amina@gmail.com', '$2y$10$abc123amina', 'Amina El Fassi', 500),
('youssef@gmail.com', '$2y$10$abc123youssef', 'Youssef Ben Ali', 800),
('fatima@gmail.com', '$2y$10$abc123fatima', 'Fatima Zahra', 300),
('hamza@gmail.com', '$2y$10$abc123hamza', 'Hamza Idrissi', 1500);

INSERT INTO rewards (name, points_required, description, stock) VALUES
('5% Discount Coupon', 200, 'Get 5% off your next purchase', -1),
('Free Shipping', 300, 'Free shipping on your next order', -1),
('10% Discount Coupon', 500, 'Get 10% off your next purchase', -1),
('Gift Card 50 MAD', 1000, '50 MAD gift card', 20),
('Gift Card 100 MAD', 2000, '100 MAD gift card', 10);

INSERT INTO points_transactions
(user_id, type, amount, description, balance_after)
VALUES
-- Kara
(1, 'earned', 500, 'Signup bonus', 500),
(1, 'earned', 700, 'Purchase reward', 1200),

-- Amina
(2, 'earned', 500, 'First purchase', 500),

-- Youssef
(3, 'earned', 1000, 'Big order bonus', 1000),
(3, 'redeemed', -200, 'Redeemed 5% Discount Coupon', 800),

-- Fatima
(4, 'earned', 300, 'Referral bonus', 300),

-- Hamza
(5, 'earned', 1500, 'VIP customer reward', 1500),
(5, 'redeemed', -500, 'Redeemed 10% Discount Coupon', 1000),
(5, 'expired', -200, 'Points expired', 800);
