<style>
#chatbot-widget {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 320px;
    max-height: 420px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 9999;
    border: 1px solid #007bff;
}

#chatbot-header {
    background: #007bff;
    color: white;
    padding: 8px;
    font-weight: bold;
    text-align: center;
}

#chatbot-messages {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    font-size: 14px;
}

#chatbot-input {
    display: flex;
    border-top: 1px solid #ccc;
}

#chatbot-input input {
    flex: 1;
    padding: 8px;
    border: none;
    outline: none;
}

#chatbot-input button {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
}

#chatbot-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #007bff;
    color: white;
    width: 50px;
    height: 50px;
    font-size: 22px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    z-index: 9999;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}
</style>

<!-- Botón burbuja -->
<div class="container">
    <button id="chatbot-toggle">💬</button>

    <!-- Caja del chatbot -->
    <div id="chatbot-widget">
        <div id="chatbot-header">Asistente Virtual</div>
        <div id="chatbot-messages"></div>
        <div id="chatbot-input">
            <input type="text" id="chatbot-text" placeholder="Escribe algo..." style="display: none;" />
            <div id="chatbot-buttons"></div>
        </div>

    </div>

</div>


<script>
let estado = 'inicio'; // control del estado de la conversación

document.addEventListener('DOMContentLoaded', function() {
    mostrarOpciones(['Horarios', 'Precios', 'Soporte Técnico']);
});

function mostrarOpciones(opciones) {
    const contenedor = document.getElementById('chatbot-buttons');
    contenedor.innerHTML = '';
    opciones.forEach(op => {
        const btn = document.createElement('button');
        btn.innerText = op;
        btn.style.margin = '5px';
        btn.onclick = () => manejarSeleccion(op);
        contenedor.appendChild(btn);
    });
}

function agregarMensaje(texto, remitente = 'Bot') {
    const mensajes = document.getElementById('chatbot-messages');
    mensajes.innerHTML += `<div><strong>${remitente}:</strong> ${texto}</div>`;
    mensajes.scrollTop = mensajes.scrollHeight;
}

function manejarSeleccion(opcion) {
    agregarMensaje(opcion, 'Tú');

    if (estado === 'inicio') {
        if (opcion === 'Horarios') {
            estado = 'horarios';
            agregarMensaje('¿Para qué servicio necesitas el horario?');
            mostrarOpciones(['Vuelos', 'Mantenimiento']);
        } else if (opcion === 'Precios') {
            estado = 'precios';
            agregarMensaje('¿Qué servicio deseas cotizar?');
            mostrarOpciones(['Vuelo VIP', 'Carga', 'Pasajeros']);
        } else if (opcion === 'Soporte Técnico') {
            estado = 'soporte';
            agregarMensaje('¿Qué tipo de soporte necesitas?');
            mostrarOpciones(['Sistema', 'App móvil', 'Reportes']);
        }
    } else if (estado === 'horarios') {
        if (opcion === 'Vuelos') {
            agregarMensaje('Los vuelos operan de 08:00 a 17:00.');
        } else if (opcion === 'Mantenimiento') {
            agregarMensaje('Mantenimiento trabaja 24/7 en turnos.');
        }
        estado = 'fin';
        mostrarOpciones(['Volver al inicio']);
    } else if (estado === 'precios') {
        agregarMensaje(`Los precios para "${opcion}" se cotizan según la tarifa actual. Contacta a ventas.`);
        estado = 'fin';
        mostrarOpciones(['Volver al inicio']);
    } else if (estado === 'soporte') {
        agregarMensaje(`Para soporte en "${opcion}", escribe a soporte@go-airsupport.com.`);
        estado = 'fin';
        mostrarOpciones(['Volver al inicio']);
    } else if (estado === 'fin') {
        estado = 'inicio';
        agregarMensaje('¿Sobre qué tema necesitas ayuda?');
        mostrarOpciones(['Horarios', 'Precios', 'Soporte Técnico']);
    }
}
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('chatbot-toggle');
    const widget = document.getElementById('chatbot-widget');

    toggle.addEventListener('click', () => {
        if (widget.style.display === 'none' || widget.style.display === '') {
            widget.style.display = 'flex';
        } else {
            widget.style.display = 'none';
        }
    });
});

async function enviarChat() {
    const input = document.getElementById('chatbot-text');
    const mensajes = document.getElementById('chatbot-messages');
    const texto = input.value.trim();
    if (!texto) return;

    mensajes.innerHTML += `<div><strong>Tú:</strong> ${texto}</div>`;
    input.value = '';

    const res = await fetch('/api/chatgpt', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            mensaje: texto
        })
    });

    const data = await res.json();
    mensajes.innerHTML += `<div><strong>Bot:</strong> ${data.respuesta}</div>`;
    mensajes.scrollTop = mensajes.scrollHeight;
}
</script>