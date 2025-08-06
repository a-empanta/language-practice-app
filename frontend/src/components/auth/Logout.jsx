import { useContext } from "react";
import { useNavigate } from "react-router-dom";
import { AppContext } from "../../Context/AppContext";
import { LogOut } from "lucide-react";

export default function Logout() {

    const {user, token, setUser, setToken, laravelBaseUrl} = useContext(AppContext);
    const navigate = useNavigate();

    async function handleLogout(e) {
        e.preventDefault()

        const res = await fetch(`${laravelBaseUrl}/api/logout`, {
            method: "post",
            headers: {
              "Accept": "application/json",
              "Content-Type": "application/json",
              "Authorization": `Bearer ${token}`
            },
        });

        if(res.ok) {
            setUser(null);
            setToken(null);
            localStorage.removeItem('token');
            navigate('/')
        }
    }

    return (
            <div className="flex items-center space-x-4">
                <form onSubmit={handleLogout}>
                    <button className=" text-purple-700 text-lg hover:none">
                    <LogOut className="h-8 w-auto" strokeWidth={2} />
                    </button>
                </form>
            </div>
    )
}
