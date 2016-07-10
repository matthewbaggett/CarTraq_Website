FROM thruio/docker-webapp

RUN apt-get update && \
    curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash - && \
    apt-get -yq install nodejs ruby && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /var/cache/apt/archives/*.deb && \
    npm install -g grunt && \
    gem install sass

ADD . /app
ADD .htaccess /app/.htaccess

RUN rm -f /var/www/html && ln -s /app/public /var/www/html
RUN chmod -R 777 /app/logs/

# Add worker service
RUN mkdir /etc/service/grunt
ADD docker/run.grunt.sh /etc/service/grunt/run
RUN chmod +x /etc/service/*/run

# increase watches
RUN echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf && sudo sysctl -p
