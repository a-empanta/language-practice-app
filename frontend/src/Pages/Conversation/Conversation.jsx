import React, { useState, useEffect, useContext, useRef } from "react";
import { Mic, MicOff, Globe, Subtitles, Headphones } from "lucide-react";
import axios from "axios";
import { AppContext } from "../../Context/AppContext";
import { useNavigate, useParams } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Textarea } from "@/components/ui/textarea"
import { cn } from "@/lib/utils";
import dutch from '../../assets/partners/dutch.webp';
import { useReactMediaRecorder } from "react-media-recorder";

// You can swap this image with a local asset/avatar if needed
const AI_WOMAN_IMAGE = dutch;

const Conversation = () => {
  // Url Params
  const { id } = useParams();

  // Context variables needed
  const { token, laravelBaseUrl, fastApiBaseUrl } = useContext(AppContext);

  // Hooks needed
  const navigate = useNavigate();
  const { startRecording, stopRecording, } = useReactMediaRecorder({audio: true, onStop: (blobUrl) => sendBlob(blobUrl) });

  // State
  const [lang, setLang] = useState("nl-NL");
  const [userTranscript, setUserTranscript] = useState('')
  const [respondingText, setRespondingText] = useState('');
  const [conversation, setConversation] = useState(null);
  const [error, setError] = useState(null);
  const [showSubtitles, setShowSubtitles] = useState(true);
  const [loadingResponse, setLoadingResponse] = useState(null);

  // Refs
  const micListening = useRef(false);
  const  voicesInitialized = useRef(0);
 
  // Fetch the conversation history
  useEffect(() => {
    const fetchConversation = async () => {
      try {
        const res = await axios.get(`${laravelBaseUrl}/api/conversations/${id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setConversation(res.data);
      } catch (err) {
        setError("Not authorized or conversation not found");
        navigate("/not-found");
      }
    };

    fetchConversation();
  }, [id, token, navigate]);

  async function sendBlob(blobUrl) {
    const response = await fetch(blobUrl);
    const blob = await response.blob();
    const file = new File([blob], 'recording.wav', { type: 'audio/wav' });
    const modelName = conversation.practising_language.transcriber_ai_model;
    const formData = new FormData();

    formData.append('file', file);
    formData.append('model_name', modelName);

    const transcriptionResponse = await axios.post( `${fastApiBaseUrl}/voice/transcribe`, 
                                                    formData, 
                                                    { headers: {
                                                      'Authorization' : `Bearer ${token}`,
                                                      'Content-Type'  : 'multipart/form-data' 
                                                      } 
                                                    });
    console.log(transcriptionResponse)

    setUserTranscript(transcriptionResponse.data.transcript);
  }

  const handleSendPrompt = async () => {
    micListening.current = false;
    setLoadingResponse(true);
  
    try {
      const { data } = await axios.post(
        `${laravelBaseUrl}/api/prompt/${id}`,
        { prompt: userTranscript },
        {
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${token}`,
          },
        }
      );

      // pull out the fields your API returns
      const { message, response, translation, replyDutchAudioDataUri } = data;
  
      // show the text on screen
      setRespondingText(response);
      // setTranslation(translation);
  
      // fire up an <audio> player
      if (replyDutchAudioDataUri) {
        const audio = new Audio(replyDutchAudioDataUri);
        audio.play().catch(err => {
          console.error('audio play failed', err);
        });
      }
  
    } catch (err) {
      console.error(err);
      setError('Failed to get AI response. Try again!');
    } finally {
      setLoadingResponse(false);
    }
  };

  const handleListenAiResponse = () => {
    const text = respondingText?.trim();
    if (!text) return;
  
    // 1) grab a fresh list of voices
    const voices = window.speechSynthesis.getVoices();
    if (voices.length === 0) {
      console.warn("No TTS voices yet—waiting for voiceschanged");
      // defer until voices arrive
      window.speechSynthesis.onvoiceschanged = () => {
        window.speechSynthesis.onvoiceschanged = null;
        handleListenAiResponse();
      };
      return;
    }
  
    // 2) pick best match, or fallback
    let selected =
      voices.find(v => v.lang === lang) ||
      voices.find(v => v.lang.startsWith(lang.split("-")[0])) ||
      voices[0];
  
    console.log(`TTS: using voice ${selected.name} (${selected.lang})`);
  
    // 3) build utterance
    const utter = new SpeechSynthesisUtterance(text);
    utter.voice  = selected;
    utter.lang   = selected.lang;
    utter.rate   = 1;
    utter.pitch  = 1;
    utter.volume = 1;
  
    utter.onstart = () => console.log("🗣 TTS started");
    utter.onerror = e => {
      console.error("🗣 TTS error", e);
    }
    utter.onend   = () => console.log("🗣 TTS finished");
  
    // 4) clear any previous, then speak after a tiny delay
    window.speechSynthesis.cancel();
    setTimeout(() => window.speechSynthesis.speak(utter), 100);
  };  
  
  const handleMic = async () => {
    if (!micListening.current) {
      startRecording();
      micListening.current = true;
    } else {
      micListening.current = false;
      stopRecording();
    }
  };     
  
  return (
    <div
    className="min-h-screen w-full flex items-center justify-center py-20"
    style={{
      background: "linear-gradient(135deg,#E5DEFF 0%, #D6BCFA 100%)",
    }}
  >
    <div className="w-full max-w-6xl flex flex-col md:flex-row items-stretch gap-0 md:gap-4 px-2 py-8 relative">
      {/* Woman Avatar Large Section */}
      <div className="flex-1 flex flex-col items-center justify-center relative">
        <div className="w-[340px] h-[340px] sm:w-[410px] sm:h-[410px] md:w-[500px] md:h-[500px] rounded-full bg-white/20 shadow-2xl overflow-hidden flex items-center justify-center border-4 border-purple-200 mx-auto ring-8 ring-purple-100 animate-fade-in">
          <img
            src={AI_WOMAN_IMAGE}
            alt="AI Woman"
            className="object-cover w-full h-full rounded-full"
            draggable={false}
            loading="eager"
            style={{userSelect: "none"}}
          />
        </div>
      </div>
      {/* <button onClick={() => speak('Hoe gaat het')}>Speak</button> */}
      {/* Conversation Card Section */}
      <div className="flex-1 flex items-center">
        <div
          className={cn(
            "glass-morphism",
            "flex flex-col items-center w-full rounded-[2.5rem] shadow-2xl bg-white/70",
            "backdrop-blur-lg border border-purple-200 p-4 animate-fade-in"
          )}
        >
          {/* Language Picker */}
          <div className="mt-8 flex items-center justify-center w-full gap-4">
            <label htmlFor="lang" className="text-purple-800 mb-1 inline-flex items-center gap-1 text-lg">
              <Globe className="inline w-4 h-4 text-purple-400" /> Language:
            </label>
            <p className="text-indigo-800 mb-1 inline-flex items-center gap-1 text-lg font-semi-bold">Dutch</p>
          </div>
          {/* Conversation History */}
          <div className="bg-white/80 mt-8 border border-purple-100 rounded-2xl shadow px-6 py-6 w-full max-h-56 min-h-[120px] overflow-y-auto flex flex-col gap-2">
            <div className="flex flex-wrap items-center justify-between">
              {/* <h1 className="text-center text-gray-600 m-0 p-0">Record your message</h1> */}
              {/* Mic and Controls */}
              <div className="flex items-center gap-1 flex-wrap justify-center w-full">
                <Button
                  size="lg"
                  className={cn(
                    "bg-gradient-to-tr from-purple-400 to-purple-700 hover:from-purple-500 hover:to-purple-900 transition text-white font-bold rounded-full px-8 py-4 shadow-lg flex items-center gap-2 text-lg tracking-wide",
                  )}
                  onClick={handleMic}
                >
                  {micListening.current ? (
                    <>
                      <MicOff className="w-7 h-7" /> Stop Recording
                    </>
                  ) : (
                    <>
                      <Mic className="w-7 h-7" /> Start Speaking
                    </>
                  )}
                </Button>

                { loadingResponse === false ? 
                  (<div>
                      <Button
                        className={cn(
                          "bg-gradient-to-tr from-purple-400 to-purple-700 hover:from-purple-500 hover:to-purple-900 transition text-white font-bold rounded-full px-5 py-5 shadow-lg flex items-center gap-2 text-lg tracking-wide",
                        )} 
                        onClick={handleListenAiResponse}>
                        <Headphones />
                        Listen to response
                      </Button>
                    </div>) 
                    : loadingResponse === true ? 
                    (<p>loading</p>) 
                    : ''
                }
              </div>

              <div className="flex flex-col gap-2 mt-2 w-full">
                <Textarea value={userTranscript} 
                          onChange={(e) => setUserTranscript(e.target.value)} id="transcriptTextArea"/>
                <Button className={
                          cn(
                            "rounded-sm bg-gradient-to-tr from-indigo-400 to-indigo-700 hover:from-indigo-500 hover:to-indigo-900 transition text-white font-semi-bold px-5 py-5 shadow-lg flex items-center gap-2 text-xl tracking-wide"
                          )
                        }
                        onClick={handleSendPrompt}
                        disabled={userTranscript === ''}>
                  Send Message
                </Button>
              </div>
            </div>
          </div>
          {/* Subtitles Section */}
          {showSubtitles ? (
            <div className="w-full mt-3 flex-column items-center gap-2">
              <div className="flex items-center justify-between mb-2 mt-2 px-2">
                <span className="text-lg font-medium text-purple-600 p-0">Subtitles</span>
                {/* Subtitles Show/Hide Toggle */}
                <div className="flex items-center gap-2">
                  <button
                    onClick={() => setShowSubtitles((p) => !p)}
                    className={cn(
                      "transition text-purple-700 px-3 py-1 text-base font-medium rounded-2xl flex items-center gap-2 border border-purple-200 bg-white/90 hover:bg-purple-50 shadow hover:shadow-md focus:outline-none focus:ring-2 focus:ring-purple-300"
                    )}
                  >
                    <Subtitles className="w-6 h-6" />
                    Hide Subtitles
                  </button>
                </div>
              </div>
              <div className="flex-1 bg-white/90 border border-purple-100 rounded-md px-4 py-2 text-purple-500 text-base min-h-[36px] shadow-sm">
              </div>
            </div>)
            : 
            (
              <div className="w-full mt-3 flex-column items-center gap-2">
                <div className="flex items-center justify-center mb-2 mt-2 px-2">
                  <button
                  onClick={() => setShowSubtitles((p) => !p)}
                  className={cn(
                    "transition text-purple-700 px-3 py-1 text-base font-medium rounded-2xl flex items-center gap-2 border border-purple-200 bg-white/90 hover:bg-purple-50 shadow hover:shadow-md focus:outline-none focus:ring-2 focus:ring-purple-300"
                  )}
                  >
                    <Subtitles className="w-6 h-6" />
                    Show Subtitles
                  </button>
                </div>
              </div>
            )
          }
          
          {/* Error / transcript */}
          {error && (
            <div className="mt-3 w-full text-center text-red-500 text-sm font-medium">{error}</div>
          )}
        </div>
      </div>
    </div>
  </div>
);
};

export default Conversation;