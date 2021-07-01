CREATE DATABASE estoque_database;

use estoque_database;


CREATE TABLE produtos(
 id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
 mes_compra VARCHAR(30) NOT NULL,
 categoria_id INTEGER,
 produto VARCHAR(100) NOT NULL,
 quantidade INTEGER

--  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

CREATE TABLE categorias(
  id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  categoria VARCHAR(30) NOT NULL
)

