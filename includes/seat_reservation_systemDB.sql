CREATE DATABASE IF NOT EXISTS seat_reservation_system;

USE seat_reservation_system;

CREATE TABLE users(
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('intern','admin')
);

CREATE TABLE seats(
  seat_id INT AUTO_INCREMENT PRIMARY KEY,
  seat_num VARCHAR(20),
  location VARCHAR(50),
  status ENUM('available','unavailable') DEFAULT 'available'
);

CREATE TABLE reservations (
  reserve_id INT AUTO_INCREMENT PRIMARY KEY,
  intern_id INT,
  seat_id INT,
  reservation_date DATE,
  time_slot VARCHAR(20),
  status ENUM('active', 'cancelled') DEFAULT 'active',
  FOREIGN KEY (intern_id) REFERENCES users(user_id ),
  FOREIGN KEY (seat_id) REFERENCES seats(seat_id)
);