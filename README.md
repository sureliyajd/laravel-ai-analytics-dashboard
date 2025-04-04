# 🚀 AI-Powered SQL Query System

## 🔄 Flow & How It Works

### 1️⃣ User Interaction
- The user logs into the dashboard.
- They type a question like:
  - 👉 "What were the top 5 selling products last month?"
- The request is sent to the Laravel backend.

### 2️⃣ Processing the Query (Backend + AI)
- Laravel forwards the request to the FastAPI microservice.
- FastAPI processes the request using OpenAI (GPT-4, etc.).
- The AI converts the question into an optimized SQL query.

### 3️⃣ Fetching Data from MySQL
- The generated query is validated for security (prevent SQL injection).
- The Laravel backend executes the query on MySQL.

### 4️⃣ Returning Data
- The results are sent back to the React frontend.
- The frontend displays the results in:
  - ✅ Tables (e.g., product names, sales data)
  - ✅ Charts (Bar, Line, Pie - using Chart.js or Recharts)

### 5️⃣ Real-Time Updates
- If data is updated, WebSockets push real-time updates.

---

## 🔧 Implementation Steps

### 🟢 Backend (Laravel)
- Set up Laravel API (Sanctum for auth, controllers for processing queries).
- Create API Endpoint (`/api/query`) to receive user input.
- Send request to FastAPI via HTTP (Laravel’s HTTP Client).
- Validate & execute SQL queries securely.
- Return data to frontend in JSON format.
- Implement WebSockets (Broadcasting with Pusher).

### 🟢 AI-Powered Query Processing (FastAPI)
- Receive user query from Laravel.
- Use OpenAI API to convert natural language → SQL.
- Return SQL query to Laravel.

### 🟢 Frontend (React)
- Create query input box for user questions.
- Send query to Laravel API and wait for response.
- Display data in tables/charts.
- Listen for WebSocket updates to refresh data automatically.

---

## 🛠️ Technologies Used
- **Backend:** Laravel (PHP), Sanctum (Auth), HTTP Client, WebSockets (Pusher)
- **AI Processing:** FastAPI (Python), OpenAI API
- **Database:** MySQL
- **Frontend:** React.js, Chart.js/Recharts for visualization

## 📌 Installation & Setup
1. Clone the repository.
2. Set up Laravel backend:
   ```sh
   cd backend
   composer install
   php artisan migrate
   php artisan serve
   ```
3. Set up FastAPI microservice:
   ```sh
   cd ai-service
   pip install -r requirements.txt
   uvicorn main:app --reload
   ```
4. Set up React frontend:
   ```sh
   cd frontend
   npm install
   npm start
   ```

## 🔗 API Endpoints
- `POST /api/query` - Process user query and return SQL results.
- `GET /api/realtime` - WebSocket endpoint for real-time updates.

## 📜 License
MIT License

---

🎯 **Contributions are welcome!** Feel free to open issues or submit PRs. 🚀
