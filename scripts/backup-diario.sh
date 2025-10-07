#!/bin/bash
BACKUP_DIR_BD="/home/root/backup/daily/BD"
BACKUP_DIR_LOGS="/home/root/backup/daily/logs"
LOG_DIR="/var/log/remote"
DB_NAME="CoopHogar"
DATE=$(date +%Y%m%d_%H%M%S)

# Backup de la base de datos
mysqldump --defaults-file=~/.my.cnf --single-transaction --routines --triggers $DB_NAME | gzip > $BACKUP_DIR_BD/backup_$DATE.sql.gz

# Eliminar backups de base de datos antiguos 
find $BACKUP_DIR_BD -name "*.sql.gz" -mtime +7 -delete

#backup logs
find $LOG_DIR -name "*.log.*.gz" -mtime -7 -exec cp {} $BACKUP_DIR_LOGS / \;
# Limpiar logs de backup antiguos (más de 7 días)
find $BACKUP_DIR_LOGS -name "*.gz" -mtime +7 -delete

