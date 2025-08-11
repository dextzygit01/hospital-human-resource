CREATE DATABASE hr_hospital;

USE hr_hospital;

-- Applicants
CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    role_applied VARCHAR(100),
    resume_link VARCHAR(255),
    status ENUM('Applied', 'Shortlisted', 'Interviewed', 'Rejected', 'Hired') DEFAULT 'Applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Job Postings
CREATE TABLE job_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    department VARCHAR(100),
    description TEXT,
    requirements TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Interviews
CREATE TABLE interviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT,
    schedule DATETIME,
    result ENUM('Pending', 'Pass', 'Fail') DEFAULT 'Pending',
    feedback TEXT,
    FOREIGN KEY (applicant_id) REFERENCES applicants(id)
);

-- Hires
CREATE TABLE hires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT,
    department VARCHAR(100),
    start_date DATE,
    onboarding_status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (applicant_id) REFERENCES applicants(id)
);

-- Performance Reviews
CREATE TABLE performance_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hire_id INT,
    period ENUM('30-day', '60-day', '90-day'),
    score INT,
    feedback TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hire_id) REFERENCES hires(id)
);

-- Social Recognition
CREATE TABLE recognitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    type ENUM('Badge', 'Star', 'Award'),
    message TEXT,
    date_sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- AI Performance Tracking
CREATE TABLE ai_performance_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hire_id INT,
    ai_score DECIMAL(5,2),
    risk_level ENUM('Low', 'Medium', 'High'),
    trend_note TEXT,
    FOREIGN KEY (hire_id) REFERENCES hires(id)
);
