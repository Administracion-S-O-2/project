#!/bin/bash
BACKUP_DIR_BD="/home/root/backup/mensual/BD"
BACKUP_DIR_LOGS="/home/root/backup/mensual/logs"
LOG_DIR="/var/log/remote"
DB_NAME="CoopHogar"
DATE=$(date +%Y%m%d_%H%M%S)
LOG_FILE="/home/root/backup/backup.log"

# Backup de la base de datos
mysqldump --defaults-file=~/.my.cnf --single-transaction --routines --triggers $DB_NAME | gzip > $BACKUP_DIR_BD/backup_mensual_$DATE.sql.gz

# Eliminar backups de base de datos antiguos (más de 365 días = 12 meses)
find $BACKUP_DIR_BD -name "*.sql.gz" -mtime +365 -delete

# Backup de logs: copiar logs rotados comprimidos de los últimos 30 días
find $LOG_DIR -name "*.log.*.gz" -mtime -30 -exec cp {} $BACKUP_DIR_LOGS/ \;

# Limpiar logs de backup antiguos (más de 365 días = 12 meses)
find $BACKUP_DIR_LOGS -name "*.gz" -mtime +365 -delete

