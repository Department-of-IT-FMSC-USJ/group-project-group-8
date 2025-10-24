CREATE DATABASE debit_card_renewal;
USE debit_card_renewal;



CREATE TABLE cards (
    card_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    card_number VARCHAR(16) NOT NULL,
    cardholder_name VARCHAR(100) NOT NULL,
    branch VARCHAR(100) NOT NULL,
    expiry_date DATE NOT NULL,
    card_pin VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_expiry_date (expiry_date),
    INDEX idx_branch (branch)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE card_renewals (
    renewal_id INT AUTO_INCREMENT PRIMARY KEY,
    old_card_id INT NOT NULL,
    new_card_number VARCHAR(16),
    new_expiry_date DATE,
    new_pin VARCHAR(255),
    delivery_status ENUM('processing', 'issued', 'sent_for_delivery', 'delivered') DEFAULT 'processing',
    officer_id INT,
    meeting_id INT,
    renewal_requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    issued_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    tracking_number VARCHAR(100),
    notes TEXT,
    FOREIGN KEY (old_card_id) REFERENCES cards(card_id) ON DELETE CASCADE,
    FOREIGN KEY (officer_id) REFERENCES bank_officers(officer_id) ON DELETE SET NULL,
    FOREIGN KEY (meeting_id) REFERENCES meetings(meeting_id) ON DELETE SET NULL,
    INDEX idx_old_card_id (old_card_id),
    INDEX idx_delivery_status (delivery_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE meetings (
    meeting_id INT AUTO_INCREMENT PRIMARY KEY,
    card_id INT NOT NULL,
    user_id INT NOT NULL,
    officer_id INT NOT NULL,
    meeting_date DATETIME NOT NULL,
    zoom_link TEXT,
    status ENUM('scheduled', 'confirmed', 'completed', 'cancelled') DEFAULT 'scheduled',
    user_confirmed BOOLEAN DEFAULT FALSE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (card_id) REFERENCES cards(card_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (officer_id) REFERENCES bank_officers(officer_id) ON DELETE CASCADE,
    INDEX idx_card_id (card_id),
    INDEX idx_user_id (user_id),
    INDEX idx_officer_id (officer_id),
    INDEX idx_meeting_date (meeting_date),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

