FROM rabbitmq:3.8-management

MAINTAINER cuong.ngo

# Define environment variables.
ENV RABBITMQ_LOG_BASE /data/log
ENV RABBITMQ_MNESIA_BASE /data/mnesia

# Define mount points.
VOLUME ["/data/log", "/data/mnesia"]

# Define working directory.
WORKDIR /data

# Define default command.
CMD ["rabbitmq-server"]

# Expose ports.
EXPOSE 5672
EXPOSE 15672