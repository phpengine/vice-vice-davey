sudo mkdir -p /var/lib/jenkins/jobs/capgemini_tests
sudo cp /var/www/drupal-hello/build/config/jenkins/config.xml /var/lib/jenkins/jobs/capgemini_tests/config.xml
sudo chmod -R 755 /var/lib/jenkins/jobs/capgemini_tests
sudo chown -R jenkins /var/lib/jenkins/jobs/capgemini_tests
sudo chgrp -R jenkins /var/lib/jenkins/jobs/capgemini_tests