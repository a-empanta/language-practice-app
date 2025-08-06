import { Link } from "react-router-dom";
import { AppContext } from "../Context/AppContext";
import { useContext } from "react";
import Logout from "./auth/Logout";
import logo from '../assets/logo.png';

export default function NavBar () {

    const { user } = useContext(AppContext);

    return (
        <>
            <nav>
                <Link to="/" className="text-purple-600 text-lg hover:none">
                <img
                    src={logo}
                    alt="App Logo"
                    className="h-20 w-auto"
                />
                </Link>

                {user ? (
                        <div className="space-x-4">
                            <Logout/>
                        </div>
                ) : (
                    <div className="space-x-4">
                        <Link to="/login" className="nav-link text-purple-600 text-lg hover:none">
                            Login
                        </Link>
                    
                        <Link to="/register" className="nav-link text-purple-600 text-lg hover:none">
                            Register
                        </Link>
                    </div>
                )}
            </nav>
        </>
    )
}