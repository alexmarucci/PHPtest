#!/bin/sh

FILE="/etc/cron.daily/importDailyTransaction"
sudo touch $FILE;

/bin/cat <<EOM | sudo tee $FILE > /dev/null
#!/bin/sh

php $PWD/bin/console transactions:import-csv
EOM

sudo chmod +x $FILE

if [ ! -f $FILE ]; then
    echo "Unable to write " $FILE
else
    echo "Command has been added successfully to the crontasks.\nLocation: "$FILE
fi