import { createContext, useEffect, useState } from "react";

export const AppContext = createContext();

export default function AppProvider({children}) {

    const [token, setToken] = useState(localStorage.getItem('token'))
    const [user, setUser] = useState(null)
    const [laravelBaseUrl, setLaravelBaseUrl] = useState('')
    const [fastApiBaseUrl, setFastApiBaseUrl] = useState('')
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        if(laravelBaseUrl == '' && fastApiBaseUrl == '') {
            setBackendBaseUrls();
        }

        if(token) {
            getUser();
        } else {
            setLoading(false);
        }
    }, [token])

    async function getUser() {
        let laravelUrl = import.meta.env.VITE_APP_URL;

        try {
            const res = await fetch(`${laravelUrl}/api/user`, {
                headers: {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`,
                },
            });
            if(res.status >= 400 && res.status < 500) {
                setLoading(false);
                throw '';
            }

            const data = await res.json();
            
            if(res.ok) {
                setUser(data.user);
                setLoading(false);
                return;
            }
        } catch (error) {
            // silent error
        }        
    }

    function setBackendBaseUrls()
    {
        setLaravelBaseUrl(import.meta.env.VITE_APP_URL);

        if(import.meta.env.VITE_APP_ENV == 'development') {
             setFastApiBaseUrl(import.meta.env.VITE_APP_URL + ':8000');
             return;
        }
        setFastApiBaseUrl(import.meta.env.VITE_APP_URL);
    }

    return(
        <AppContext.Provider value={{token, setToken, user, setUser, laravelBaseUrl, fastApiBaseUrl, loading}}>
            {children}
        </AppContext.Provider>
    )
}