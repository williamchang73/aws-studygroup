aws-studygroup
==============

for aws study group


first week
==============
1. create instance
     - Ubuntu Server 13.04
     - register Elastic IPs
          - Allocate New Address
               - Associate with instance
          - Management Security Group
               - open 22, 80 port
     - login to ec2
          ssh -i ~/dev/aboutus.pem ubuntu@54.251.253.84


2. update ubuntu, install php, apache
     - switch to root
          - sudo bash
     - installation
          - apt-get update
          - apt-get dist-upgrade -y
          - apt-get install -y curl g++ make php5-cli php-pear php5-curl php5-mcrypt libcurl3 libcurl3-dev git apache2  libapache2-mod-php5
          - service apache2 restart
     - verify
          - http://54.251.253.84/


3. Build Service
     - mkdir ~/workspace
     - cd ~/workspace
     - check out example project
          - git clone https://github.com/williamchang73/aws-studygroup.git
          - cd aws-studygroup
          - mkdir img
          - chmod 777 img
     
     - vi /etc/apache2/sites-enabled/000-default (chnage document root and add one directory  )
               DocumentRoot /home/ubuntu/workspace/aws-studygroup
             <Directory />
                     Options FollowSymLinks
                     AllowOverride None
             </Directory>

             <Directory /home/ubuntu/workspace/aws-studygroup>
                     Options FollowSymLinks MultiViews
                     AllowOverride All
                     Order allow,deny
                     allow from all
             </Directory>
     - service apache2 restart
     - verify
          - http://54.251.253.84/
               - http://54.251.253.84/img/1368808994.jpg

4. Mount new EBS
     - df -h --> /dev/xvda1      7.8G  1.2G  6.3G  16%
     - go to AWS click Volumes , select the same zone with instance
          - select standard , 5GB
          - attachment volume
               - choice attach instance
     - go to instance terminal
          - mkfs.ext4 /dev/xvdf
          - mkdir /mnt2
          - mount /dev/xvdf /mnt2
          - verify
               - df -h
                    - /dev/xvdf       4.8G   10M  4.6G   1% /mnt2
     - make symbolic link
          mkdir /mnt2/images
          chmod 777 /mnt2/images
          rm -rf ~/workspace/aws-studygroup/img
          ln -s /mnt2/images ~/workspace/aws-studygroup/img
          ls -al ~/workspace/aws-studygroup/
               img -> /mnt2/images
     - verify          
          - http://54.251.253.84/
               - ls /mnt2/images/

Done !
