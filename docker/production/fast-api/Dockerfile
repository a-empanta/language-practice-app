# 1) Builder stage: install build-time deps & pip install
FROM python:3.11-slim AS builder

# Install compiler, FFmpeg, audio libs, curl
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      build-essential \
      ffmpeg \
      portaudio19-dev \
      libsndfile1 \
      curl \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Copy & install your Python requirements globally
COPY fast-api/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copy your FastAPI application code
COPY fast-api/ .

# 2) Production stage: lean runtime image
FROM python:3.11-slim

# Only the runtime system libs (no compilers, no dev-headers)
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      ffmpeg \
      libsndfile1 \
      curl \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Copy over all installed Python packages from builder
COPY --from=builder /usr/local/lib/python3.11/site-packages /usr/local/lib/python3.11/site-packages
# Copy any console scripts (gunicorn, uvicorn, etc.)
COPY --from=builder /usr/local/bin /usr/local/bin

# Copy your application code
COPY --from=builder /app .

# Expose the port the app listens on
EXPOSE 8000

# Start Gunicorn with Uvicorn workers
CMD ["gunicorn", \
     "app:app", \
     "-k", "uvicorn.workers.UvicornWorker", \
     "--bind", "0.0.0.0:8000", \
     "--workers", "4", \
     "--timeout", "60" ]