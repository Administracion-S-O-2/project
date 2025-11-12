#!/bin/bash

echo "=== Test de Backup ==="
echo ""

# Variables
DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/root/project/backup/backup.log"
TEST_DIR="/root/project/backup/test"

# Crear directorio de log
mkdir -p "$(dirname "$LOG_FILE")"
touch "$LOG_FILE"

echo "1. Verificando permisos de escritura en log..."
if echo "Test $(date)" >> "$LOG_FILE"; then
    echo "   ✓ Log funciona correctamente"
else
    echo "   ✗ No se puede escribir en el log"
    exit 1
fi

echo ""
echo "2. Verificando MySQL..."
if systemctl is-active --quiet mysql; then
    echo "   ✓ MySQL está activo"
else
    echo "   ✗ MySQL NO está activo o no está instalado"
fi

echo ""
echo "3. Verificando directorio de MySQL..."
if [ -d "/var/lib/mysql" ]; then
    echo "   ✓ /var/lib/mysql existe"
    echo "   Archivos: $(ls -1 /var/lib/mysql | wc -l)"
else
    echo "   ✗ /var/lib/mysql NO existe"
fi

echo ""
echo "4. Verificando directorio de logs del sistema..."
if [ -d "/var/log/journal" ]; then
    echo "   ✓ /var/log/journal existe"
    echo "   Tamaño: $(du -sh /var/log/journal | cut -f1)"
else
    echo "   ✗ /var/log/journal NO existe"
fi

echo ""
echo "5. Probando rsync simple..."
mkdir -p "$TEST_DIR"
if rsync -av /etc/hostname "$TEST_DIR/" >> "$LOG_FILE" 2>&1; then
    echo "   ✓ rsync funciona correctamente"
    ls -lh "$TEST_DIR/hostname"
else
    echo "   ✗ rsync falló"
fi

echo ""
echo "6. Contenido del log:"
tail -20 "$LOG_FILE"
