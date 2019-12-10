import axios from 'axios';
import http from '@http';

class UserService {
    constructor() {
        if (UserService.instance) {
            return UserService.instance;
        }

        UserService.instance = this;
    }

    getUsers() {
        return http.get('/admin/users').then(res => {
            return res.data;
        });
    }

    getUser(id) {
        return http.get(`/admin/user/${id}/show`).then(res => {
            return res.data;
        });
    }

    storeUser(data) {
        return http.post('/admin/user/store', data);
    }

    updateUser(id, data) {
        return http.put(`/admin/user/${id}/update`, data);
    }

    deleteUser(id) {
        return http.delete(`/admin/user/${id}/destroy`).then(res => {
            return res.data;
        });
    }

}

export default new UserService();
