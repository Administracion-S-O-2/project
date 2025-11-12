#!/bin/bash

DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/root/project/backup/backup.log"

mkdir -p "$(dirname "$LOG_FILE")"

log_msg() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

log_msg "========================================="
log_msg "Iniciando backup DIFERENCIAL"
log_msg "========================================="

mysqlEstaActivo() {
    systemctl is-active --quiet mysqld 2>/dev/null
}

Backup_bd_diferencial() {
    local destino="/root/project/backup/monthly/BD/$DATE"
    mkdir -p "$destino"
    
    log_msg "Respaldando MySQL diferencial..."
    
    if rsync -av --delete /var/lib/mysql/ "$destino/" 2>&1 | tee -a "$LOG_FILE" | tail -5; then
        local size=$(du -sh "$destino" 2>/dev/null | cut -f1)
        log_msg "✓ Backup BD diferencial exitoso - Tamaño: $size"
        return 0
    else
        log_msg "✗ Backup BD diferencial fallido"
        return 1
    fi
}

Backup_logs_diferencial() {
    local destino="/root/project/backup/monthly/logs/$DATE"
    mkdir -p "$destino"
    
    log_msg "Respaldando logs diferencial..."
    
    if rsync -av --delete /var/log/journal/ "$destino/" 2>&1 | tee -a "$LOG_FILE" | tail -5; then
        local size=$(du -sh "$destino" 2>/dev/null | cut -f1)
        log_msg "✓ Backup logs diferencial exitoso - Tamaño: $size"
        return 0
    else
        log_msg "✗ Backup logs diferencial fallido"
        return 1
    fi
}

if mysqlEstaActivo; then
    log_msg "MySQL activo - Deteniendo servicio..."
    systemctl stop mysqld
    sleep 2
    
    Backup_bd_diferencial
    Backup_logs_diferencial
    
    log_msg "Reiniciando MySQL..."
    systemctl start mysqld
    sleep 2
    log_msg "✓ MySQL reiniciado"
else
    Backup_bd_diferencial
    Backup_logs_diferencial
fi

log_msg "========================================="
log_msg "Backup DIFERENCIAL completado"
log_msg ""
