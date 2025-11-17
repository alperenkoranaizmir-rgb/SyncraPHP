import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY || process.env.PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER || process.env.PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
});

// Example usage:
// window.Echo.channel('project.1').listen('DecisionStatusChanged', (e) => { console.log(e); });
