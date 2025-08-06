
import { Button } from "@/components/ui/button";
import { Link, Mic } from "lucide-react";
import { useNavigate } from "react-router-dom";

export const Hero = () => {

  const navigate = useNavigate();

  return (
    <div className="min-h-[100vh] flex flex-col items-center justify-center text-center px-6 bg-gradient-to-b from-blue-50 to-purple-50">
      <h1 className="font-bold mt-24 mb-6 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent animate-fade-in"
          style={{fontSize: "3rem", maxWidth: "70vw"}}>
        Master A Language Through Natural Conversation
      </h1>
      <p className="text-xl md:text-2xl text-gray-600 mb-8 max-w-2xl animate-fade-in">
        Practice speaking with our AI language partner. Get instant feedback and improve your pronunciation in real-time.
      </p>
        <Button size="lg" onClick={() => navigate("/conversations")} className="bg-purple-600 hover:bg-purple-700 text-white px-8 py-6 text-lg rounded-full transition-all hover:scale-105 animate-fade-in flex items-center gap-2">
          <Mic className="w-5 h-5" />
          Start Speaking Now
        </Button>
    </div>
  );
};