FROM gaibz/ubuntu20-php7.4-nginx:latest

RUN apt update && apt install openjdk-8-jdk -y
RUN apt install php7.4-curl php7.4-mbstring
RUN rm /etc/nginx/sites-enabled/default.conf
COPY etc/default.conf /etc/nginx/sites-enabled/default.conf
