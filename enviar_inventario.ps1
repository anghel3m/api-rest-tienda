
# Script PowerShell para enviar información de inventario a la API
# Uso: PowerShell -ExecutionPolicy Bypass -File script.ps1

# ============================================
# CONFIGURACIÓN
# ============================================
$APIUrl = "http://localhost/api-rest-tienda/src/create.php"
$APIToken = "tu_token_secreto_aqui_2025"  # CAMBIA ESTE VALOR

# ============================================
# OBTENER INFORMACIÓN DEL SISTEMA
# ============================================
Write-Host "📊 Recopilando información del sistema..." -ForegroundColor Cyan

# Información general
$computerInfo = Get-WmiObject Win32_ComputerSystem
$osInfo = Get-WmiObject Win32_OperatingSystem
$cpuInfo = Get-WmiObject Win32_Processor
$bios = Get-WmiObject Win32_BIOS

# Información de disco
$diskInfo = Get-WmiObject Win32_LogicalDisk -Filter "DeviceName='C:'"

# Información de RAM
$ramGB = [math]::Round($computerInfo.TotalPhysicalMemory / 1GB, 2)

# Último arranque
$bootTime = [management.managementdatetimeconverter]::ConvertFromDmtfDateTime((Get-WmiObject Win32_OperatingSystem).LastBootUpTime)

# Información de usuario
$usuario = $env:USERNAME
$dominio = $env:USERDOMAIN

# Versión de Windows
$osVersion = $osInfo.Version
$osCaption = $osInfo.Caption

# ============================================
# PREPARAR DATOS JSON
# ============================================
$payload = @{
    token = $APIToken
    nombre_responsable = "$dominio\$usuario"
    id_responsable = $usuario
    nombre_equipo = $computerInfo.Name
    usuario = $usuario
    sistema_operativo = $osCaption
    version_windows = $osVersion
    modelo = $computerInfo.Model
    marca = $computerInfo.Manufacturer
    serial_bios = $bios.SerialNumber
    uuid_equipo = $computerInfo.SystemFamily
    procesador = $cpuInfo.Name
    nucleos = $cpuInfo.NumberOfCores
    ram_total_gb = $ramGB
    disco_total_gb = [math]::Round($diskInfo.Size / 1GB, 2)
    tipo_disco = "SSD"
    fecha_reporte = (Get-Date -Format "yyyy-MM-dd HH:mm:ss")
    ultimo_arranque = $bootTime.ToString("yyyy-MM-dd HH:mm:ss")
} | ConvertTo-Json

# ============================================
# MOSTRAR INFORMACIÓN (DEBUG)
# ============================================
Write-Host "`n📋 Información a enviar:" -ForegroundColor Yellow
$payload | ConvertFrom-Json | Format-Table -AutoSize

# ============================================
# ENVIAR A LA API
# ============================================
Write-Host "`n📡 Enviando datos a la API..." -ForegroundColor Cyan

try {
    $response = Invoke-WebRequest `
        -Uri $APIUrl `
        -Method Post `
        -Body $payload `
        -ContentType "application/json" `
        -ErrorAction Stop

    $responseData = $response.Content | ConvertFrom-Json

    if ($responseData.exito) {
        Write-Host "`n✅ ÉXITO" -ForegroundColor Green
        Write-Host "Mensaje: $($responseData.mensaje)" -ForegroundColor Green
        Write-Host "Serial BIOS: $($responseData.datos.serial_bios)" -ForegroundColor Green
        Write-Host "Acción: $($responseData.datos.accion)" -ForegroundColor Green
    } else {
        Write-Host "`n❌ ERROR EN RESPUESTA" -ForegroundColor Red
        Write-Host "Mensaje: $($responseData.mensaje)" -ForegroundColor Red
        Write-Host "Código: $($responseData.codigo)" -ForegroundColor Red
    }

} catch {
    Write-Host "`n❌ ERROR EN LA SOLICITUD" -ForegroundColor Red
    Write-Host "Error: $_" -ForegroundColor Red
    Write-Host "StatusCode: $($_.Exception.Response.StatusCode)" -ForegroundColor Red
    
    # Intentar leer el cuerpo del error
    try {
        $errorResponse = $_.Exception.Response.GetResponseStream()
        $reader = New-Object System.IO.StreamReader($errorResponse)
        $errorBody = $reader.ReadToEnd()
        Write-Host "Response Body: $errorBody" -ForegroundColor Red
    } catch { }
}

Write-Host "`n✔️  Proceso completado." -ForegroundColor Cyan
