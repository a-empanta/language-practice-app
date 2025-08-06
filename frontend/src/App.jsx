import { BrowserRouter, Routes, Route } from "react-router-dom";
import "./App.css";
import Home from "./Pages/Home/Home";
import Conversation from "./Pages/Conversation/Conversation";
import Layout from "./Pages/Layout";
import Register from "./Pages/Auth/Register";
import Login from "./Pages/Auth/Login";
import { useContext } from "react";
import { AppContext } from "./Context/AppContext";
import EnterConversation from "./Pages/Conversation/EnterConversation";
import NewConversationForm from "./Pages/Conversation/NewConversationForm";

export default function App() {

    const {user} = useContext(AppContext);

    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<Layout />}>
                    <Route index element={<Home />} />
                    <Route path="/conversations/:id" element={user ?<Conversation /> : <Login />} />
                    <Route path="/conversations" element={user ?<EnterConversation /> : <Login />} />
                    <Route path="/new-conversation-form" element={user ?<NewConversationForm /> : <Login />} />
                    <Route path="/login" element={user ? <Home/> : <Login />} />
                    <Route path="/register" element={user ? <Home/> : <Register />} />
                    <Route path="/not-found" element={<div>Page not found</div>} />
                </Route>
            </Routes>
        </BrowserRouter>
    )
}

