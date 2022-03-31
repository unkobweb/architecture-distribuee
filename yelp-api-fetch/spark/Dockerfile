FROM debian:bullseye

USER root

RUN apt update
RUN apt -y upgrade

RUN apt install curl mlocate default-jdk wget -y
RUN wget https://archive.apache.org/dist/spark/spark-3.0.3/spark-3.0.3-bin-hadoop3.2.tgz
RUN tar xvf spark-3.0.3-bin-hadoop3.2.tgz
RUN mv spark-3.0.3-bin-hadoop3.2/ /opt/spark
RUN cp /opt/spark/conf/spark-defaults.conf.template /opt/spark/conf/spark-defaults.conf
RUN echo 'spark.mongodb.input.uri     mongodb://mongo/Archi' >> /opt/spark/conf/spark-defaults.conf
RUN echo 'spark.mongodb.output.uri      mongodb://mongo/Archi' >> /opt/spark/conf/spark-defaults.conf

WORKDIR /opt/spark

ADD . /app
ADD mongo-java-driver-3.12.10.jar /opt/spark/jars

# CMD ["/opt/spark/bin/spark-shell"]
CMD ["/opt/spark/bin/spark-shell","-I","/app/streamingToMongo.scala","--packages","org.mongodb.spark:mongo-spark-connector_2.12:3.0.1","--conf","spark.sql.catalogImplementation=in-memory"]
# /opt/spark/bin/spark-shell -I /app/streamingToMongo.scala --packages org.mongodb.spark:mongo-spark-connector_2.12:3.0.1 --conf spark.sql.catalogImplementation=in-memory