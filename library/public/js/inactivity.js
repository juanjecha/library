(function () {
    // Lee la configuración desde el <script> que carga este archivo
    const script = document.currentScript;
    const logoutUrl = script.dataset.logoutUrl || '/logout';
    const timeoutMs = (parseInt(script.dataset.minutes, 10) || 10) * 60 * 1000;

    let timer;

    function logoutUser() {
        window.location.href = logoutUrl;
    }

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(logoutUser, timeoutMs);
    }

    // Eventos que indican actividad del usuario
    ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'click'].forEach(function (evt) {
        window.addEventListener(evt, resetTimer, { passive: true });
    });

    resetTimer(); // iniciar el temporizador al cargar la página
})();