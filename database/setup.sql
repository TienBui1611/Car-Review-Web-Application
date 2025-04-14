-- Drop tables if they already exist
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS cars;
DROP TABLE IF EXISTS manufacturers;

-- Create the manufacturers table
CREATE TABLE manufacturers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL
);

-- Create the cars table
CREATE TABLE cars (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    manufacturer_id INTEGER NOT NULL,
    model VARCHAR(255) NOT NULL,
    year INTEGER NOT NULL,
    type VARCHAR(50),
    FOREIGN KEY (manufacturer_id) REFERENCES manufacturers(id)
);

-- Create the reviews table
CREATE TABLE reviews (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    car_id INTEGER NOT NULL,
    reviewer_name VARCHAR(255) NOT NULL,
    rating INTEGER NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id)
);

-- Insert manufacturers
INSERT INTO manufacturers (name) VALUES ('Toyota'), ('Ford'), ('BMW');

-- Insert cars
INSERT INTO cars (name, manufacturer_id, model, year, type) 
VALUES 
('Camry', 1, 'SE', 2020, 'Sedan'),
('Mustang', 2, 'GT', 2021, 'Coupe'),
('3 Series', 3, '330i', 2019, 'Sedan');

-- Insert reviews
INSERT INTO reviews (car_id, reviewer_name, rating, review_text) 
VALUES 
(1, 'JohnDoe', 4, 'Very comfortable and fuel-efficient.'),
(1, 'JaneSmith', 5, 'Smooth ride and great handling.'),
(2, 'MikeJones', 3, 'Powerful but not very practical.'),
(3, 'AnnaBell', 5, 'Luxurious and fast!');
