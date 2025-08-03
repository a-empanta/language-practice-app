from fastapi import FastAPI

app = FastAPI()

@app.get("/voice/health-check")
def health_check():
    return {"message": "Service Working"}