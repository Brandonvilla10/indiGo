# INSTRUCCIONES PARA COMPLETAR EL BACKEND

## Has completado hasta ahora:
✅ Instalación de Laravel 10
✅ Configuración de base de datos MySQL
✅ Migraciones creadas y ejecutadas
✅ Modelos con relaciones
✅ Repositorios (interfaces e implementaciones)
✅ Services (lógica de negocio)

## Para completar el backend, ejecuta estos comandos en orden:

```bash
cd c:\laragon\www\indiGO\backend-laravel

# 1. Crear los Request Validators restantes
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:request LoginRequest
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:request StoreProductRequest
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:request UpdateProductRequest
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:request StoreSaleRequest

# 2. Crear los Resources
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:resource ProductResource
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:resource CategoryResource
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:resource SaleResource
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:resource SaleItemResource

# 3. Crear el Seeder para datos de prueba
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:seeder CategorySeeder
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:seeder ProductSeeder
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan make:seeder UserSeeder

# 4. Publicar configuración de Sanctum
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# 5. Crear symlink para storage
c:\laragon\bin\php\php-8.1.10-Win32-vs16-x64\php.exe artisan storage:link
```

## Archivos que debes editar manualmente:

Voy a crear los archivos completos a continuación.
