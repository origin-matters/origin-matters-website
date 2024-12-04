FROM nginx:alpine

# Remove default nginx static assets
RUN rm -rf /usr/share/nginx/html/*

# Copy static assets to nginx directory
COPY index.html /usr/share/nginx/html/
COPY css/ /usr/share/nginx/html/css/
COPY images/ /usr/share/nginx/html/images/
COPY js/ /usr/share/nginx/html/js/
COPY fonts/ /usr/share/nginx/html/fonts/

# Expose port 80
EXPOSE 80

# Start nginx
CMD ["nginx", "-g", "daemon off;"]