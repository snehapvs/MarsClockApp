# MarsClockApp

### Prerequisites
* PHP(>5.6)
* composer

### Installation:

Excecute the following comands from a terminal to install the project

```sh git clone https://github.com/coder477/MarsClockApp.git```
```sh cd MarsClockApp```
``` sh composer install ```(the db settings that pop up through the setup can be ignored as we are not using any DB setup for the application)

### Running the Application:
1. Run tests with the following :
```sh vendor/bin/simple-phpunit ```
2.Run the API using the following command
``` sh  php bin/console server:run ```


### HTTP API Endpoint URLs:

1. Run the following curl command from terminal to test the API 
Ex:
`
curl -X GET  http://127.0.0.1:8000/api/marsclock/utcTime=Wednesday,%2026-Feb-20%2015:43:25%20UTC
`
2. or directly open a browser and run the following link to input a utc time from query params like below

   http://127.0.0.1:8000/api/marsclock/utcTime={inputimeinutc}


### References and Improvements:
1. All the formulae used to find Mars sol Date (MSD) and Mars Time Cordinates (MTC) are referred from the following link
https://www.giss.nasa.gov/tools/mars24/help/algorithm.html
2. Additionally referred mars24 webiste for additional time difference adjustments and accurate leapdays count.
3. Used Symphony based PHP skeleton to build the microservice(skelton on default has DB/ORM settings which can be avoided). the setup could be automated through docker

