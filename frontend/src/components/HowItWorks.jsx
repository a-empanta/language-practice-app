export const HowItWorks = () => {
    const steps = [
      {
        number: "1",
        title: "Choose Your Language",
        description: "Select from multiple languages and difficulty levels"
      },
      {
        number: "2",
        title: "Start Speaking",
        description: "Begin your conversation with our AI language partner"
      },
      {
        number: "3",
        title: "Get Feedback",
        description: "Receive instant corrections and improvement suggestions"
      }
    ];
  
    return (
      <section className="py-20 bg-gradient-to-b from-purple-50 to-blue-50">
        <div className="max-w-6xl mx-auto px-4">
          <h2 className="text-3xl md:text-4xl font-bold text-center mb-12">How It Works</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {steps.map((step) => (
              <div key={step.number} className="relative">
                <div className="text-6xl font-bold text-purple-200 absolute -top-6 left-0">
                  {step.number}
                </div>
                <div className="pt-8 pl-4">
                  <h3 className="text-xl font-semibold mb-3">{step.title}</h3>
                  <p className="text-gray-600">{step.description}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    );
  };