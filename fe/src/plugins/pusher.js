import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import axios from 'axios'

window.Pusher = Pusher;

const customAuthorizer = (channel, options) => {
    return {
        authorize: (socketId, callback) => {
            axios.post(`${import.meta.env.VITE_BASE_URL}/broadcasting/auth`, {
                socket_id: socketId,
                channel_name: channel.name
            },{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(response => {
                callback(null, response.data);
            })
            .catch(error => {
                callback(error);
            });
        }
    };
};

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    forceTLS: true,
    authorizer: customAuthorizer,
});


   