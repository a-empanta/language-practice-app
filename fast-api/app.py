from fastapi import FastAPI, File, UploadFile, HTTPException, Header, Form
import shutil
import os
from transcriber import convert_to_wav, transcribe_wav
from logger import initialize_logging
import logging
from fastapi.middleware.cors import CORSMiddleware
from auth import validate_user
from dotenv import load_dotenv
import sys

load_dotenv()

# Rip out any existing handlers Uvicorn set up
for h in list(logging.root.handlers):
    logging.root.removeHandler(h)

initialize_logging()

app = FastAPI()

app.add_middleware(
  CORSMiddleware,
  allow_origins=["*"],  # or ["*"] for any origin
  allow_methods=["*"],  # allow all HTTP methods (including OPTIONS)
  allow_headers=["*"],
)

UPLOAD_DIR = "/tmp"

environment = os.getenv('APP_ENV')

@app.post("/voice/transcribe")
async def transcribe(file: UploadFile = File(...), model_name: str = Form(...) ,authorization: str = Header(None)):
    url = "http://localhost"
    validate_user(authorization, url)
    
    if not file.filename.endswith((".wav", ".webm", ".ogg", ".mp3")):
        raise HTTPException(status_code=400, detail="Unsupported file type")

    try:
        original_path = os.path.join(UPLOAD_DIR, file.filename)
        
        with open(original_path, "wb") as buffer:
            shutil.copyfileobj(file.file, buffer)

        converted_path = original_path + "_converted.wav"
        convert_to_wav(original_path, converted_path)
        transcript = transcribe_wav(converted_path, model_name).replace('<unk>', '')

        return {"transcript": transcript}

    except Exception as e:
        logging.error(e)
        raise HTTPException(status_code=500, detail="Internal server error")

    finally:
        for path in [original_path, converted_path]:
            if os.path.exists(path):
                os.remove(path)

@app.get("/voice/health-check")
def health_check():
    # logging.error('hey')
    return {"message": "Service Working"}