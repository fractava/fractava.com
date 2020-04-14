FROM nginx:latest

RUN mkdir -p /config-buildtime/www/ /config-buildtime/log/nginx/ /config-buildtime/nginx/

# copy data
COPY www/dist /config-buildtime/www/dist/
COPY www/assets /config-buildtime/www/assets/
COPY www/lang /config-buildtime/www/lang/
COPY www/js/libaries /config-buildtime/www/js/libaries/
COPY www/index.html /config-buildtime/www/
COPY www/robots.txt /config-buildtime/www/

# remove default nginx config
RUN rm -R /etc/nginx/*
COPY nginx/nginx.conf /etc/nginx/

# copy new nginx config
COPY nginx/exposed-config/ /config-buildtime/nginx/

# copy start script
COPY start.sh /
RUN chmod +x /start.sh

EXPOSE 80

ENTRYPOINT ["bash","/start.sh"]
