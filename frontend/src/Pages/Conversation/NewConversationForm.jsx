import { useContext, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { AppContext } from "../../Context/AppContext";
import axios from "axios";
import { Button } from "@/components/ui/button";
import { LoaderCircle } from "lucide-react";

export default function NewConversationForm() {
    const { token, laravelBaseUrl, setLoading } = useContext(AppContext);
    const navigate = useNavigate();

    const [topicCategoriesWithTopics, setTopicCategoriesWithTopics] = useState([]);
    const [selectedTopicCategoryId, setSelectedTopicCategoryId] = useState(0);
    const [topics, setTopics] = useState([]);
    const [selectedTopicId, setSelectedTopicId] = useState(0);
    const [loadingTopicCategories, setLoadingTopicCategories] = useState(true);
    const [level, setLevel] = useState("Beginner (A1)");
    const [availableLanguages, setAvailableLanguages] = useState({});
    const [practiseLanguageId, setPractiseLanguageId] = useState(0);
    const [translatingLanguageId, setTranslatingLanguageId] = useState(0);
    const [formError, setFormError] = useState('');

    const levels = [
        { value: "Beginner (A1)", label: "Beginner (A1)" },
        { value: "Elementary (A2)", label: "Elementary (A2)" },
        { value: "Intermediate (B1)", label: "Intermediate (B1)" },
        { value: "Upper Intermediate (B2)", label: "Upper Intermediate (B2)" },
        { value: "Advanced (C1)", label: "Advanced (C1)" },
        { value: "Proficient (C2)", label: "Proficient (C2)" },
    ];

    useEffect(() => {
            getTopicCategories();
            getAvailableLanguages();
    }, []);

    async function getTopicCategories() {
        try {
            const { data } = await axios.get(
                `${laravelBaseUrl}/api/topic-categories`,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                }
            );
            setTopicCategoriesWithTopics(data.topicCategories);
            setTopics(data.topicCategories[0].topics);
            setSelectedTopicCategoryId(data.topicCategories[0].id);
            setSelectedTopicId(data.topicCategories[0].topics[0].id);
            setLoadingTopicCategories(false);
        } catch (err) {
            // Handle error if necessary
        } finally {
            // Finalize loading state if needed
        }
    }

    async function getAvailableLanguages() {
        let languages;

        try {
            const response = await axios.get(
                    `${laravelBaseUrl}/api/get-available-languages`,
                    {
                    headers: {
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                        "Authorization": `Bearer ${token}`,
                    }
                }
            );
            languages = response.data.languages;
        } catch (err) {
            console.log(err.message);
        } finally {
            let firstLanguage = Object.values(languages)[0];
            setPractiseLanguageId(firstLanguage);
            setTranslatingLanguageId(firstLanguage);
            setAvailableLanguages(languages);
        }
    }

    function handleChangeTopicCategory(event) {
        let selectedTopicCategoryObject = topicCategoriesWithTopics.find(
            (value) => value.id == event.target.value
        );

        setTopics(selectedTopicCategoryObject.topics);
        setSelectedTopicCategoryId(selectedTopicCategoryObject.id);
        setSelectedTopicId(selectedTopicCategoryObject.topics[0].id);
    }

    async function handleEnterNewConversation(e) {
        e.preventDefault();
        let conversationId;

        try {
            const response = await axios.post(`${laravelBaseUrl}/api/new-conversation`,
                                                    {
                                                        practiseLanguageId: practiseLanguageId,
                                                        translatingLanguageId: translatingLanguageId,
                                                        categoryId: selectedTopicCategoryId,
                                                        topicId: selectedTopicId,
                                                        level: level
                                                    },
                                                    {
                                                        headers: {
                                                            "Accept": "application/json",
                                                            "Content-Type": "application/json",
                                                            "Authorization": `Bearer ${token}`
                                                        }
                                                    }
                                                  )
            conversationId = response.data.conversationId;
            navigate(`/conversations/${conversationId}`);
        } catch (err) {
            if(err.response.status >= 400 && err.response.status < 500) {
                return setFormError('There are error or missing fields in your form.');
            }
            setFormError('An unexpected error occurred on the server. Please try again later.');
        }   
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50 pt-36">
            <div className="max-w-lg w-full bg-white rounded-3xl shadow-2xl p-8">
                <h1 className="text-2xl font-extrabold text-center text-indigo-600 mb-8">
                    Start a New Conversation
                </h1>
                <form onSubmit={handleEnterNewConversation} className="space-y-5">
                    
                    {formError && (
                        <div className="text-red-600 bg-red-100 p-3 rounded-lg border border-red-300">
                            {formError}
                        </div>
                    )}

                    {/* Language to Practise */}
                    <div className="flex flex-col">
                        <label className="mb-2 text-sm font-semibold text-gray-700">
                            Language to Practise
                        </label>
                        {(!availableLanguages || Object.keys(availableLanguages).length === 0) ? (
                            <div className="h-12 bg-purple-200 rounded-xl animate-pulse flex items-center gap-2 pl-3">
                                <LoaderCircle className="h-6 w-6 animate-spin" />
                                Loading...
                            </div>
                        ) : (
                            <select
                                className="p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                value={practiseLanguageId}
                                onChange={(event) => setPractiseLanguageId(event.target.value)}
                            >
                                {Object.entries(availableLanguages).map(([name, id]) => (
                                    <option key={id} value={id}>
                                        {name}
                                    </option>
                                ))}
                            </select>
                        )}
                    </div>

                    {/* Translating Language */}
                    <div className="flex flex-col">
                        <label className="mb-2 text-sm font-semibold text-gray-700">
                            Translating Language
                        </label>
                        {(!availableLanguages || Object.keys(availableLanguages).length === 0) ? (
                            <div className="h-12 bg-purple-200 rounded-xl animate-pulse flex items-center gap-2 pl-3">
                                <LoaderCircle className="h-6 w-6 animate-spin" />
                                Loading...
                            </div>
                        ) : (
                            <select
                                className="p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                value={translatingLanguageId}
                                onChange={(event) => setTranslatingLanguageId(event.target.value)}
                            >
                                {Object.entries(availableLanguages).map(([name, id]) => (
                                    <option key={id} value={id}>
                                        {name}
                                    </option>
                                ))}
                            </select>
                        )}
                    </div>

                    {/* Category */}
                    <div className="flex flex-col">
                        <label className="mb-2 text-sm font-semibold text-gray-700">
                            Category
                        </label>
                        {loadingTopicCategories ? (
                            <div className="h-12 bg-purple-200 rounded-xl animate-pulse flex items-center gap-2 pl-3">
                                <LoaderCircle className="h-6 w-6 animate-spin" />
                                Loading...
                            </div>
                        ) : (
                            <select
                                className="p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                value={selectedTopicCategoryId}
                                onChange={handleChangeTopicCategory}
                            >
                                {topicCategoriesWithTopics.map((cat) => (
                                    <option key={cat.id} value={cat.id}>
                                        {cat.title}
                                    </option>
                                ))}
                            </select>
                        )}
                    </div>

                    {/* Topic */}
                    <div className="flex flex-col">
                        <label className="mb-2 text-sm font-semibold text-gray-700">
                            Topic
                        </label>
                        {loadingTopicCategories ? (
                            <div className="h-12 bg-purple-200 rounded-xl animate-pulse flex items-center gap-2 pl-3">
                                <LoaderCircle className="h-6 w-6 animate-spin" />
                                Loading...
                            </div>
                        ) : (
                            <select
                                className="p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                value={selectedTopicId}
                                onChange={(e) => setSelectedTopicId(e.target.value)}
                            >
                                {topics.map((topic) => (
                                    <option key={topic.id} value={topic.id}>
                                        {topic.title}
                                    </option>
                                ))}
                            </select>
                        )}
                    </div>
                    
                    {/* Level */}
                    <div className="flex flex-col">
                        <label className="mb-2 text-sm font-semibold text-gray-700">
                            Your Level
                        </label>
                        <select
                            className="p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400"
                            value={level}
                            onChange={(e) => setLevel(e.target.value)}
                        >
                            {levels.map((levelOption) => (
                                <option key={levelOption.value} value={levelOption.value}>
                                    {levelOption.label}
                                </option>
                            ))}
                        </select>
                    </div>

                    <Button
                        type="submit"
                        size="lg"
                        className="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-md transition-all duration-200"
                    >
                        Enter the Conversation
                    </Button>
                </form>
            </div>
        </div>
    );
}
