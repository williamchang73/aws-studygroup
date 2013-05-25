1. create S3instance
    - https://console.aws.amazon.com/s3/home (same region)
    - create bucket
    	- aws-group
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
	- get key and Secret
		- https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials
		- click Access keys and Show


Done !
