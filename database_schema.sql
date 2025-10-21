-- Database: dbujikom
-- Tabel kategori
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL
);

-- Tabel petugas
CREATE TABLE petugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel posts
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    kategori_id INT NOT NULL,
    isi TEXT NOT NULL,
    petugas_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE CASCADE,
    FOREIGN KEY (petugas_id) REFERENCES petugas(id) ON DELETE CASCADE
);

-- Tabel profile
CREATE TABLE profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel galery
CREATE TABLE galery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    position INT NOT NULL,
    status INT NOT NULL DEFAULT 1,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

-- Tabel foto
CREATE TABLE foto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    galery_id INT NOT NULL,
    file VARCHAR(255) NOT NULL,
    judul VARCHAR(255) NOT NULL,
    FOREIGN KEY (galery_id) REFERENCES galery(id) ON DELETE CASCADE
);

-- Insert sample data untuk testing
INSERT INTO kategori (judul) VALUES 
('Teknologi'),
('Olahraga'),
('Pendidikan');

INSERT INTO petugas (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password
('editor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password

INSERT INTO profile (judul, isi) VALUES 
('Tentang Kami', 'Ini adalah halaman tentang kami'),
('Visi Misi', 'Visi dan misi perusahaan kami');
