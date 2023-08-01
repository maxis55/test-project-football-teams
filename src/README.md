## LARAVEL SAIL SET UP
## Prerequisites

To set up the project you need to have docker installed on your system, refer to the documentation for further details depending on the OS
https://laravel.com/docs/10.x#laravel-and-docker

## Set-up

To run the project you need to run the command
```
./vendor/bin/sail up
```
You might also want to set up the alias 
```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```
I'm going to refer to commands as if alias is set

After sail has finished creating the docker container, you can use migrations and seeds
Make sure to run this command in the separate tab from the one that has docker container running
```
sail artisan migrate --seed
```
Build assets if vite failed to build them automatically
```
sail npm run build 
```
for production, or
```
sail npm run dev
```
for dev(will monitor changes)

## Testing
```
sail artisan test
```

## Issues
You might run into issues if you already have an instance of DB or Nginx running on your machine and occupying the ports
In that case just change the .env variables for the port that creates an issue
Here's a list of .env parameters I had to change
```
APP_PORT=2020
FORWARD_REDIS_PORT=6380
FORWARD_DB_PORT=3307
```
