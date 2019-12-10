import axios from 'axios';

const state = {
    permissions: []
}

const mutations = {
    'SET_PERMISSIONS'(state, permissions) {
        state.permissions = permissions;
    }
}

const actions = {
    fetchUserPermissions({commit}) {
        axios.get('/user-permissions').then(res => {
            commit('SET_PERMISSIONS', res.data);
            // console.log(res.data)
        }).catch(error => console.log(error));
    }
}

const getters = {
    getUserPermissions: state => {
        return state.permissions;
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}