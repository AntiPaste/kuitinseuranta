INSERT INTO users (username, password) VALUES ('admin', '$2a$10$mgINLB9gUb/jDww1k0P4NuCT4LEW5g.0XTqHU7pYWIZE4fKtJ5Qay');

INSERT INTO categories (user_id, name) VALUES (1, 'Sekalaista');

INSERT INTO location_categories (user_id, category_id, location) VALUES (1, 1, 'UniCafe');

INSERT INTO receipts (user_id, location, date, sum) VALUES (1, 'UniCafe', '2015-09-18 12:00', 2.60);

INSERT INTO receipt_categories (receipt_id, category_id) VALUES (1, 1);