import { Volume, MessageCircle, User } from "lucide-react";

export const Features = () => {
  const features = [
    {
      icon: <MessageCircle className="w-10 h-10 text-purple-600" />,
      title: "Natural Conversations",
      description: "Engage in realistic dialogues with our AI that adapts to your level"
    },
    {
      icon: <Volume className="w-10 h-10 text-purple-600" />,
      title: "Instant Feedback",
      description: "Get real-time pronunciation corrections and suggestions"
    },
    {
      icon: <User className="w-10 h-10 text-purple-600" />,
      title: "Personalized Learning",
      description: "AI adjusts to your pace and focuses on your improvement areas"
    }
  ];

  return (
    <section className="py-20 bg-white">
      <div className="max-w-6xl mx-auto px-4">
        <h2 className="text-3xl md:text-4xl font-bold text-center mb-12">Why Choose Our App?</h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {features.map((feature, index) => (
            <div 
              key={index}
              className="p-6 rounded-xl bg-white shadow-lg hover:shadow-xl transition-shadow duration-300 text-center"
            >
              <div className="flex justify-center mb-4">{feature.icon}</div>
              <h3 className="text-xl font-semibold mb-3">{feature.title}</h3>
              <p className="text-gray-600">{feature.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};