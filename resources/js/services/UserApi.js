import axios from 'axios';
import { updateUserFormData, createUserFormData } from '@services/UserService.js';

export function updateUser(user, id) {
    return axios.post(`/account/${id}`, updateUserFormData(user));
}

export function createUser(user) {
    return axios.post("/account", createUserFormData(user));
}