# 🚀 AI-Powered SQL Query System

A natural language to SQL query converter using Laravel, FastAPI, and OpenAI.

## 🔄 Flow & How It Works

### 1️⃣ User Interaction
- User enters a natural language question in the React interface
- Example: "How many employees do we have?"
- The system automatically detects database schema

### 2️⃣ Processing the Query (Backend + AI)
- Laravel backend captures the request and database schema
- Sends both query and schema to FastAPI microservice
- FastAPI processes the request using OpenAI (GPT-4)
- AI generates SQL query based on actual database structure

### 3️⃣ Query Execution
- Generated SQL query is cleaned and validated
- Laravel executes the query on MySQL database
- Results are formatted and returned to frontend

### 4️⃣ Data Visualization
- Results displayed in interactive tables
- Automatic chart generation using Recharts
- Support for various chart types based on data

## 🛠️ Technical Stack

### Backend (Laravel)
- Laravel 10.x
- Laravel Sanctum for authentication
- MySQL database
- Custom DatabaseSchemaHelper for schema management

### AI Service (FastAPI)
- FastAPI with Python 3.8+
- OpenAI GPT-4 integration
- Pydantic for request/response validation
- CORS middleware enabled

### Frontend (React)
- React with TypeScript
- Material-UI components
- Recharts for data visualization
- Axios for API communication

## 📦 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd <project-folder>
```

### 2. Backend Setup
```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Install Node.js dependencies
npm install
```

### 3. AI Service Setup
```bash
# Create Python virtual environment
python -m venv venv
source venv/bin/activate  # On Windows: venv\Scripts\activate

# Install Python dependencies
pip install -r requirements.txt

# Configure environment variables
cp .env.example .env
# Add your OpenAI API key to .env
```

### 4. Environment Configuration

#### Laravel (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

FASTAPI_URL=http://localhost:8000
```

#### FastAPI (.env)
```env
OPENAI_API_KEY=your_openai_api_key
```

## 🚀 Running the Application

1. Start Laravel Development Server:
```bash
php artisan serve
```

2. Start Vite Development Server:
```bash
npm run dev
```

3. Start FastAPI Server:
```bash
cd ai-service
uvicorn main:app --reload
```

## 🔒 Authentication

The system uses Laravel Sanctum for API authentication:
- Register: POST /api/register
- Login: POST /api/login
- Logout: POST /api/logout
- Protected routes require Bearer token

## 📝 API Endpoints

### Authentication
- POST `/api/register` - Register new user
- POST `/api/login` - User login
- POST `/api/logout` - User logout

### Query Processing
- POST `/api/query` - Process natural language query
  - Requires authentication
  - Accepts natural language query
  - Returns SQL results and visualization data

## 🎯 Features

- ✅ Natural Language Query Processing
- ✅ Real Database Schema Integration
- ✅ Automatic SQL Query Generation
- ✅ Interactive Data Visualization
- ✅ User Authentication
- ✅ Error Handling
- ✅ Query Validation
- ✅ Response Formatting

## 🔍 Development Notes

- The system automatically detects and uses your database schema
- SQL queries are generated based on actual table and column names
- Responses include both data and the generated SQL query
- Error handling includes detailed logging
- Frontend includes loading states and error messages

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is licensed under the MIT License.

---

🌟 **Star this repository if you find it helpful!**

For questions or issues, please open an issue in the repository.
