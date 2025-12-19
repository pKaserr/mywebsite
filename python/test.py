import os
from dotenv import load_dotenv
from google import genai

load_dotenv("../includes/.env")
api_key = os.getenv('GEMINI_API_KEY')

if __name__ == "__main__":
    client = genai.Client(api_key=api_key)
    response = client.models.generate_content(
        model="gemini-2.5-flash", contents="Das ist nur ein Text um herauszufinden, ob du meine API-Schlüssel verwenden kannst."
    )
    print(response.text)
