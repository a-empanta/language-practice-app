FROM python:3.11-slim

# Install system dependencies for audio and file I/O
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       ffmpeg \
       portaudio19-dev \
       libsndfile1 \
       curl \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Install Python dependencies
COPY fast-api/requirements.txt .

RUN pip install --upgrade pip

RUN pip install --no-cache-dir -r requirements.txt

# Copy application code
COPY fast-api/ .

EXPOSE 8000

# No CMD: container idles so Laravel can exec scripts on demand
CMD ["uvicorn", "app:app", "--host", "0.0.0.0", "--port", "8000", "--reload"]