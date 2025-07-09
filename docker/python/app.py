from fastapi import FastAPI, Request
from textblob import TextBlob
import nltk
nltk.download('punkt')

app = FastAPI()

@app.post("/analyze")
async def analyze(request: Request):
    data = await request.json()
    text = data.get("text", "")
    blob = TextBlob(text)
    polarity = blob.sentiment.polarity
    score = (polarity + 1) / 2  # 0–1
    return {"score": round(score, 3), "polarity": polarity}
