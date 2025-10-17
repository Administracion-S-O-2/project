#!/bin/bash

destino_backup_bd="/home/root/backup/daily/BD"
origen_backup_bd="/var/lib/mysql/CoopHogar"
origen_dir_logs="/var/log/journal"
destino_backup_logs="/home/root/backup/daily/logs"
DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/home/root/backup/backup.log"
Backup_exitoso=0

mysqlEstaActivo() {
    if systemctl is-active --quiet mysql; then
        return 0
    else
        return 1
    fi
}

Backup_bd() {
    backup_dir_bd="$destino_backup_bd/$DATE"
    mkdir -p "$backup_dir_bd"
    
    if rsync -av --delete "$origen_backup_bd/" "$backup_dir_bd" >> "$LOG_FILE" 2>&1; then
        echo "$(date): Backup incremental BD exitoso en $backup_dir_bd" >> "$LOG_FILE"
        return 0
    else
        echo "$(date): Backup incremental BD fallido" >> "$LOG_FILE"
        return 1
    fi
}

Backup_logs() {
    backup_dir_logs="$destino_backup_logs/$DATE"
    mkdir -p "$backup_dir_logs"
    
    if rsync -av --delete "$origen_dir_logs/" "$backup_dir_logs" >> "$LOG_FILE" 2>&1; then
        echo "$(date): Backup incremental logs exitoso en $backup_dir_logs" >> "$LOG_FILE"
        return 0
    else
        echo "$(date): Backup incremental logs fallido" >> "$LOG_FILE"
        return 1
    fi
}

if mysqlEstaActivo; then
    systemctl stop mysql
    Backup_bd
    Backup_logs
    systemctl start mysql
else
    Backup_bd
    Backup_logs
fi

echo "$(date): Backup incremental realizado el $DATE" >> "$LOG_FILE"

