#!/bin/bash

DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/root/project/backup/backup.log"

mkdir -p "$(dirname "$LOG_FILE")"

log_msg() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

log_msg "========================================="
log_msg "Iniciando backup incremental"
log_msg "========================================="

mysqlEstaActivo() {
    if systemctl is-active --quiet mysqld 2>/dev/null; then
        return 0
    else
        return 1
    fi
}

Backup_bd_local(){
    local origen="/var/lib/mysql"
    local destino="/root/project/backup/daily/BD/$DATE"
    
    if [ ! -d "$origen" ]; then
        log_msg "ERROR: $origen no existe"
        return 1
    fi
    
    mkdir -p "$destino"
    log_msg "Respaldando MySQL de $origen a $destino..."
    
    # Usar rsync y mostrar progreso
    if rsync -av --delete "$origen/" "$destino/" 2>&1 | tee -a "$LOG_FILE" | tail -5; then
        local size=$(du -sh "$destino" 2>/dev/null | cut -f1)
        log_msg "✓ Backup BD exitoso - Tamaño: $size"
        return 0
    else
        log_msg "✗ Backup BD fallido"
        return 1
    fi
}

Backup_logs() {
    local origen="/var/log/journal"
    local destino="/root/project/backup/daily/logs/$DATE"
    
    if [ ! -d "$origen" ]; then
        log_msg "ERROR: $origen no existe"
        return 1
    fi
    
    mkdir -p "$destino"
    log_msg "Respaldando logs de $origen a $destino..."
    
    if rsync -av --delete "$origen/" "$destino/" 2>&1 | tee -a "$LOG_FILE" | tail -5; then
        local size=$(du -sh "$destino" 2>/dev/null | cut -f1)
        log_msg "✓ Backup logs exitoso - Tamaño: $size"
        return 0
    else
        log_msg "✗ Backup logs fallido"
        return 1
    fi
}

if mysqlEstaActivo; then
    log_msg "MySQL está activo - Deteniendo servicio..."
    systemctl stop mysqld
    sleep 2
    
    Backup_bd_local
    Backup_logs
    
    log_msg "Reiniciando MySQL..."
    systemctl start mysqld
    sleep 2
    
    if systemctl is-active --quiet mysqld; then
        log_msg "✓ MySQL reiniciado correctamente"
    else
        log_msg "✗ ERROR: MySQL no se pudo reiniciar"
    fi
else
    log_msg "MySQL no está activo - Procediendo sin detener servicio"
    Backup_bd_local
    Backup_logs
fi

log_msg "========================================="
log_msg "Resumen de backups:"
du -sh /root/project/backup/daily/* 2>/dev/null | tee -a "$LOG_FILE"
log_msg "========================================="
log_msg "Backup incremental completado"
log_msg ""

