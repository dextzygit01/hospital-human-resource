-- Hospital Management System - HR Database Schema
-- Complete 7-step workflow implementation

-- 1. Department Applicant Requests
CREATE TABLE department_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    qualifications TEXT,
    positions_needed INT DEFAULT 1,
    job_description TEXT,
    reason_for_hiring TEXT,
    urgency_level ENUM('low', 'medium', 'high') DEFAULT 'medium',
    request_status ENUM('pending', 'approved', 'rejected', 'completed') DEFAULT 'pending',
    requested_by VARCHAR(100),
    approved_by VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Recruitment Management
CREATE TABLE job_postings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT,
    job_title VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    description TEXT,
    requirements TEXT,
    salary_range VARCHAR(50),
    location VARCHAR(100),
    employment_type ENUM('full-time', 'part-time', 'contract') DEFAULT 'full-time',
    status ENUM('active', 'closed', 'on-hold') DEFAULT 'active',
    posted_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    closing_date DATE,
    FOREIGN KEY (request_id) REFERENCES department_requests(id)
);

-- 3. Applicant Management
CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_posting_id INT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    resume_url VARCHAR(255),
    cover_letter TEXT,
    qualifications TEXT,
    experience_years INT DEFAULT 0,
    application_status ENUM('new', 'screening', 'interview', 'hired', 'rejected') DEFAULT 'new',
    screening_notes TEXT,
    interview_date DATETIME,
    interview_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_posting_id) REFERENCES job_postings(id)
);

-- 4. New Hire Onboarding
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) UNIQUE NOT NULL,
    applicant_id INT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    department VARCHAR(100),
    position VARCHAR(100),
    hire_date DATE,
    start_date DATE,
    salary DECIMAL(10,2),
    employment_status ENUM('probation', 'active', 'inactive', 'terminated') DEFAULT 'probation',
    onboarding_status ENUM('not-started', 'in-progress', 'completed') DEFAULT 'not-started',
    medical_clearance BOOLEAN DEFAULT FALSE,
    background_check BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (applicant_id) REFERENCES applicants(id)
);

CREATE TABLE onboarding_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    task_name VARCHAR(100) NOT NULL,
    task_description TEXT,
    due_date DATE,
    completion_status ENUM('pending', 'in-progress', 'completed') DEFAULT 'pending',
    assigned_to VARCHAR(100),
    completed_date DATE,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- 5. Performance Tracking
CREATE TABLE performance_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    review_period VARCHAR(50),
    attendance_score DECIMAL(3,2),
    task_completion_score DECIMAL(3,2),
    patient_feedback_score DECIMAL(3,2),
    team_collaboration_score DECIMAL(3,2),
    training_progress_score DECIMAL(3,2),
    overall_rating DECIMAL(3,2),
    review_notes TEXT,
    reviewer_name VARCHAR(100),
    review_date DATE,
    next_review_date DATE,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- 6. Azure AI Performance Analytics
CREATE TABLE ai_insights (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    performance_prediction DECIMAL(3,2),
    attrition_risk_score DECIMAL(3,2),
    skill_gap_analysis TEXT,
    training_recommendations TEXT,
    mentorship_needed BOOLEAN DEFAULT FALSE,
    role_adjustment_needed BOOLEAN DEFAULT FALSE,
    ai_confidence_score DECIMAL(3,2),
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- 7. Social Recognition
CREATE TABLE recognitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT,
    recognition_type ENUM('excellence', 'achievement', 'milestone', 'team-player'),
    title VARCHAR(100) NOT NULL,
    description TEXT,
    given_by VARCHAR(100),
    given_date DATE,
    certificate_url VARCHAR(255),
    points_awarded INT DEFAULT 0,
    is_public BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (employee_id) REFERENCES employees(id)
);

-- Indexes for performance
CREATE INDEX idx_applicants_status ON applicants(application_status);
CREATE INDEX idx_employees_department ON employees(department);
CREATE INDEX idx_performance_employee ON performance_reviews(employee_id);
CREATE INDEX idx_ai_insights_employee ON ai_insights(employee_id);
