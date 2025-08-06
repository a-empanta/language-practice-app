from fastapi import HTTPException
import requests
import logging

logger = logging.getLogger("auth")

def validate_user(authorization, url):
    
    # Validate token
    if not authorization or not authorization.startswith("Bearer "):
        raise HTTPException(status_code=401, detail="Authorization token missing or invalid")

    token = authorization.split(" ")[1]

    # Send token to Laravel for validation
    try:
        response = requests.get(
            f"{url}/api/validate-token",
            headers={"Authorization": f"Bearer {token}"}
        )
        if response.status_code != 200:
            raise HTTPException(status_code=401, detail="Invalid token")
    except requests.RequestException:
        logging.error("Failed to contact auth server")
        raise HTTPException(status_code=500, detail="Failed to contact auth server")