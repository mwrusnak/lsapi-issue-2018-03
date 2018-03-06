<?php

/******************************************************************************
This file simulates an issue with mod_lsapi, where the connection between the
web server and lsphp breaks, causing a broken pipe when PHP tries to read the
POST body.

This file depends on having a file at /usr/local/lsws/Example/html/index.php
that reads php://input for lsphp to use. (See index.php)

To reproduce the issue:
1. Run PHP in sapi/litespeed/ with:
   strace -s 8192 ./sapi/litespeed/php -b 127.0.0.1:8877 2>&1 | tee output.txt

2. Edit this file -- uncomment the first $lsapi_command to run a "normal" request, or
   uncomment the second one to run the truncated request (missing the POST body)

3. Run this script

4. If using the truncated request, kill this script when it hangs (simulating
   the broken pipe)

5. Note in the strace output that it is continually writing to a temp file,
   but there should be no data to write. Sometimes this may take a few seconds,
   while other times, it may run for minutes, making arbitrarily large temp
   files and must be killed.

******************************************************************************/

// This lsapi request was copied from "strace" during a valid lsapi request
//$lsapi_command = "LS\1\0W\4\0\0\277\1\0\0\26\0\0\0D\1\0\0\215\1\0\0|\1\0\0\346\1\0\0\1\0\0\0\17\0\0\0\0\0\0\0\0\0\0\0\0\16\0\35DOCUMENT_ROOT\0/usr/local/lsws/Example/html\0\0\f\0\16REMOTE_ADDR\000192.168.10.18\0\0\f\0\6REMOTE_PORT\00044854\0\0\f\0\16SERVER_ADDR\000192.168.10.18\0\0\f\0\tSERVER_NAME\0wp16.dev\0\0\f\0\5SERVER_PORT\0008088\0\0\f\0\vREQUEST_URI\0/index.php\0\0\r\0\25LSWS_EDITION\0Openlitespeed 1.4.27\0\0\n\0\2X-LSCACHE\0001\0\0\20\0'SCRIPT_FILENAME\0/usr/local/lsws/Example/html/index.php\0\0\r\0\1QUERY_STRING\0\0\0\f\0\vSCRIPT_NAME\0/index.php\0\0\20\0\tSERVER_PROTOCOL\0HTTP/1.1\0\0\20\0\nSERVER_SOFTWARE\0LiteSpeed\0\0\17\0\5REQUEST_METHOD\0POST\0\0\0\0\0\0?\0\0\0\0\0\16\0\0\0\5\0!\0\2\0\35\0\0\0\r\0\0\0\36\0L\0\t\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\225\0\0\0\0\0\0\0\0\0\0\0\347\0\0\0\0\0\0\0\230\1\0\0.\1\0\0a\1\0\0m\1\0\0\0\0\0\0$\0\0\0\0\0\0\0\0\1\0\0?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\237\1\0\0\31\0\0\0\272\1\0\0\1\0\0\0\0\0\0\0POST /index.php HTTP/1.1\r\nHost: wp16.dev:8088\r\nUser-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0\r\nAccept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\nAccept-Language: en-US,en;q=0.5\r\nReferer: http://wp16.dev:8088/index.php\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 22\r\nCookie: wp-settings-time-1=1491621002\r\nConnection: close\r\nUpgrade-Insecure-Requests: 1\r\n\r\ntheText=&submit=Submit";

// This lsapi request is the same as the above, but with the POST body removed (kill the script when it hangs)
$lsapi_command = "LS\1\0W\4\0\0\277\1\0\0\26\0\0\0D\1\0\0\215\1\0\0|\1\0\0\346\1\0\0\1\0\0\0\17\0\0\0\0\0\0\0\0\0\0\0\0\16\0\35DOCUMENT_ROOT\0/usr/local/lsws/Example/html\0\0\f\0\16REMOTE_ADDR\000192.168.10.18\0\0\f\0\6REMOTE_PORT\00044854\0\0\f\0\16SERVER_ADDR\000192.168.10.18\0\0\f\0\tSERVER_NAME\0wp16.dev\0\0\f\0\5SERVER_PORT\0008088\0\0\f\0\vREQUEST_URI\0/index.php\0\0\r\0\25LSWS_EDITION\0Openlitespeed 1.4.27\0\0\n\0\2X-LSCACHE\0001\0\0\20\0'SCRIPT_FILENAME\0/usr/local/lsws/Example/html/index.php\0\0\r\0\1QUERY_STRING\0\0\0\f\0\vSCRIPT_NAME\0/index.php\0\0\20\0\tSERVER_PROTOCOL\0HTTP/1.1\0\0\20\0\nSERVER_SOFTWARE\0LiteSpeed\0\0\17\0\5REQUEST_METHOD\0POST\0\0\0\0\0\0?\0\0\0\0\0\16\0\0\0\5\0!\0\2\0\35\0\0\0\r\0\0\0\36\0L\0\t\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\225\0\0\0\0\0\0\0\0\0\0\0\347\0\0\0\0\0\0\0\230\1\0\0.\1\0\0a\1\0\0m\1\0\0\0\0\0\0$\0\0\0\0\0\0\0\0\1\0\0?\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\237\1\0\0\31\0\0\0\272\1\0\0\1\0\0\0\0\0\0\0POST /index.php HTTP/1.1\r\nHost: wp16.dev:8088\r\nUser-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0\r\nAccept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\nAccept-Language: en-US,en;q=0.5\r\nReferer: http://wp16.dev:8088/index.php\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: 22\r\nCookie: wp-settings-time-1=1491621002\r\nConnection: close\r\nUpgrade-Insecure-Requests: 1\r\n\r\n";


// Here, we're taking the role of the web server, connecting to lsphp.
$sock = stream_socket_client("tcp://localhost:8877", $errno, $errst);

if($sock) {
	fwrite($sock, $lsapi_command);

	echo PHP_EOL . "Read data:" . PHP_EOL;

	while(!feof($sock)) {
		echo urlencode(fread($sock, 8192)) . PHP_EOL . PHP_EOL;
	}
	fclose($sock);
}

