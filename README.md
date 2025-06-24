# 🤖 ChatGPT Lite (XAMPP Version)

A lightweight PHP-based chatbot that connects to GPT-3.5-Turbo via the OpenRouter API.  
Designed to run locally on XAMPP for easy self-hosting and development.

---

## 📂 Project Structure

/
├── index.php      # Chat interface (HTML + JS)  
├── api.php        # Backend API (PHP) handling chat requests and session storage  
├── clear.php      # Clears session-based chat history  
├── download_chat.php # Provides chat export functionality  
└── README.md      # Project documentation

---

## ⚙️ Features

✅ Chat with GPT-3.5-Turbo via OpenRouter API  
✅ Local hosting on XAMPP with PHP session-based chat history  
✅ Real-time loading indicator while GPT is typing  
✅ Regenerate previous response option  
✅ Text-to-Speech (TTS) playback for bot replies  
✅ Offline detection with alert banner  
✅ Reset chat functionality with session clearing  
✅ Export full chat history to text file  
✅ Responsive, modern UI with auto-resizing input  
✅ Smartly positioned export/download button for optimal UX

---

## 🔑 Setup Instructions (XAMPP)

1. Download and install [XAMPP](https://www.apachefriends.org/index.html).  
2. Place your project folder inside the `htdocs` directory (e.g., `C:\xampp\htdocs\chatgpt-lite`).  
3. Start Apache via the XAMPP Control Panel.  
4. Open your browser and navigate to:  
   `http://localhost/chatgpt-lite/index.php`  
5. Update your `api.php` with your OpenRouter API key:  
   ```php
   $apiKey = "sk-your-openrouter-api-key";
Replace this with your actual OpenRouter API key.

---

## 💬 How It Works

**index.php**  
Frontend built with HTML, CSS, and Vanilla JavaScript. Sends user messages asynchronously to `api.php` and displays responses in the chat UI with loading indicators, speech, and control buttons.

**api.php**  
Backend PHP script receiving messages, managing session-based chat history, forwarding requests to OpenRouter GPT-3.5-Turbo API, and returning AI responses.

**clear.php**  
Resets chat history by destroying the PHP session securely.

**download_chat.php**  
Provides downloadable chat history as a `.txt` file to export the entire conversation.

---

## 📢 Notes

- Ensure Apache server is running in XAMPP before accessing the app.  
- Chat history is stored in PHP sessions, cleared on reset or server restart.  
- The project runs fully locally — no external hosting required.  
- Validate your OpenRouter API key is active and correctly set in `api.php`.  
- The app detects offline status and alerts the user dynamically.

---

## 🔁 Reset Chat

Visit or trigger `clear.php` to reset your session and clear chat history safely.

---

## 🌟 Credits

- Powered by OpenRouter GPT-3.5-Turbo API  
- Developed and maintained by HaiderIjaz5

---

Build, explore, and customize your own lightweight AI chat experience with ease! 🚀
