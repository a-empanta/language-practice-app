from fastapi import FastAPI

app = FastAPI()

@app.get("/voice/health")
def read_root():
    return {"message": "Service Working"}