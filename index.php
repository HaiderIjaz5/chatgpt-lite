<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ChatGPT Lite</title>
  <style>
    * {
      box-sizing: border-box;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
      background: #e9eff1;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    header {
      background: #10a37f;
      color: white;
      padding: 15px 20px;
      font-size: 1.5rem;
      font-weight: bold;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .offline-banner {
      text-align: center;
      background: #ffcccb;
      color: #990000;
      padding: 5px;
      font-size: 0.9rem;
      display: none;
    }

    #chat {
      flex: 1;
      padding: 15px;
      overflow-y: auto;
      background: #f5f5f5;
      display: flex;
      flex-direction: column;
    }

    .msg {
      max-width: 75%;
      padding: 12px 15px;
      margin: 10px 0;
      border-radius: 18px;
      line-height: 1.4;
      word-wrap: break-word;
      white-space: pre-wrap;
    }

    .user {
      background-color: #d1e7dd;
      align-self: flex-end;
      margin-left: auto;
    }

    .bot {
      background-color: #e2e3e5;
      align-self: flex-start;
      margin-right: auto;
      position: relative;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
    }

    .loading {
      font-style: italic;
      color: #888;
    }

    #inputArea {
      display: flex;
      padding: 10px;
      background: #ffffff;
      border-top: 1px solid #ccc;
      gap: 10px;
      position: sticky;
      bottom: 0;
      z-index: 10;
    }

    textarea {
      flex: 1;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 15px;
      font-size: 1rem;
      resize: none;
      min-height: 45px;
      max-height: 200px;
      overflow-y: auto;
    }

    button {
      background: #10a37f;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 25px;
      cursor: pointer;
      font-size: 1rem;
    }

    button:hover {
      background: #0d8b6c;
    }

    .icon-btn {
      background: none;
      border: none;
      color: #0d6efd;
      font-size: 1.2rem;
      cursor: pointer;
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <header>🤖 ChatGPT Lite</header>
  <div class="offline-banner" id="offlineBanner">⚠️ You are offline</div>

  <div id="chat"></div>

  <div id="inputArea">
    <!-- Export button moved to left -->
    <button onclick="downloadChat()" style="background-color:#0d6efd;">💾 Export</button>
    <textarea id="input" placeholder="Type a message..."></textarea>
    <button onclick="sendMessage()">🚀 Send</button>
    <button onclick="resetChat()" style="background-color:#dc3545;">🗑️ Clear</button>
  </div>

  <script>
    const chat = document.getElementById('chat');
    const input = document.getElementById('input');
    const offlineBanner = document.getElementById('offlineBanner');
    let lastUserMessage = "";

    function updateOnlineStatus() {
      offlineBanner.style.display = navigator.onLine ? 'none' : 'block';
    }
    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
    updateOnlineStatus();

    async function sendMessage(textToSend = null, isRetry = false) {
      const userMsg = textToSend || input.value.trim();
      if (!userMsg) return;

      lastUserMessage = userMsg;

      if (!isRetry) appendMessage('👤 You', userMsg, 'user');
      input.value = '';
      resizeInput();
      appendLoading();

      try {
        const response = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ message: userMsg })
        });

        const data = await response.json();
        removeLoading();

        const reply = data.reply || '❌ No reply received.';
        if (reply.startsWith('❌')) {
          appendError(reply, userMsg);
        } else {
          appendMessage('🤖 GPT', reply, 'bot', true);
        }

      } catch (e) {
        removeLoading();
        appendError("❌ Network error.", userMsg);
      }
    }

    function appendMessage(sender, text, role, withControls = false) {
      const msgDiv = document.createElement('div');
      msgDiv.className = `msg ${role}`;
      msgDiv.innerHTML = `<strong>${sender}:</strong>\n${text}`;

      if (role === 'bot' && withControls) {
        const actions = document.createElement('div');

        const regenBtn = document.createElement('button');
        regenBtn.className = 'icon-btn';
        regenBtn.textContent = '🔄';
        regenBtn.title = 'Regenerate response';
        regenBtn.onclick = () => sendMessage(lastUserMessage, true);
        actions.appendChild(regenBtn);

        const ttsBtn = document.createElement('button');
        ttsBtn.className = 'icon-btn';
        ttsBtn.textContent = '🔊';
        ttsBtn.title = 'Speak';
        let spoken = false;

        ttsBtn.onclick = () => {
          if (!spoken) {
            speak(text);
            ttsBtn.textContent = '🔇';
            ttsBtn.title = 'Stop';
            spoken = true;
          } else {
            speechSynthesis.cancel();
            ttsBtn.textContent = '🔊';
            ttsBtn.title = 'Speak';
            spoken = false;
          }
        };

        actions.appendChild(ttsBtn);
        msgDiv.appendChild(actions);
      }

      chat.appendChild(msgDiv);
      chat.scrollTop = chat.scrollHeight;
    }

    function appendLoading() {
      const loadingDiv = document.createElement('div');
      loadingDiv.className = 'msg bot loading';
      loadingDiv.id = 'loading-msg';
      loadingDiv.textContent = '🤖 GPT is typing...';
      chat.appendChild(loadingDiv);
      chat.scrollTop = chat.scrollHeight;
    }

    function removeLoading() {
      const loading = document.getElementById('loading-msg');
      if (loading) loading.remove();
    }

    function appendError(errorText, originalMessage) {
      const msgDiv = document.createElement('div');
      msgDiv.className = `msg bot error`;
      msgDiv.innerHTML = `
        <strong>❌ Error:</strong>\n${errorText}
        <button class="icon-btn" title="Retry" onclick="sendMessage(\`${originalMessage.replace(/`/g, '\\`')}\`, true)">🔁</button>
      `;
      chat.appendChild(msgDiv);
      chat.scrollTop = chat.scrollHeight;
    }

    function resizeInput() {
      input.style.height = 'auto';
      input.style.height = input.scrollHeight + 'px';
    }

    function speak(text) {
      if (!('speechSynthesis' in window)) return;
      const utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'en-US';
      speechSynthesis.speak(utterance);
    }

    function resetChat() {
      fetch('clear.php')
        .then(response => response.text())
        .then(msg => {
          chat.innerHTML = '';
          alert(msg);
        })
        .catch(err => {
          alert('❌ Failed to reset chat.');
        });
    }

    function downloadChat() {
      fetch('download_chat.php')
        .then(response => response.json())
        .then(data => {
          if (data.status === 'error') {
            alert(data.message);
          } else {
            const blob = new Blob([data.content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `chat_history_${new Date().toISOString().slice(0, 19).replace(/:/g, "-")}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
          }
        })
        .catch(error => {
          alert('❌ Failed to download chat.');
        });
    }

    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    input.addEventListener('input', resizeInput);
  </script>
</body>

</html>
