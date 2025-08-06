import { useContext, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { AppContext } from "../../Context/AppContext";
import axios from "axios";
import { Button } from "@/components/ui/button";

export default function NewConversationForm() {
    const { token, laravelBaseUrl } = useContext(AppContext);
    const navigate = useNavigate();

    const [topicCategoriesWithTopics, setTopicCategoriesWithTopics] = useState([]);
    const [selectedTopicCategoryId, setSelectedTopicCategoryId] = useState(0);
    const [topics, setTopics] = useState([]);
    const [selectedTopicId, setSelectedTopicId] = useState(0);
    const [loadingTopicCategories, setLoadingTopicCategories] = useState(true);
    const [level, setLevel] = useState("Beginner (A1)");

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
        try {
        } catch (err) {
            // Handle error if necessary
        } finally {
            // Finalize loading state if needed
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
        console.log("Category id:" + selectedTopicCategoryId);
        console.log("Topic id:" + selectedTopicId);
        console.log("Level:" + level);

        // You can continue to handle the conversation creation here
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50 p-4">
            <div className="max-w-md w-full bg-white rounded-2xl shadow-xl p-8">
                <h1 className="text-3xl font-extrabold text-center text-indigo-600 mb-6">
                    Fill up this form
                </h1>
                <form onSubmit={handleEnterNewConversation}>
                    <label className="block mb-2 text-sm font-medium text-gray-700">
                        Category
                    </label>
                    <select
                        className="w-full p-2 border border-gray-300 rounded-lg"
                        value={selectedTopicCategoryId}
                        onChange={(event) => handleChangeTopicCategory(event)}
                    >
                        {!loadingTopicCategories &&
                            topicCategoriesWithTopics.map((cat) => (
                                <option key={cat.id} value={cat.id}>
                                    {cat.title}
                                </option>
                            ))}
                    </select>

                    <label className="block mb-2 text-sm font-medium text-gray-700">
                        Topic
                    </label>
                    <select
                        className="w-full p-2 border border-gray-300 rounded-lg"
                        value={selectedTopicId}
                        onChange={(e) => setSelectedTopicId(e.target.value)}
                    >
                        {!loadingTopicCategories &&
                            topics.map((topic) => (
                                <option key={topic.id} value={topic.id}>
                                    {topic.title}
                                </option>
                            ))}
                    </select>

                    <label className="block mb-2 text-sm font-medium text-gray-700">
                        Your Level
                    </label>
                    <select
                        className="w-full p-2 border border-gray-300 rounded-lg"
                        value={level}
                        onChange={(e) => setLevel(e.target.value)}
                    >
                        {levels.map((levelOption) => (
                            <option key={levelOption.value} value={levelOption.value}>
                                {levelOption.label}
                            </option>
                        ))}
                    </select>

                    <Button type="submit" size="lg">
                        Enter the conversation
                    </Button>
                </form>
            </div>
        </div>
    );
}
