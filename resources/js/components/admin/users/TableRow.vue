<template>
    <tr>
        <td>{{ index + 1 }}</td>
        <td>
            <span>
                {{ user.full_name }}
            </span>
        </td>
        <td>
            <span class="float-right">
                <a href="javascript:void(0)" @click="edit()">
                    {{ $t("edit") }}
                </a>
                <span> | </span>
                <a href="javascript:void(0)"
                   @click="destroy(user.id)">{{ $t("delete") }}
                </a>
            </span>
        </td>
    </tr>
</template>

<script>

    import UserService from '@services/user.service';

    export default {
        props: ['user', 'index'],
        methods: {
            edit() {
                this.$router.push({
                    name: 'admin.user.edit',
                    params: {
                        user_id: this.user.id
                    }
                })
            },
            destroy(id) {
                if (!window.confirm(this.$t("delete") + '?')) {
                    return false;
                }
                UserService.deleteUser(id).then(res => {
                    this.$toastr.s(this.$t("deleted"));
                    this.$emit('removeUser', this.index);
                }).catch(error => {
                    console.log(error.response.data)
                    this.$toastr.e(this.$t(error.response.data));
                });
            }
        }
    }
</script>
