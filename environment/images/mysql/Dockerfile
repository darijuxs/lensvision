FROM ubuntu:18.04
ENV TERM=xterm
EXPOSE 3306
#VOLUME /var/lib/mysql
COPY bootstrap.sh /build/bootstrap.sh
COPY start.sh /build/start.sh
RUN /build/bootstrap.sh
CMD ["/build/start.sh"]