import React, { useState, useEffect, useContext } from "react";
import { useNavigate } from "react-router-dom";
import './Conversation.css';
import { Button } from "@/components/ui/button";
import { Mic, ArrowRight, ChevronsDown, LoaderCircle } from "lucide-react";
import { AppContext } from '../../Context/AppContext';

export default function EnterConversation() {
  const {token, laravelBaseUrl } = useContext(AppContext);
  const navigate = useNavigate();

  const [latestConversationId, setLatestConversationId] = useState(null);
  const [latestConversationFetced, setLatestConversationFetced] = useState(false);

  useEffect(() => {
      fetchLatestConversation();
  }, [navigate]);

  function goToLatestConversation() {
      navigate(`/conversations/${latestConversationId}`);
  }

  // Make an api request to fetch the last conversation of this specific user
  async function fetchLatestConversation() {      
    try {
      const res = await fetch(`${laravelBaseUrl}/api/get-latest-conversation`, {
          headers: {
              "Accept": "application/json",
              "Content-Type": "application/json",
              "Authorization": `Bearer ${token}`
            },
      });
      const data = await res.json();
      setLatestConversationId(data.conversationId);      
      setLatestConversationFetced(true)
    } catch (err) {
      console.log(err.message);
    }
  }

  async function handleEnterNewConversation (e) {
    e.preventDefault()
    navigate('/new-conversation-form');
  }

  return (
    <div className="min-h-[100vh] flex flex-col justify-center items-center bg-gradient-to-b from-[#e5deff] to-[#d3e4fd] px-4">
      <h1 className="text-3xl md:text-4xl font-bold mb-2 text-[#7E69AB] tracking-tight">
        Conversations
      </h1>
      <div className="flex flex-col items-center gap-3 mb-8">
        <span className="rounded-full bg-gradient-to-r from-blue-600 my-6 to-purple-600 p-4 shadow-xl flex items-center justify-center cursor-default">
          <ChevronsDown className="text-gray-200 w-14 h-14" />
        </span>
        <p className="text-gray-600 text-lg max-w-md text-center font-medium">
          Start a new conversation or jump back into your previous one.
          Practice freely with AI in a safe, supportive environment!
        </p>
      </div>
      <div className="w-full max-w-md flex flex-col gap-4">
        {! latestConversationFetced ? 
            (
              <div className="h-10 bg-purple-400 rounded-full animate-pulse flex items-center gap-2 justify-center text-white font-medium">
                <LoaderCircle className="h-5 w-5 animate-spin" />
                Loading previous conversation...
              </div>
            ) : 
            (
              latestConversationId &&
              <Button
                variant="secondary"
                size="lg"
                className="w-full flex items-center justify-center gap-2 text-[#7E69AB] bg-white border border-[#9b87f5] hover:bg-[#f1f0fb] font-semibold shadow rounded-full transition-all hover:scale-105 shadow"
                onClick={() => goToLatestConversation()}
              >
                <ArrowRight className="w-5 h-5" />
                Resume a previous conversation
              </Button>
        )}
        {/* <form onSubmit={() => navigate('/new-conversation-form')}> */}
        <form onSubmit={handleEnterNewConversation}>
          <Button
            type="submit"
            size="lg"
            className="w-full flex items-center justify-center gap-2 text-white bg-[#9b87f5] rounded-full hover:bg-[#7E69AB] font-semibold text-lg py-4 transition-all hover:scale-105 shadow"
            disabled={!token}
          >
            <Mic className="w-5 h-5" />
            Enter a new conversation
          </Button>
        </form>
      </div>
    </div>
  );
}