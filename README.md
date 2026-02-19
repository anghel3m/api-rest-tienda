
# 🖥️ API REST - Sistema de Inventario de Equipos

> API REST para gestionar inventario de equipos por medio de JSON y PowerShell

## 📋 Descripción

Sistema web construido en **PHP 8+** que recibe información de inventario de equipos desde scripts de PowerShell. 
Los datos se envían en formato JSON y se almacenan en una base de datos MySQL con validación por token.

**Características principales:**
- ✅ API sin autenticación de usuarios (solo validación de token)
- ✅ Recibe datos en JSON desde PowerShell
- ✅ INSERT ... ON DUPLICATE KEY UPDATE (actualización automática)
- ✅ Endpoints RESTful: POST, GET, PUT, DELETE
- ✅ Manejo de errores con respuestas JSON
- ✅ Sin frontend web (solo API)

---

## 🏗️ Estructura del Proyecto

```
api-rest-tienda/
├── config/
│   ├── database.php          # Conexión PDO a MySQL
│   ├── constants.php         # Token y constantes
│   ├── api_helpers.php       # Funciones auxiliares
│   └── ca.pem               # Certificado SSL
├── src/
│   ├── create.php           # API POST - Insertar/Actualizar
│   ├── read.php             # API GET - Recuperar datos
│   ├── update.php           # API PUT - Actualizar parcial
│   └── delete.php           # API DELETE - Eliminar
├── public/
│   └── style.css            # (Heredado, no se usa)
├── api.php                  # (Heredado, no se usa)
├── index.php                # (Heredado, no se usa)
├── enviar_inventario.ps1    # Script PowerShell para enviar datos
├── API_DOCUMENTATION.md     # Documentación completa
└── README.md               # Este archivo
```

---

## 🚀 Inicio Rápido

### 1. Crear la tabla en la base de datos

```sql
CREATE TABLE equipos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_responsable VARCHAR(150) NULL,
    id_responsable VARCHAR(50) NULL,
    nombre_equipo VARCHAR(100) NOT NULL,
    usuario VARCHAR(100) NULL,
    sistema_operativo VARCHAR(150) NULL,
    version_windows VARCHAR(100) NULL,
    modelo VARCHAR(150) NULL,
    marca VARCHAR(100) NULL,
    serial_bios VARCHAR(100) NOT NULL UNIQUE,
    uuid_equipo VARCHAR(100) NULL,
    procesador VARCHAR(255) NULL,
    nucleos INT NULL,
    ram_total_gb DECIMAL(6,2) NULL,
    disco_total_gb DECIMAL(10,2) NULL,
    tipo_disco VARCHAR(50) NULL,
    fecha_reporte DATETIME NOT NULL,
    ultimo_arranque DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 2. Configurar el token

Edita `config/constants.php`:

```php
define('API_TOKEN', 'TU_TOKEN_SECRETO_AQUI');
```

### 3. Probar un endpoint

**Desde PowerShell:**

```powershell
$uri = "http://localhost/api-rest-tienda/src/create.php"
$body = @{
    token = "TU_TOKEN_SECRETO_AQUI"
    serial_bios = "ABC123DEF456"
    nombre_equipo = "PC-OFICINA-001"
    fecha_reporte = (Get-Date -Format "yyyy-MM-dd HH:mm:ss")
} | ConvertTo-Json

Invoke-WebRequest -Uri $uri -Method Post -Body $body -ContentType "application/json"
```

---

## 📡 Endpoints Disponibles

### POST - Crear o Actualizar Equipo
```
POST /src/create.php
```
Inserta un nuevo equipo o actualiza si `serial_bios` ya existe.

### GET - Recuperar Equipos
```
GET /src/read.php?token=TOKEN&serial_bios=ABC123
```
Recupera todos los equipos o filtra por `serial_bios`, `id`, o `nombre_equipo`.

### PUT - Actualizar Campos Específicos
```
PUT /src/update.php
```
Actualiza solo los campos enviados en el JSON.

### DELETE - Eliminar Equipo
```
DELETE /src/delete.php
```
Elimina un equipo por `serial_bios` o `id`.

---

## 📝 Ejemplo de Solicitud POST

**URL:** `http://localhost/api-rest-tienda/src/create.php`

**Headers:** `Content-Type: application/json`

**Body:**
```json
{
  "token": "tu_token_secreto_aqui_2025",
  "nombre_responsable": "Juan Pérez",
  "id_responsable": "A-12345",
  "nombre_equipo": "PC-VENTAS-001",
  "usuario": "jpérez",
  "sistema_operativo": "Windows 11",
  "version_windows": "23H2",
  "modelo": "OptiPlex 5090",
  "marca": "Dell",
  "serial_bios": "1A5F8K9L2M3N",
  "uuid_equipo": "{550e8400-e29b-41d4-a716-446655440000}",
  "procesador": "Intel Core i7-10700",
  "nucleos": 8,
  "ram_total_gb": 16.00,
  "disco_total_gb": 512.50,
  "tipo_disco": "SSD NVMe",
  "fecha_reporte": "2025-02-19 14:30:00",
  "ultimo_arranque": "2025-02-19 08:15:00"
}
```

**Respuesta:**
```json
{
  "exito": true,
  "mensaje": "Equipo insertado correctamente",
  "datos": {
    "serial_bios": "1A5F8K9L2M3N",
    "accion": "insertado"
  }
}
```

---

## 🔧 Script PowerShell Automático

Usa `enviar_inventario.ps1` para enviar datos automáticamente:

```powershell
PowerShell -ExecutionPolicy Bypass -File enviar_inventario.ps1
```

Para ejecutarlo automáticamente cada hora, crea una tarea programada (como administrador):

```powershell
$action = New-ScheduledTaskAction -Execute "powershell.exe" `
  -Argument "-NoProfile -ExecutionPolicy Bypass -File C:\path\to\enviar_inventario.ps1"
$trigger = New-ScheduledTaskTrigger -AtStartup
Register-ScheduledTask -TaskName "EnviarInventarioEquipo" -Action $action -Trigger $trigger -RunLevel Highest
```

---

## 🔐 Seguridad

- **Token simple:** La validación se realiza mediante un token (no es producción)
- **Sin sesiones:** No se requiere login de usuarios
- **HTTPS recomendado:** Usa SSL/TLS en producción
- **Cambiar token:** Actualiza `config/constants.php` con un token más seguro

---

## 📚 Documentación Completa

Para documentación detallada de todos los endpoints, consulta:
👉 [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

## 💾 Base de Datos

**Connection:** PDO MySQL con certificado SSL

Configurado en variables de entorno:
- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`
- `ca.pem` (certificado)

---

## ✨ Características

| Característica | Estado |
|---|---|
| API REST | ✅ |
| Token de validación | ✅ |
| INSERT ... ON DUPLICATE KEY | ✅ |
| Manejo de errores JSON | ✅ |
| Script PowerShell | ✅ |
| Documentación | ✅ |
| Sin autenticación usuarios | ✅ |

---

## 🛠️ Requirements

- PHP 8.0+
- MySQL 5.7+
- PDO MySQL
- PowerShell 5.1+ (para scripts)

---

## 📄 Licencia

Libre para uso interno

---

## 📧 Soporte

Para detalles adicionales, revisa [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
