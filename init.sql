CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(255) UNIQUE NOT NULL,
  password TEXT NOT NULL
);

CREATE TABLE recipes (
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL,
  prep_time INT NOT NULL,
  difficulty INT CHECK (difficulty BETWEEN 1 AND 3),
  vegetarian BOOLEAN NOT NULL
  user_id INT REFERENCES users(id),
);

CREATE TABLE ratings (
  id SERIAL PRIMARY KEY,
  recipe_id INT REFERENCES recipes(id),
  user_id INT REFERENCES users(id),
  rating INT CHECK (rating BETWEEN 1 AND 5),
  rated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert demo data
INSERT INTO users (username, password) VALUES
('harsh', '123456'),
('user1', 'pass');

INSERT INTO recipes (name, prep_time, difficulty, vegetarian) VALUES
('Paneer Butter Masala', 45, 2, TRUE, 1),
('Chicken Biryani', 60, 3, FALSE, 2),
('Dal Tadka', 30, 1, TRUE, 1);

INSERT INTO ratings (recipe_id, user_id, rating) VALUES
(1, 1, 5),
(2, 1, 4),
(3, 2, 3);
