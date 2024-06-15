CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    company_id INT,
    start_date DATETIME,
    end_date DATETIME,
    details JSON,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    message TEXT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES companies(id)
);

CREATE TABLE verification_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT,
    question TEXT,
    type ENUM('text', 'number', 'date', 'choice'),
    options JSON,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

CREATE TABLE verification_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT,
    question_id INT,
    answer TEXT,
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (question_id) REFERENCES verification_questions(id)
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT,
    user_id INT,
    company_id INT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    review TEXT,
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

ALTER TABLE users ADD COLUMN profile TEXT;
ALTER TABLE companies ADD COLUMN profile TEXT;

