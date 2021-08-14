use myapp;
CREATE TABLE IF NOT EXISTS admins(
  id INT NOT NULL AUTO_INCREMENT, 
  login_id VARCHAR(20) NOT NULL,
  password VARCHAR(32) NOT NULL,
  email VARCHAR(50) NOT NULL,
  sex INT NOT NULL,
  officer INT NOT NULL,
  profile VARCHAR(100) NOT NULL DEFAULT "",
  birth DATE NOT NULL,
  face_img VARCHAR(30) NOT NULL DEFAULT "",
  PRIMARY KEY (id)
);