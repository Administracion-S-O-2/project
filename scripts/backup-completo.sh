#!/bin/bash

DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/root/project/backup/backup.log"

mkdir -p "$(dirname "$LOG_FILE")"

log_msg() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" | tee -a "$LOG_FILE"
}

log_msg "========================================="
log_msg "Iniciando backup COMPLETO"
log_msg "========================================="

mysqlEstaActivo() {
    systemctl is-active --quiet mysqld 2>/dev/null
}

Backup_bd_completo(){
    local destino="/root/project/backup/weekly/BD/$DATE"
    mkdir -p "$destino"
    
    log_msg "Respaldando MySQL completo..."
    
    if rsync -av /var/lib/mysql/ "$destino/" 2>&1 | tee -a "$LOG_FILE" | tail -5; then
        local size=$(du -sh "$destino" 2>/dev/null | cut -f1)
        log_msg "✓ Backup BD completo exitoso - Tamaño: $size"
        return 0
    else
        log_msg "✗ Backup BD completo fallido"
        return 1
    fi
}

Backup_logs_completo() {
    local destino="/root/project/backup/weekly/logs/$DATE"
    mkdir -p "$destino"
    
    log_msg "Respaldando logs completo..."
    
    if rsync -av /var/log/journal/ "$destino/" 2>&1 | tee -a "$LOG_FILE" | tail -5; then
        local size=$(du -sh "$destino" 2>/dev/null | cut -f1)
        log_msg "✓ Backup logs completo exitoso - Tamaño: $size"
        return 0
    else
        log_msg "✗ Backup logs completo fallido"
        return 1
    fi
}

if mysqlEstaActivo; then
    log_msg "MySQL activo - Deteniendo servicio..."
    systemctl stop mysqld
    sleep 2
    
    Backup_bd_completo
    Backup_logs_completo
    
    log_msg "Reiniciando MySQL..."
    systemctl start mysqld
    sleep 2
    log_msg "✓ MySQL reiniciado"
else
    Backup_bd_completo
    Backup_logs_completo
fi

log_msg "========================================="
log_msg "Backup COMPLETO completado"
log_msg ""
