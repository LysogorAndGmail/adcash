import axios from 'axios';

const state = {
    orgs: [],
    selected_org_id: null
}

const mutations = {
    'SET_ORGS'(state, orgs) {
        state.orgs = orgs;
    },
    'SET_SELECTED_ORG'(state, org) {
        state.selected_org_id = org;
    }
}

const actions = {
    fetchUserOrgs({commit, state, dispatch}) {
        axios.get('/user-organizations').then(res => {
            commit('SET_ORGS', res.data);
            commit('SET_SELECTED_ORG', res.data[0].id);
        }).then(() => {
            dispatch('fetchUserRoles', state.selected_org_id);
        }).catch(error => console.log(error));
    }
}

const getters = {
    getUserOrgs: state => {
        return state.orgs;
    },
    getUserSelectedOrg: state => {
        return state.selected_org_id;
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}