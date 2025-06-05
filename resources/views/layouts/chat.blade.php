<!-- Chat AI Component -->
<div class="chat-wrapper">
    <button class="chat-toggle" id="chatToggle">AI</button>
    <div class="chat-container" id="chatContainer">
        <div class="chat-header">
            <div class="chat-header-icon">🤖</div>
            <div class="chat-header-info">
                <h3>SaveBite Assistant</h3>
                <p>Tanyakan seputar penyimpanan dan ketahanan makanan anda</p>
            </div>
        </div>
        <div class="chat-messages" id="chatMessages"></div>
        <div class="loading-message" id="loadingMessage">SaveBite sedang mengetik</div>
        <div class="chat-input-container">
            <input type="text" class="chat-input" id="chatInput" placeholder="Tanyakan tentang makanan...">
            <button class="chat-send-button" id="sendMessage">Kirim</button>
        </div>
    </div>
</div>

<!-- Chat Styles -->
<style>
    .chat-wrapper {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 1000;
        width: auto;
        margin: 0;
    }

    .chat-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(90deg, #3e6ff4 0%, #5be9b9 100%);
        border: none;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(62,111,244,0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .chat-toggle:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(62,111,244,0.4);
    }

    .chat-container {
        position: absolute;
        bottom: 80px;
        left: 0;
        width: 450px;
        height: 500px;
        border-radius: 22px;
        background: linear-gradient(225deg,rgb(253, 253, 253), #d6d9dd);
        box-shadow: 0px 3px 40px rgba(248, 243, 243, 0.73);
        display: none;
        flex-direction: column;
        overflow: hidden;
    }

    @media screen and (max-width: 768px) {
        .chat-container {
            width: 400px;
        }
    }

    .chat-container.active {
        display: flex;
    }

    .chat-header {
        background: linear-gradient(90deg, #3e6ff4 0%, #5be9b9 100%);
        padding: 15px 20px;
        border-radius: 22px 22px 0 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-header-icon {
        font-size: 24px;
    }

    .chat-header-info h3 {
        color: white;
        margin: 0;
        font-size: 18px;
    }

    .chat-header-info p {
        color: rgba(255, 255, 255, 0.9);
        margin: 5px 0 0;
        font-size: 14px;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .message {
        padding: 1rem;
        border-radius: 12px;
        max-width: 85%;
        margin-bottom: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .user-message {
        background: linear-gradient(90deg, #3e6ff4 0%, #5be9b9 100%);
        color: white;
        align-self: flex-end;
        margin-left: 15%;
    }

    .bot-message {
        background: white;
        color: #232946;
        align-self: flex-start;
        margin-right: 15%;
    }

    .loading-message {
        color: #6c757d;
        padding: 1rem;
        display: none;
        align-items: center;
        gap: 8px;
    }

    .chat-input-container {
        display: flex;
        padding: 1rem;
        border-top: 1px solid #ddd;
        background: #f8f9fa;
        border-radius: 0 0 22px 22px;
    }

    .chat-input {
        flex: 1;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 12px;
        margin-right: 0.5rem;
        font-size: 1em;
        background: white;
    }

    .chat-send-button {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(90deg, #3e6ff4 0%, #5be9b9 100%);
        color: white;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .chat-send-button:hover {
        background: linear-gradient(90deg, #5be9b9 0%, #3e6ff4 100%);
        transform: scale(1.05);
    }

    .info-section {
        display: flex;
        gap: 12px;
        margin-bottom: 8px;
        align-items: flex-start;
    }

    .info-icon {
        font-size: 1.5em;
        min-width: 30px;
        text-align: center;
    }

    .info-content {
        flex: 1;
        line-height: 1.5;
    }

    .info-content strong {
        color: #3e6ff4;
        display: inline-block;
        margin-bottom: 4px;
    }

    .bot-message .info-section:not(:last-child) {
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding-bottom: 8px;
    }
</style>

<!-- Chat Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatInput = $('#chatInput');
        const sendButton = $('#sendMessage');
        const chatMessages = $('#chatMessages');
        const loadingMessage = $('#loadingMessage');

        function formatResponse(text) {
            function cleanText(text) {
                return text.replace(/\*+/g, '').trim();
            }
            
            const sections = text.split(/(?=-\s*Ketahanan di suhu ruang|Ketahanan di kulkas|Tips penyimpanan)/g);
            
            if (sections.length > 1) {
                return sections.map(section => {
                    section = section.trim();
                    if (section.startsWith('-')) {
                        section = section.substring(1).trim();
                    }
                    if (section.includes('Ketahanan di suhu ruang')) {
                        return `<div class="info-section">
                            <span class="info-icon">🌡️</span>
                            <div class="info-content">
                                <strong>Ketahanan di Suhu Ruang:</strong><br>
                                ${cleanText(section.replace('Ketahanan di suhu ruang:', ''))}
                            </div>
                        </div>`;
                    } else if (section.includes('Ketahanan di kulkas')) {
                        return `<div class="info-section">
                            <span class="info-icon">❄️</span>
                            <div class="info-content">
                                <strong>Ketahanan di Kulkas:</strong><br>
                                ${cleanText(section.replace('Ketahanan di kulkas:', ''))}
                            </div>
                        </div>`;
                    } else if (section.includes('Tips penyimpanan')) {
                        return `<div class="info-section">
                            <span class="info-icon">💡</span>
                            <div class="info-content">
                                <strong>Tips Penyimpanan:</strong><br>
                                ${cleanText(section.replace('Tips penyimpanan:', ''))}
                            </div>
                        </div>`;
                    } else {
                        return `<div class="info-section">
                            <span class="info-icon">ℹ️</span>
                            <div class="info-content">${cleanText(section)}</div>
                        </div>`;
                    }
                }).join('');
            } else {
                return `<div class="info-section">
                    <span class="info-icon">ℹ️</span>
                    <div class="info-content">${cleanText(text)}</div>
                </div>`;
            }
        }

        function addMessage(text, type) {
            const messageDiv = $('<div>')
                .addClass('message')
                .addClass(type + '-message');

            if (type === 'bot') {
                messageDiv.html(formatResponse(text));
            } else {
                messageDiv.text(text);
            }

            $('#chatMessages').append(messageDiv);
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
        }

        async function sendMessage() {
            const message = chatInput.val().trim();
            if (!message) return;

            addMessage(message, 'user');
            chatInput.val('');

            loadingMessage.css('display', 'flex');
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);

            try {
                const response = await $.ajax({
                    url: '{{ route("api.chat") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        message: message
                    }),
                    processData: false
                });

                loadingMessage.css('display', 'none');
                if (response && response.response) {
                    addMessage(response.response, 'bot');
                } else {
                    console.error('Invalid response format:', response);
                    addMessage('Maaf, terjadi kesalahan format respons.', 'bot');
                }
            } catch (error) {
                console.error('Error details:', error);
                loadingMessage.css('display', 'none');
                addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
            }
        }

        sendButton.click(() => sendMessage());
        chatInput.keypress(function(e) {
            if (e.which == 13) {
                sendMessage();
            }
        });

        // Chat toggle functionality
        document.getElementById('chatToggle').addEventListener('click', function() {
            const chatContainer = document.getElementById('chatContainer');
            chatContainer.classList.toggle('active');
            
            if (chatContainer.classList.contains('active')) {
                const chatMessages = document.getElementById('chatMessages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });

        // Close chat when clicking outside
        document.addEventListener('click', function(event) {
            const chatWrapper = document.querySelector('.chat-wrapper');
            const chatContainer = document.getElementById('chatContainer');
            const chatToggle = document.getElementById('chatToggle');
            
            if (!chatWrapper.contains(event.target) && chatContainer.classList.contains('active')) {
                chatContainer.classList.remove('active');
            }
        });
    });
</script>
