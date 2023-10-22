#!/usr/bin/env bash


echo "MySQL sh-20: #########################################################"

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    GRANT ALL PRIVILEGES ON \`$MYSQL_DATABASE%\`.* TO '$MYSQL_USER'@'%'  IDENTIFIED BY '$MYSQL_PASSWORD';
EOSQL

echo "MySQL sh-20: Done user grant"
echo "MySQL sh-20: #########################################################"
