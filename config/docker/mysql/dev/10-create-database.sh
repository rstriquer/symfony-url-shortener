#!/usr/bin/env bash


echo "MySQL sh-10: #########################################################"

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE;
EOSQL

echo "MySQL sh-10: Done database creation"
echo "MySQL sh-10: #########################################################"
