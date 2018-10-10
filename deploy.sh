#!/bin/bash
# shellcheck disable=SC2164
function usage() {
    echo "Usage: ./deploy.sh --user <db username> --host <db host> --database --root <web root to deploy> --path <deploy path>"
}

RED='\033[1;31m'
GREEN='\033[1;32m'
NC='\033[0m'
deployPath=""
deployRoot=""
dbUser=""
dbHost="localhost"
db=""
pw=""

while true; do
  if [[ $# -le 0 ]]; then
    break;
  fi
  case $1 in
    "--user")
      shift;
      dbUser=$1
    ;;
    "--db")
      shift;
      db=$1
    ;;
    "--host")
      shift;
      dbHost=$1
    ;;
    "--root")
      shift;
      deployRoot=$1
    ;;
    "--path")
      shift;
      deployPath=$1
    ;;
    "--")
      shift;
      break;
    ;;
    *)
      echo "Unable to process $1"
      usage
      exit 1
    ;;
  esac
  shift
done
echo -n "Password for mysql $dbUser@$dbHost> "
read -rs pw
echo
echo -n "Testing mysql connection..."
mysql "--host=$dbHost" "--database=$db" "--password=$pw" "--user=$dbUser" "--execute=select 1;" >/dev/null 2>/dev/null
testResult=$?
if [[ $testResult -ne 0 ]]; then
  echo -e "$RED FAILED $NC"
  echo "There was an error testing mysql connection!"
  exit 1
fi
echo -e "$GREEN OK $NC"
echo -n "Getting git repo..."
rm -rf /tmp/gamerwings
mkdir /tmp/gamerwings
fullPath="$deployRoot/$deployPath"
mkdir -p "$fullPath"
cd /tmp/gamerwings
git clone git@github.com:iso88592/gamerwings.git >/dev/null 2>/dev/null
testResult=$?
if [[ $testResult -ne 0 ]]; then
    echo -e "$RED FAILED $NC"
    echo "There was an error cloning the git repo!"
    exit 1
fi
cd gamerwings
git pull --rebase origin master >/dev/null 2>/dev/null
cp -r src/web/* "$fullPath/"
testResult=$?
if [[ $testResult -ne 0 ]]; then
    echo -e "$RED FAILED $NC"
    echo "There was an error copying the web page!"
    exit 1
fi

configFile="$fullPath/res/config/config.php"
touch "$configFile"
{
echo -e "<?php"
echo -e "\$servername = \"$dbHost\";"
echo -e "\$username = \"$dbUser\";"
echo -e "\$password = \"$pw\";"
echo -e "\$database = \"$db\";"
echo -e "?>"
} >"$configFile"
echo -e "$GREEN OK $NC"
