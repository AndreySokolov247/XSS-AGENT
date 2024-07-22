FROM debian:latest

# Install Tor
RUN apt-get update && apt-get install -y tor

# Configure Tor
COPY ./keys/* /var/lib/tor/hidden_service/
RUN echo "HiddenServiceDir /var/lib/tor/hidden_service/" >> /etc/tor/torrc \
    && echo "HiddenServicePort 80 webserver:80" >> /etc/tor/torrc \
    && echo "HiddenServicePort 443 webserver:443" >> /etc/tor/torrc \
    && echo "HiddenServiceVersion 3" >> /etc/tor/torrc

RUN chmod 700 /var/lib/tor/hidden_service/

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Run Tor in the background
CMD tor -f /etc/tor/torrc





