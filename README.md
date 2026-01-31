# Sistema de Productos y Ventas

Sistema completo de gestión de productos y ventas con backend en Laravel y frontend en React.

## 🎯 Características

- ✅ CRUD completo de productos (nombre, precio, stock, categoría, imagen)
- ✅ Registro de ventas con múltiples ítems
- ✅ Reporte de ventas por rango de fechas
- ✅ Autenticación con Laravel Sanctum
- ✅ Arquitectura Hexagonal (Clean Architecture)
- ✅ API RESTful documentada
- ✅ Frontend React moderno con TailwindCSS

## 📋 Requisitos Previos

- PHP >= 8.1
- Composer
- Node.js >= 18
- MySQL/PostgreSQL/SQLite
- Git

## 🏗️ Arquitectura del Sistema

### Backend (Laravel 11)
```
backend-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Capa de presentación
│   │   ├── Requests/        # Validaciones
│   │   └── Resources/       # Transformadores de respuesta
│   ├── Services/            # Lógica de negocio (Casos de uso)
│   ├── Repositories/        # Acceso a datos (Puertos)
│   │   └── Contracts/       # Interfaces
│   ├── Models/              # Entidades del dominio
│   └── DTOs/                # Data Transfer Objects
├── database/
│   ├── migrations/
│   └── seeders/
└── routes/
    └── api.php
```

### Frontend (React + Vite)
```
frontend-react/
├── src/
│   ├── components/          # Componentes reutilizables
│   ├── pages/               # Páginas/Vistas
│   ├── services/            # Llamadas a API (Axios)
│   ├── contexts/            # Context API (Auth, etc)
│   ├── hooks/               # Custom hooks
│   └── utils/               # Utilidades
└── public/
```

## 🚀 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/Brandonvilla10/indiGo.git
cd indigo
```

### 2. Backend (Laravel)
```bash
cd backend-laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

El backend estará disponible en: `http://localhost:8000`

### 3. Frontend (React)
```bash
cd frontend-react
npm install
npm run dev
```

El frontend estará disponible en: `http://localhost:5173`

## 📊 Base de Datos

### Tablas Principales

**users**
- id, name, email, password

**categories**
- id, name, description

**products**
- id, name, description, price, stock, category_id, image

**sales**
- id, user_id, total, sale_date

**sale_items**
- id, sale_id, product_id, quantity, price, subtotal

## 🔐 Autenticación

El sistema usa **Laravel Sanctum** para autenticación basada en tokens.

### Endpoints de Auth:
- `POST /api/register` - Registro de usuario
- `POST /api/login` - Login (devuelve token)
- `POST /api/logout` - Cerrar sesión
- `GET /api/user` - Usuario actual (requiere token)

### Uso del Token:
```javascript
headers: {
  'Authorization': 'Bearer {token}'
}
```

## 📡 API Endpoints

### Productos
- `GET /api/products` - Listar productos
- `POST /api/products` - Crear producto
- `GET /api/products/{id}` - Ver producto
- `PUT /api/products/{id}` - Actualizar producto
- `DELETE /api/products/{id}` - Eliminar producto

### Categorías
- `GET /api/categories` - Listar categorías

### Ventas
- `GET /api/sales` - Listar ventas
- `POST /api/sales` - Registrar venta
- `GET /api/sales/{id}` - Ver detalle de venta
- `GET /api/sales/report?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD` - Reporte

## 🎨 Frontend - Páginas

- `/login` - Inicio de sesión
- `/register` - Registro
- `/products` - Listado de productos
- `/products/create` - Crear producto
- `/products/edit/:id` - Editar producto
- `/sales` - Listado de ventas
- `/sales/create` - Nueva venta
- `/sales/report` - Reporte de ventas

## 🧪 Testing

### Backend
```bash
cd backend-laravel
php artisan test
```

### Frontend
```bash
cd frontend-react
npm run test
```

## 📦 Tecnologías Utilizadas

### Backend
- Laravel 11
- Laravel Sanctum (Auth)
- Eloquent ORM
- MySQL/PostgreSQL/SQLite
- PHP 8.1+

### Frontend
- React 18
- Vite
- React Router v6
- Axios
- TailwindCSS
- React Hook Form

##  Usuarios de Prueba

Después de ejecutar los seeders:

```
Email: admin@indigo.com
Password: password
```

### 1. Flujo de Datos

```
Request → Controller → Service → Repository → Model → Database
                                               ↓
Response ← Resource ← Controller ← Service ← Repository
```







