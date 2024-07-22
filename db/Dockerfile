# Use a base image for MySQL
FROM mysql:latest

# Environment variables for MySQL configuration
ENV MYSQL_ROOT_PASSWORD=password
ENV MYSQL_DATABASE=xss_agent
ENV MYSQL_USER=xss_agent
ENV MYSQL_PASSWORD=password

# Optionally, you can copy custom configuration files
# COPY ./mysql/my.cnf /etc/mysql/my.cnf

# Copy initialization script to MySQL's entrypoint directory
COPY xss_agent.sql /docker-entrypoint-initdb.d/

# Expose port
EXPOSE 3306




