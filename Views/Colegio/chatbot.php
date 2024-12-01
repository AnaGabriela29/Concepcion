<!-- Botón de Chat -->
<div id="chatbot-button" class="chatbot-button">
    <i class="bi bi-chat-dots-fill"></i>
</div>

<div id="chatbot-window" class="chatbot-window d-none shadow rounded">
    <div class="chat-header d-flex justify-content-between align-items-center px-3 py-2 bg-primary text-white rounded">
        <h5 class="m-0">Chat UNIMAT IA</h5>
        <button id="close-chatbot" class="btn btn-sm btn-light text-danger">X</button>
    </div>
    <div class="chat-body p-3 overflow-auto" style="max-height: 300px;">
        <div class="message bot-message d-flex align-items-center mb-2">
            <img src="path-to-bot-icon.png" alt="Bot" class="icon me-2">
            <div class="message-text bg-light p-2 rounded">
                ¡Hola! Soy tu asistente virtual, ¿en qué puedo ayudarte?
            </div>
        </div>
        <!-- Aquí se agregarán los mensajes dinámicamente -->
    </div>
    <div class="chat-footer d-flex p-2 bg-light border-top">
        <input type="text" id="chat-input" class="form-control rounded-start" placeholder="Escribe tu mensaje aquí...">
        <button id="send-chat" class="btn btn-primary rounded-end ms-2">
            <i class="bi bi-send"></i>
        </button>
    </div>
</div>
