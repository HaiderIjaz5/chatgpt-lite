# 🤖 ChatGPT Lite (XAMPP Version)

A lightweight PHP-based chatbot that connects to GPT-3.5-Turbo using the OpenRouter API. This version is designed to run locally on **XAMPP**.

## 📂 Project Structure
```
/
├── index.php      # Chat interface (HTML + JS)
├── api.php        # Backend API (PHP) for handling chat requests
├── clear.php      # Clears session-based chat history
└── README.md      # Project documentation
```

## ⚙️ Features
- ✅ Chat with GPT-3.5-Turbo via OpenRouter API
- ✅ Local hosting on XAMPP
- ✅ Session-based chat history
- ✅ Loading effect while bot is "typing"
- ✅ Regenerate response option
- ✅ Text-to-Speech (TTS) for bot replies
- ✅ Offline detection
- ✅ Reset chat functionality

## 🔑 Setup Instructions (XAMPP)
1. **Download and install XAMPP.**
2. Place your project folder in the `htdocs` directory (e.g. `C:\xampp\htdocs\chatgpt-lite`).
3. Start Apache from XAMPP Control Panel.
4. Access the project in your browser at:
   ```
   http://localhost/chatgpt-lite/index.php
   ```
5. Update your `api.php`:
   ```php
   $apiKey = "sk-your-openrouter-api-key";
   ```
   Replace this with your actual **OpenRouter API key.**

## 💬 How It Works
- `index.php`  
  👉 Frontend (HTML + JavaScript) that sends user input to `api.php` using `fetch()`.

- `api.php`  
  👉 Receives input, stores chat history in `$_SESSION`, sends request to OpenRouter API, and returns the response.

- `clear.php`  
  👉 Clears the chat by destroying the session.

## 📢 Notes
- Make sure your XAMPP Apache server is running.
- This project runs on **localhost**, no internet hosting required.
- Ensure your API key is valid and not expired.
- Sessions work locally and will reset when you clear browser sessions or restart Apache.

## 🔁 Reset Chat
- Visit `http://localhost/chatgpt-lite/clear.php` to reset the chat session.

## 🌟 Credits
- Powered by [OpenRouter](https://openrouter.ai/)
- Developed by HaiderIjaz5
