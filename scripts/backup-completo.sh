#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
destino_backup_bd="/home/root/backup/monthly/BD"
origen_backup_bd="/var/lib/mysql/CoopHogar"
origen_dir_logs="/var/log/journal"
destino_backup_logs="/home/root/backup/monthly/logs"
LOG_FILE="/home/root/backup/backup.log"

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

    if cp -r "$origen_backup_bd" "$backup_dir_bd"; then
        echo "$(date): Backup completo BD exitoso en $backup_dir_bd" >> "$LOG_FILE"
        return 0
    else
        echo "$(date): Backup completo BD fallido" >> "$LOG_FILE"
        return 1
    fi
}

Backup_logs() {
    backup_dir_logs="$destino_backup_logs/$DATE"
    mkdir -p "$backup_dir_logs"

    if cp -r "$origen_dir_logs" "$backup_dir_logs"; then
        echo "$(date): Backup completo de logs exitoso en $backup_dir_logs" >> "$LOG_FILE"
        return 0
    else
        echo "$(date): Backup completo logs fallido" >> "$LOG_FILE"
        return 1
    fi
}


If mysqlEstaActivo() then
systemctl stop mysql
Backup_bd
Backup_logs 
systemctl start mysql
else
Backup_bd
Backup_logs 
fi

echo "Backup incremental realizado el $DATE" >> "$LOG_FILE

