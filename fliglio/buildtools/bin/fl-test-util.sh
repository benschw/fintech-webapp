#!/bin/bash

# wipe out all unit test databases
# ssh ben@deployer.bvidev.com "mysql -h mysqlmaster-phpunit.bvops.net -u bens -pchangeme -e\"SHOW DATABASES;\"" | grep "^UnitTest" | xargs -I "@@" ssh ben@deployer.bvidev.com "mysql -h mysqlmaster-phpunit.bvops.net -u bens -pchangeme -e\"DROP DATABASE @@;\""

# Local Wipe all unit test databases
# mysql -u bens -pchangeme -e "SHOW DATABASES;" | grep "^UnitTest" | xargs -I "@@" mysql -u bens -pchangeme -e "DROP DATABASE @@;"

function get_tmp_path() {
	 echo $(mktemp -d -t fl_unit_testingXXXXXXX)
}

function get_db_ns() {
	echo "UnitTest_"$RANDOM"_"
}

function drop_all_test_databases() {
	MYSQL_LOGIN=$1
	MYSQL_PASS=$2
	SCHEMA_PATH=$3
	DB_NS=$4
	DB=$5
	DB_SERVER='127.0.0.1' # params not working for this command...

	mysql -h $DB_SERVER -u $MYSQL_LOGIN -p$MYSQL_PASS -e "SHOW DATABASES;" | grep "^UnitTest" | xargs -I "@@" mysql -h $DB_SERVER -u $MYSQL_LOGIN -p$MYSQL_PASS -e "DROP DATABASE @@;"
}

function export_database() {
	MYSQL_LOGIN=$1
	MYSQL_PASS=$2
	SCHEMA_PATH=$3
	DB_NS=$4
	DB=$5
	DB_SERVER=$6

	echo "DROP DATABASE IF EXISTS ${DB_NS}${DB};" > $SCHEMA_PATH/${DB_NS}${DB}
	echo "CREATE DATABASE ${DB_NS}${DB};" >> $SCHEMA_PATH/${DB_NS}${DB}
	echo "GRANT SELECT, INSERT, UPDATE ON ${DB_NS}${DB}.* TO 'devFirstBase';" >> $SCHEMA_PATH/${DB_NS}${DB}
	echo "USE ${DB_NS}${DB};" >> $SCHEMA_PATH/${DB_NS}${DB}

	mysqldump --no-data --tables -h $DB_SERVER -u $MYSQL_LOGIN -p$MYSQL_PASS $DB >> ${SCHEMA_PATH}/${DB_NS}${DB}
}

function import_database() {
	MYSQL_LOGIN=$1
	MYSQL_PASS=$2
	SCHEMA_PATH=$3
	DB_NS=$4
	DB=$5
	DB_SERVER=$6
	
	mysql -h $DB_SERVER -u $MYSQL_LOGIN -p$MYSQL_PASS < $SCHEMA_PATH/${DB_NS}${DB}
}

function drop_database() {
	MYSQL_LOGIN=$1
	MYSQL_PASS=$2
	SCHEMA_PATH=$3
	DB_NS=$4
	DB=$5
	DB_SERVER=$6
	
	mysql -h $DB_SERVER -u $MYSQL_LOGIN -p$MYSQL_PASS -e 'DROP DATABASE IF EXISTS '$DB_NS$DB
	# Truncate tables instead - failing due to stupid foreign key constraints
	# mysql -h $DB_SERVER -u $MYSQL_LOGIN -p$MYSQL_PASS -Nse "USE $DB_NS$DB; SHOW TABLES;" | while read table; do mysql -h $DB_SERVER -u $MYSQL_LOGIN -p$MYSQL_PASS -e "USE $DB_NS$DB; TRUNCATE TABLE $table;"; done
}

function import_data() {
	MYSQL_LOGIN=$1
	MYSQL_PASS=$2
	DB=$3
	DATA_PATH=$4
	DB_SERVER=$5
	
	mysql -h $DB_SERVER -u $MYSQL_LOGIN -p$MYSQL_PASS $DB < $4
}

usage() {
	echo "Usage: `basename $0` <action>"
	echo
	echo "  export-database"
	echo "  import-database"
	echo "  drop-database"
	echo "  drop-all-test-databases"
	echo
	echo "ex: `basename $0` cache-pages"
}


function setup() {
	echo "Please fill in the following to continue."

	echo "MySQL login on mysqlmaster-phpunittest.bvops.net:"
	read MYSQL_LOGIN
	echo "MYSQL_LOGIN='"$MYSQL_LOGIN"'" >> ~/.fl-test-config.cfg

	echo "MySQL password on mysqlmaster-phpunittest.bvops.net:"
	read MYSQL_PASS
	echo "MYSQL_PASS='"$MYSQL_PASS"'" >> ~/.fl-test-config.cfg
}

if [ "$1" == 'setup' ]; then
	setup
fi

if [ ! -f ~/.fl-test-config.cfg ]; then
	setup
fi

. ~/.fl-test-config.cfg

if [ "$MYSQL_LOGIN" == "" ]; then
	echo "Please run \"$0 setup\" to set up before using"
	exit 1
fi


SCHEMA_PATH=$2
DB_NS=$3
DB=$4
DB_SERVER=$5

case $1 in
	get-tmp-path) get_tmp_path;;

	get-db-ns) get_db_ns;;

	export-database) export_database $MYSQL_LOGIN $MYSQL_PASS $SCHEMA_PATH $DB_NS $DB $DB_SERVER;;

	import-database) import_database $MYSQL_LOGIN $MYSQL_PASS $SCHEMA_PATH $DB_NS $DB $DB_SERVER;;

	drop-database) drop_database $MYSQL_LOGIN $MYSQL_PASS $SCHEMA_PATH $DB_NS $DB $DB_SERVER;;

	drop-all-test-databases) drop_all_test_databases $MYSQL_LOGIN $MYSQL_PASS $SCHEMA_PATH $DB_NS $DB $DB_SERVER;;

	import-data) import_data $MYSQL_LOGIN $MYSQL_PASS $2 $3 $4;;

	setup) ;;
	*)
		usage
		exit 1
	;;
esac

