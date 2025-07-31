FROM node:24-alpine as react-builder
 
# Set the working directory inside the container
WORKDIR /app
 
# Copy all files
COPY frontend/package.json .
 
# Install dependencies
RUN npm install

# Copy all files to the container
COPY frontend .

# Define the command to run your app
RUN npm run build

FROM nginx:stable-alpine

# Copy the react build into the nginx container
COPY --from=build /app/build /usr/share/nginx/html