FROM node:24-alpine as react-builder
 
WORKDIR /app

COPY frontend/package.json .

RUN npm install

COPY frontend .
 
RUN npm run build

FROM nginx:alpine

WORKDIR /var/www/html

COPY ./docker/production/react/default.conf /etc/nginx/conf.d/

COPY --from=react-builder /app/build /usr/share/nginx/html

EXPOSE 81

CMD ["nginx", "-g", "daemon off;"]