import axios from 'axios';

const state = {
    fullname: null
}

const mutations = {
    'SET_FULLNAME'(state, fullname) {
        state.fullname = fullname;
    },
}

const actions = {
    fetchAuthUser({commit}) {
        axios.get('/auth-user').then(res => {
            commit('SET_FULLNAME', res.data.fname + ' ' + res.data.lname);
        }).catch(error => console.log(error));
    }
}

const getters = {
    getUserFullname: state => {
        return state.fullname;
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}