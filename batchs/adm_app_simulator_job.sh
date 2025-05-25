#!/bin/sh

DATE=$(date '+%Y-%m-%d-%H-%M-%S')

php /var/www/adm/batchs/adm_simulator_job.php $DATE >  /var/www/adm/log/adm_simulator_job-$DATE.log &

echo "to see log run : ";
echo "tail -f /var/www/adm/log/adm_simulator_job-$DATE.log ";