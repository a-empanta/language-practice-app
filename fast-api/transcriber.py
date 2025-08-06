import wave
import json
from vosk import Model, KaldiRecognizer
import subprocess

model = Model(lang="en-us")  # Load once globally

def convert_to_wav(input_path: str, output_path: str):
    try:
        subprocess.run([
            "ffmpeg", "-y", "-i", input_path,
            "-ac", "1", "-ar", "16000", "-sample_fmt", "s16",
            output_path
        ], check=True, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL)
    except subprocess.CalledProcessError:
        raise RuntimeError("ffmpeg conversion failed")

def transcribe_wav(file_path: str) -> str:
    wf = wave.open(file_path, "rb")

    if wf.getnchannels() != 1 or wf.getsampwidth() != 2:
        raise ValueError("Audio must be mono PCM WAV with 16-bit samples")

    rec = KaldiRecognizer(model, wf.getframerate())
    transcript_parts = []

    while True:
        data = wf.readframes(4000)
        if len(data) == 0:
            break
        if rec.AcceptWaveform(data):
            result = json.loads(rec.Result())
            transcript_parts.append(result.get("text", ""))

    # Add final part
    final_result = json.loads(rec.FinalResult())
    transcript_parts.append(final_result.get("text", ""))

    return " ".join(transcript_parts).strip()
