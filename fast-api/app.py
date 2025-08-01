from fastapi import FastAPI

app = FastAPI()

@api.get("/voice/")
def read_root():
    return {"message": "Hello, World!"}