import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import App from './App.jsx'
import AppProvider from './Context/AppContext.jsx'
import './index.css'
import { ErrorBoundary } from "react-error-boundary";

function Fallback({ error, resetErrorBoundary }) {
    // Call resetErrorBoundary() to reset the error boundary and retry the render.
   
    return (
      <div role="alert">
        <p>Something went wrong:</p>
        <pre style={{ color: "red" }}>{error.stack}</pre>
      </div>
    );
  }

createRoot(document.getElementById('root'))
.render(
    <ErrorBoundary
        FallbackComponent={Fallback}
        onReset={(details) => {
            // Reset the state of your app so the error doesn't happen again
        }}
        >
    <AppProvider>
        <App />  
    </AppProvider>
    </ErrorBoundary>
)
