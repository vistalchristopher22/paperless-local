import { io } from "https://cdn.socket.io/4.7.4/socket.io.esm.min.js";
let socket;
function getSocketInstance() {
    if (!socket) {
        socket = io(import.meta.env.VITE_SOCKET_URL, {
            forceNew: true,
        });
    }
    return socket;
}

export default getSocketInstance;