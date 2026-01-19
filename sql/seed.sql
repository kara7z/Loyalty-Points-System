INSERT INTO rewards (name, points_required, description, stock) VALUES
('5$ voucher', 500, 'Instant 5$ discount on your next order.', -1),
('Free shipping', 1000, 'Standard shipping is free.', -1),
('20$ voucher', 2000, '20$ discount on eligible order.', 50);

INSERT INTO products (name, price, image, description, stock) VALUES
('Gaming Headset X', 49.99, 'https://commons.wikimedia.org/wiki/Special:FilePath/Sound%20BlasterX%20H5%20Gaming%20Headset.jpg', 'Comfortable headset with mic for calls & gaming.', 30),
('Mechanical Keyboard', 79.00, 'https://commons.wikimedia.org/wiki/Special:FilePath/Mechanical%20Keyboard.jpg', 'Mechanical keyboard with RGB lighting.', 25),
('Wireless Mouse Pro', 39.50, 'https://commons.wikimedia.org/wiki/Special:FilePath/Wireless%20mouse.jpg', 'Wireless mouse with comfortable grip.', 40),
('USB-C Charger 65W', 25.00, 'https://commons.wikimedia.org/wiki/Special:FilePath/USB-C%20and%20Barrel%20Plug.jpg', 'USB-C charging accessory (demo product).', 60);

INSERT INTO users (email, password_hash, name, total_points) VALUES
('test@demo.com',   '$2y$12$P6j4rdUjEs.KL.zslKy19eBPgjO5RDRILMsOjQSgtl1f2B.H3sNWS', 'Test User', 0),
('kara@demo.com',   '$2y$12$P6j4rdUjEs.KL.zslKy19eBPgjO5RDRILMsOjQSgtl1f2B.H3sNWS', 'Kara', 0),
('admin@demo.com',  '$2y$12$P6j4rdUjEs.KL.zslKy19eBPgjO5RDRILMsOjQSgtl1f2B.H3sNWS', 'Admin', 0),
('meryem@demo.com', '$2y$12$P6j4rdUjEs.KL.zslKy19eBPgjO5RDRILMsOjQSgtl1f2B.H3sNWS', 'Meryem', 0),
('youssef@demo.com','$2y$12$P6j4rdUjEs.KL.zslKy19eBPgjO5RDRILMsOjQSgtl1f2B.H3sNWS', 'Youssef', 0);

UPDATE users
SET password_hash = '$2y$12$P6j4rdUjEs.KL.zslKy19eBPgjO5RDRILMsOjQSgtl1f2B.H3sNWS'
WHERE email IN (
  'test@demo.com',
  'kara@demo.com',
  'admin@demo.com',
  'meryem@demo.com',
  'youssef@demo.com'
);

UPDATE users
SET password_hash = '$2y$12$P6j4rdUjEs.KL.zslKy19eBPgjO5RDRILMsOjQSgtl1f2B.H3sNWS'
WHERE email IN ('test@demo.com','kara@demo.com','admin@demo.com','meryem@demo.com','youssef@demo.com');
