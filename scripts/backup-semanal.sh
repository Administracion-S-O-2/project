#!/bin/bash
BACKUP_DIR_BD="/home/root/backup/semanal/BD"
BACKUP_DIR_LOGS="/home/root/backup/semanal/logs"
LOG_DIR="/var/log/remote"
DB_NAME="CoopHogar"
LOG_FILE="/home/root/backup/backup.log"
DATE=$(date +%Y%m%d_%H%M%S)

# Backup de la base de datos
mysqldump --defaults-file=~/.my.cnf --single-transaction --routines --triggers $DB_NAME | gzip > $BACKUP_DIR_BD/backup_semanal_$DATE.sql.gz

# Eliminar backups de base de datos antiguos (más de 28 días = 4 semanas)
find $BACKUP_DIR_BD -name "*.sql.gz" -mtime +28 -delete

# Backup de logs: copiar logs rotados comprimidos de los últimos 7 días
find $LOG_DIR -name "*.log.*.gz" -mtime -7 -exec cp {} $BACKUP_DIR_LOGS/ \;

# Limpiar logs de backup antiguos (más de 28 días = 4 semanas)
find $BACKUP_DIR_LOGS -name "*.gz" -mtime +28 -delete

