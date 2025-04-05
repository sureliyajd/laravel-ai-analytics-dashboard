from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from typing import Optional
import openai
from openai import OpenAI
import os
from dotenv import load_dotenv
from fastapi.middleware.cors import CORSMiddleware

# Load environment variables first
load_dotenv()

# set client 
client = OpenAI(api_key=os.getenv("OPENAI_API_KEY"))

# Initialize FastAPI app
app = FastAPI(title="AI SQL Query Generator")

# Add CORS middleware
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Your Laravel app URL
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

class QueryRequest(BaseModel):
    query: str
    schema: str
class QueryResponse(BaseModel):
    sql_query: str

@app.post("/generate-sql", response_model=QueryResponse)
async def generate_sql(request: QueryRequest):
    try:
        # Create the prompt for OpenAI
        prompt = f"""        
        You are an expert SQL generator.

Given the database schema below, convert the natural language question into a valid MySQL SQL query.

Database Schema:{request.schema}
Question:
{request.query}
Instructions:

Generate only the SQL query.

Use only the tables and columns explicitly defined in the schema.

Do not assume or invent any columns or relationships.

Include appropriate WHERE, JOIN, GROUP BY, and ORDER BY clauses based on the question.

Follow proper MySQL syntax and formatting.

Do not include any explanation, comments, or extra text — just output the SQL query.
"""

        # Call OpenAI API
        response = client.chat.completions.create(
            model="gpt-4o",
            messages=[
                {"role": "system", "content": "You are a SQL expert. Generate only the SQL query without any explanation. Give the result in a way that i can directly use to trigger a query in a database."},
                {"role": "user", "content": prompt}
            ],
            temperature=0.3,
            max_tokens=150
        )

        # Extract the SQL query from the response
        sql_query = response.choices[0].message.content.strip()

        return QueryResponse(sql_query=sql_query)

    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000) 