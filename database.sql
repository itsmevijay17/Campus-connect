-- Add organizers table
CREATE TABLE organizers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    department VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add organizer_events table to track which events are managed by which organizers
CREATE TABLE organizer_events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    organizer_id INT,
    event_name VARCHAR(255),
    event_date DATE,
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES organizers(id)
);

-- Add selected_participants table to track organizer selections
CREATE TABLE selected_participants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    student_reg_no VARCHAR(20),
    status VARCHAR(50),
    selected_by INT,
    selected_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES organizer_events(id),
    FOREIGN KEY (selected_by) REFERENCES organizers(id)
);

-- Modify existing od_requests table to include organizer approval
ALTER TABLE od_requests 
ADD organizer_status VARCHAR(50) DEFAULT 'Pending',
ADD organizer_id INT,
ADD FOREIGN KEY (organizer_id) REFERENCES organizers(id);