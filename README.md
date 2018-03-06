# lsapi-issue-2018-03

* __send-request-to-lsapi.php__ - run from the command line to simulate a request to litespeed PHP that triggers the issue
  * Contains instructions that reproduces the issue
* __index.php__ - Belongs at /usr/local/lsws/Example/html/index.php (a simple form that uses `file_get_contents('php://input');`)
* Three strace files:
  * __strace-1-original-litespeed-request.txt__ - captured using index.php on a litespeed installation
  * __strace-2-normal-duplicated-request.txt__ - captured a request using __send-request-to-lsapi.php__, confirming that it works
  * __strace-3-bad-truncated-request.txt__ - captured using __send-request-to-lsapi.php__, with the POST body removed, which causes the excessive writing to tmp files
  
