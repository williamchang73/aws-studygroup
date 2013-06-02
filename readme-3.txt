1. create RDS
    - select mysql
    - database name studygroup
    - t1 micro
    - monitor version upgrade -> no
    - set up storeage : 5GB
    - account and password : studygroup / XXX
    - no backup
    
2. set up security group
	- create a new security name : studygroup
	- edit
	- connect to your ec2 security group
	- add CIDR/IP : 0.0.0.0/0 ( for all )
	- go to EC2 settings
		- add 3306 port for ec2 security group
	- the setting should like 
		- http://54.251.253.84/rds_sg_setting.png
	- check RDS instance status

3. create table
	- ssh your ec2, sudo bash ( to root )
	- cd ~/workspace/aws-studygroup
	- git pull .
	- change your config file 
	- set your host, password
		- define("AWS_RDS_HOST", "");
			- check the endpint on RDS instance at AWS webconsole
		- define("AWS_RDS_PASS", "XXX");
	-  create db command
		- php db_create_table.php
	- verify
		- Table created successfully

4. start testing
	- check code

Done !
