FROM nginx:latest

ARG HOST_UID=1000

RUN usermod -u ${HOST_UID} nginx && groupmod -g ${HOST_UID} nginx