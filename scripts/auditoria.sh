#!/bin/bash

menu(){
    clear
    echo "-- Menu auditoria -- "
    echo "1. Usuarios presentes en sistemas"
    echo "2. Actividad de usuarios presentes"
    echo "3. Ver totalidad de logs"
    echo "4. Ver mensajes criticos"
    echo "5. Ultimos accesos exitosos"
    echo "6. Ultimos accesos fallidos"
    echo "7. Ver servicios fallidos"
    echo "8. Ver errores del ultimo arranque"
    echo "9. Ver procesos activos"
    echo "10. Promedio de carga del sistema"
    echo "0. Salir"
}

opciones(){
    clear
    case $1 in
        1) usuarios_presentes ;;
        2) actividad_usuarios ;;
        3) logs ;;
        4) mensajes_criticos ;;
        5) accesos_exitosos ;;
        6) accesos_fallidos ;;
        7) servicios_fallidos ;;
        8) errores_ultimo_arranque ;;
        9) procesos_activos ;;
        10) promedio_carga_sistema ;;
        0) salir ;;
        *) echo "Opcion invalida" ;;

        if [ "$1" != "0" ]; then
            echo ""
            read -p "Presiona ENTER para volver al menu..."
        fi
    esac
}

usuarios_presentes(){
    who
}

actividad_usuarios(){
    w
}

logs(){
    journalctl --no-pager | tail -n 100
}

mensajes_criticos(){
    journalctl -p crit --no-pager | head -n 100
    # "scripts.sh" 91L, 1574B
}

accesos_exitosos(){
    echo "-- Ultimos accesos exitosos --"
    last
    echo "-- Ultimos accesos exitosos ssh"
    journalctl -u sshd | grep "Failed password"
}

accesos_fallidos(){
    echo "-- Ultimos accesos fallidos --"
    lastb
    echo "-- Ultimos accesos fallidos ssh"
    journalctl -u sshd | grep "Failed password"
}

servicios_fallidos(){
    systemctl --failed
}

errores_ultimo_arranque(){
    journalctl -b -p err
}

procesos_activos(){
    top
}

promedio_carga_sistema(){
    uptime
}

salir(){
    echo "Nos vemos, chau"
    exit 0
}

while true; do
    menu
    read -p "Ingrese una opcion del 0 al 10 " opcion
    opciones $opcion
done

