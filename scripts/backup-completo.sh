#!/bin/bash

origen_backup_bd="/var/lib/mysql"
destino_backup_bd="/home/root/project/backup/daily/BD"

origen_dir_logs="/var/log/journal"
destino_backup_logs="/home/root/project/backup/daily/logs"

DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/home/root/project/backup/backup.log"

mysqlEstaActivo() {
    if systemctl is-active --quiet mysql; then
        return 0
    else
        return 1
    fi
}

Backup_bd() {
    Backup_bd_local
    Backup_bd_remoto
}

Backup_bd_local(){
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

Backup_bd_remoto(){

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

echo "Backup INCREMENTAL realizado el $DATE" >> "$LOG_FILE"

