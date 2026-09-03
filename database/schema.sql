CREATE DATABASE IF NOT EXISTS communitylink_db;
USE communitylink_db;

CREATE TABLE users (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    bio TEXT,
    location VARCHAR(255),
    latitude DECIMAL(10,7),
    longitude DECIMAL(10,7),
    role ENUM('CONTRIBUTOR','ORG_ADMIN','SCHOOL_ADMIN','ADMIN') NOT NULL DEFAULT 'CONTRIBUTOR',
    verified BOOLEAN NOT NULL DEFAULT FALSE,
    volunteer_hours DECIMAL(6,2) NOT NULL DEFAULT 0.00,
    projects_completed INT NOT NULL DEFAULT 0,
    email_verified BOOLEAN NOT NULL DEFAULT FALSE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE user_skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id CHAR(36) NOT NULL,
    skill VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY user_skill_unique (user_id, skill)
);

CREATE TABLE credentials (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) NOT NULL,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    status ENUM('PENDING','VERIFIED','REJECTED') NOT NULL DEFAULT 'PENDING',
    uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE organizations (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    name VARCHAR(255) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    type ENUM('NGO','BARANGAY','SCHOOL','LGU','OTHER') NOT NULL,
    verified BOOLEAN NOT NULL DEFAULT FALSE,
    owner_id CHAR(36) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES users(id)
);

CREATE TABLE opportunities (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    org_id CHAR(36) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL,
    latitude DECIMAL(10,7),
    longitude DECIMAL(10,7),
    start_date DATETIME NOT NULL,
    end_date DATETIME,
    opp_type ENUM('VOLUNTEER','PAID','INKIND','EITHER') NOT NULL,
    compensation DECIMAL(12,2) NULL,
    needed_skills TEXT,
    slots_needed INT NOT NULL DEFAULT 1,
    status ENUM('OPEN','FILLING','CLOSED','COMPLETED') NOT NULL DEFAULT 'OPEN',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (org_id) REFERENCES organizations(id) ON DELETE CASCADE
);

CREATE TABLE applications (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) NOT NULL,
    opportunity_id CHAR(36) NOT NULL,
    status ENUM('PENDING','REVIEWED','ACCEPTED','REJECTED','WITHDRAWN') NOT NULL DEFAULT 'PENDING',
    applied_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (opportunity_id) REFERENCES opportunities(id) ON DELETE CASCADE
);

CREATE TABLE contributions (
    id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
    user_id CHAR(36) NOT NULL,
    opportunity_id CHAR(36) NULL,
    project_id CHAR(36) NULL,
    qr_token VARCHAR(255) NULL UNIQUE,
    check_in DATETIME NULL,
    check_out DATETIME NULL,
    hours_logged DECIMAL(6,2) NULL,
    verified BOOLEAN NOT NULL DEFAULT FALSE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);