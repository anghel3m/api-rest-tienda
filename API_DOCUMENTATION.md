# 📚 Documentación API REST - Inventario de Equipos

## Configuración Inicial

### 1. Token de Autenticación
Edita el archivo `config/constants.php` y cambia el token:

```php
define('API_TOKEN', 'tu_token_secreto_aqui_2025');
```

**Importante:** Cambia este valor a un token seguro en producción.

---

## 🔌 Endpoints Disponibles

### 1️⃣ POST - Crear o Actualizar Equipo
**URL:** `POST http://localhost/api-rest-tienda/src/create.php`

**Encabezados obligatorios:**
```
Content-Type: application/json
```

**Cuerpo JSON (todos los campos):**
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

**Campos requeridos:**
- `token`
- `serial_bios` (identificador único)
- `nombre_equipo`
- `fecha_reporte`

**Campos opcionales:**
- Todos los demás

**Respuesta exitosa (201):**
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

**Respuesta si se actualiza (201):**
```json
{
  "exito": true,
  "mensaje": "Equipo actualizado correctamente",
  "datos": {
    "serial_bios": "1A5F8K9L2M3N",
    "accion": "actualizado"
  }
}
```

---

### 2️⃣ GET - Recuperar Equipos
**URL:** `GET http://localhost/api-rest-tienda/src/read.php?token=TU_TOKEN`

**Opciones de filtrado:**

#### Obtener todos los equipos:
```
GET http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025
```

#### Obtener un equipo por serial_bios:
```
GET http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025&serial_bios=1A5F8K9L2M3N
```

#### Obtener un equipo por ID:
```
GET http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025&id=1
```

#### Buscar equipos por nombre:
```
GET http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025&nombre_equipo=VENTAS
```

**Respuesta exitosa (200):**
```json
{
  "exito": true,
  "mensaje": "Equipos recuperados correctamente",
  "datos": {
    "total": 2,
    "equipos": [
      {
        "id": 1,
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
        "ram_total_gb": "16.00",
        "disco_total_gb": "512.50",
        "tipo_disco": "SSD NVMe",
        "fecha_reporte": "2025-02-19 14:30:00",
        "ultimo_arranque": "2025-02-19 08:15:00",
        "created_at": "2025-02-19 10:00:00",
        "updated_at": "2025-02-19 10:00:00"
      }
    ]
  }
}
```

---

### 3️⃣ DELETE - Eliminar Equipo
**URL:** `DELETE http://localhost/api-rest-tienda/src/delete.php`

**Encabezados obligatorios:**
```
Content-Type: application/json
```

**Cuerpo JSON (una de estas opciones):**

#### Eliminar por serial_bios:
```json
{
  "token": "tu_token_secreto_aqui_2025",
  "serial_bios": "1A5F8K9L2M3N"
}
```

#### Eliminar por ID:
```json
{
  "token": "tu_token_secreto_aqui_2025",
  "id": 1
}
```

**Respuesta exitosa (200):**
```json
{
  "exito": true,
  "mensaje": "Equipo eliminado correctamente",
  "datos": {
    "tipo": "serial_bios",
    "valor": "1A5F8K9L2M3N"
  }
}
```

---

### 4️⃣ PUT - Actualizar un Campo Específico
**URL:** `PUT http://localhost/api-rest-tienda/src/update.php`

**Encabezados obligatorios:**
```
Content-Type: application/json
```

**Cuerpo JSON:**
```json
{
  "token": "tu_token_secreto_aqui_2025",
  "serial_bios": "1A5F8K9L2M3N",
  "nombre_responsable": "Carlos García",
  "usuario": "cgarcia",
  "ultimo_arranque": "2025-02-19 09:45:00"
}
```

**Respuesta exitosa (200):**
```json
{
  "exito": true,
  "mensaje": "Equipo actualizado correctamente",
  "datos": {
    "identificador": "serial_bios",
    "valor": "1A5F8K9L2M3N",
    "campos_actualizados": 3
  }
}
```

---

## 🔐 Códigos de Error

| Código HTTP | Respuesta JSON | Descripción |
|---|---|---|
| 400 | `TOKEN_FALTANTE` | No se envió el token |
| 401 | `TOKEN_INVALIDO` | El token es incorrecto |
| 404 | `NO_ENCONTRADO` | El equipo con ese serial_bios/id no existe |
| 405 | `METODO_NO_PERMITIDO` | Método HTTP no permitido |
| 500 | `ERROR_BD` | Error de base de datos |

---

## 🔧 Ejemplos de Uso desde PowerShell

### 1. Crear/Actualizar un Equipo

```powershell
$uri = "http://localhost/api-rest-tienda/src/create.php"
$token = "tu_token_secreto_aqui_2025"

$body = @{
    token = $token
    nombre_responsable = "Juan Pérez"
    id_responsable = "A-12345"
    nombre_equipo = "PC-VENTAS-001"
    usuario = "jpérez"
    sistema_operativo = "Windows 11"
    version_windows = "23H2"
    modelo = "OptiPlex 5090"
    marca = "Dell"
    serial_bios = "1A5F8K9L2M3N"
    uuid_equipo = "{550e8400-e29b-41d4-a716-446655440000}"
    procesador = "Intel Core i7-10700"
    nucleos = 8
    ram_total_gb = 16.00
    disco_total_gb = 512.50
    tipo_disco = "SSD NVMe"
    fecha_reporte = (Get-Date -Format "yyyy-MM-dd HH:mm:ss")
    ultimo_arranque = (Get-Date).AddHours(-6).ToString("yyyy-MM-dd HH:mm:ss")
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri $uri -Method Post -Body $body -ContentType "application/json"
$response.Content | ConvertFrom-Json | Format-Table -AutoSize
```

### 2. Recuperar Todos los Equipos

```powershell
$uri = "http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025"

$response = Invoke-WebRequest -Uri $uri -Method Get
$equipos = $response.Content | ConvertFrom-Json

Write-Host "Total de equipos: $($equipos.datos.total)"
$equipos.datos.equipos | Format-Table -Property id, nombre_equipo, serial_bios, usuario -AutoSize
```

### 3. Recuperar un Equipo por Serial BIOS

```powershell
$serial = "1A5F8K9L2M3N"
$uri = "http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025&serial_bios=$serial"

$response = Invoke-WebRequest -Uri $uri -Method Get
$equipos = $response.Content | ConvertFrom-Json

if ($equipos.datos.total -gt 0) {
    $equipos.datos.equipos[0] | Format-Table -Property * -AutoSize
} else {
    Write-Host "Equipo no encontrado"
}
```

### 4. Actualizar un Equipo

```powershell
$uri = "http://localhost/api-rest-tienda/src/update.php"
$token = "tu_token_secreto_aqui_2025"

$body = @{
    token = $token
    serial_bios = "1A5F8K9L2M3N"
    nombre_responsable = "Carlos García"
    usuario = "cgarcia"
    ultimo_arranque = (Get-Date -Format "yyyy-MM-dd HH:mm:ss")
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri $uri -Method Put -Body $body -ContentType "application/json"
$response.Content | ConvertFrom-Json | Format-Table -AutoSize
```

### 5. Eliminar un Equipo

```powershell
$uri = "http://localhost/api-rest-tienda/src/delete.php"
$token = "tu_token_secreto_aqui_2025"

$body = @{
    token = $token
    serial_bios = "1A5F8K9L2M3N"
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri $uri -Method Delete -Body $body -ContentType "application/json"
$response.Content | ConvertFrom-Json | Format-Table -AutoSize
```

### 6. Script Completo para Monitoreo Automático

```powershell
# Script que corre cada hora y envía info del equipo local
$ScriptPath = "C:\Scripts\enviar_inventario.ps1"

$ScriptContent = @'
$uri = "http://localhost/api-rest-tienda/src/create.php"
$token = "tu_token_secreto_aqui_2025"

# Obtener información del sistema
$cpuInfo = Get-WmiObject Win32_Processor
$osInfo = Get-WmiObject Win32_OperatingSystem
$computerInfo = Get-WmiObject Win32_ComputerSystem
$diskInfo = Get-WmiObject Win32_LogicalDisk -Filter "DeviceName='C:'"
$bios = Get-WmiObject Win32_BIOS
$bootTime = [management.managementdatetimeconverter]::ConvertFromDmtfDateTime((Get-WmiObject Win32_OperatingSystem).LastBootUpTime)

$body = @{
    token = $token
    nombre_responsable = $env:USERNAME
    id_responsable = $env:USERDOMAIN
    nombre_equipo = $computerInfo.Name
    usuario = $env:USERNAME
    sistema_operativo = "$($osInfo.Caption)"
    version_windows = "$($osInfo.Version)"
    modelo = $computerInfo.Model
    marca = $computerInfo.Manufacturer
    serial_bios = $bios.SerialNumber
    uuid_equipo = $computerInfo.SystemFamily
    procesador = $cpuInfo.Name
    nucleos = $cpuInfo.NumberOfCores
    ram_total_gb = [math]::Round($computerInfo.TotalPhysicalMemory / 1GB, 2)
    disco_total_gb = [math]::Round($diskInfo.Size / 1GB, 2)
    tipo_disco = "SSD"
    fecha_reporte = (Get-Date -Format "yyyy-MM-dd HH:mm:ss")
    ultimo_arranque = $bootTime.ToString("yyyy-MM-dd HH:mm:ss")
} | ConvertTo-Json

try {
    $response = Invoke-WebRequest -Uri $uri -Method Post -Body $body -ContentType "application/json"
    $responseData = $response.Content | ConvertFrom-Json
    Write-Host "✅ Éxito: $($responseData.mensaje)"
} catch {
    Write-Host "❌ Error: $_"
}
'@

$ScriptContent | Out-File -FilePath $ScriptPath -Encoding UTF8

# Crear tarea programada (ejecutar como administrador)
$action = New-ScheduledTaskAction -Execute "powershell.exe" -Argument "-NoProfile -ExecutionPolicy Bypass -File $ScriptPath"
$trigger = New-ScheduledTaskTrigger -AtStartup
Register-ScheduledTask -TaskName "EnviarInventarioEquipo" -Action $action -Trigger $trigger -RunLevel Highest
```

---

## 📝 Notas Importantes

1. **serial_bios es UNIQUE:** Cada equipo tiene un BIOS serial único. Si envías el mismo serial_bios, se actualizará automáticamente en lugar de crear un duplicado.

2. **Campos fechas:** Usa formato `yyyy-MM-dd HH:mm:ss`

3. **Token obligatorio:** Siempre incluye el token en todas las peticiones

4. **Sin autenticación de usuario:** No se requiere login, solo el token

5. **Seguridad:** Cambia el token en `config/constants.php` a algo más seguro en producción

6. **Base de datos:** La tabla `equipos` se crea automáticamente con el SQL proporcionado

---

## ✅ Checklist de Instalación

- [ ] Crear tabla `equipos` en la base de datos
- [ ] Editar `config/constants.php` con un token seguro
- [ ] Probar endpoint `POST create.php` con PowerShell
- [ ] Probar endpoint `GET read.php` con un navegador o PowerShell
- [ ] Verificar que INSERT ... ON DUPLICATE KEY UPDATE funciona
- [ ] Programar script automático en Windows Task Scheduler
