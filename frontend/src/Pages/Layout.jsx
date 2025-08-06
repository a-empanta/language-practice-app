import { Outlet } from "react-router-dom";
import NavBar from "../components/Navbar";


export default function Layout() {

    return (
        <>
            <header className="bg-transparent absolute w-full shadow-none">
                <NavBar />
            </header>
            
            <main className="max-w-none">
                <Outlet />
            </main>
        </>
    );
}