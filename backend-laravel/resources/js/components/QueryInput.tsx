import React, { useState } from 'react';
import { 
    TextField, 
    Button, 
    Box, 
    Paper, 
    Typography,
    CircularProgress
} from '@mui/material';
import SendIcon from '@mui/icons-material/Send';

interface QueryInputProps {
    onQuerySubmit: (query: string) => void;
    isLoading: boolean;
}

const QueryInput: React.FC<QueryInputProps> = ({ onQuerySubmit, isLoading }) => {
    const [query, setQuery] = useState('');

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if (query.trim()) {
            onQuerySubmit(query);
            setQuery('');
        }
    };

    return (
        <Paper elevation={3} sx={{ p: 3, mb: 3 }}>
            <Typography variant="h6" gutterBottom>
                Ask Your Question
            </Typography>
            <Box component="form" onSubmit={handleSubmit} sx={{ display: 'flex', gap: 2 }}>
                <TextField
                    fullWidth
                    variant="outlined"
                    placeholder="e.g., What were the top 5 selling products last month?"
                    value={query}
                    onChange={(e) => setQuery(e.target.value)}
                    disabled={isLoading}
                />
                <Button
                    type="submit"
                    variant="contained"
                    color="primary"
                    endIcon={isLoading ? <CircularProgress size={20} /> : <SendIcon />}
                    disabled={isLoading || !query.trim()}
                >
                    {isLoading ? 'Processing' : 'Ask'}
                </Button>
            </Box>
        </Paper>
    );
};

export default QueryInput; 