--database with sample games (implement later)--
CREATE DATABASE IF NOT EXISTS gamerack;

USE gamerack;

CREATE TABLE games(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    platform VARCHAR(50) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    status VARCHAR(20) NOT NULL,
    hours INT NOT NULL
);

INSERT INTO games(title, platform, genre, status, hours) VALUES
('Elden Ring', 'PC', 'RPG', 'Playing', 42),
('Hades', 'Switch', 'Roguelike', 'Completed', 31),
('Halo Infinite', 'Xbox', 'Shooter', 'Unplayed', 0),
('God of War', 'PlayStation', 'Action', 'Unplayed', 3);