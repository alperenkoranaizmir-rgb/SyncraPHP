import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Configure Echo to use Pusher (hosted Pusher by default). Use environment
// variables defined in .env (PUSHER_APP_*) or the MIX_ prefixed vars used by
// Laravel Mix / Vite when building frontend assets.
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY || process.env.PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER || process.env.PUSHER_APP_CLUSTER,
    wsHost: process.env.MIX_PUSHER_HOST || process.env.PUSHER_HOST || undefined,
    wsPort: process.env.MIX_PUSHER_PORT || process.env.PUSHER_PORT || undefined,
    wssPort: process.env.MIX_PUSHER_PORT || process.env.PUSHER_PORT || undefined,
    forceTLS: (process.env.MIX_PUSHER_FORCE_TLS || process.env.PUSHER_APP_FORCE_TLS || 'true') === 'true',
    encrypted: (process.env.MIX_PUSHER_ENCRYPTED || process.env.PUSHER_APP_ENCRYPTED || 'true') === 'true',
    enabledTransports: ['ws', 'wss'],
});

// Example usage:
// window.Echo.channel(`project.${projectId}`).listen('DecisionStatusChanged', (e) => { console.log(e); });
