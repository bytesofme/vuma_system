FROM php:8.2-cli

WORKDIR /app

COPY . .

# Install a simple PHP server that serves static files
RUN apt-get update && apt-get install -y python3

EXPOSE 8080

# Use Python to serve both PHP and static files
CMD ["sh", "-c", "php -S 0.0.0.0:8080 & python3 -m http.server 8081 --directory ."]
# Add these lines to your existing Dockerfile
RUN chmod 755 /var/www/html
RUN chmod 666 /var/www/html/includes/vuma_parcel.db 2>/dev/null || true
