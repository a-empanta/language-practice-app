from fastapi import FastAPI

app = FastAPI()

@api.get("/voice/health")
def read_root():
    return {"message": "Service Working"}