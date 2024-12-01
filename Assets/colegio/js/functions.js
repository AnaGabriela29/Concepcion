document.addEventListener("DOMContentLoaded", () => {
    // Variables
    const chatbotButton = document.getElementById("chatbot-button");
    const chatbotWindow = document.getElementById("chatbot-window");
    const closeChatbot = document.getElementById("close-chatbot");
    const chatInput = document.getElementById("chat-input");
    const chatBody = document.querySelector(".chat-body");
    const sendChat = document.getElementById("send-chat");

    let isChatOpen = false; // Variable de estado

    // Mostrar/Ocultar Ventana del Chat
    chatbotButton.addEventListener("click", () => {
        if (!isChatOpen) {
            chatbotWindow.classList.remove("d-none");
          
        } else {
            chatbotWindow.classList.add("d-none");
        }
        isChatOpen = !isChatOpen; // Alterna el estado
    });

      // Cerrar el Chat al presionar el botón de cerrar
      closeChatbot.addEventListener("click", () => {
        if (isChatOpen) {
            chatbotWindow.classList.add("d-none");
            isChatOpen = false;
        }
    });

    // Enviar Mensaje
    sendChat.addEventListener("click", () => {
        const userMessage = chatInput.value.trim();
        if (userMessage) {
            // Mensaje del Usuario
            const userMessageElement = document.createElement("div");
            userMessageElement.classList.add("message", "user-message");
            userMessageElement.innerHTML = `
                <img src="path-to-user-icon.png" alt="User" class="icon ms-2">
                <div class="message-text">${userMessage}</div>
            `;
            chatBody.appendChild(userMessageElement);

            // Respuesta del Bot
            setTimeout(() => {
                const botMessageElement = document.createElement("div");
                botMessageElement.classList.add("message", "bot-message");
                botMessageElement.innerHTML = `
                    <img src="path-to-bot-icon.png" alt="Bot" class="icon me-2">
                    <div class="message-text">Gracias por tu mensaje. Estoy aquí para ayudarte.</div>
                `;
                chatBody.appendChild(botMessageElement);

                // Auto-scroll
                chatBody.scrollTop = chatBody.scrollHeight;
            }, 1000);
             // Auto-scroll hacia el mensaje enviado por el usuario
             chatBody.scrollTop = chatBody.scrollHeight;

            chatInput.value = ""; // Limpia el input
        }
    });
});
