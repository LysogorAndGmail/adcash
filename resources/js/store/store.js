import Vue from 'vue';
import Vuex from 'vuex';

import user from './modules/user/user';
import user_orgs from './modules/user/user_orgs';
import user_roles from './modules/user/user_roles';
import user_permissions from './modules/user/user_permissions';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user,
        user_orgs,
        user_roles,
        user_permissions
    }
});