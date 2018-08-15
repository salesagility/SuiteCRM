
# postfix
sudo apt-get update -qq
sudo apt-get install -y -qq postfix

# dovecot
sudo apt-get -qq -y install dovecot-imapd
sudo touch /etc/dovecot/local.conf
sudo echo 'mail_location = maildir:/home/%u/Maildir' >> /etc/dovecot/local.conf
sudo echo 'disable_plaintext_auth = no' >> /etc/dovecot/local.conf
sudo echo 'mail_max_userip_connections = 10000' >> /etc/dovecot/local.conf
sudo restart dovecot

# creating test user
sudo useradd testuser -m -s /bin/bash
echo "testuser:chilisauce" | sudo chpasswd

# setup email
sudo stop dovecot
[ -d "/home/testuser/Maildir" ] && sudo rm -R /home/testuser/Maildir
sudo cp -Rp /resources/Maildir /home/testuser/
sudo chown -R testuser:testuser /home/testuser/Maildir
sudo start dovecot

# TODO: dovecot SSL?