# 🔧 Ejemplos de Uso con cURL

Estos son ejemplos de cómo llamar a los endpoints usando `cURL` desde una terminal.

## ⚙️ Configuración

```bash
API_URL="http://localhost/api-rest-tienda"
TOKEN="tu_token_secreto_aqui_2025"
```

---

## 1️⃣ POST - Crear o Actualizar Equipo

```bash
curl -X POST "http://localhost/api-rest-tienda/src/create.php" \
  -H "Content-Type: application/json" \
  -d '{
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
  }' | jq
```

**Respuesta esperada:**
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

## 2️⃣ GET - Recuperar Todos los Equipos

```bash
curl -X GET "http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025" | jq
```

---

## 3️⃣ GET - Recuperar un Equipo por Serial BIOS

```bash
curl -X GET "http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025&serial_bios=1A5F8K9L2M3N" | jq
```

---

## 4️⃣ GET - Buscar Equipos por Nombre

```bash
curl -X GET "http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025&nombre_equipo=VENTAS" | jq
```

---

## 5️⃣ PUT - Actualizar un Campo Específico

```bash
curl -X PUT "http://localhost/api-rest-tienda/src/update.php" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "tu_token_secreto_aqui_2025",
    "serial_bios": "1A5F8K9L2M3N",
    "nombre_responsable": "Carlos García",
    "usuario": "cgarcia"
  }' | jq
```

---

## 6️⃣ DELETE - Eliminar por Serial BIOS

```bash
curl -X DELETE "http://localhost/api-rest-tienda/src/delete.php" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "tu_token_secreto_aqui_2025",
    "serial_bios": "1A5F8K9L2M3N"
  }' | jq
```

---

## 7️⃣ DELETE - Eliminar por ID

```bash
curl -X DELETE "http://localhost/api-rest-tienda/src/delete.php" \
  -H "Content-Type: application/json" \
  -d '{
    "token": "tu_token_secreto_aqui_2025",
    "id": 1
  }' | jq
```

---

## 🔐 Con Autenticación HTTP Basic (opcional)

Si deseas agregar autenticación HTTP adicional:

```bash
curl -X POST "http://localhost/api-rest-tienda/src/create.php" \
  -u "usuario:contraseña" \
  -H "Content-Type: application/json" \
  -d '{ ... }' | jq
```

---

## 📊 Guardar Respuesta a Archivo

```bash
curl -X GET "http://localhost/api-rest-tienda/src/read.php?token=tu_token_secreto_aqui_2025" \
  -o response.json

cat response.json | jq
```

---

## 🔄 Script bash para Crear Múltiples Equipos

```bash
#!/bin/bash

# Script para crear múltiples equipos
TOKEN="tu_token_secreto_aqui_2025"
API_URL="http://localhost/api-rest-tienda/src/create.php"

# Array de equipos
declare -a serials=("SERIAL001" "SERIAL002" "SERIAL003")
declare -a nombres=("PC-ADMIN-001" "PC-ADMIN-002" "PC-ADMIN-003")

for i in "${!serials[@]}"; do
    echo "Creando equipo ${nombres[$i]}..."
    
    curl -X POST "$API_URL" \
      -H "Content-Type: application/json" \
      -d "{
        \"token\": \"$TOKEN\",
        \"serial_bios\": \"${serials[$i]}\",
        \"nombre_equipo\": \"${nombres[$i]}\",
        \"fecha_reporte\": \"$(date '+%Y-%m-%d %H:%M:%S')\",
        \"usuario\": \"admin\",
        \"procesador\": \"Intel Core i7\",
        \"nucleos\": 8,
        \"ram_total_gb\": 16.00
      }" | jq
    
    echo "---"
done
```

---

## 📋 Notas Importantes

1. **jq** es una herramienta para formatear JSON. Instálala:
   - Linux: `sudo apt-get install jq`
   - macOS: `brew install jq`
   - Windows: Descarga desde https://stedolan.github.io/jq/

2. **Token obligatorio** en todas las peticiones

3. **Content-Type:** `application/json`

4. **Timeouts:** Ajusta según necesidad
   ```bash
   curl -m 5 ...  # Timeout de 5 segundos
   ```

5. **Verbose mode** para debugging:
   ```bash
   curl -v ...
   ```
