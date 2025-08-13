import { Loader2 } from "lucide-react";

export default function LoadingPage() {
    return (
        <div className="min-h-screen w-full flex flex-col items-center justify-center bg-purple-100 text-gray-700">
            <Loader2 className="h-14 w-14 animate-spin text-purple-500" />
            <p className="mt-4 text-lg font-medium animate-pulse">
                Loading, please wait...
            </p>
        </div>
    );
}
