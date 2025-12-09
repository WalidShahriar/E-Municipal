var video = document.getElementById("hero_video");
var btn = document.getElementById("video_btn");

function toggleVideo() {
    if (video.paused) {
        video.play();
        btn.innerHTML = "&#9646;";
    } else {
        video.pause();
        btn.innerHTML = "&#9658;"; // &#9658; is a Play triangle symbol
    }
}

/* For Chatbot */

function toggleChat() {
    const chatWindow = document.getElementById('chat-window');
    const toggleButton = document.getElementById('chat-toggle-button');
    
    if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
        chatWindow.style.display = 'flex';
        // Hide badge when chat is open
        const badge = toggleButton.querySelector('.chat-badge');
        if (badge) {
            badge.style.display = 'none';
        }
        // Focus on input when opening
        setTimeout(() => {
            document.getElementById('chat-input').focus();
        }, 100);
    } else {
        chatWindow.style.display = 'none';
    }
}

function handleEnter(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

async function sendMessage() {
    const inputField = document.getElementById('chat-input');
    const message = inputField.value.trim();
    const chatBody = document.getElementById('chat-messages');
    const sendBtn = document.querySelector('.chat-send-btn');

    if (message === "") return;

    // Disable input and button while sending
    inputField.disabled = true;
    sendBtn.disabled = true;

    // 1. Show User Message with proper structure
    const userMessageDiv = document.createElement('div');
    userMessageDiv.className = 'user-message';
    userMessageDiv.innerHTML = `
        <div class="message-avatar">You</div>
        <div class="message-content">
            <div class="message-text">${escapeHtml(message)}</div>
            <div class="message-time">${getCurrentTime()}</div>
        </div>
    `;
    chatBody.appendChild(userMessageDiv);
    inputField.value = '';
    chatBody.scrollTop = chatBody.scrollHeight; 

    // 2. Show "Thinking..." message
    const loadingDiv = document.createElement('div');
    loadingDiv.className = 'bot-message';
    loadingDiv.innerHTML = `
        <div class="message-avatar">AI</div>
        <div class="message-content">
            <div class="message-text">Thinking...</div>
        </div>
    `;
    chatBody.appendChild(loadingDiv);
    chatBody.scrollTop = chatBody.scrollHeight;

    try {
        // Get CSRF token
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfTokenMeta) {
            throw new Error('CSRF token not found. Please refresh the page.');
        }
        const csrfToken = csrfTokenMeta.getAttribute('content');

        // 3. Call Laravel Backend
        const response = await fetch('/chatbot/ask', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: message })
        });

        // Check if response is OK
        if (!response.ok) {
            let errorMessage = `HTTP error! status: ${response.status}`;
            try {
                const errorData = await response.json();
                if (errorData.reply) {
                    errorMessage = errorData.reply;
                } else if (errorData.message) {
                    errorMessage = errorData.message;
                }
            } catch (e) {
                // If response is not JSON, use status text
                errorMessage = response.statusText || errorMessage;
            }
            throw new Error(errorMessage);
        }

        const data = await response.json();

        // 4. Replace "Thinking..." with actual reply
        loadingDiv.innerHTML = `
            <div class="message-avatar">AI</div>
            <div class="message-content">
                <div class="message-text">${escapeHtml(data.reply || "Sorry, I couldn't process that request.")}</div>
                <div class="message-time">${getCurrentTime()}</div>
            </div>
        `;

    } catch (error) {
        console.error('Chatbot error:', error);
        loadingDiv.innerHTML = `
            <div class="message-avatar">AI</div>
            <div class="message-content">
                <div class="message-text" style="color: #d32f2f;">${escapeHtml(error.message || "Error connecting to server. Please try again later.")}</div>
                <div class="message-time">${getCurrentTime()}</div>
            </div>
        `;
    } finally {
        // Re-enable input and button
        inputField.disabled = false;
        sendBtn.disabled = false;
        inputField.focus();
    }

    chatBody.scrollTop = chatBody.scrollHeight;
}

// Helper function to escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Helper function to get current time
function getCurrentTime() {
    const now = new Date();
    return now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
}