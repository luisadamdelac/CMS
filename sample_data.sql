-- Sample data for platia_db
-- Insert menu categories
INSERT INTO menu_categories (category_name, description, display_order, is_active) VALUES
('Appetizers', 'Delicious starters and small bites', 1, 1),
('Main Courses', 'Hearty main dishes', 2, 1),
('Desserts', 'Sweet treats and desserts', 3, 1),
('Beverages', 'Refreshing drinks and beverages', 4, 1);

-- Insert menu items (assuming category_ids: 1=Appetizers, 2=Main Courses, 3=Desserts, 4=Beverages)
INSERT INTO menu_items (category_id, item_name, description, price, is_available) VALUES
(1, 'Caesar Salad', 'Fresh romaine lettuce with Caesar dressing', 8.99, 1),
(1, 'Chicken Wings', 'Spicy buffalo wings with ranch dip', 12.99, 1),
(2, 'Grilled Salmon', 'Fresh salmon fillet with vegetables', 18.99, 1),
(2, 'Beef Steak', 'Tender beef steak with mashed potatoes', 24.99, 1),
(2, 'Vegetarian Pasta', 'Pasta with seasonal vegetables', 14.99, 1),
(3, 'Chocolate Cake', 'Rich chocolate cake with vanilla ice cream', 6.99, 1),
(3, 'Tiramisu', 'Classic Italian dessert', 7.99, 1),
(4, 'Coffee', 'Fresh brewed coffee', 3.99, 1),
(4, 'Orange Juice', 'Fresh squeezed orange juice', 4.99, 1),
(4, 'Soda', 'Assorted soft drinks', 2.99, 1);

-- Insert restaurant tables
INSERT INTO restaurant_tables (table_number, capacity, is_available) VALUES
('1', 4, 1),
('2', 6, 1),
('3', 2, 1),
('4', 8, 1),
('5', 4, 1),
('6', 6, 1);

-- Insert sample reservations (assuming customer_id=1 for admin, table_id from above)
INSERT INTO reservations (customer_id, table_id, reservation_date, reservation_time, party_size, special_requests, status) VALUES
(1, 1, '2025-11-01', '19:00:00', 4, 'Window seat preferred', 'confirmed'),
(1, 2, '2025-11-02', '20:00:00', 6, 'Birthday celebration', 'pending'),
(1, 3, '2025-11-03', '18:30:00', 2, 'Quiet table', 'confirmed');
