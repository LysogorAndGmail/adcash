import axios from 'axios';

const state = {
    roles: []
}

const mutations = {
    'SET_ROLES'(state, roles) {
        state.roles = roles;
    }
}

const actions = {
    fetchUserRoles({commit}) {
        axios.get('/user-roles').then(res => {
            commit('SET_ROLES', res.data);
        }).catch(error => console.log(error));
    }
}

const getters = {
    getUserRoles: state => {
        return state.roles;
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}