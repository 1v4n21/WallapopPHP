CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sid VARCHAR(255) UNIQUE,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    telefono INT(9) NOT NULL,
    poblacion VARCHAR(255) NOT NULL
);

CREATE TABLE anuncios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idUsuario VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion VARCHAR(500) NOT NULL,
    foto_principal VARCHAR(255) NOT NULL,
    foto2 VARCHAR(255),
    foto3 VARCHAR(255),
    foto4 VARCHAR(255),
    precio DECIMAL(10, 2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    vendido BOOLEAN NOT NULL,
    idComprador VARCHAR(255),
    FOREIGN KEY (idUsuario) REFERENCES usuarios(email),
    FOREIGN KEY (idComprador) REFERENCES usuarios(email)
);


