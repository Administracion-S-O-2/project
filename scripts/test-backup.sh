#!/bin/bash

LOG_FILE="/root/project/backup/backup.log"
mkdir -p "$(dirname "$LOG_FILE")"

echo "=== Test de Backup ===" | tee -a "$LOG_FILE"
echo "" | tee -a "$LOG_FILE"

echo "1. Verificando permisos de escritura en log..." | tee -a "$LOG_FILE"
if echo "Test $(date)" >> "$LOG_FILE" 2>&1; then
    echo "   ✓ Log funciona correctamente" | tee -a "$LOG_FILE"
    echo "   Ubicación: $LOG_FILE" | tee -a "$LOG_FILE"
else
    echo "   ✗ No se puede escribir en el log"
    exit 1
fi

echo "" | tee -a "$LOG_FILE"
echo "2. Verificando MySQL/MariaDB..." | tee -a "$LOG_FILE"
if systemctl is-active --quiet mysqld 2>/dev/null; then
    echo "   ✓ mysqld está activo" | tee -a "$LOG_FILE"
    MYSQL_RUNNING=true
elif systemctl is-active --quiet mysql 2>/dev/null; then
    echo "   ✓ mysql está activo" | tee -a "$LOG_FILE"
    MYSQL_RUNNING=true
else
    echo "   ✗ MySQL NO está activo o no está instalado" | tee -a "$LOG_FILE"
    MYSQL_RUNNING=false
fi

echo "" | tee -a "$LOG_FILE"
echo "3. Verificando directorio de MySQL..." | tee -a "$LOG_FILE"
if [ -d "/var/lib/mysql" ]; then
    FILES=$(ls -1 /var/lib/mysql 2>/dev/null | wc -l)
    SIZE=$(du -sh /var/lib/mysql 2>/dev/null | cut -f1)
    echo "   ✓ /var/lib/mysql existe" | tee -a "$LOG_FILE"
    echo "   Archivos: $FILES" | tee -a "$LOG_FILE"
    echo "   Tamaño: $SIZE" | tee -a "$LOG_FILE"
else
    echo "   ✗ /var/lib/mysql NO existe" | tee -a "$LOG_FILE"
fi

echo "" | tee -a "$LOG_FILE"
echo "4. Verificando directorio de logs del sistema..." | tee -a "$LOG_FILE"
if [ -d "/var/log/journal" ]; then
    SIZE=$(du -sh /var/log/journal 2>/dev/null | cut -f1)
    echo "   ✓ /var/log/journal existe" | tee -a "$LOG_FILE"
    echo "   Tamaño: $SIZE" | tee -a "$LOG_FILE"
else
    echo "   ✗ /var/log/journal NO existe" | tee -a "$LOG_FILE"
fi

echo "" | tee -a "$LOG_FILE"
echo "5. Probando rsync simple..." | tee -a "$LOG_FILE"
TEST_DIR="/root/project/backup/test"
mkdir -p "$TEST_DIR"

if rsync -av /etc/hostname "$TEST_DIR/" >> "$LOG_FILE" 2>&1; then
    echo "   ✓ rsync funciona correctamente" | tee -a "$LOG_FILE"
    if [ -f "$TEST_DIR/hostname" ]; then
        echo "   ✓ Archivo copiado: $(ls -lh $TEST_DIR/hostname | awk '{print $5}')" | tee -a "$LOG_FILE"
    fi
else
    echo "   ✗ rsync falló" | tee -a "$LOG_FILE"
fi

echo "" | tee -a "$LOG_FILE"
echo "6. Estructura de directorios de backup:" | tee -a "$LOG_FILE"
tree -L 2 /root/project/backup/ 2>/dev/null | tee -a "$LOG_FILE" || find /root/project/backup/ -type d | head -20 | tee -a "$LOG_FILE"

echo "" | tee -a "$LOG_FILE"
echo "7. Últimas 10 líneas del log:" | tee -a "$LOG_FILE"
tail -10 "$LOG_FILE"

echo "" | tee -a "$LOG_FILE"
echo "=== Test completado ===" | tee -a "$LOG_FILE"
echo ""
echo "6. Contenido del log:"
tail -20 "$LOG_FILE"
