import { Button } from "@/components/ui/button";
import { Mic } from "lucide-react";
import { useNavigate } from "react-router-dom";

export const CTA = () => {

  const navigate = useNavigate();

  return (
    <section className="flex items-center justify-center py-20 min-h-[60vh] bg-gradient-to-r from-purple-600 to-blue-600 text-white">
      <div className="max-w-4xl mx-auto px-4 text-center">
        <h2 className="text-3xl md:text-4xl font-bold mb-6">
          Ready to Start Speaking?
        </h2>
        <p className="text-xl mb-8 text-purple-100">
          Join thousands of learners already improving their language skills
        </p>
        <Button onClick={() => navigate("/conversations")} size="lg" variant="secondary" className="bg-white text-purple-600 hover:bg-purple-50 px-8 py-6 text-lg rounded-full transition-all hover:scale-105 flex items-center gap-2 mx-auto">
          <Mic className="w-5 h-5" />
          Try for Free
        </Button>
      </div>
    </section>
  );
};