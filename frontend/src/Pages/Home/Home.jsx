import { useContext } from "react";
import { AppContext } from "../../Context/AppContext";
import { Button } from "@/components/ui/button"
import { CTA } from "../../components/CTA";
import { Hero } from "../../components/Hero";
import { Features } from "../../components/Features";
import { HowItWorks } from "../../components/HowItWorks";

export default function Home() {


    return (
        <div className="min-h-screen w-full">
            <Hero />
            <Features />
            <HowItWorks />
            <CTA />
        </div>
    );
}