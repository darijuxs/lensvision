FROM ubuntu:18.04
ENV TERM=xterm
ENV DEBIAN_FRONTEND=noninteractive
EXPOSE 80
COPY bootstrap.sh /build/bootstrap.sh
COPY vhosts /build/vhosts
COPY start.sh /build/start.sh
RUN /build/bootstrap.sh
CMD ["/build/start.sh"]