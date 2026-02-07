document.addEventListener('DOMContentLoaded', () => {
    const music = document.getElementById('bg-music');
    const btn = document.getElementById('toggle-sound');

    if (!music || !btn) return;

    music.volume = 0.3;
    music.muted = true; // état initial

    btn.addEventListener('click', () => {
        if (music.paused) {
            music.play();
            music.muted = false;
            btn.textContent = '🔊';
        } else {
            music.muted = !music.muted;
            btn.textContent = music.muted ? '🔇' : '🔊';
        }
    });
    document.addEventListener('click', () => {
        music.play();
        music.muted = false;
        btn.textContent = '🔊';
    }, { once: true });
});
