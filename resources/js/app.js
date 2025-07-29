import './bootstrap';
// Importer Particles.js
import particles from 'particles.js';
import Alpine from 'alpinejs';
window.onload = function() {
    particlesJS.load('particles-js', 'particles.json', function() {
        console.log('Particles.js config loaded');
    });
};
window.Alpine = Alpine;

Alpine.start();
