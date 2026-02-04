# 📘 Laravel Books API

API REST desarrollada en Laravel 5.8.

El proyecto implementa autenticación JWT, módulos de usuarios, autores y libros con operaciones CRUD, exportación de datos en formato Excel (XLSX) y un proceso asíncrono para mantener actualizada la cantidad de libros por autor.

---

## 🧰 Tecnologías

- PHP 7.3+
- Laravel 5.8
- SQLite
- JWT (auth:api)
- Laravel Excel (exportación XLSX)
- Events, Listeners y Jobs

---

## 📁 Requisitos

- PHP >= 7.3
- Composer
- SQLite habilitado
- Extensiones PHP: pdo, pdo_sqlite, openssl

---

## 🚀 Instalación

- Clonar el repositorio
```bash
git clone https://github.com/juanmeanho/laravel-books-api.git
```

- Entrar al directorio
```bash
cd laravel-books-api

composer install
```
- Crear el arcivo .env
```bash
cp .env.example .env
```

- Crear base de datos SQLite
```bash
touch database/database.sqlite
```
- Agregar a .env
```bash
DB_CONNECTION=sqlite
DB_DATABASE=/ruta_absoluta/al/proyecto/database/database.sqlite
```

- Generar la clave de la aplicación:
```bash
php artisan key:generate
```

- Genera el JWT secret y agregar a ,env:
```bash
php artisan jwt:secret
wt-auth secret [tuI7ft44gr.....9rhSYZ1sj95dSj0cDDk] set successfully.
```
- En .env
```bash
JWT_SECRET=tuI7ft44gr.....9rhSYZ1sj95dSj0cDDk
```

- Ejecutar las migraciones
```bash
php artisan migrate
```

- Iniciar servidor
```bash
php artisan serve
```
---
# 📘 Laravel Books API – Documentación API

La API utiliza **JWT** para autenticar las rutas protegidas.  
Todas las rutas protegidas requieren el token:


## 🔑 Autenticación

### Registro de usuario

**POST** `/api/register`

**Body (JSON):**
```json
{
  "name": "Pedro Perez",
  "email": "pedro@example.com",
  "password": "123456"
}
```
Respuesta
```json
{
  "message": "Usuario registrado exitosamente",
  "user": {
    "id": 1,
    "name": "Pedro Perez",
    "email": "pedro@example.com",
    "created_at": "2026-02-04T14:00:00"
  }
}
```

### Login de usuario

**POST** `/api/login`

**Body (JSON):**
```json
{
  "email": "pedro@example.com",
  "password": "123456"
}
```
Respuesta
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```
### Perfil de usuario

**GET** `/api/me`

**Headers: Authorization: Bearer <token>**

**Body (JSON):**

Respuesta
```json
{
    "id": 14,
    "name": "Juan Pedro",
    "email": "juanpedro@test.com",
    "email_verified_at": null,
    "created_at": "2026-02-04 19:09:09",
    "updated_at": "2026-02-04 19:09:09"
}
```

### Logout

**POST** `/api/logout`

**Headers: Authorization: Bearer <token>**

```json
{
    "message": "Usuario desconectado"
}
```
### Usuarios


## 📡 API Endpoints - Usuarios

- **GET** `/api/users` - Listar todos los usuarios
- **GET** `/api/users/{id}` - Ver detalle de un usuario
- **POST** `/api/users` - Crear un nuevo usuario
- **PUT** `/api/users/{id}` - Actualizar un usuario
- **DELETE** `/api/users/{id}` - Eliminar un usuario



**GET** `/api/users` - Listar Usuarios

**Headers: Authorization: Bearer <token>**

**Respuesta:**

```json
{
    "id": 1,
    "name": "Pedro Manuel",
    "email": "pedromanuel@test.com",
    "email_verified_at": null,
    "created_at": "2026-02-04 19:09:09",
    "updated_at": "2026-02-04 19:09:09"
}
{
    "id": 14,
    "name": "Juan Pedro",
    "email": "juanpedro@test.com",
    "email_verified_at": null,
    "created_at": "2026-02-04 19:09:09",
    "updated_at": "2026-02-04 19:09:09"
}
```
**GET** `/api/users/{id}` - Ver detalle de un usuario

**Headers: Authorization: Bearer <token>**

**Respuesta:**
```json
{
    "id": 14,
    "name": "Juan Pedro",
    "email": "juanpedro@test.com",
    "email_verified_at": null,
    "created_at": "2026-02-04 19:09:09",
    "updated_at": "2026-02-04 19:09:09"
}
```
**POST** `/api/users` - Crear un usuario

**Headers: Authorization: Bearer <token>**

**Body (JSON):**
```json
{
  "email": "pedro@example.com",
  "name": "Pedro Example",
  "password": "123456"
}
```
Respuesta
```json
{
    "name": "Pedro Example",
    "email": "pedro@example.com",
    "updated_at": "2026-02-04 19:42:06",
    "created_at": "2026-02-04 19:42:06",
    "id": 15
}
```
**PUT** `/api/users/{id}` - Actualizar un usuario

**Headers: Authorization: Bearer <token>**

**Body (JSON):**
```json
{
  "name": "Pedro Pérez Actualizado",
  "email": "pedro.actualizado@example.com",
  "password": "nuevo123"   // opcional, solo si deseas cambiarla
}
```
Respuesta
```json
{
  "id": 2,
  "name": "Pedro Pérez Actualizado",
  "email": "pedro.actualizado@example.com",
  "updated_at": "2026-02-04T17:00:00"
}

```
**DELETE** `/api/users/{id}` - Borrar un usuario

**Headers: Authorization: Bearer <token>**

**Body (JSON):**

Respuesta
```json
{
    "message": "Usuario eliminado correctamente"
}
```

## 📡 API Endpoints - Autores

- **GET** `/api/authors` - Listar todos los autores
- **GET** `/api/authors/{id}` - Ver detalle de un autor
- **POST** `/api/authors` - Crear un nuevo autor
- **PUT** `/api/authors/{id}` - Actualizar un autor
- **DELETE** `/api/authors/{id}` - Eliminar un autor

---

**GET** `/api/authors` - Listar Autores

**Headers:** Authorization: Bearer <token>

**Respuesta:**
```json
[
  {
    "id": 1,
    "name": "Gabriel García Márquez",
    "books_count": 3,
    "created_at": "2026-02-04 18:00:00",
    "updated_at": "2026-02-04 18:00:00"
  },
  {
    "id": 2,
    "name": "Isabel Allende",
    "books_count": 2,
    "created_at": "2026-02-04 18:10:00",
    "updated_at": "2026-02-04 18:10:00"
  }
]
```
**GET** `/api/authors/{id}` - Ver detalle de un autor

**Headers: Authorization: Bearer <token>**

**Respuesta:**
```json
{
  "id": 1,
  "name": "Gabriel García Márquez",
  "books_count": 3,
  "created_at": "2026-02-04 18:00:00",
  "updated_at": "2026-02-04 18:00:00"
}

```
**POST** `/api/authors` - Crear un Autor

**Headers: Authorization: Bearer <token>**

**Body (JSON):**
```json
{
  "name": "J.K. Rowling"
}

```
Respuesta
```json
{
  "id": 3,
  "name": "J.K. Rowling",
  "books_count": 0,
  "created_at": "2026-02-04 18:30:00",
  "updated_at": "2026-02-04 18:30:00"
}

```
**PUT** `/api/authors/{id}` - Actualizar un autor

**Headers: Authorization: Bearer <token>**

**Body (JSON):**
```json
{
  "name": "Gabriel G. Márquez"
}
```
Respuesta
```json
{
  "id": 1,
  "name": "Gabriel G. Márquez",
  "books_count": 3,
  "updated_at": "2026-02-04 18:45:00"
}


```
**DELETE** `/api/authors/{id}` - Borrar un autor

**Headers: Authorization: Bearer <token>**

**Body (JSON):**

Respuesta
```json
{
    "message": "Autor eliminado correctamente"
}
```

## 📡 API Endpoints - Libros

- **GET** `/api/books` - Listar todos los libros
- **GET** `/api/books/{id}` - Ver detalle de un libro
- **POST** `/api/books` - Crear un nuevo libro
- **PUT** `/api/books/{id}` - Actualizar un libro
- **DELETE** `/api/books/{id}` - Eliminar un libro

---

**GET** `/api/books` - Listar Libros

**Headers:** Authorization: Bearer <token>

**Respuesta:**
```json
[
  {
    "id": 1,
    "title": "Cien años de soledad",
    "author_id": 1,
    "author_name": "Gabriel García Márquez",
    "created_at": "2026-02-04 18:00:00",
    "updated_at": "2026-02-04 18:00:00"
  },
  {
    "id": 2,
    "title": "La casa de los espíritus",
    "author_id": 2,
    "author_name": "Isabel Allende",
    "created_at": "2026-02-04 18:10:00",
    "updated_at": "2026-02-04 18:10:00"
  }
]

```
**GET** `/api/books/{id}` - Ver detalle de un libro

**Headers: Authorization: Bearer <token>**

**Respuesta:**
```json
{
  "id": 1,
  "title": "Cien años de soledad",
  "author_id": 1,
  "author_name": "Gabriel García Márquez",
  "created_at": "2026-02-04 18:00:00",
  "updated_at": "2026-02-04 18:00:00"
}
```
**POST** `/api/books` - Crear un libro

**Headers: Authorization: Bearer <token>**

**Body (JSON):**
```json
{
  "title": "Harry Potter y la piedra filosofal",
  "author_id": 3
}
```
Respuesta
```json
{
  "id": 3,
  "title": "Harry Potter y la piedra filosofal",
  "author_id": 3,
  "created_at": "2026-02-04 18:30:00",
  "updated_at": "2026-02-04 18:30:00"
}
```
**PUT** `/api/books/{id}` - Actualizar un libro

**Headers: Authorization: Bearer <token>**

**Body (JSON):**
```json
{
  "title": "Cien años de soledad - Edición Especial",
  "author_id": 1
}
```
Respuesta
```json
{
  "id": 1,
  "title": "Cien años de soledad - Edición Especial",
  "author_id": 1,
  "updated_at": "2026-02-04 18:45:00"
}
```
**DELETE** `/api/books/{id}` - Borrar un libro

**Headers: Authorization: Bearer <token>**

**Body (JSON):**

Respuesta
```json
{
    "message": "Libro eliminado correctamente"
}
```
## 📡 API Endpoints - Exportar Libros y Autores a xls.

**Headers: Authorization: Bearer <token>**

- **GET** `/api/export/authors` - Exportar todos los autores
- **GET** `/api/export/books` - Exportar todos los libros