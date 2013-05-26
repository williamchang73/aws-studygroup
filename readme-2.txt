1. create S3instance
    - https://console.aws.amazon.com/s3/home (same region)
    - create bucket
    	- aws-study-group (already registered by me, name yours)
    - create folder
        - name : images
        - right click : make public

2. set up cloud front
	- create distribute
		- https://console.aws.amazon.com/cloudfront/home
		- select the s3 bucket
		- copy the domain
	- verify
		- d1qjbwzye6rcb4.cloudfront.net (something like this)


3. integrate with aws-php-sdk
	- get your key and Secret
		- https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials
		- click Access keys and Show
		- copy the key and secert
	- update project
		- ssh to ec2
		- sudo bash (change to root)
		- cd ~/workspace/aws-studygroup/
		- git pull
	- set up your variables
		- vi config.php
			- define("AWS_KEY", "xxx");
			- define("AWS_SECERT", "xxx");
			- define("AWS_S3_DOMAIN", "xxx.s3-ap-southeast-1.amazonaws.com");
			- define("AWS_CLOUDFRONT_DOMAIN", "xxx");
			- define("AWS_S3_BUCKET", "xxx");
			- save file
	- verify
		- go to http://54.251.253.84/ upload images
		- check urls
			- s3 url, and cloud-front (CDN) url
		- go to https://console.aws.amazon.com/s3/home
			- check file exitst in S3

Done !
