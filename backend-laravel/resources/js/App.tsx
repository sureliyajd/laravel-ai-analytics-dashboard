import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import { Container, CssBaseline, ThemeProvider, createTheme } from '@mui/material';
import QueryInput from './components/QueryInput';
import ResultsDisplay from './components/ResultsDisplay';

const theme = createTheme({
    palette: {
        mode: 'light',
    },
});

function App() {
    const [isLoading, setIsLoading] = React.useState(false);
    const [results, setResults] = React.useState<any[]>([]);

    const handleQuerySubmit = async (query: string) => {
        setIsLoading(true);
        try {
            // First, generate SQL query
            const sqlResponse = await fetch('/api/query', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                body: JSON.stringify({ 
                    query: query  // Make sure query is sent as a string
                })
            });

            if (!sqlResponse.ok) {
                throw new Error('Failed to process query');
            }

            const data = await sqlResponse.json();
            setResults(data.data || []);
        } catch (error) {
            console.error('Error processing query:', error);
            setResults([]);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <ThemeProvider theme={theme}>
            <CssBaseline />
            <Container maxWidth="lg" sx={{ py: 4 }}>
                <h1>AI SQL Query System</h1>
                <QueryInput onQuerySubmit={handleQuerySubmit} isLoading={isLoading} />
                <ResultsDisplay data={results} isLoading={isLoading} />
            </Container>
        </ThemeProvider>
    );
}

// Add this console log for debugging
console.log('React app starting');

const container = document.getElementById('app');
if (container) {
    const root = createRoot(container);
    root.render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
} else {
    console.error('Failed to find app element');
} 