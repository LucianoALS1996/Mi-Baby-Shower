# MiBabyShower

**Aplicación Laravel para gestionar babyshowers, invitados, regalos y envíos de invitaciones con acceso público mediante tokens.**

---

## 🚀 Descripción

MiBabyShower es una aplicación web construida con **Laravel 12** y **PHP 8.2**. Permite a un organizador:

- crear y administrar babyshowers
- agregar y gestionar invitados
- definir y administrar regalos del evento
- enviar invitaciones y manejar respuestas
- permitir a invitados confirmar asistencia y reservar regalos desde un enlace público

---

## ✨ Características principales

- Registro y autenticación de organizadores
- Administración de eventos babyshowower
- Gestión de invitados con token de invitación
- Envío masivo de invitaciones
- Lista dnologías usadas

- PHP ^8.2
- Laravel ^12.0
- Bootstrap
- MySQL 8 

---

## 📦 Instalación

1. Clona o copia el proyecto al directorio de trabajo.
2. Instala dependencias PHP:

```bash
composer install
```

3. Crea el archivo de ambiente:

```bash
cp .env.example .env
```

4. Genera la clave de aplicación:

```bash
php artisan key:generate
```

5. Configura la base de datos en `.env`.

6. Ejecuta migraciones:

```bash
php artisan migrate
```


---

## 🧰 Comandos útiles

```bash
composer setup       # instala dependencias, copia .env, genera clave, migra y compila
npm run dev          # arranca Vite en modo desarrollo
npm run build        # compila los assets para producción
php artisan serve    # inicia servidor local;

```

---

## 🌐 Rutas principales

### Públicas

- `/` → página principal
- `/login` → formulario de ingreso
- `/register` → formulario de registro
- `/recuperar-password` → formulario de recuperación de contraseña
- `/nueva-password/{token}` → formulario para establecer nueva contraseña

### Invitación pública

- `/invitacion/{token}` → ver invitación
- `POST /invitacion/{token}/confirmar` → confirma asistencia
- `POST /invitacion/{token}/rechazar` → rechaza asistencia
- `POST /invitacion/{token}/reservar/{idRegalo}` → reserva un regalo
- `POST /invitacion/{token}/revertir/{idReserva}` → revierte una reserva

### Rutas protegidas por sesión

- `/babyshowers` → lista de babyshowers
- `/babyshowers/create` → crear un babyshower
- `/babyshowers/{id}` → ver un babyshower
- `/babyshowers/{id}/edit` → editar un babyshower
- `/babyshowers/{id}/invitados` → lista de invitados
- `/babyshowers/{id}/invitados/create` → agregar invitado
- `/babyshowers/{id}/regalos` → lista de regalos
- `/babyshowers/{id}/regalos/create` → crear regalo

---

## 🧭 Estructura del proyecto

- `app/Models/` → modelos de datos
- `app/Http/Controllers/` → controladores de lógica de negocio
- `routes/web.php` → definiciones de rutas
- `resources/views/` → vistas Blade
- `database/migrations/` → migraciones de esquema
- `public/` → activos públicos

---

## 💡 Flujo de uso

1. El organizador crea una cuenta y accede.
2. Crea un babyshower con fecha, lugar y descripción.
3. Agrega invitados al evento.
4. Define regalos disponibles para el babyshower.
5. Envía invitaciones o comparte el enlace público.
6. El invitado usa `/invitacion/{token}` para confirmar asistencia o reservar regalos.

---

## 📌 Notas importantes

- El registro de usuario es únicamente para organizadores.
- La contraseña se almacena encriptada con `Hash::make`.
- La tabla `password_resets` se usa para la recuperación de contraseña.
- Las invitaciones usan tokens de acceso y expiración asociados al evento.
- Cuando un invitado rechaza o revierte una reserva, se libera la cantidad reservada.

---

## 📄 Licencia

- MITe regalos con control de cantidades reservadas
- Flujo público de invitación con confirmación, rechazo, reserva y reversión de reservas

---

## 🧩 Tecnologías usadas

- PHP ^8.2
- Laravel ^12.0
- Bootstrap
- MySQL 8 

---

## 📦 Instalación

1. Clona o copia el proyecto al directorio de trabajo.
2. Instala dependencias PHP:

```bash
composer install
```

3. Crea el archivo de ambiente:

```bash
cp .env.example .env
```

4. Genera la clave de aplicación:

```bash
php artisan key:generate
```

5. Configura la base de datos en `.env`.

6. Ejecuta migraciones:

```bash
php artisan migrate
```


---

## 🧰 Comandos útiles

```bash
composer setup       # instala dependencias, copia .env, genera clave, migra y compila
npm run dev          # arranca Vite en modo desarrollo
npm run build        # compila los assets para producción
php artisan serve    # inicia servidor local;

```

---

## 🌐 Rutas principales

### Públicas

- `/` → página principal
- `/login` → formulario de ingreso
- `/register` → formulario de registro
- `/recuperar-password` → formulario de recuperación de contraseña
- `/nueva-password/{token}` → formulario para establecer nueva contraseña

### Invitación pública

- `/invitacion/{token}` → ver invitación
- `POST /invitacion/{token}/confirmar` → confirma asistencia
- `POST /invitacion/{token}/rechazar` → rechaza asistencia
- `POST /invitacion/{token}/reservar/{idRegalo}` → reserva un regalo
- `POST /invitacion/{token}/revertir/{idReserva}` → revierte una reserva

### Rutas protegidas por sesión

- `/babyshowers` → lista de babyshowers
- `/babyshowers/create` → crear un babyshower
- `/babyshowers/{id}` → ver un babyshower
- `/babyshowers/{id}/edit` → editar un babyshower
- `/babyshowers/{id}/invitados` → lista de invitados
- `/babyshowers/{id}/invitados/create` → agregar invitado
- `/babyshowers/{id}/regalos` → lista de regalos
- `/babyshowers/{id}/regalos/create` → crear regalo

---

## 🧭 Estructura del proyecto

- `app/Models/` → modelos de datos
- `app/Http/Controllers/` → controladores de lógica de negocio
- `routes/web.php` → definiciones de rutas
- `resources/views/` → vistas Blade
- `database/migrations/` → migraciones de esquema
- `public/` → activos públicos

---

## 💡 Flujo de uso

1. El organizador crea una cuenta y accede.
2. Crea un babyshower con fecha, lugar y descripción.
3. Agrega invitados al evento.
4. Define regalos disponibles para el babyshower.
5. Envía invitaciones o comparte el enlace público.
6. El invitado usa `/invitacion/{token}` para confirmar asistencia o reservar regalos.

---

## 📌 Notas importantes

- El registro de usuario es únicamente para organizadores.
- La contraseña se almacena encriptada con `Hash::make`.
- La tabla `password_resets` se usa para la recuperación de contraseña.
- Las invitaciones usan tokens de acceso y expiración asociados al evento.
- Cuando un invitado rechaza o revierte una reserva, se libera la cantidad reservada.

---

## 📄 Licencia

- MIT

