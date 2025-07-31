FROM node:24-alpine as react-builder
 
WORKDIR /app

COPY frontend/package.json .

RUN npm install

COPY frontend .
 
RUN npm run build