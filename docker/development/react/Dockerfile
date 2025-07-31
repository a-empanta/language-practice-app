FROM node:24-alpine
 
# Set the working directory inside the container
WORKDIR /app
 
# Copy all files
COPY frontend .
 
# Install dependencies
RUN npm install

# Expose the port your app runs on
EXPOSE 5173
 
# Define the command to run your app
CMD ["npm", "start"]