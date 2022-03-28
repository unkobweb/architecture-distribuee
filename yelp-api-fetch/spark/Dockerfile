FROM debian:bullseye

USER root

RUN apt update
RUN apt -y upgrade

RUN apt install curl mlocate default-jdk wget -y
RUN wget https://archive.apache.org/dist/spark/spark-3.0.3/spark-3.0.3-bin-hadoop3.2.tgz
RUN tar xvf spark-3.0.3-bin-hadoop3.2.tgz
RUN mv spark-3.0.3-bin-hadoop3.2/ /opt/spark

WORKDIR /opt/spark

ADD . /app

CMD ["/opt/spark/bin/spark-shell","-I","/app/main.scala"]