-- Tabel user untuk authentication
CREATE TABLE IF NOT EXISTS tb_user (
    id_user    INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    nama       VARCHAR(100) NOT NULL,
    role       ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default login: admin / admin123
INSERT INTO tb_user (username, password, nama, role) VALUES
('admin', '$2y$10$j/u5e9HaqK9vkhPqf3wK1.w9wTSGP2eLCKPXNtzNyQzYKb68yE9mu', 'Administrator', 'admin');
